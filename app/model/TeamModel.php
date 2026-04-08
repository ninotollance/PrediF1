<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model

class TeamModel extends Model{
    // La table correspondante en BDD
    protected $table = "TEAM";
    // Toutes les méthodes CRUD sont héritées de Model !
    // getAll(), getById(), create(), update(), delete()

}
    /* // Attribut qui stocke la connexion PDO accessible dans toute la classe
    private PDO $db;

    // Récupère la connexion PDO du singleton
    // Pas de paramètre
    // Pas de retour, initialise juste $this->db
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupère une écurie par rapport à son id
    // Paramètre : $idTeam (int) - l'id de l'écurie recherchée
    // Retourne : un tableau associatif avec les infos de l'écurie, ou false si introuvable
    public function getTeamById($idTeam) {
        $query = "SELECT * FROM TEAM WHERE idTeam = :idTeam";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTeam', $idTeam);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupère toutes les écuries
    // Pas de paramètre
    // Retourne : un tableau de tableaux associatifs, chaque ligne = une écurie
    public function getAllTeam() {
        $query = "SELECT * FROM TEAM";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée une nouvelle écurie (Admin uniquement)
    // Paramètres :
    //   $name (string)    - le nom de l'écurie
    //   $country (string) - le pays de l'écurie
    //   $picture (string) - le chemin vers l'image de l'écurie
    // Retourne : true si l'insertion a réussi, false sinon
    public function createTeam($name, $country, $picture) {
        $query = "INSERT INTO TEAM (name, country, picture) VALUES (:name, :country, :picture)"; // Attention : virgule manquante dans l'original entre :country et :picture
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':picture', $picture);
        return $stmt->execute();
    }

    // Met à jour les informations d'une écurie (Admin uniquement)
    // Paramètres :
    //   $idTeam (int)     - l'id de l'écurie à modifier
    //   $name (string)    - le nouveau nom
    //   $country (string) - le nouveau pays
    //   $picture (string) - le nouveau chemin vers l'image
    // Retourne : true si la mise à jour a réussi, false sinon
    public function updateTeam($idTeam, $name, $country, $picture) {
        $query = "UPDATE TEAM SET name = :name, country = :country, picture = :picture 
                  WHERE idTeam = :idTeam";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTeam', $idTeam);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':picture', $picture);
        return $stmt->execute();
    }

    // Supprime une écurie par son id (Admin uniquement)
    // Paramètre : $idTeam (int) - l'id de l'écurie à supprimer
    // Retourne : true si la suppression a réussi, false sinon
    public function deleteTeam($idTeam) {
        $query = "DELETE FROM TEAM WHERE idTeam = :idTeam";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idTeam', $idTeam);
        return $stmt->execute();
    } */
