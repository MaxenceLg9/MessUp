<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/token/jwt_utils.php";
function apiVerifyToken(): void
{
//    echo get_authorization_header();
    $url = "messup.app/api/auth/";
    $data = json_encode([
        "token"=> "1"
    ]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

     if(json_decode($response,true)["valid"] == false){
         header("Location: /vue/login.php");
         die();
     }
}