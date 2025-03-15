<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Message.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Token.php";

use function Message\nouveauMessage;
use function Token\apiVerifyToken;
use function Token\getPayload;

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
        if($jsonBody["message"] === "") {
            http_response_code(400);
            $message = array("status" => 400, "response" => "Message cannot be empty", "data" => []);
        }else{
            $data = nouveauMessage($jsonBody["message"], $jsonBody["idSalle"], $idUser);
            $message = array("status" => 200, "response" => "Message bien ajouté", "data" => $data);
        }
    }
    else {
        http_response_code(400);
        $message = array("status" => 400, "response" => "Message, salle and author are required", "data" => []);
    }
}else{
    http_response_code(405);
    header('Content-Type: application/json');
    $message = array("status" => 405, "response" => "Method not allowed", "data" => []);
}
echo json_encode($message);