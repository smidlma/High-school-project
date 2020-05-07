<?php
require 'db_connect.php';
session_start();
$id = $_SESSION['id'];
$query = "SELECT datum, CONCAT(spz,' ',znacka,' ',model,' ',rok_vyroby) AS auto, stav
        FROM servisni_objednavka s INNER JOIN auto a USING(auto_id)
        WHERE s.provozovatel_id = $id AND (CURDATE() < ADDDATE(s.ukonceno,INTERVAL 1 WEEK) OR s.ukonceno IS null) AND stav NOT LIKE 'storno'
        ORDER BY datum ASC";
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
