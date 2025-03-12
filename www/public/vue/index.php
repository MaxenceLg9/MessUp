<?php
require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/modele/Token.php";


/*if(!apiVerifyToken()){
    header("Location: /auth.php");
    die();
}*/

$body = file_get_contents('php://input');
$user = "Maxence"
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/resources/style/message.css"
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Messup</title>
</head>
<body>
<div class="main">
    <nav class="rooms">
        <ul id="rooms">
            <li value="1">Salle 1</li>
            <li value="2">Salle 2</li>
            <li value="3">Salle 3</li>
            <li value="4">Salle 4</li>
        </ul>
    </nav>
    <section id="channel">
        <div id="content"></div>
        <div class="input-container">
            <input type="text" id="message" placeholder="Type your message...">
            <button id="send">Send</button>
        </div>
        <div class="user">
            <p id="user"><?= $user?></p>
        </div>
    </section>
</div>
</body>
<script src="../resources/js/messages.js"></script>
</html>