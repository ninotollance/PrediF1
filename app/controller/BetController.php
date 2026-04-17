<?php

namespace PrediF1\controller;
use PrediF1\model\BetModel; // Importe le modèle Bet pour gérer les paris
use PrediF1\model\RaceModel; // Importe le modèle Race pour vérifier les dates
use PrediF1\model\DriverModel; // Importe le modèle Driver pour gérer les paris
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)
use DateTime;

class BetController extends Controller {

    private $betModel; // Instance du modèle Bet
    private $raceModel; // Instance du modèle Race
    private $driverModel; // Instance du modèle Driver


    public function __construct() {
        $this->betModel = new BetModel(); // Instancie le modèle Bet
        $this->raceModel = new RaceModel(); // Instancie le modèle RAce
        $this->driverModel = new DriverModel(); // Instancie le modèle Driver
    }
    

    // Crée un pari (Admin uniquement)
    public function createByAdmin() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $id = $_POST['idUser'];
        if(!is_numeric($id)) {      // ← Vérifie que c'est un nombre
            $this->redirect('admin');
        }
        $id = (int)$id;
        try {
            $this->betModel->create([ // Crée le pari en BDD
                'date_' => date('Y-m-d H:i:s'), // Date automatique du pari
                'idRace' => $_POST['idRace'], // Id de la course
                'idDriver' => $_POST['idDriver'], // Id du pilote parié
                'idUser' => $id, // Id de l'utilisateur concerné
            ]);
            $this->success('Pari créé avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'bets'; // Récupère la section ou 'bets' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Supprime un pari (Admin uniquement)
    public function deleteByAdmin() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $id = $_GET['id']; // Récupère l'id du pari à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->betModel->delete($id); // Supprime le pari en BDD
            $this->success('Pari supprimé avec succès !'); // Message de succès
        } catch (Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_GET['section'] ?? 'bets'; // Récupère la section ou 'bets' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Crée un pari (Utilisateur connecté)
    public function createByUser() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('creer-pari'); // Redirige vers la route 'creer-pari'
        }
        $idRace = $_POST['idRace'];
        if(!is_numeric($idRace)) { // Vérifie que c'est bien un nombre
            $this->redirect('accueil');
        }
        $idRace = (int)$idRace; // Convertit en entier
        try {
            $race = $this->raceModel->getById($idRace); // Récupère la course par son id
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        if(!$race) { // Si la course n'existe pas en BDD (getById() retourne false si aucun résultat)
            $this->error('Course introuvable'); // Message d'erreur pour l'utilisateur
            $this->redirect('accueil'); // Redirige vers l'accueil et arrête l'exécution
        }
        // Si la course n'est pas disponible aux paris (terminée ou annulée)
        if($race['status'] === 'cancelled' || $race['status'] === 'finished') {
            $this->error('Cette course n\'est pas disponible aux paris');
            $this->redirect('accueil');
        }
        $now = new DateTime(); // Date et heure actuelles
        $start = new DateTime($race['raceStart']); // Date de début de la course
        if($now >= $start) {
            $this->error('Paris clos, La course a dejà commencée');
            $this->redirect('accueil'); // Redirige vers la route 'accueil'
        }
        try {
            $alreadyBet = $this->betModel->existsByUserAndRace($_SESSION['user_id'], $idRace);
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }

        if($alreadyBet) { // Si un pari existe déjà
            $this->error('Vous avez déjà parié sur cette course !');
            $this->redirect('courses'); // Redirige vers les courses
        }
        try {
            $this->betModel->create([ // Crée le pari en BDD
                'date_' => date('Y-m-d H:i:s'), // Date automatique du pari
                'idRace' => $idRace, // Id de la course
                'idDriver' => $_POST['idDriver'], // Id du pilote parié
                'idUser' => $_SESSION['user_id'], // Id de l'utilisateur concerné
            ]);
            $this->success('Pari placé avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('historique-paris'); // Redirige vers la route 'historique-paris'
    }

    // Supprime un pari (Utilisateur connecté)
    public function deleteByUser() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        $id = $_GET['id']; // Récupère l'id du pari à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('historique-paris'); // Redirige vers la route 'historique-paris' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->betModel->deleteByUser($id, $_SESSION['user_id']); // Supprime le pari en vérifiant qu'il appartient à l'utilisateur connecté
            $this->success('Pari supprimé avec succès !'); // Message de succès // Message de succès
        } catch (Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('historique-paris'); // Redirige vers la route 'historique-paris'
    }

    // Affiche le formulaire de pari pour une course donnée (Utilisateur connecté uniquement)
    public function showBet() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        $idRace = $_GET['idRace']; // Récupère l'id de la course depuis l'URL
        if(!is_numeric($idRace)) { // Vérifie que l'id est bien un nombre
            $this->redirect('accueil'); // Redirige vers l'accueil si l'id est invalide
        }
        $idRace = (int)$idRace; // Convertit en entier pour sécuriser
        try {
            $race = $this->raceModel->getById($idRace); // Récupère la course en BDD par son id
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        
        if(!$race) { // Si la course n'existe pas en BDD
            $this->error('Course introuvable'); // Message d'erreur pour l'utilisateur
            $this->redirect('accueil'); // Redirige vers l'accueil
        }
        $this->setTitle('Parier sur ' . $race['name'] . ' - PrediF1');
        // Si la course n'est pas disponible aux paris (terminée ou annulée)
        if($race['status'] === 'cancelled' || $race['status'] === 'finished') {
            $this->error('Cette course n\'est pas disponible aux paris');
            $this->redirect('accueil');
        }
        $now = new DateTime(); // Date et heure actuelles
        $start = new DateTime($race['raceStart']); // Date de début de la course depuis la BDD
        if($now >= $start) { // Si la course a déjà commencé
            $this->error('Paris clos, la course a déjà commencé'); // Message d'erreur
            $this->redirect('accueil'); // Redirige vers l'accueil et arrête l'exécution
        }
        try {
            $drivers = $this->driverModel->getDriversByRace($idRace); // Récupère tous les pilotes participant à cette course
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        require RACINE . "/app/view/layout/header.php"; // Charge le header commun
        require RACINE . "/app/view/user/bet.php"; // Charge la vue pari ($race et $drivers disponibles)
        require RACINE . "/app/view/layout/footer.php"; // Charge le footer commun
    }

    
}