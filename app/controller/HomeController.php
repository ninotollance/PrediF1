<?php
 
namespace PrediF1\controller;
use PrediF1\model\RaceModel; // Importe le modèle Race
use Exception;
 
class HomeController extends Controller {

    private $raceModel;

    public function __construct(){
        $this->raceModel = new RaceModel(); // Instancie le modèle Race
    }
 
    // Affiche la page d'accueil
    public function index() {
        try {
            $nextRace = $this->raceModel->getNextRace();// Récupère la prochaine course à venir (date future la plus proche)
            $lastRace = $this->raceModel->getLastRace(); // Récupère la dernière course passée avec le nom du vainqueur
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        
        require RACINE . "/app/view/layout/header.php"; // Charge le header
        require RACINE . "/app/view/user/home.php"; // Charge la vue accueil
        require RACINE . "/app/view/layout/footer.php"; // Charge le footer
    }
}