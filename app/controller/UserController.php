<?php

namespace PrediF1\controller;
use PrediF1\model\UserModel; // Importe le modèle User pour gérer les données utilisateur
use PrediF1\model\BetModel; // Importe le modèle Bet pour gérer les paris
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class UserController extends Controller {

    private $userModel; // Instance du modèle User
    private $betModel; // Instance du modèle Bet

    public function __construct() {
        $this->userModel = new UserModel(); // Instancie le modèle User
        $this->betModel = new BetModel(); // Instancie le modèle Bet
    }

    // Affiche le profil de l'utilisateur connecté
    public function profile() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        try {
            $user = $this->userModel->getById($_SESSION['user_id']); // Récupère les infos de l'utilisateur connecté via son id en session
            $bets = $this->betModel->getAllByUser($_SESSION['user_id']);
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $totalBets = count($bets); 
        $wonBets = count(array_filter($bets, fn($bet) => $bet['won'] === 1));
        require RACINE . "/app/view/layout/header.php";
        require RACINE . '/app/view/user/profile.php'; // Affiche la vue profil avec les données
        require RACINE . "/app/view/layout/footer.php";
    }

    // Modifie le profil utilisateur
    public function update() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . '/app/view/user/profile.php'; // Affiche le formulaire
            return; // Arrête la fonction
        }
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash le mot de passe (jamais stocker en clair !)
        try {
            $this->userModel->update($_SESSION['user_id'], [ // Modifie l'utilisateur en BDD via son id en session
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'firstName' => $_POST['firstname'],
            ]);
            $this->success('Profil modifié avec succès !'); // Message de succès
        } catch(Exception $e) {
            error_log($e->getMessage()); // ← log l'erreur
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('profil'); // Redirige vers la route 'profil'
    }

    // Supprime le compte de l'utilisateur connecté
    public function deleteUser() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        try {
            $this->userModel->delete($_SESSION['user_id']); // Supprime l'utilisateur en BDD via son id en session
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $_SESSION = []; // Vide toutes les variables de session
        session_destroy(); // Détruit la session
        $this->redirect('accueil'); // Redirige vers la route 'accueil'
    }

    // Affiche l'historique des paris de l'utilisateur connecté
    public function betHistory() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        try {
            $bets = $this->betModel->getAllByUser($_SESSION['user_id']); // Récupère tous les paris de l'utilisateur connecté
        } catch (Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $totalBets = count($bets); // Compte le nombre total de paris de l'utilisateur
        $wonBets = count(array_filter($bets, fn($bet) => $bet['won'] === 1)); // Compte uniquement les paris gagnés (won === 1 signifie que le pilote parié est le vainqueur)
        require RACINE . "/app/view/layout/header.php";
        require RACINE . '/app/view/user/betHistory.php'; // Affiche la vue historique des paris
        require RACINE . "/app/view/layout/footer.php";
    }
}