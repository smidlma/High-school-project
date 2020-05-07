<?php
require "db_connect.php";

$query = "SELECT provozovatel_id,firma, CONCAT(jmeno,' ', prijmeni) AS
provozovatel,email
FROM provozovatel INNER JOIN adresa USING(adresa_id)
WHERE provozovatel_id NOT LIKE 1
ORDER BY provozovatel_id DESC;";

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