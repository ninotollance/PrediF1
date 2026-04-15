<?php

namespace PrediF1\controller;

class ContactController extends Controller {

    public function show() {
        require RACINE . "/app/view/layout/header.php";
        require RACINE . '/app/view/user/contact.php';
        require RACINE . "/app/view/layout/footer.php";

    }

    public function send() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('contact');
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
