<?php
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');
// header('Acces-Control-Allow-Headers: Acces-Control-Allow-Headers,
// Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

//DB
$database = new Database();
$db = $database->connect();

$user = new User($db);

//Get data from app
$data = json_decode(file_get_contents("php://input"));

$user->email = $data->Email;
$user->password = md5($data->Password);

//User login check
if ($user->login()) {

        // Check token
        $user->checkToken();
        
        echo json_encode(array('Token' => $user->token, 'Date' => $user->date));
        http_response_code(200);
    

} else {
    //echo json_encode(array('message' => 'Špatné jméno nebo password'));
    http_response_code(403);
}
