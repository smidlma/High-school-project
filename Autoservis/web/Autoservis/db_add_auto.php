<?php
require "db_connect.php";

$spz = $_POST['spz'];
$znacka = $_POST['znacka'];
$model = $_POST['model'];
$rok_vyroby = $_POST['rok_vyroby'];
$motor = $_POST['motor'];
$provozovatel_id = $_POST['provozovatel'];

session_start();

$check = "SELECT * FROM auto WHERE spz LIKE '$spz';";

if ($provozovatel_id == null) {
    $_SESSION['info2'] = "Provozovatel nebyl vybrán";
} else if ($conn->query($check)->num_rows > 0) {

    $_SESSION['info'] = "Auto s SPZ: $spz už existuje !!!";

} else {
    $query = "INSERT INTO auto(spz,znacka,model,rok_vyroby,motor,provozovatel_id)
VALUES('$spz','$znacka','$model','$rok_vyroby','$motor','$provozovatel_id')";

    if (!$conn->query($query)) {
        echo ("Error query: " . $query . $conn->connect_error);
    }
}
$conn->close();
header("Location: auta.php");
