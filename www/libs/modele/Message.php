<?php


namespace Message {

    use DateTime;
    use PDO;

    function formatDate(string &$dateString): void
    {
        $date = new DateTime($dateString);
        $now = new DateTime();
        $yesterday = (clone $now)->modify('-1 day');

        // Formatting for comparison
        $dateFormat = $date->format('Y-m-d');
        $nowFormat = $now->format('Y-m-d');
        $yesterdayFormat = $yesterday->format('Y-m-d');

        // Handle Today & Yesterday
        if ($dateFormat === $nowFormat) {
            $dateString = "Today at " . $date->format('g:i A');
        } elseif ($dateFormat === $yesterdayFormat) {
            $dateString = "Yesterday at " . $date->format('g:i A');
        } else {

            // Handle other dates
            $day = $date->format('j'); // Day without leading zero
            $month = $date->format('F'); // Full month name
            $year = $date->format('Y'); // Year
            $time = $date->format('g:i A'); // Time in 12-hour format

            // Handle ordinal suffix (1st, 2nd, 3rd, etc.)
            $suffix = date('S', mktime(0, 0, 0, 1, $day));

            $dateString = "{$day}{$suffix} of {$month} {$year} at {$time}";
        }
//    echo $dateString;
    }

    require_once "../../libs/db/connexion.php";

    //créé un nouveau message et le renvoie si aucun problème
    function nouveauMessage(string $message,int $idSalle, string $idUser): array
    {
        $pdo = creerConnexion();

        $query = $pdo -> prepare("INSERT INTO message (content,time,idUser,idSalle) VALUES (:message,:time,:idUser,:idSalle)");

        $date = (new DateTime())->format("Y-m-d H:i:s");

        $query->bindParam(":message",$message);
        $query->bindParam(":time",$date);
        $query->bindParam(":idUser",$idUser);
        $query->bindParam(":idSalle",$idSalle);
        $query->execute();

        $id = $pdo->lastInsertId();
        return getMessage($id,$idSalle);
    }

    function getMessage(string $idMessage, int $idSalle): array
    {
        $pdo = creerConnexion();

        $query = $pdo -> prepare("SELECT content,idMessage,time,username FROM message JOIN users ON users.idUser = message.idUser WHERE idSalle = :idSalle AND idMessage = :idMessage");

        $query->bindParam(":idMessage",$idMessage);
        $query->bindParam(":idSalle",$idSalle);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$value) {
            formatDate($value["time"]);
        }
        return $result;
    }

    function getLastMessages(int $idUser,int $idSalle): array{
        $pdo = creerConnexion();

        $query = $pdo->prepare("SELECT * FROM 
             (SELECT content,idMessage,time,username FROM message JOIN users ON users.idUser = message.idUser WHERE idSalle = :idSalle AND idMessage > :idUser ORDER BY idMessage DESC LIMIT 20)
                 AS subquery ORDER BY idMessage ");
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":idUser", $idUser);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$value) {
            formatDate($value["time"]);
        }
        return $result;
    }

    function getPreviousMessages(int $idMessage, int $idSalle): array
    {
        $pdo = creerConnexion();

        $query = $pdo->prepare("SELECT content,idMessage,time,username FROM message JOIN users ON users.idUser = message.idUser WHERE idSalle = :idSalle AND idMessage < :idMessage ORDER BY idMessage DESC LIMIT 20");
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":idMessage", $idMessage);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$value) {
            formatDate($value["time"]);
        }
        return $result;
    }
}