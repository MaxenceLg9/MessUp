<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/messup/libs/modele/Token.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/messup/libs/modele/Message.php";

use function Message\getLastMessages;
use function Message\getPreviousMessages;
use function Token\apiVerifyToken;
use function Token\getPayload;

header('Content-Type: application/json');

if(!apiVerifyToken()){
    http_response_code(401);
    $message = array("status" => 401, "response" => "Unauthorized", "data" => []);
    echo json_encode($message);
    die();
}


if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET["idSalle"])) {
        $idSalle = $_GET["idSalle"];
        if ($idSalle > 10 || $idSalle < 1) {
            $message = array("status" => 400, "response" => "Salle must be between 1 and 10", "data" => []);
        } else {
            if (isset($_GET["idMessage"]) && isset($_GET["last"])) {
                $id = $_GET["idMessage"];
                if ($_GET["last"] == "1") {
                    $message = array("status" => 200, "response" => "10 derniers messages récupérés à partir du message : " . $id, "data" => getLastMessages($id, $idSalle));
                } else {
                    $message = array("status" => 200, "response" => "10 précédents messages récupérés à partir du message : " . $id, "data" => getPreviousMessages($id, $idSalle));
                }
            } else {
                $message = array("status" => 200, "response" => "10 derniers messages récupérés", "data" => getLastMessages(0, $idSalle));
            }
        }
    }  else {
        $message = array("status" => 405, "response" => "IdSalle is required", "data" => []);
    }
}else{
    $message = array("status" => 403, "response" => "You are not allowed to access this method", "data" => []);
}

http_response_code($message["status"]);
echo json_encode($message);