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
        $query = "SELECT RACE.*, DRIVER.name as winnerName, DRIVER.firstName as winnerFirstName
        FROM RACE 
        LEFT JOIN DRIVER ON RACE.idWinner = DRIVER.id 
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

    /* // Attribut qui stocke la connexion PDO accessible dans toute la classe
    private PDO $db;

    // Récupère la connexion PDO du singleton
    // Pas de paramètre
    // Pas de retour, initialise juste $this->db
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    } */

    /* // Récupère une course par son id
    // Paramètre : $idRace (int) - l'id de la course recherchée
    // Retourne : un tableau associatif avec les infos de la course, ou false si introuvable
    public function getById($idRace) {
        $query = "SELECT * FROM RACE WHERE idRace = :idRace";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idRace', $idRace);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les courses
    // Pas de paramètre
    // Retourne : un tableau de tableaux associatifs, chaque ligne = une course
    public function getAll() {
        $query = "SELECT * FROM RACE";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée une nouvelle course (Admin uniquement)
    // Paramètres :
    //   $name (string)           - le nom du Grand Prix
    //   $dateRace (datetime)     - la date et l'heure de la course
    //   $country (string)        - le pays où se déroule la course
    //   $circuitKey_api (int)    - l'identifiant du circuit dans l'API F1
    // Retourne : true si l'insertion a réussi, false sinon
    public function create($name, $dateRace, $country, $circuitKey_api) {
        $query = "INSERT INTO RACE (name, dateRace, country, circuitKey_api) 
                  VALUES (:name, :dateRace, :country, :circuitKey_api)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':dateRace', $dateRace);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':circuitKey_api', $circuitKey_api);
        return $stmt->execute();
    }

    // Modifie les informations d'une course (Admin uniquement)
    // Paramètres :
    //   $idRace (int)            - l'id de la course à modifier
    //   $name (string)           - le nouveau nom
    //   $dateRace (datetime)     - la nouvelle date
    //   $country (string)        - le nouveau pays
    //   $circuitKey_api (int)    - le nouvel identifiant API du circuit
    // Retourne : true si la mise à jour a réussi, false sinon
    public function update($idRace, $name, $dateRace, $country, $circuitKey_api) {
        $query = "UPDATE RACE SET name = :name, dateRace = :dateRace, country = :country, 
                  circuitKey_api = :circuitKey_api WHERE idRace = :idRace";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idRace', $idRace);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':dateRace', $dateRace);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':circuitKey_api', $circuitKey_api);
        return $stmt->execute();
    }

    // Supprime une course (Admin uniquement)
    // Paramètre : $idRace (int) - l'id de la course à supprimer
    // Retourne : true si la suppression a réussi, false sinon
    public function delete($idRace) {
        $query = "DELETE FROM RACE WHERE idRace = :idRace";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idRace', $idRace);
        return $stmt->execute();
    } */

