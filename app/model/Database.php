<?php

namespace PrediF1\model; // Déclare que cette classe appartient au namespace PrediF1\model
use PDO; // Nécessaire car on utilise PDO::PARAM_INT, PDO::FETCH_ASSOC (obligatoire avec les namespace)
use PDOException;
use Exception;


class Database {
    
    // L'instance est stockée dans une propriété statique
    // elle persiste pendant toute l'exécution du script
    private static ?Database $instance = null;
    private PDO $connection;

    // Constructeur privé : empêche l'instanciation directe
    // Pas de paramètre
    // Crée la connexion PDO avec les variables d'environnement
    private function __construct(){
        try {
            $this->connection = new PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD']
            );
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données");
        }
    }

    // Méthode statique pour récupérer l'instance unique
    // Pas de paramètre
    // Retourne : l'instance unique de Database (la crée si elle n'existe pas encore)
    public static function getInstance(): Database {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Accéder à la connexion PDO
    // Pas de paramètre
    // Retourne : l'objet PDO qui permet de faire des requêtes SQL
    public function getConnection(): PDO {
        return $this->connection;
    }
}