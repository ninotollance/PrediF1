<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)
use PDOException;
use Exception;

class BetModel extends Model {
    
    protected $table = "BET"; // Nom de la table en BDD

    // Récupère tous les paris d'une course avec les infos pilote et course
    public function getAllByRace($id) {
        try {
            $query = "SELECT BET.id, BET.date_, 
                    RACE.name AS nameRace, RACE.country, 
                    DRIVER.number_api, DRIVER.name AS nameDriver, DRIVER.firstName 
                    FROM BET
                    JOIN RACE ON BET.idRace = RACE.id 
                    JOIN DRIVER ON BET.idDriver = DRIVER.id
                    WHERE BET.idRace = :idRace";        // Filtre par course
            $stmt = $this->db->prepare($query);         // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':idRace', $id);           // Lie l'id de la course
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   // fetchAll car une course peut avoir plusieurs paris
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getAllByRace : ' . $e->getMessage());
        }
    }

    // Récupère tous les paris d'un utilisateur avec résultat (gagné/perdu)
    public function getAllByUser($id) {
        try {
            $query = "SELECT BET.id, BET.date_, 
                    RACE.name AS nameRace, RACE.country,
                    RACE.status, 
                    DRIVER.number_api, DRIVER.name AS nameDriver, DRIVER.firstName,
                    winDriver.firstName AS winnerFirstName,
                    winDriver.name AS winnerName,
                    CASE WHEN BET.idDriver = RACE.idWinner THEN 1 ELSE 0 END AS won /* Compare le pilote parié avec le vainqueur */
                    FROM BET
                    JOIN RACE ON BET.idRace = RACE.id
                    JOIN DRIVER ON BET.idDriver = DRIVER.id
                    LEFT JOIN DRIVER AS winDriver ON RACE.idWinner = winDriver.id /* Vainqueur de la course pariée */
                    WHERE BET.idUser = :idUser 
                    ORDER BY BET.date_ DESC";           // Plus récent en premier
            $stmt = $this->db->prepare($query);         // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':idUser', $id);           // Lie l'id du user
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   // fetchAll car un utilisateur peut avoir plusieurs paris
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getAllByUser : ' . $e->getMessage());
        }
    }

    // Supprime un pari en vérifiant qu'il appartient bien à l'utilisateur (sécurité !)
    public function deleteByUser($id, $idUser) {
        try {
            $query = "DELETE FROM BET WHERE BET.id = :id AND BET.idUser = :idUser"; // AND vérifie que le pari appartient à l'utilisateur
            $stmt = $this->db->prepare($query);     // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':id', $id);           // Lie l'id du pari
            $stmt->bindParam(':idUser', $idUser);   // Lie l'id de l'utilisateur
            return $stmt->execute();                // Exécute, retourne true/false
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD deleteByUser : ' . $e->getMessage());
        }
    }

    // Supprime tous les paris d'un utilisateur (utilisé avant la suppression du compte)
    public function deleteAllByUser($id) {
        try {
            $query = "DELETE FROM BET WHERE idUser = :idUser";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUser', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD deleteAllByUser : ' . $e->getMessage());
        }
    }

    // Supprime n'importe quel pari (Admin uniquement)
    public function deleteByAdmin($id) {
        try {
            $query = "DELETE FROM BET WHERE BET.id = :id"; // Admin peut supprimer n'importe quel pari
            $stmt = $this->db->prepare($query);            // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':id', $id);                  // Lie l'id du pari
            return $stmt->execute();                       // Exécute, retourne true/false
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD deleteByAdmin : ' . $e->getMessage());
        }
    }

    // Récupère tous les paris avec les infos utilisateur, course et pilote (Admin)
    public function getAllWithDetails() {
        try {
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
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getAllWithDetails : ' . $e->getMessage());
        }
    }

    // Vérifie si un utilisateur a déjà parié sur une course (évite les doublons)
    public function existsByUserAndRace($idUser, $idRace) {
        try {
            $query = "SELECT COUNT(*) FROM BET 
                    WHERE idUser = :idUser 
                    AND idRace = :idRace"; // Compte les paris de cet utilisateur sur cette course
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->bindParam(':idRace', $idRace);
            $stmt->execute();
            return $stmt->fetchColumn() > 0; // Retourne true si un pari existe déjà
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD existsByUserAndRace : ' . $e->getMessage());
        }
    }
}

    