<?php

namespace TestCDA\controller;
use TestCDA\model\UserModel; // Importe le modèle User pour gérer les données utilisateur
use TestCDA\model\ClientModel; // Importe le modèle Client pour l'export au logout
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class AuthController extends Controller {

    private $userModel; // Instance du modèle User
    private $clientModel; // Instance du modèle Client

    public function __construct() {
        $this->userModel = new UserModel(); // Instancie le modèle User
        $this->clientModel = new ClientModel(); // Instancie le modèle Client
    }


    // Affiche le formulaire de connexion
    public function showLogin() {
        $this->setTitle('Connexion - TestCDA');
        if(!empty($_SESSION['user_logged'])) { // Si l'utilisateur est déjà connecté
            $this->redirect('home'); // Redirige vers la route 'home'
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/login.php";
        require RACINE . "/app/view/layout/footer.php";
    }

    // Connecte l'utilisateur avec son email et mot de passe
    public function login() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . "/app/view/user/login.php";
            return;
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Cherche l'utilisateur par email
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        if(!$user) { // Si l'email n'existe pas en BDD
            $this->error('Email ou mot de passe incorrects');
            $_SESSION['form_email'] = $_POST['email'];
            $this->redirect('login');
            return;
        }
        if(password_verify($_POST['password'], $user['password'])) { // Vérifie le mot de passe
            $_SESSION['user_logged'] = true; // Marque l'utilisateur comme connecté
            $_SESSION['user_id'] = $user['id']; // Stocke l'id en session
            $_SESSION['user_role'] = $user['role']; // Stocke le rôle en session
            $_SESSION['user_email'] = $_POST['email']; // Stocke l'email en session
            if($_SESSION['user_role'] === 'admin') {
                $this->redirect('admin');
            } else {
                $this->redirect('home');
            }
        } else {
            $this->error('Email ou mot de passe incorrects');
            $_SESSION['form_email'] = $_POST['email'];
            $this->redirect('login');
            return;
        }
    }

    // Affiche le formulaire d'inscription
    public function showRegister() {
        $this->setTitle('Inscription - TestCDA');
        if(!empty($_SESSION['user_logged'])) { // Si l'utilisateur est déjà connecté
            $this->redirect('home');
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/register.php";
        require RACINE . "/app/view/layout/footer.php";
    }

    // Inscrit un nouvel utilisateur
    public function register() {
        $this->setTitle('Inscription - TestCDA');
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/user/register.php';
            require RACINE . '/app/view/layout/footer.php';
            return;
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire

        $errors = []; // Initialise le tableau d'erreurs

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
            require RACINE . '/app/view/user/register.php';
            require RACINE . '/app/view/layout/footer.php';
            return;
        }

        try {
            $user = $this->userModel->getByEmail($_POST['email']); // Vérifie si l'email existe déjà
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        if($user) { // Si l'email existe déjà
            $this->formError('Email déjà existant');
            $this->redirect('login');
            return;
        }
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash le mot de passe
        try {
            $this->userModel->create([
                'email' => $_POST['email'],
                'password' => $hashedPassword,
                'name' => $_POST['name'],
                'firstName' => $_POST['firstname'],
                'role' => 'user', // Rôle par défaut
            ]);
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        $this->success('Inscription réussie ! Connectez-vous.');
        $this->redirect('login');
    }

    // Exporte les clients puis déconnecte l'utilisateur et détruit la session
    public function logout() {
        try {
            $clients = $this->clientModel->getAll(); // Récupère tous les clients
            foreach($clients as $c) { // Boucle sur chaque client et ajoute une ligne CSV
                $content .= '"'.$c['id'].'","'.$c['name'].'","'.$c['firstName'].'","'.$c['phone'].'","'.$c['address'].'","'.$c['zipCode'].'","'.$c['city'].'"'."\n";
            }
            file_put_contents(RACINE . '/Data/data.dat', $content); // Écrit dans le fichier
        } catch(Exception $e) {
            error_log($e->getMessage()); // Log l'erreur sans bloquer la déconnexion
        }
        $_SESSION = []; // Vide toutes les variables de session
        session_destroy(); // Détruit la session
        $this->redirect('home');
    }
}