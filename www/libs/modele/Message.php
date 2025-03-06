<?php


namespace Message {

    use PDO;

    require_once "{$_SERVER["DOCUMENT_ROOT"]}/../libs/db/connexion.php";

    //créé un nouveau message et le renvoie si aucun problème
    function nouveauMessage(string $message,int $idSalle, string $author){
        $pdo = creerConnexion();

        $query = $pdo -> prepare("INSERT INTO message (content,time,author,idSalle) VALUES (:message,:time,:author,:idSalle)");

        $date = date("Y-m-d H:i:s");

        $query->bindParam(":message",$message);
        $query->bindParam(":time",$date);
        $query->bindParam(":author",$author);
        $query->bindParam(":idSalle",$idSalle);
        $query->execute();

        $id = $pdo->lastInsertId();
        return getMessage($id);
    }

    function getMessage(string $id){
        $pdo = creerConnexion();

        $query = $pdo -> prepare("SELECT * FROM message WHERE idMessage = :id");

        $query->bindParam(":id",$id);
        $query->execute();
        return $query -> fetchAll(PDO::FETCH_ASSOC)[0]["content"];
    }

    function getLastMessages(int $id,int $idSalle): array{
        $pdo = creerConnexion();

        $query = $pdo->prepare("SELECT * FROM 
             (SELECT * FROM message WHERE idSalle = :idSalle AND idMessage > :id ORDER BY idMessage DESC LIMIT 50)
                 AS subquery ORDER BY idMessage ");
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getPreviousMessages(int $id, int $idSalle): array
    {
        $pdo = creerConnexion();

        $query = $pdo->prepare("SELECT * FROM message WHERE idSalle = :idSalle AND idMessage < :id ORDER BY idMessage DESC LIMIT 50");
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}