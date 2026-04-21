<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO;
use PDOException;
use Exception;

class DriverModel extends Model {

    protected $table = "DRIVER";

    // toutes les méthodes CRUD sont héritées de Model
    // getAll(), getById(), create(), update(), delete()

    // Récupère tous les pilotes participant à une course spécifique avec le nom de leur écurie
    public function getDriversByRace($idRace) {
        try {
            $query = 'SELECT DRIVER.*, TEAM.name as teamName
            FROM DRIVER
            JOIN DRIVE_IN ON DRIVER.id = DRIVE_IN.idDriver   -- Joint DRIVE_IN pour récupérer les pilotes liés à la course
            JOIN TEAM ON DRIVER.idTeam = TEAM.id              -- Joint TEAM pour récupérer le nom de l\'écurie
            WHERE DRIVE_IN.idRace = :idRace';                 // Filtre sur l'id de la course passé en paramètre
            $stmt = $this->db->prepare($query);               // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':idRace', $idRace);             // Lie l'id de la course au paramètre :idRace
            $stmt->execute();                                 // Exécute la requête
            return $stmt->fetchAll(PDO::FETCH_ASSOC);         // Retourne tous les pilotes sous forme de tableau associatif
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getDriversByRace : ' . $e->getMessage());
        }
    }

    // Récupère tous les pilotes avec le nom de leur écurie via un JOIN
    public function getAllWithTeam() {
        try {
            $query = 'SELECT DRIVER.*, TEAM.name as teamName
            FROM DRIVER
            JOIN TEAM ON DRIVER.idTeam = TEAM.id              -- Joint TEAM sur l\'id de l\'écurie du pilote
            ORDER BY DRIVER.number_api ASC';                  // Trie par numéro de voiture croissant
            $stmt = $this->db->prepare($query);               // Prépare la requête (anti-injection SQL)
            $stmt->execute();                                 // Exécute la requête
            return $stmt->fetchAll(PDO::FETCH_ASSOC);         // Retourne tous les pilotes sous forme de tableau associatif
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getAllWithTeam : ' . $e->getMessage());
        }
    }
}
    
