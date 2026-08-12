<?php

namespace AFPA\Controller;

use AFPA\Entity\Personne;

class PersonneController {

    public function index() {
        global $twig;
        $personnes = Personne::all();
        echo $twig->render("personne/index.html.twig", [
            "title" => "Liste des Personnes",
            "personnes" => $personnes
        ]);
    }

    public function create() {
        global $twig;
        echo $twig->render("personne/create.html.twig", [
            "title" => "Créer une Personne"
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!verifyCSRFToken($token)) {
                die('Token CSRF invalide');
            }
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $email = $_POST['email'] ?? '';
            $gender = $_POST['gender'] ?? '';

            if (!empty($firstname) && !empty($lastname) && !empty($email)) {
                Personne::create($firstname, $lastname, $email, $gender);
                header('Location: ' . $GLOBALS['router']->generate('personne_index'));
                exit;
            }
        }
        // Rediriger en cas d'erreur
        header('Location: ' . $GLOBALS['router']->generate('personne_create'));
        exit;
    }

    public function show($id) {
        global $twig;
        $personne = Personne::find($id);
        if (!$personne) {
            echo "Personne non trouvé";
            return;
        }
        echo $twig->render("personne/show.html.twig", [
            "title" => "Détails du Personne",
            "personne" => $personne
        ]);
    }

    public function edit($id) {
        global $twig;
        $personne = Personne::find($id);
        if (!$personne) {
            echo "personne non trouvé";
            return;
        }
        echo $twig->render("personne/edit.html.twig", [
            "title" => "Éditer le personne",
            "personne" => $personne
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!verifyCSRFToken($token)) {
                die('Token CSRF invalide');
            }
            $nom = $_POST['nom'] ?? '';
            if (!empty($nom)) {
                Personne::update($id, $nom);
                header('Location: ' . $GLOBALS['router']->generate('personne_index'));
                exit;
            }
        }
        // Rediriger en cas d'erreur
        header('Location: ' . $GLOBALS['router']->generate('personne_edit', ['id' => $id]));
        exit;
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!verifyCSRFToken($token)) {
                die('Token CSRF invalide');
            }
            Personne::delete($id);
        }
        header('Location: ' . $GLOBALS['router']->generate('personne_index'));
        exit;
    }
}