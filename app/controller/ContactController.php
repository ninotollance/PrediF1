<?php

namespace PrediF1\controller;

class ContactController extends Controller {

    public function show() {
        $this->setTitle('Contact - PrediF1');
        require RACINE . "/app/view/layout/header.php";
        require RACINE . '/app/view/user/contact.php';
        require RACINE . "/app/view/layout/footer.php";

    }

    public function send() {
        
        // tableau des erreurs vide
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('contact');
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        // Si le champ firstname est vide → on ajoute une erreur pour ce champ
        if(empty($_POST['firstName'])) {
            $errors['firstName'] = 'Prénom requis';
        }
        // Si le champ name est vide → on ajoute une erreur pour ce champ
        if(empty($_POST['name'])) {
            $errors['name'] = 'Nom requis';
        }
        if(empty($_POST['sujet'])) {
            $errors['sujet'] = 'Sujet requis';
        }
        
        // Vérifier filter_var seulement si l'email n'est pas vide
        if(empty($_POST['email'])) {
            $errors['email'] = 'Email requis';
        } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide';
        }
        // Si le message est trop court ou trop long → on ajoute une erreur
        if(empty($_POST['message'])) {
            $errors['message'] = 'Message requis';
        } elseif (strlen($_POST['message']) < 10 || strlen($_POST['message']) > 1000) {
            $errors['message'] = 'Message entre 10 et 1000 caractères';
        }

        if(!empty($errors)) {
            // Il y a des erreurs → réafficher le formulaire
            $this->setTitle('Contact - PrediF1');
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/user/contact.php'; // $errors est disponible dans la vue !
            require RACINE . '/app/view/layout/footer.php';
            return;
        }

        $email = 'contact@predif1.com';
        $contenu = "De : " . htmlspecialchars($_POST['firstName'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') . "\n";
        $contenu .= "Email : " . htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') . "\n";
        $contenu .= "Message : " . htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') ;
        mail($email,htmlspecialchars($_POST['sujet'], ENT_QUOTES, 'UTF-8'),
            $contenu); // Néttoyé
        $this->success('Email envoyé avec succès ! Vous recevrez une réponse prochainement.'); // Message de succès
        $this->redirect('accueil');
    }


}
