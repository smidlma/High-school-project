<?php
require "db_connect.php";

if ($_POST) {
    $datum = $_POST['datum'];
    $cena = $_POST['cena'];
    if (!empty($_POST['popis'])) {
        $popis = $_POST['popis'];
    } else {
        $popis = null;
    }
    $typ_zasahu_id = $_POST['typ_zasahu_id'];
    $servisak_id = $_POST['servisak_id'];
    $servisni_objednavka_id = $_POST['servisni_objednavka_id'];

    $query = "INSERT INTO servisni_objednavka_radky() VALUES(null,'$datum',$cena,'$popis',$typ_zasahu_id,$servisak_id,$servisni_objednavka_id);";

    

    if($conn->query($query) === true)
    {
        header("Location: objednavky.php");
    }else{
        echo "Error: " . $query . " " . $conn->connect_error;
    }
}
$conn->close();