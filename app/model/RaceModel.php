<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO;
use PDOException;
use Exception;

class RaceModel extends Model {

    protected $table = "RACE";

    // Ajoute le vainqueur d'une course après qu'elle se soit déroulée (Admin uniquement)
    // Séparé de update() car le vainqueur n'est connu qu'après la course
    public function addWinner(int $id, int $idWinner) {
        try {
            $query = "UPDATE RACE SET idWinner = :idWinner WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':idWinner', $idWinner);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD addWinner : ' . $e->getMessage());
        }
    }

    // Récupère la prochaine course à venir (date future la plus proche)
    public function getNextRace() {
        try {
            $query = "SELECT * FROM RACE 
            WHERE raceStart > NOW() 
            ORDER BY raceStart ASC 
            LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getNextRace : ' . $e->getMessage());
        }
    }

    // Récupère la dernière course passée avec le nom du vainqueur
    public function getLastRace() {
        try {
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
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getLastRace : ' . $e->getMessage());
        }
    }

    // Récupère toutes les courses avec le nom du vainqueur via un JOIN
    public function getAllWithWinner() {
        try {
            $query = 'SELECT RACE.*, DRIVER.name as winnerName, DRIVER.firstName as winnerFirstName
            FROM RACE
            LEFT JOIN DRIVER ON RACE.idWinner = DRIVER.id
            ORDER BY RACE.gpStart ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getAllWithWinner : ' . $e->getMessage());
        }
    }

}

    