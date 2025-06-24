<?php

namespace app\controllers\CRM;

use Flight;
use \app\models\SRMmodels\CategorieClientModel;
class CategorieClientController
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

        $categorie_client_liste = new CategorieClientModel(Flight::db());
        $data = ['page' => "CRM/categorie_client_liste", 'categorie_client_liste' => $categorie_client_liste->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $categorie_client_liste = new CategorieClientModel(Flight::db());
        $description = $_POST['description'];

        if (isset($description) && $description != '') {
            $categorie_client_liste->create($description);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Categorie client ajoutée avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'La description ne peut pas être vide!'
            ];
        }

        Flight::redirect('/CRM/categorie-client');
    }
    public function modified()
    {
        $categorie_client_liste = new CategorieClientModel(Flight::db());
        $description = $_POST['description'];
        $id_categorie_client = $_POST['id_categorie'];
        if (isset($description) && $description != '') {
            $categorie_client_liste->update($description, $id_categorie_client);
        } else {
            echo "vide";
        }
        Flight::redirect('/CRM/categorie-client');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_categorie_client'];
        try {
            $categorie_client_liste = new CategorieClientModel(Flight::db());
            $categorie_client_liste->delete($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression du categorie client effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression du categorie client!'
            ];
        }

        Flight::redirect('/CRM/categorie-client');
    }
}