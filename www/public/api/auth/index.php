<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/token/jwt_utils.php";

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["token"])){
        $token = $_POST["token"];
        //vérification
    }else if(isset($_POST["email"]) && isset($_POST["password"])){
        //check login credential

    }
}



header("Content-type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $credits = json_decode(file_get_contents('php://input'), true);
    if (isset($credits["login"]) && isset($credits["password"])) {
        $headers = array("alg" => "HS256", "typ" => "JWT");
        $payload = array("login" => $credits["login"], "password" => $credits["password"], "exp" => time() + 3600);
        $response = array("status_message" => "OK", "status_code" => 200, "token" => generate_jwt($headers, $payload, 4500));
        echo json_encode($response);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = array("status_message" => "Unsupported method", "status_code" => 400, "token" => "");
    echo json_encode($response);
}