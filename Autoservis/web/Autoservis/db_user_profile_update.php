<?php
require "db_connect.php";
session_start();
$id = $_SESSION['id'];
$email = $_POST['emailU'];
$tel = $_POST['telU'];

$query = "UPDATE provozovatel
SET email = '$email', telefon = '$tel'
WHERE provozovatel_id = $id";

if ($conn->query($query) === true) {
    header("Location: userProfile.php");
} else {
    echo "Error sql";
}
$conn->close();
