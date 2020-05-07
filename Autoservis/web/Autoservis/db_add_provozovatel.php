<?php
require "db_connect.php";

function randomPassword()
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_+.";
    $pass = array();
    $lenght = strlen($chars) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $lenght);
        $pass[] = $chars[$n];

    }

    $heslomd5 = md5(implode($pass));
    $heslo = implode($pass);
    require "db_connect.php";

    $check = "SELECT * FROM provozovatel WHERE password LIKE '$heslomd5'";

    if ($conn->query($check)->num_rows > 0) {
        randomPassword();
        $conn->close();
    } else {
        return $heslo;
        $conn->close();
    }

}

if ($_POST) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset('utf8');

    if ($_POST['firma'] != null) {
        $firma = $_POST['firma'];
    } else {
        $firma = "jednotlivec";
    }
    $jmeno = $_POST['first_name'];
    $prijmeni = $_POST['last_name'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];

    $check = "SELECT * FROM provozovatel WHERE email LIKE '$email';";
    if ($conn->query($check)->num_rows > 0) {
        session_start();
        $info = "Provozovatel s emailovou adresou: $email už existuje !!!";
        $_SESSION['info'] = $info;
        header("Location: provozovatele.php");
        exit();
    }

    $mesto = $_POST['mesto'];
    $ulice = $_POST['ulice'];
    $cislo_popisne = $_POST['cislo_popisne'];
    $psc = $_POST['psc'];
    $heslo = randomPassword();
    $hesloMd5 = md5($heslo);

    $check = "SELECT * FROM adresa WHERE ulice LIKE '$ulice' AND cislo_popisne LIKE '$cislo_popisne' AND mesto LIKE '$mesto' AND psc LIKE '$psc'";
    if ($conn->query($check)->num_rows > 0) {
        $query = "SELECT adresa_id FROM adresa WHERE ulice LIKE '$ulice' AND cislo_popisne LIKE '$cislo_popisne' AND mesto LIKE '$mesto' AND psc LIKE '$psc'";
        if ($result = $conn->query($query)) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $last_id = $row['adresa_id'];
            }
        } else {
            echo "Error: " . $query . "<br>" . $conn->connect_error;
        }

    } else {
        $query = "INSERT INTO adresa(mesto,ulice,cislo_popisne,psc) VALUES ('$mesto','$ulice','$cislo_popisne','$psc')";

        if ($conn->query($query) === true) {
            $last_id = $conn->insert_id;
        } else {
            echo "Error: " . $query . "<br>" . $conn->connect_error;
        }
    }

    $query = "INSERT INTO provozovatel(firma,jmeno,prijmeni,telefon,email,password,adresa_id) VALUES('$firma','$jmeno','$prijmeni','$telefon','$email','$hesloMd5','$last_id')";

    if ($conn->query($query) === true) {
        require "mailSender/registrace.php";
    } else {
        echo "Error: " . $query . "<br>" . $conn->connect_error;
    }

    $conn->close();

    header("Location: provozovatele.php");
}