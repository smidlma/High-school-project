<?php
require "db_connect.php";

$query = "SELECT servisni_objednavka_id,datum, CONCAT(jmeno,' ', prijmeni) AS provozovatel,CONCAT(znacka,' ', model)AS auto,
stav, zavada FROM servisni_objednavka INNER JOIN provozovatel USING(provozovatel_id)
INNER JOIN auto USING(auto_id) WHERE datum <= CURDATE() AND stav LIKE 'probíhá' ORDER BY datum";

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