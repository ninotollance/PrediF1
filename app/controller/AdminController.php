<?php

namespace PrediF1\controller;
use PrediF1\model\UserModel; // Importe le modèle User pour gérer les données utilisateur
use PrediF1\model\RaceModel; // Importe le modèle Race pour gérer les données utilisateur
use PrediF1\model\DriverModel; // Importe le modèle Driver pour gérer les données utilisateur
use PrediF1\model\TeamModel; // Importe le modèle Team pour gérer les données utilisateur
use PrediF1\model\BetModel; // Importe le modèle Bet pour gérer les données utilisateur
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class AdminController extends Controller {

    private $userModel; // Instance du modèle User
    private $raceModel; // Instance du modèle Race
    private $driverModel; // Instance du modèle Driver
    private $teamModel; // Instance du modèle Team
    private $betModel; // Instance du modèle Bet


    public function __construct() {
        $this->userModel = new UserModel(); // Instancie le modèle User
        $this->raceModel  = new RaceModel(); // Instancie le modèle Race
        $this->driverModel = new DriverModel(); // Instancie le modèle Driver
        $this->teamModel  = new TeamModel(); // Instancie le modèle Team
        $this->betModel   = new BetModel(); // ← ajouter
    }


    // Affiche le dashboard admin
    public function dashboard() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $section = $_GET['section'] ?? 'races'; // Récupère la section ou 'races' par défaut
        try {
            $users = $this->userModel->getAll(); // Tous les utilisateurs
            $races = $this->raceModel->getAll(); // Toutes les courses
            $drivers = $this->driverModel->getAllWithTeam();  // Tous les pilotes
            $teams = $this->teamModel->getAll(); // Toutes les écuries
            $bets = $this->betModel->getAllWithDetails(); // Tous les paris avec infos
            $finishedRaces = array_filter($races, function($r) {
                return $r['status'] === 'finished';
            }); // Filtre les courses terminées pour le formulaire vainqueur
            $finishedRaces = array_values($finishedRaces); // Réindexe le tableau pour éviter les problèmes d'index
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        require RACINE . '/app/view/admin/dashboard.php'; // Affiche la vue dashboard admin
    }


    ////////////////////////////// UTILISATEUR //////////////////////////////

    // Modifie le profil d'un utilisateur (Admin uniquement)
    public function updateUser() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash le mot de passe (jamais stocker en clair !)
        $id = $_GET['id']; // Récupère l'id de l'utilisateur à modifier depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        // Empêche de modifier un autre admin
        try {
            $user = $this->userModel->getById($id);
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        if($user['role'] === 'admin') {
            $this->error('impossible de modifier cet utilisateur');
            $this->redirect('admin');
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->userModel->update($id, [ // Modifie l'utilisateur en BDD
                'email' => $_POST['email'],
                'password' => $hashedPassword,
                'name' => $_POST['name'],
                'firstName' => $_POST['firstname'],
            ]);
            $this->success('Utilisateur modifié avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'users'; // Récupère la section ou 'users' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Supprime un utilisateur (Admin uniquement)
    public function deleteUser() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $id = $_GET['id']; // Récupère l'id de l'utilisateur à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        // Empêche l'admin de se supprimer lui-même
        if($_SESSION['user_id'] === $id) {
            $this->error('Vous ne pouvez pas supprimer votre propre compte');
            $this->redirect('admin');
        }
        // Empêche de supprimer un autre admin
        try {
            $user = $this->userModel->getById($id);
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        if($user['role'] === 'admin') {
            $this->error('impossible de supprimer cet utilisateur');
            $this->redirect('admin');
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->betModel->deleteAllByUser($id); // Supprime d'abord tous les paris de l'utilisateur
            $this->userModel->delete($id); // Supprime l'utilisateur en BDD
            $this->success('Utilisateur supprimé avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_GET['section'] ?? 'users'; // Récupère la section ou 'users' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }
}