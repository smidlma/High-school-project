<?php
require 'db_connect.php';

$query = "SELECT provozovatel_id,auto_id, CONCAT(jmeno,' ',prijmeni) AS provozovatel,znacka,model,spz
FROM auto INNER JOIN provozovatel USING(provozovatel_id) WHERE auto_id != 1";

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