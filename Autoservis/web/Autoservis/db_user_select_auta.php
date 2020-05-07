<?php
require 'db_connect.php';
session_start();
$id = $_SESSION['id'];
$query = "SELECT auto_id,spz, CONCAT(znacka,' ',model,' ',rok_vyroby) AS nazev
FROM auto
WHERE provozovatel_id = $id";

$result = $conn->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $data[] = $row;
}
header("Content-Type: application/json");

if (empty($data) != true) {
    $output = '{"data":' . json_encode($data) . '}';
} else {
    $output = '{"data": [
        
    ]}';
}

echo $output;
$conn->close();