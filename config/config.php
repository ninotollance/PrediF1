<?php
// ============================================================
// PREDIF1 - Configuration Globale
// ============================================================

// --- Racine du projet ---

define('RACINE', __DIR__ . '/..'); // Pointe vers le dossier PrediF1/

// Charge les variables d'environnement du fichier .env dans $_ENV
require_once RACINE . '/vendor/autoload.php'; 
$dotenv = Dotenv\Dotenv::createImmutable(RACINE);
$dotenv->load();   

// Génère un token CSRF unique par session s'il n'existe pas encore
// bin2hex() convertit des octets aléatoires en chaîne hexadécimale lisible
// random_bytes(32) génère 32 octets cryptographiquement sécurisés → 64 caractères hex
if(empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/helpers.php';