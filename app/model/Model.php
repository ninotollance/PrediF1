<?php 

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)

abstract class Model {
    
    protected $table;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Récupère un enregistrement par son id
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id"; // La requête SQL est juste une string
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id pour le WHERE
        $stmt->execute(); // exécute
        return $stmt->fetch(PDO::FETCH_ASSOC); // retourne le résultat
    }

    // Récupère tous les enregistrements de la table
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);  // Prépare la requête (anti-injection SQL)
        $stmt->execute(); // exécute
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retourne le résultat
    }
    
    // Insère un nouvel enregistrement dans la table
    public function create(array $data) {
        $columns = implode(', ', array_keys($data)); // array_keys() récupère uniquement les clés du tableau → ['email', 'name', '...']
        $params = implode(',', array_map(fn($col) => ":$col", array_keys($data))); // array_map() transforme chaque clé en paramètre préparé en ajoutant ':' devant
        $query = "INSERT INTO $this->table ($columns) VALUES ($params)"; // "INSERT INTO table du model (email, name, ...) VALUES (:email, :name, :...)"
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        return $stmt->execute($data); // Lie $data et exécute, retourne true/false
    }

    // Supprime un enregistrement par son id
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id"; // La requête SQL est juste une string
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id pour le WHERE
        return $stmt->execute(); // exécute, retourne true/false
        
    }

    // Modifie un enregistrement par son id
    public function update(int $id, array $data) {
        $set = implode(',', array_map(fn($col) => "$col = :$col", array_keys($data))); // Construit "email = :email, name = :name" à partir des clés de $data
        $query = "UPDATE $this->table SET $set WHERE id = :id"; // Construit la requête UPDATE avec le SET dynamique à partir de la variable $set
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id pour le WHERE
        return $stmt->execute($data); // Lie $data et exécute, retourne true/false
    }


}
