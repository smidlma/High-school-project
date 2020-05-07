<?php
require 'db_connect.php';

$query = "SELECT typ_zasahu_id, nazev, cena FROM typ_zasahu WHERE valid = 0 AND typ_zasahu_id != 1;";

$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
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
