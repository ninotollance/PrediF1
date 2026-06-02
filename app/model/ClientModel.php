<?php

namespace TestCDA\model; // Déclare que cette classe appartient au namespace TestCDA\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)
use PDOException;
use Exception;

class ClientModel extends Model {

    protected $table = "CLIENT";

    // Retourne les clients correspondant au nom recherché
    public function getByName($name) {
        try {
            $query = "SELECT * FROM $this->table WHERE name = :name";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erreur BDD getByName : ' . $e->getMessage());
        }
    }

}