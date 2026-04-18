<?php 

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)

abstract class Model {
    
    protected $table;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupère un enregistrement par son id
     * @param int $id - l'id de l'enregistrement recherché
     * @return array|false - tableau associatif ou false si introuvable
     */
    public function getById($id) {
        $query = "SELECT * FROM $this->table WHERE id = :id"; // La requête SQL est juste une string
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id pour le WHERE
        $stmt->execute(); // exécute
        return $stmt->fetch(PDO::FETCH_ASSOC); // retourne le résultat
    }

    /**
     * Récupère tout les enregistrement 
     * @return array - tableau associatif ou false si introuvable
     */
    public function getAll() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($query);  // Prépare la requête (anti-injection SQL)
        $stmt->execute(); // exécute
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // retourne le résultat
    }

    /**
     * Insère un nouvel enregistrement dans la table 
     * @param array $data - tableau associatif des colonnes et valeurs à insérer
     * @return bool - true si l'insertion a réussi, false sinon
     */ 
    public function create(array $data) {
        // Nettoie chaque valeur — supprime les espaces et balises HTML avant insertion
        foreach($data as $col => $value) {
            if(is_string($value)) { // Nettoie uniquement les chaînes, pas les entiers
                $data[$col] = trim(strip_tags($value));
            }
        }
        $columns = implode(', ', array_keys($data)); // array_keys() récupère uniquement les clés du tableau → ['email', 'name', '...']
        $params = implode(', ', array_map(function($col) { return ':' . $col; }, array_keys($data))); // Transforme chaque clé en paramètre préparé → [':email', ':name', '...']
        $query = "INSERT INTO $this->table ($columns) VALUES ($params)"; // "INSERT INTO table du model (email, name, ...) VALUES (:email, :name, :...)"
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        return $stmt->execute($data); // Lie $data et exécute, retourne true/false
    }

    /**
     * Supprime un enregistrement par son id
     * @param int $id - l'id de l'enregistrement recherché
     * @return bool - true si la suppression a réussi, false sinon
     */ 
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = :id"; // La requête SQL est juste une string
        $stmt = $this->db->prepare($query); // Prépare la requête (anti-injection SQL)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id pour le WHERE
        return $stmt->execute(); // exécute, retourne true/false
        
    }

    /**
     * Modifie un enregistrement par son id
     * @param int $id - l'id de l'enregistrement recherché
     * @param array $data - tableau associatif des colonnes et valeurs à modifier
     * @return bool - true si la modification a réussi, false sinon
     */  
    public function update(int $id, array $data) {
        // Nettoie chaque valeur — supprime les espaces et balises HTML avant modification
        foreach($data as $col => $value) {
            if(is_string($value)) { // Nettoie uniquement les chaînes, pas les entiers
                $data[$col] = trim(strip_tags($value));
            }
        }

        $setParts = array(); // Tableau pour stocker les parties du SET
        foreach(array_keys($data) as $col) {
            $setParts[] = "$col = :$col"; // Construit "colonne = :colonne"
        }
        $set = implode(', ', $setParts); // Joint avec des virgules
        $query = "UPDATE $this->table SET $set WHERE id = :id";
        $stmt = $this->db->prepare($query);
        foreach($data as $col => $value) {
            $stmt->bindValue(':' . $col, $value); // Lie chaque paramètre
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Lie l'id séparément
        return $stmt->execute();
    }


}
