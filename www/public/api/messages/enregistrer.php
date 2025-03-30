<?php

require_once "../../libs/modele/Message.php";
require_once "../../libs/modele/Token.php";

use function Message\nouveauMessage;
use function Token\apiVerifyToken,Token\getPayload,Token\apiReloadToken;

header('Content-Type: application/json');

if(!apiVerifyToken()){
    http_response_code(401);
    $message = array("status" => 401, "response" => "Unauthorized", "data" => []);
    echo json_encode($message);
    die();
}

$idUser = getPayload()["id"];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonBody = json_decode(file_get_contents('php://input'), true);
    if(isset($jsonBody["message"]) && isset($jsonBody["idSalle"])) {
        $jsonBody["message"] = trim($jsonBody["message"]);
        if ($jsonBody["message"] === "") {
            $message = array("status" => 400, "response" => "Message cannot be empty", "data" => []);
        } else if ($jsonBody["idSalle"] > 10 || $jsonBody["idSalle"] < 1) {
            $message = array("status" => 400, "response" => "Salle must be between 1 and 10", "data" => []);
        }else{
            $token = apiReloadToken();
            setcookie("token",$token,time() + 1800,"/");
            $message = array("status" => 200, "response" => "Message bien ajouté", "data" => nouveauMessage($jsonBody["message"], $jsonBody["idSalle"], $idUser), "token" => $token);
        }
    }
    else {
        $message = array("status" => 400, "response" => "Message, salle and author are required", "data" => []);
    }
}else{
    $message = array("status" => 405, "response" => "Method not allowed", "data" => []);
}
http_response_code($message["status"]);
echo json_encode($message);