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
    // Attribut qui stocke la connexion PDO accessible dans toute la classe
   /*  private PDO $db;

    // Récupère la connexion PDO du singleton
    // Pas de paramètre
    // Pas de retour, initialise juste $this->db
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupère un pilote par son id
    // Paramètre : $idDriver (int) - l'id du pilote recherché
    // Retourne : un tableau associatif avec les infos du pilote, ou false si introuvable
    public function getById($idDriver) {
        $query = "SELECT * FROM DRIVER WHERE idDriver = :idDriver";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idDriver', $idDriver);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère tous les pilotes
    // Pas de paramètre
    // Retourne : un tableau de tableaux associatifs, chaque ligne = un pilote
    public function getAll() {
        $query = "SELECT * FROM DRIVER";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée un nouveau pilote (Admin uniquement)
    // Paramètres :
    //   $name (string)       - le nom de famille du pilote
    //   $firstName (string)  - le prénom du pilote
    //   $number_api (int)    - le numéro du pilote dans l'API F1
    //   $picture (string)    - le chemin vers la photo du pilote
    //   $idTeam (int)        - l'id de l'écurie à laquelle appartient le pilote (clé étrangère vers TEAM)
    // Retourne : true si l'insertion a réussi, false sinon
    public function create($name, $firstName, $number_api, $picture, $idTeam) {
        $query = "INSERT INTO DRIVER (name, firstName, number_api, picture, idTeam) 
                  VALUES (:name, :firstName, :number_api, :picture, :idTeam)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':number_api', $number_api);
        $stmt->bindParam(':picture', $picture);
        $stmt->bindParam(':idTeam', $idTeam);
        return $stmt->execute();
    }

    // Modifie les informations d'un pilote (Admin uniquement)
    // Paramètres :
    //   $idDriver (int)      - l'id du pilote à modifier
    //   $name (string)       - le nouveau nom
    //   $firstName (string)  - le nouveau prénom
    //   $number_api (int)    - le nouveau numéro API
    //   $picture (string)    - le nouveau chemin vers la photo
    // Retourne : true si la mise à jour a réussi, false sinon
    public function update($idDriver, $name, $firstName, $number_api, $picture) {
        $query = "UPDATE DRIVER SET name = :name, firstName = :firstName, number_api = :number_api, 
                  picture = :picture WHERE idDriver = :idDriver";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idDriver', $idDriver);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':number_api', $number_api);
        $stmt->bindParam(':picture', $picture);
        return $stmt->execute();
    }

    // Supprime un pilote (Admin uniquement)
    // Paramètre : $idDriver (int) - l'id du pilote à supprimer
    // Retourne : true si la suppression a réussi, false sinon
    public function delete($idDriver) {
        $query = "DELETE FROM DRIVER WHERE idDriver = :idDriver";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idDriver', $idDriver);
        return $stmt->execute();
    } */
