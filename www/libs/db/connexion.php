<?php

function creerConnexion() : PDO {
    return new PDO('mysql:host=localhost;dbname=messup;charset=utf8','root','pq04WX11me2005!');
}