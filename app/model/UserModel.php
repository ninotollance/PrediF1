<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)

class UserModel extends Model {
    
    protected $table = "USER_";

    // Retourne un utilisateur par son email (utilisé pour la connexion)
    public function getByEmail($email) {
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindParam(':email', $email); // Lie l'email saisi dans le formulaire
        $stmt->execute(); // Exécute
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur ou false si introuvable
}

}
    /* 
    // Attribut qui stocke la connexion PDO accessible dans toute la classe
    private PDO $db;

    // Récupère la connexion PDO du singleton
    // Pas de paramètre
    // Pas de retour, initialise juste $this->db
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Crée un nouvel utilisateur
    // Paramètres :
    //   $email (string)     - l'email du nouvel utilisateur
    //   $password (string)  - le mot de passe en clair (sera hashé avant insertion)
    //   $name (string)      - le nom de famille
    //   $firstName (string) - le prénom
    // Retourne : true si l'insertion a réussi, false sinon
    public function createUser($email, $password, $name, $firstName) {
        $query = "INSERT INTO USER_ (email, password, name, firstName, role) 
                  VALUES (:email, :password, :name, :firstName, 'user')";
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash le mot de passe, jamais stocker en clair
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':firstName', $firstName); // Attention : respecter la casse du paramètre
        return $stmt->execute();
    }

    // Met à jour les informations d'un utilisateur
    // Paramètres :
    //   $email (string)     - le nouvel email
    //   $name (string)      - le nouveau nom
    //   $firstName (string) - le nouveau prénom
    //   $idUser (int)       - l'id de l'utilisateur à modifier
    // Retourne : true si la mise à jour a réussi, false sinon
    public function updateUser($email, $name, $firstName, $idUser) {
        $query = "UPDATE USER_ SET email = :email, name = :name, firstName = :firstName 
                  WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':firstName', $firstName); // Attention : respecter la casse du paramètre
        $stmt->bindParam(':idUser', $idUser);
        return $stmt->execute();
    }

    // Supprime un utilisateur par son id
    // Paramètre : $idUser (int) - l'id de l'utilisateur à supprimer
    // Retourne : true si la suppression a réussi, false sinon
    public function deleteUser($idUser) {
        $query = "DELETE FROM USER_ WHERE idUser = :idUser";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUser', $idUser); // Le paramètre doit correspondre exactement à celui de la requête
        return $stmt->execute();
    }
    

    // Retourne tous les utilisateurs (utilisé par l'admin)
    // Pas de paramètre
    // Retourne : un tableau de tableaux associatifs, chaque ligne = un utilisateur
    public function getAll() {
        $query = "SELECT * FROM USER_";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } */
