<?php
require "db_connect.php";

if ($_POST) {
    if (isset($_POST['servisak_id'])) {
        $id = $_POST['servisak_id'];
        $query = "UPDATE servisak SET valid = 1 WHERE servisak_id = $id;";
    } else {
        $id = $_POST['typ_zasahu_id'];
        $query = "UPDATE typ_zasahu SET valid = 1 WHERE typ_zasahu_id = $id;";
    }

    if ($conn->query($query) === true) {
        header("Location: nastaveni.php");
    } else {
        echo "Error: " . $conn->connect_error . "Query: " . $query;
    }
}

$conn->close();
