<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model

use PDO;

class RaceModel extends Model {

    protected $table = "RACE";

    // Ajoute le vainqueur d'une course après qu'elle se soit déroulée (Admin uniquement)
    // Séparé de update() car le vainqueur n'est connu qu'après la course
    // Paramètres :
    //   $idRace (int)    - l'id de la course concernée
    //   $idWinner (int)  - l'id du pilote vainqueur (clé étrangère vers DRIVER)
    // Retourne : true si la mise à jour a réussi, false sinon
    public function addWinner(int $id, int $idWinner) {
        $query = "UPDATE RACE SET idWinner = :idWinner WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idWinner', $idWinner);
        return $stmt->execute();
    }

    public function getNextRace() {
        $query = "SELECT * FROM RACE 
        WHERE raceStart > NOW() 
        ORDER BY raceStart ASC 
        LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastRace() {
        $query = "SELECT RACE.*, DRIVER.name as winnerName, DRIVER.firstName as winnerFirstName, TEAM.name as teamName
        FROM RACE 
        LEFT JOIN DRIVER ON RACE.idWinner = DRIVER.id
        LEFT JOIN TEAM ON DRIVER.idTeam = TEAM.id 
        WHERE RACE.raceStart < NOW()
        ORDER BY RACE.raceStart DESC
        LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllWithWinner() {
        $query = 'SELECT RACE.*, DRIVER.name as winnerName, DRIVER.firstName as winnerFirstName
        FROM RACE
        LEFT JOIN DRIVER ON RACE.idWinner = DRIVER.id
        ORDER BY RACE.gpStart ASC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

    