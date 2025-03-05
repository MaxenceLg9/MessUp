<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/token/jwt_utils.php";

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

http_response_code(200);

$data = json_decode(file_get_contents("php://input"), true);

//var_dump($data);

//send only data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //login and password defined => creating the token
    if (isset($data["login"]) && isset($data["password"])) {
        //check validity/truth of the login credentials

        //generate the response and so the token
        $response = array("status_message" => "OK", "status_code" => 200, "token" => encode($data["login"]));
    }
    //the case to check the token authenticity
    elseif(isset($data["token"])){
        //valid or not
        if(is_valid_token($data["token"])){
            $response = array("status_message" => "OK", "status_code" => 200,"valid"=> true);
        }else{
            http_response_code(400);
            $response = array("status_message" => "Token is invalid", "status_code" => 400,"valid"=> false);
        }
    }
    //default case
    else {
        http_response_code(400);
        $response = array("status_message" => "Please provide a token", "status_code" => 400);
    }
}
//update the token (refresh exp time)
elseif($_SERVER["REQUEST_METHOD"] == "PATCH") {
    //if valid, refreshing token
    if(is_valid_token($data["token"])){
        $response = array("status_message" => "OK", "status_code" => 200, "token" => refreshJwt($data["token"]));
    }else{
        http_response_code(400);
        $response = array("status_message" => "Token is invalid", "status_code" => 400);
    }
}
else{
    $response = array("status_message" => "Unsupported method", "status_code" => 400, "token" => "");
}
echo json_encode($response);