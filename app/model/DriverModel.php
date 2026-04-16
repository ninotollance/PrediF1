<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO;



class DriverModel extends Model {

    protected $table = "DRIVER";

    // toutes les méthodes CRUD sonr héritées de Model
    // getAll(), getById(), create(), update(), delete()

    // Récupère tous les pilotes participant à une course spécifique avec le nom de leur écurie
    public function getDriversByRace($idRace) {
        $query = 'SELECT DRIVER.*, TEAM.name as teamName  -- Sélectionne toutes les colonnes de DRIVER et le nom de l\'écurie
        FROM DRIVER
        JOIN DRIVE_IN ON DRIVER.id = DRIVE_IN.idDriver   -- Joint la table DRIVE_IN pour récupérer les pilotes liés à la course
        JOIN TEAM ON DRIVER.idTeam = TEAM.id              -- Joint la table TEAM pour récupérer le nom de l\'écurie
        WHERE DRIVE_IN.idRace = :idRace';                 // Filtre sur l\'id de la course passé en paramètre
        $stmt = $this->db->prepare($query);               // Prépare la requête (anti-injection SQL)
        $stmt->bindParam(':idRace', $idRace);             // Lie l\'id de la course au paramètre :idRace
        $stmt->execute();                                 // Exécute la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC);         // Retourne tous les pilotes sous forme de tableau associatif
    }

    // Récupère tous les pilotes avec le nom de leur écurie via un JOIN
    public function getAllWithTeam() {
        $query = 'SELECT DRIVER.*, TEAM.name as teamName  -- Sélectionne toutes les colonnes de DRIVER et le nom de l\'écurie
        FROM DRIVER
        JOIN TEAM ON DRIVER.idTeam = TEAM.id              -- Joint la table TEAM sur l\'id de l\'écurie du pilote
        ORDER BY DRIVER.number_api ASC';                  // Trie par numéro de voiture croissant
        $stmt = $this->db->prepare($query);               // Prépare la requête (anti-injection SQL)
        $stmt->execute();                                 // Exécute la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC);         // Retourne tous les pilotes sous forme de tableau associatif

    }
}
    
