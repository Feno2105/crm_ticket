<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\CommentaireModel;
use Flight;

class CommentaireController
{

    public function __construct() {}

    public function entry()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $commentaire = $_POST['commentaire'] ?? '';
    $ticket = $_POST['id_ticket'] ?? ''; // ou id_ticket selon votre formulaire
    
    if (!isset($_POST['id'])) {
        $this->add($commentaire, $ticket);
    } else {
        $id_com = $_POST['id'];
        $this->update();
    }
}

    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ticketModel = new CommentaireModel();

        // Récupération des données du formulaire
        $sujet = $_POST['commentaire'] ?? '';
        $ticket = (int)$_POST['id_ticket'] ?? '';
        

        // Validation des champs obligatoires (fichier non inclus)
        if (empty($sujet) ) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Veuillez compléter tous les champs obligatoires (sujet, description)'
            ];
            header('Location: /commentaire');
            exit();
        }
        $ticketModel->create($sujet,$ticket);

        Flight::redirect('/commentaire');
        return;
       
    }


    public function update()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $ticketModel = new CommentaireModel(Flight::db());
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
           
            $commentaire = (string)$_POST['commentaire'];
            $ticketModel = new CommentaireModel();
            $success = $ticketModel->update($commentaire, $id);
    
            if ($success) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'text' => 'Ticket mis à jour avec succès'   
                ];
            } else {
                throw new Exception('Échec de la mise à jour');
            }
        }
        

        // Préparation des données
      

    } catch (Exception $e) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'text' => 'Erreur: ' . $e->getMessage()
        ];
    }

    Flight::redirect('/commentaire');
}

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id'];
        try {
            $liste_model = new CommentaireModel();
            $liste_model->remove($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression de l\'action effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de l\'action!'
            ];
        }

        Flight::redirect('/commentaire');
    }
}
