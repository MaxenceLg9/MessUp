<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Message.php";

use function Message\nouveauMessage;

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = json_decode(file_get_contents('php://input'), true);
    $data = nouveauMessage($content["message"], $content["salle"], $content["author"]);
    $message = array("status" => 200, "response" => "Message bien ajouté", "data" => $data);
    echo json_encode($message);
}else{
    http_response_code(405);
    header('Content-Type: application/json');
    $message = array("status" => 405, "response" => "Method not allowed", "data" => []);
    echo json_encode($message);
}