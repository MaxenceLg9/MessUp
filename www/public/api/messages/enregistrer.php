<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Message.php";

use function Message\nouveauMessage;

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonBody = json_decode(file_get_contents('php://input'), true);
    if(isset($jsonBody["message"]) && isset($jsonBody["salle"]) && isset($jsonBody["author"])) {
        $data = nouveauMessage($jsonBody["message"], $jsonBody["salle"], $jsonBody["author"]);
        $message = array("status" => 200, "response" => "Message bien ajouté", "data" => $data);
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