<?php

namespace app\controllers\CRM;

use Flight;
use \app\models\SRMmodels\ListeActionModel;
class ActionController
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

        $liste_action_model = new ListeActionModel(Flight::db());
        $data = ['page' => "CRM/liste_action_liste", 'liste_action_model' => $liste_action_model->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $liste_action_model = new ListeActionModel(Flight::db());
        $description = $_POST['description'];

        if (isset($description) && $description != '') {
            $liste_action_model->create($description);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Action ajoutée avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'La description ne peut pas être vide!'
            ];
        }

        Flight::redirect('/CRM/action');
    }
    public function modified()
    {
        $liste_action_model = new ListeActionModel(Flight::db());
        $description = $_POST['description'];
        $id_action = $_POST['action_id'];
        if (isset($description) && $description != '') {
            $liste_action_model->update($description, $id_action);
        } else {
            echo "vide";
        }
        Flight::redirect('/CRM/action');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_action'];
        try {
            $liste_action_model = new ListeActionModel(Flight::db());
            $liste_action_model->delete($id);
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

        Flight::redirect('/CRM/action');
    }
}