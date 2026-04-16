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
                WHERE BET.idUser = :idUser 
                ORDER BY BET.date_ DESC";      // lie BET à RACE et lie BET à DRIVER et filtre par course DESC
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

    // Supprime tous les paris d'un utilisateur avant de supprimer son compte
    public function deleteAllByUser($id) {
        $query = "DELETE FROM BET WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUser', $id);
        return $stmt->execute();
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

    