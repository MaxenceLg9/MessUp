<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Message.php";

use function Message\getLastMessages;

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $headers = apache_request_headers();
//    if(true){
    if(isset($headers["Authorization"])) {
        if(isset($_GET["idSalle"])) {
            $idSalle = $_GET["idSalle"];
            http_response_code(200);
            $message = array("status" => 200, "response" => "10 derniers messages récupérés");
            if (isset($_GET["idMessage"])) {
                $id = $_GET["idMessage"];
                $message["data"] = getLastMessages($id, $idSalle);
            } else {
                $message["data"] = getLastMessages(0, $idSalle);
            }
        }  else {
            http_response_code(405);
            $message = [];
            $message["status"] = 405;
            $message["message"] = "IdSalle is required";
            $message["data"] = [];
        }
    }else{
        http_response_code(403);
        $message = [];
        $message["status"] = 403;
        $message["message"] = "Authentification is required to access this resource";
        $message["data"] = [];
    }
    echo json_encode($message);
}else{
    http_response_code(405);
    $message = [];
    $message["status"] = 405;
    $message["message"] = "You are not allowed to access this method";
    $message["data"] = [];
    echo json_encode($message);
}