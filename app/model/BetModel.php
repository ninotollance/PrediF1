<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)

class BetModel extends Model {
    
    protected $table = "BET"; // Nom de la table en BDD

    // Récupère tout les paris par course 
    public function getAllByRace($id) {
        $query = "SELECT BET.id, BET.date_, 
                RACE.name AS nameRace, RACE.country, 
                DRIVER.number_api, DRIVER.name AS nameDriver, DRIVER.firstName 
                FROM BET
                JOIN RACE ON BET.idRace = RACE.id 
                JOIN DRIVER ON BET.idDriver = DRIVER.id
                WHERE BET.idRace = :idRace";        // lie BET à RACE et lie BET à DRIVER et filtre par course
        $stmt = $this->db->prepare($query);         // prépare la requête (anti-injection SQL)
        $stmt->bindParam(':idRace', $id);           // lie l'id de la course
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   // fetchAll car une course peut avoir plusieurs paris
    }

    // Récupère tout les paris par user 
    public function getAllByUser($id) {
        $query = "SELECT BET.id, BET.date_, 
                RACE.name AS nameRace, RACE.country,
                RACE.status, 
                DRIVER.number_api, DRIVER.name AS nameDriver, DRIVER.firstName,
                winDriver.firstName AS winnerFirstName,
                winDriver.name AS winnerName,
                CASE WHEN BET.idDriver = RACE.idWinner THEN 1 ELSE 0 END AS won /* Compare le pilote parié avec le pilote vainqueur */
                FROM BET
                JOIN RACE ON BET.idRace = RACE.id
                JOIN DRIVER ON BET.idDriver = DRIVER.id
                LEFT JOIN DRIVER AS winDriver ON RACE.idWinner = winDriver.id /* vainqueur de la course pariée */
                WHERE BET.idUser = :idUser";        // lie BET à RACE et lie BET à DRIVER et filtre par course
        $stmt = $this->db->prepare($query);         // prépare la requête (anti-injection SQL)
        $stmt->bindParam(':idUser', $id);           // lie l'id du user
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   // fetchAll car un utilisateur peut avoir plusieurs paris
    }

    // Supprime un pari du userA par userA
    public function deleteByUser($id, $idUser) {
        $query = "DELETE FROM BET WHERE BET.id = :id AND BET.idUser = :idUser"; // AND vérifie que le pari appartient à l'utilisateur (sécurité !)
        $stmt = $this->db->prepare($query);     // prépare la requête (anti-injection SQL)
        $stmt->bindParam(':id', $id);           // lie l'id du pari
        $stmt->bindParam(':idUser', $idUser);   // lie l'id de l'utilisateur
        return $stmt->execute();                // exécute, retourne true/false
    }

    // Supprime un pari par l'admin
    public function deleteByAdmin($id) {
        $query = "DELETE FROM BET WHERE BET.id = :id"; // admin peut supprimer n'importe quel pari
        $stmt = $this->db->prepare($query);            // prépare la requête (anti-injection SQL)
        $stmt->bindParam(':id', $id);                  // lie l'id du pari
        return $stmt->execute();                       // exécute, retourne true/false
    }

    // Récupère tous les paris avec les infos utilisateur, course et pilote
    public function getAllWithDetails() {
        $query = "SELECT BET.id, BET.date_,
                USER_.name AS userName, USER_.firstName AS userFirstName,
                RACE.name AS nameRace,
                DRIVER.name AS nameDriver, DRIVER.firstName AS driverFirstName
                FROM BET
                JOIN USER_ ON BET.idUser = USER_.id
                JOIN RACE ON BET.idRace = RACE.id
                JOIN DRIVER ON BET.idDriver = DRIVER.id
                ORDER BY BET.date_ DESC"; // Plus récent en premier
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifie si un utilisateur a déjà parié sur une course
    public function existsByUserAndRace($idUser, $idRace) {
        $query = "SELECT COUNT(*) FROM BET 
                WHERE idUser = :idUser 
                AND idRace = :idRace"; // Compte les paris de cet utilisateur sur cette course
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':idRace', $idRace);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Retourne true si un pari existe déjà
    }
}

    /* // Attribut qui stocke la connexion PDO accessible dans toute la classe
    private PDO $db;

    // Récupère la connexion PDO du singleton
    // Pas de paramètre
    // Pas de retour, initialise juste $this->db
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

     // Récupère un seul pari par son id
    // Paramètre : $idBet (int) - l'id du pari recherché
    // Retourne : un tableau associatif avec les infos du pari, du pilote et de la course associés, ou false si introuvable
    public function getById($idBet) {
        $query = "SELECT BET.idBet, BET.dateBet, 
                         RACE.name AS nameRace, RACE.country, 
                         DRIVER.number_api, DRIVER.name AS nameDriver, DRIVER.firstName 
                  FROM BET
                  JOIN RACE ON BET.idRace = RACE.idRace
                  JOIN DRIVER ON BET.idDriver = DRIVER.idDriver
                  WHERE BET.idBet = :idBet";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idBet', $idBet);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // fetch car on cherche UN seul pari par son id unique
    }

    // Crée un nouveau pari
    // Paramètres :
    //   $idDriver (int) - l'id du pilote sur lequel l'utilisateur parie
    //   $idRace (int)   - l'id de la course concernée
    //   $idUser (int)   - l'id de l'utilisateur qui place le pari
    // Retourne : true si l'insertion a réussi, false sinon
    // Note : la date est automatiquement renseignée avec NOW() au moment de l'insertion
    public function create($idDriver, $idRace, $idUser) {
        $query = "INSERT INTO BET (dateBet, idDriver, idRace, idUser) 
                  VALUES (NOW(), :idDriver, :idRace, :idUser)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idDriver', $idDriver);
        $stmt->bindParam(':idRace', $idRace);
        $stmt->bindParam(':idUser', $idUser);
        return $stmt->execute();
    } */