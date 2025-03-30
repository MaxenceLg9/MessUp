<?php

require_once "../../libs/modele/Token.php";

use function Token\apiVerifyToken;

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
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <link rel="stylesheet" href="/resources/style/auth.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<form id="login">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <button id="login">Connexion</button>
</form>
<form id="register">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
    <label for="confirmpassword">Confirm Password</label>
    <input type="password" id="confirmpassword" name="confirmpassword">
    <button id="register">Inscription</button>
</form>
<p id="toggle">Vous n'avez pas de compte?</p>
<button id="toggle">S'Inscrire</button>
</body>
<script src="../resources/js/auth.js"></script>
</html>
