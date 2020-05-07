<?php
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/Order.php';

//DB
$database = new Database();
$db = $database->connect();

$order = new Order($db);

//Get data from app
$data = json_decode(file_get_contents("php://input"));

$order->token = $data->Token;

if ($order->checkToken()) {

    $resultArray = array();
    $result = $order->read();

    if ($result->rowCount() > 0) {

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $rowArray = array(
                'ID' => $row['id'],
                'Datum' => $row['datum'],
                'Stav' => $row['stav'],
                'Auto' => $row['auto'],
            );

            //Push
            array_push($resultArray, $rowArray);

        }

        //To Json
        echo json_encode($resultArray);
        //echo(json_encode($order->resultArray));
        http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(404);
}
