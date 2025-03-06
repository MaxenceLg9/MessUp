<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/token/jwt_utils.php";

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

http_response_code(200);

$jsonBody = json_decode(file_get_contents("php://input"), true);


//send only data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //login and password defined => creating the token
    if (isset($jsonBody["login"]) && isset($jsonBody["password"])) {
        //check validity/truth of the login credentials

        //generate the response and so the token
        $response = array("response" => "OK", "status" => 200, "token" => encode($jsonBody["login"]));
    }
    //the case to check the token authenticity
    elseif(isset($jsonBody["token"])){
        //valid or not
        if(is_valid_token($jsonBody["token"])){
            $response = array("response" => "OK", "status" => 200,"valid"=> true);
        }else{
            http_response_code(400);
            $response = array("response" => "Token is invalid", "status" => 400,"valid"=> false);
        }
    }
    //default case
    else {
        http_response_code(400);
        $response = array("response" => "Please provide a token", "status" => 400);
    }
}
//update the token (refresh exp time)
elseif($_SERVER["REQUEST_METHOD"] == "PATCH") {
    //if valid, refreshing token
    if(is_valid_token($jsonBody["token"])){
        $response = array("response" => "OK", "status" => 200, "token" => refreshJwt($jsonBody["token"]));
    }else{
        http_response_code(405);
        $response = array("response" => "Token is invalid", "status" => 405);
    }
}
else{
    $response = array("response" => "Unsupported method", "status" => 400, "token" => "");
}
echo json_encode($response);