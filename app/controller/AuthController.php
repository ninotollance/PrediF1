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
        $this->setTitle('Connexion - PrediF1');
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
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Cherche l'utilisateur en BDD par son email
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        if(!$user) { // Si l'email n'existe pas en BDD
            $this->error('Email ou mot de passe incorrects'); // Stocke l'erreur en session
            $_SESSION['form_email'] = $_POST['email']; // Stocke l'email en session
            $this->redirect('connexion'); // Redirige → plus de POST en mémoire
            return;
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
            $this->error('Email ou mot de passe incorrects'); // Stocke l'erreur en session
            $_SESSION['form_email'] = $_POST['email']; // Stocke l'email en session
            $this->redirect('connexion'); // remplacer les require par ça
            return;
        }
    }

    // Affiche le formulaire d'inscription
    public function showRegister() {
        $this->setTitle('Inscription - PrediF1');
        if(!empty($_SESSION['user_logged'])) { // Si l'utilisateur est déjà connecté
            $this->redirect('accueil'); // Redirige vers la route 'accueil'
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/register.php"; // Affiche le formulaire d'inscription
        require RACINE . "/app/view/layout/footer.php";
    }

    // Inscrit un nouvel utilisateur
    public function register() {
        $this->setTitle('Inscription - PrediF1');
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/user/register.php';
            require RACINE . '/app/view/layout/footer.php';
            return;
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire

        // Initialise le tableau d'erreurs
        $errors = [];

        // Vérifie que les champs ne sont pas vides
        if(empty($_POST['name'])) $errors['name'] = 'Nom requis';
        if(empty($_POST['firstname'])) $errors['firstname'] = 'Prénom requis';

        // Vérifie l'email
        if(empty($_POST['email'])) {
            $errors['email'] = 'Email requis';
        } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide';
        }

        // Vérifie le mot de passe
        if(empty($_POST['password'])) {
            $errors['password'] = 'Mot de passe requis';
        } elseif(strlen($_POST['password']) < 8) {
            $errors['password'] = 'Minimum 8 caractères';
        }

        // Si erreurs → réaffiche le formulaire avec les erreurs
        if(!empty($errors)) {
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/user/register.php'; // $errors disponible dans la vue
            require RACINE . '/app/view/layout/footer.php';
            return;
        }

        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Vérifie si l'email existe déjà en BDD
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        if($user) { // Si l'email existe déjà
            $this->formError('Email déjà existant'); // Message d'erreur
            $this->redirect('connexion'); // ← l'utilisateur existe déjà, on le redirige vers la connexion
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