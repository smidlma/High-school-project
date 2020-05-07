<?php
class User
{

    //DB
    private $conn;
    private $table = "provozovatel";

    //User
    public $provozovatel_id;
    public $email;
    public $password;
    public $newPassword;
    public $token;
    public $date;
    //Con DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Login
    public function login()
    {
        $query = 'SELECT provozovatel_id,email FROM ' . $this->table . ' WHERE email LIKE ? AND password LIKE ?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->password);

        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->provozovatel_id = $row['provozovatel_id'];

            return true;
        } else {
            return false;
        }

    }
    public function changePassword()
    {
        $query = "SELECT jmeno
        FROM provozovatel
        WHERE provozovatel_id = ? AND password LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $passwd = md5($this->password);
        $stmt->bindParam(2, $passwd);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $query = "UPDATE provozovatel
             SET password = ?
             WHERE provozovatel_id = ?";
            $stmt = $this->conn->prepare($query);
            $passwd = md5($this->newPassword);
            $stmt->bindParam(1, $passwd);
            $stmt->bindParam(2, $this->provozovatel_id);
            $stmt->execute();

            return true;
        } else {
            return false;
        }

    }

    public function checkToken()
    {
        $query = 'SELECT value, date_ex  FROM tokens
        WHERE provozovatel_id = ? AND date_ex > NOW();';
        //(SELECT value FROM tokens WHERE provozovatel_id = ?)
        // AND date_ex >= NOW()';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->token = $row['value'];
            $this->date = $row['date_ex'];

        } else {
            $this->createToken();
        }

    }

    public function checkToken2()
    {
        $query = 'SELECT * FROM tokens WHERE value LIKE ? AND date_ex >= NOW()';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {

            //Set provozovatel_id
            $query = "SELECT provozovatel_id FROM tokens WHERE value LIKE ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->token);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->provozovatel_id = $row['provozovatel_id'];
            return true;
        } else {
            return false;
        }
    }

    public function userInfo()
    {
        $query = "SELECT CONCAT(jmeno,' ',prijmeni) AS uzivatel, email, telefon,
        CONCAT(ulice,' ',cislo_popisne,' ',mesto,' ',psc) AS adresa
        FROM provozovatel INNER JOIN adresa USING(adresa_id)
        WHERE provozovatel_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $stmt->execute();
        return $stmt;
    }

    public function createToken()
    {
        //Create token
        $hash = hash('sha256', random_bytes(64));
        //Check
        $query = "SELECT * FROM tokens WHERE value LIKE ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $hash);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            $this->createToken();
        } else {
            //Set token
            $this->token = $hash;

            //Set expiration date
            $this->date = date('Y-m-d', strtotime('+1 month'));

            //Insert token to DB
            $query = "INSERT INTO tokens() VALUES(null,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $hash);
            $stmt->bindParam(2, $this->date);
            $stmt->bindParam(3, $this->provozovatel_id);
            $stmt->execute();
        }

    }
}
