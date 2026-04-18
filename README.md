# PrediF1

Plateforme de paris fictifs sur les courses de Formule 1.
Les utilisateurs peuvent consulter les courses, pilotes et écuries,
et parier sur le vainqueur de chaque Grand Prix.

## Prérequis

- PHP 8.0+
- MySQL 8.0+
- Composer

## Installation

# Cloner le projet
git clone https://github.com/ton-repo/predif1.git

# Installer les dépendances
composer install

## Configuration

# Copier le fichier d'exemple
cp .env.example .env

# Remplir les variables dans .env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=predif1
DB_USER=ton_utilisateur
DB_PASSWORD=ton_mot_de_passe

## Base de données

Importer le script SQL depuis le dossier Ressources :
mysql -u ton_utilisateur -p predif1 < Ressources/F1.sql

## Structure du projet

predif1/
├── app/          # Contrôleurs, Modèles, Vues
├── config/       # Configuration et routing
├── public/       # CSS, JS, images
└── index.php     # Point d'entrée