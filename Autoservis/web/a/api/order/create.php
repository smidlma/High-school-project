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

//Set token
$order->token = $data->Token;
$order->auto_id = $data->Id;
$order->datum_objednavky = $data->Date;
$order->zavada = $data->Zavada;

if($order->checkToken()){
    if($order->createOrder()){
        http_response_code(200);
        //echo(json_encode(array('provozovatel_id' => $order->provozovatel_id)));
    }else{
        http_response_code(404);
    }
}else{
    http_response_code(404);
}