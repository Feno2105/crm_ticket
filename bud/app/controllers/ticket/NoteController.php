<?php

namespace app\controllers\ticket;

use Exception;
use app\models\Ticket\NoteModel;
use Flight;

class NoteController
{

    public function __construct() {}

    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ticketModel = new NoteModel();

        // Récupération des données du formulaire
        $sujet = $_POST['note'] ?? '';
        $ticket = $_POST['id_tiket'] ?? '';
        

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
        $ticketModel = new NoteModel(Flight::db());
        $id = $_POST['id'];

        // Préparation des données
        $data = [
            'note' => $_POST['note'],
        ];

        // Validation minimale
        if (empty($data['note'])) {
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
            $liste_model = new NoteModel();
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
