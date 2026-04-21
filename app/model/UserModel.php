<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)
use PDOException;
use Exception;

class UserModel extends Model {
    
    protected $table = "USER_";

    // Retourne un utilisateur par son email (utilisé pour la connexion)
    public function getByEmail($email) {
        try {
            $query = "SELECT * FROM $this->table WHERE email = :email";
            $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
            $stmt->bindParam(':email', $email); // Lie l'email saisi dans le formulaire
            $stmt->execute(); // Exécute
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'utilisateur ou false si introuvable
        } catch (PDOException $e) {
            // PDOException = erreur spécifique à la BDD (connexion, requête mal formée...)
            // On relance en Exception générique pour que le contrôleur puisse la catch
            throw new Exception('Erreur BDD getByEmail : ' . $e->getMessage());
        }
    }

}
    
