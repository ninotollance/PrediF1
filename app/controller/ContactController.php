<?php

namespace PrediF1\controller;
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

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
        mail($email,htmlspecialchars($_POST['sujet'], ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')); // Néttoyé
        $this->success('Email envoyé avec succès ! Vous recevrez une réponse prochainement.'); // Message de succès
        $this->redirect('accueil');
    }


}
