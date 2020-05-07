<?php
require "db_connect.php";
session_start();
$id = $_SESSION['id'];
$new = md5($_POST['new']);
$old = md5($_POST['old']);

$check = "SELECT password
FROM provozovatel
WHERE provozovatel_id = $id";
$result = $conn->query($check);
$row = $result->fetch_array(MYSQLI_ASSOC);
$db_password = $row['password'];

if ($db_password == $old && $db_password != $new) {
    $query = "UPDATE provozovatel
    SET password = '$new'
    WHERE provozovatel_id = $id";
    $conn->query($query);
    $_SESSION['info'] = "Heslo bylo úspěšně změněno.";
} else {
    $_SESSION['info'] = "Zadali jste špatné heslo nebo se Vaše nové heslo shoduje se starým.";
}

header("Location: userProfile.php");

$conn->close();
