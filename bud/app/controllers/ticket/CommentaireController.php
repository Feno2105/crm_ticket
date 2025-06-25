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
        $message = [];
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        $commentaireModel = new CommentaireModel(Flight::db());
        $commentaire = $_POST['commentaire'] ?? '';
        $ticket = $_POST['id_ticket'] ?? '';
       

        if (!isset($_POST['id_commentaire'])) {
            
            $this->add($commentaire,$ticket);
        } else {
            $id_com = $_POST['id_commentaire'] ?? '';
            $this->update($commentaire,$ticket);
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
        $ticket = $_POST['id_ticket_produit'] ?? '';
        

        // Validation des champs obligatoires (fichier non inclus)
        if (empty($sujet) || empty($ticket) ) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Veuillez compléter tous les champs obligatoires (sujet, description, priorité)'
            ];
            header('Location: /commentaire');
            exit();
        }
        $ticketModel->create($sujet,$ticket);

        Flight::redirect('/commentaire');
        return;
        Flight::redirect('/commentaire'); // Redirection même en cas d'erreur
        return;
    }


    public function update()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $ticketModel = new CommentaireModel(Flight::db());
        if (isset($_POST['id_commentaire'])) {
            $id = $_POST['id_commentaire'];
            $data = [
                'commentaire' => $_POST['commentaire'],
            ];
    
            // Validation minimale
            if (empty($data['commentaire'])) {
                throw new Exception('Le sujet est obligatoire');
            }
    
            // Mise à jour
            $success = $ticketModel->update($id, $data);
    
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
