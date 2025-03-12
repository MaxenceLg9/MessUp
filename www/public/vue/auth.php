<?php

require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Token.php";

if(apiVerifyToken()){
    header("Location: /index.php");
    die();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/resources/style/message.css"
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<form id="login">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <button id="login">Login</button>
</form>
<form id="register">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <label for="confirmpassword">Confirm Password</label>
    <input type="password" id="confirmpassword" name="confirmpassword">
    <button id="register">Login</button>
</form>
</body>
<script src="../resources/js/auth.js"></script>
</html>
