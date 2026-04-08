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