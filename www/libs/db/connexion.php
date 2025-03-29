<?php

function creerConnexion() : PDO {
    return new PDO('mysql:host=mysql-maxencelg.alwaysdata.net;dbname=maxencelg_messup;charset=utf8','maxencelg_user','$iutinfo'); //machine
//    return new PDO('mysql:host=db;dbname=messup;charset=utf8','root','pq04WX11me2005!'); //container docker
}