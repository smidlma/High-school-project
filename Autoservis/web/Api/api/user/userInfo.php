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

if ($user->checkToken2()) {

    
    $result = $user->userInfo();

    if ($result->rowCount() > 0) {

        $row = $result->fetch(PDO::FETCH_ASSOC);

            $rowArray = array(
                'User' => $row['uzivatel'],
                'Email' => $row['email'],
                'Phone' => $row['telefon'],
                'Adress' => $row['adresa'],
            );

            
            

        

        //To Json
        echo json_encode($rowArray);
        
        http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(403);
}
