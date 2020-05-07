<?php
class Order
{
    //DB
    private $conn;
    private $table;
    public $token;

    //Order
    public $servisni_objednavka_id;
    public $datum_objednavky;
    public $stav;
    public $provozovatel_id;
    public $auto_id;
    public $zavada;

    //Detail
    public $datum_zasahu;
    public $cena;
    public $popis;
    public $typ_zasahu;
    public $servisak;
    //  public $resultArray = array();

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function checkToken()
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

    public function createOrder()
    {

        //Limit
        $check = "SELECT servisni_objednavka_id FROM servisni_objednavka WHERE datum LIKE ? AND stav NOT LIKE 'storno'";
        $stmt = $this->conn->prepare($check);
        $stmt->bindParam(1, $this->datum_objednavky);
        $stmt->execute();

        if ($stmt->rowCount() > 5) {
            return false;
        } else {
            //Create order
            $query = "INSERT INTO servisni_objednavka() VALUES(null,?,'přijato',null,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->datum_objednavky);
            $stmt->bindParam(2,$this->zavada);
            $stmt->bindParam(3, $this->provozovatel_id);
            $stmt->bindParam(4, $this->auto_id);
            if ($stmt->execute() === true) {
                return true;
            } else {
                return false;
            }
        }

    }
    public function read()
    {
        //Select data
        $query = "SELECT servisni_objednavka_id as 'id', datum as 'datum', stav as 'stav', ukonceno,CONCAT(znacka,' ',model) AS 'auto'
        FROM servisni_objednavka s INNER JOIN auto a USING(auto_id)
        WHERE s.provozovatel_id = ? AND (CURDATE() < ADDDATE(s.ukonceno,INTERVAL 1 WEEK) OR s.ukonceno IS null)
        ORDER BY datum ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $stmt->execute();
        return $stmt;

    }

    public function readHistory()
    {
        //Select data
        $query = "SELECT so.servisni_objednavka_id AS 'id', so.datum AS 'datum', CONCAT(a.znacka,' ',a.model) AS 'auto', SUM(sr.cena) AS 'cena'
        FROM auto a INNER JOIN servisni_objednavka so USING(auto_id)
        RIGHT JOIN servisni_objednavka_radky sr USING(servisni_objednavka_id)
        WHERE so.provozovatel_id = ? AND stav LIKE 'dokončeno'
        GROUP BY so.servisni_objednavka_id ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $stmt->execute();
        return $stmt;
    }

    public function readDetail()
    {
        $query = "SELECT datum, s.cena, popis, nazev
        FROM servisni_objednavka_radky s INNER JOIN typ_zasahu USING(typ_zasahu_id)
        WHERE servisni_objednavka_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->servisni_objednavka_id);
        $stmt->execute();
        return $stmt;
    }
    public function readCars()
    {
        $query = "SELECT auto_id, spz, znacka, model, rok_vyroby
        FROM auto
        WHERE provozovatel_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->provozovatel_id);
        $stmt->execute();
        return $stmt;
    }

    public function orderAdd($id, $datum)
    {
        $query = "INSERT INTO servisni_objednavka()
        VALUES(null,?,'probíhá',null,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $this->provozovatel_id);
        $stmt->bindParam(3, $datum);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

}
