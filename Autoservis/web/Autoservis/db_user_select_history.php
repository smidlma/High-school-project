<?php
require 'db_connect.php';
session_start();
$id = $_SESSION['id'];
$query = "SELECT so.servisni_objednavka_id AS 'id', so.datum AS 'datum', CONCAT(a.znacka,' ',a.model) AS 'auto', SUM(sr.cena) AS 'cena'
        FROM auto a INNER JOIN servisni_objednavka so USING(auto_id)
        RIGHT JOIN servisni_objednavka_radky sr USING(servisni_objednavka_id)
        WHERE so.provozovatel_id = $id AND stav LIKE 'dokončeno'
        GROUP BY so.servisni_objednavka_id ";
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
