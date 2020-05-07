<?php
require "db_connect.php";

if ($_POST) {
    if (isset($_POST['nazev'])) {
        $nazev = $_POST['nazev'];
        $cena = $_POST['cena'];

        $query = "INSERT INTO typ_zasahu() VALUES(null,'$nazev',$cena,0)";

    } else {

        $jmeno = $_POST['jmeno'];
        $prijmeni = $_POST['prijmeni'];

        $query = "INSERT INTO servisak() VALUES(null,'$jmeno','$prijmeni',0)";

    }
    if ($conn->query($query) === true) {

    } else {
        echo "Error: " . $conn->connect_error . " Query: " . $query;
    }
    header("Location: nastaveni.php");
}
$conn->close();
