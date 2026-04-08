<?php

namespace PrediF1\controller;
use PrediF1\model\UserModel; // Importe le modèle User pour gérer les données utilisateur
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class AuthController extends Controller {

    private $userModel; // Instance du modèle User

    public function __construct() {
        $this->userModel = new UserModel(); // Instancie le modèle User
    }

    // Affiche le formulaire de connexion
    public function showLogin() {
        if(!empty($_SESSION['user_logged'])) { // Si l'utilisateur est déjà connecté
            $this->redirect('accueil'); // Redirige vers la route 'accueil'
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/login.php"; // Affiche le formulaire de connexion
        require RACINE . "/app/view/layout/footer.php";
    }

    // Connecte l'utilisateur avec son email et mot de passe
    public function login() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . "/app/view/user/login.php"; // Affiche le formulaire de connexion
            return; // Arrête la fonction
        }
        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Cherche l'utilisateur en BDD par son email
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        if(!$user) { // Si l'email n'existe pas en BDD
            $this->error('Email ou mot de passe incorrects'); // Message d'erreur
            return; // Arrête la fonction
        }
        if(password_verify($_POST['password'], $user['password'])) { // Vérifie le mot de passe avec le hash en BDD
            $_SESSION['user_logged'] = true; // Marque l'utilisateur comme connecté
            $_SESSION['user_id'] = $user['id']; // Stocke l'id en session
            $_SESSION['user_role'] = $user['role']; // Stocke le rôle en session (user/admin)
            $_SESSION['user_email'] = $_POST['email']; // Stocke l'email en session
            if($_SESSION['user_role'] === 'admin') {
                $this->redirect('admin'); // ← admin → dashboard
            } else {
                $this->redirect('accueil'); // ← user → accueil
            }
        } else {
            $this->error('Email ou mot de passe incorrects'); // Message d'erreur
        }
    }

    // Affiche le formulaire d'inscription
    public function showRegister() {
        if(!empty($_SESSION['user_logged'])) { // Si l'utilisateur est déjà connecté
            $this->redirect('accueil'); // Redirige vers la route 'accueil'
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/register.php"; // Affiche le formulaire d'inscription
        require RACINE . "/app/view/layout/footer.php";
    }

    // Inscrit un nouvel utilisateur
    public function register() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . '/app/view/user/register.php'; // Affiche le formulaire
            return; // Arrête la fonction
        }
        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Vérifie si l'email existe déjà en BDD
        } catch(Exception $e) {
            $this->error($e);
            return; // Arrête la fonction
        }
        if($user) { // Si l'email existe déjà
            $this->error('Email déjà existant'); // Message d'erreur
            return; // Arrête la fonction
        }
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash le mot de passe (jamais stocker en clair !)
        try {
            $this->userModel->create([ // Crée l'utilisateur en BDD
                'email' => $_POST['email'],
                'password' => $hashedPassword,
                'name' => $_POST['name'],
                'firstName' => $_POST['firstname'],
                'role' => 'user', // Rôle par défaut
            ]);
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Récupère le nouvel utilisateur en BDD
            $_SESSION['user_logged'] = true; // Marque l'utilisateur comme connecté
            $_SESSION['user_id'] = $user['id']; // Stocke l'id en session
            $_SESSION['user_role'] = $user['role']; // Stocke le rôle en session (user/admin)
            $_SESSION['user_email'] = $_POST['email']; // Stocke l'email en session
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('accueil'); // Redirige vers la route 'accueil'
    }

    // Déconnecte l'utilisateur et détruit la session
    public function logout() {
        $_SESSION = []; // Vide toutes les variables de session
        session_destroy(); // Détruit la session
        $this->redirect('accueil'); // Redirige vers la route 'accueil'
    }
}