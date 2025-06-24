<?php

namespace app\controllers\CRM;

use Flight;
use \app\models\SRMmodels\ListeReactionModel;
class ReactionController
{
    private $liste_action_model;
    public function __construct()
    {
    }
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = [];
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']); // Important: supprimer le message après l'avoir récupéré
        }

        $liste_reaction_model = new ListeReactionModel(Flight::db());
        $data = ['page' => "CRM/liste_reaction_liste", 'liste_reaction_model' => $liste_reaction_model->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $liste_reaction_model = new ListeReactionModel(Flight::db());
        $description = $_POST['description'];
        $type_reaction = $_POST['type_reaction'];

        if (isset($description) && $description != '' && isset($type_reaction) && $type_reaction != '') {
            $liste_reaction_model->create($description, $type_reaction);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Reaction ajoutée avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Veillez completer les donnees'
            ];
        }

        Flight::redirect('/CRM/reaction');
    }
    public function modified()
    {
        $liste_reaction_model = new ListeReactionModel(Flight::db());
        $description = $_POST['description'];
        $type_reaction = $_POST['type_reaction'];
        $id_reaction = $_POST['reaction_id'];

        if (!isset($description) || $description == '' || !isset($type_reaction) || $type_reaction == '') {

        } else {
            $liste_reaction_model->update($description, $type_reaction, $id_reaction);
        }
        Flight::redirect('/CRM/reaction');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_reaction'];
        try {
            $liste_reaction_model = new ListeReactionModel(Flight::db());
            $liste_reaction_model->delete($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression de l\'reaction effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de la reaction!'
            ];
        }

        Flight::redirect('/CRM/reaction');
    }
}