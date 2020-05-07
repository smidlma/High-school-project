<?php
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/User.php';

//DB
$database = new Database();
$db = $database->connect();

$user = new User($db);

//Get data from app
$data = json_decode(file_get_contents("php://input"));

$user->token = $data->Token;
$user->password = $data->Password;
$user->newPassword = $data->NewPassword;

if ($user->checkToken2()) {

    if($user->changePassword()){
        http_response_code(200);
    }else{
        http_response_code(404);
        echo(json_encode(array("Token" => $user->token,"Stare" => $user->password,"Nove" => $user->newPassword)));
    }
    
} else {
    http_response_code(403);
}
