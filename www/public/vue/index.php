<?php

require_once "../../libs/modele/Token.php";

use function Token\apiVerifyToken,Token\getPayload;

if(!apiVerifyToken()){
    header("Location: /auth.php");
    die();
}

$body = file_get_contents('php://input');
$body = file_get_contents('php://input');

$user = getPayload()["login"];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <link rel="stylesheet" href="/resources/style/message.css"
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messup</title>
</head>
<body>
<div class="main">
    <nav class="rooms">
        <ul id="rooms">
            <?php for($i = 1; $i <= 10; $i++) { ?>
                <li value="<?=$i?>">Salle <?=$i?></li>
            <?php } ?>
        </ul>
        <ul>
            <li id="disconnect">Se Déconnecter</li>
        </ul>
    </nav>
    <section id="channel">
        <div id="content"></div>
        <div class="input-container">
            <label for="message"></label><input type="text" id="message" placeholder="Type your message...">
        </div>
        <div class="user">
            <p id="user"><?= $user?></p>
        </div>
    </section>
</div>
</body>
<script src="../resources/js/messages.js"></script>
</html>