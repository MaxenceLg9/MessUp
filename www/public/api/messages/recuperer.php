<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Token.php";
require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Message.php";

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
        http_response_code(200);
        $message = array("status" => 200);
        if (isset($_GET["idMessage"]) && isset($_GET["last"])) {
            $id = $_GET["idMessage"];
            if($_GET["last"] == "1") {
                $message["response"] = "10 derniers messages récupérés à partir du message : ".$id;
                $message["data"] = getLastMessages($id, $idSalle);
            }
            else {
                $message["response"] = "10 précédents messages récupérés à partir du message : " . $id;
                $message["data"] = getPreviousMessages($id, $idSalle);
            }
        } else {
            $message["response"] = "10 derniers messages récupérés";
            $message["data"] = getLastMessages(0, $idSalle);
        }
    }  else {
        http_response_code(405);
        $message = array("status" => 405, "response" => "IdSalle is required", "data" => []);
    }
}else{
    http_response_code(403);
    $message = array("status" => 403, "response" => "You are not allowed to access this method", "data" => []);
}
echo json_encode($message);