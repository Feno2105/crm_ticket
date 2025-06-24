<?php

namespace app\controllers\CRM;

use Flight;
use \app\models\SRMmodels\CategorieProduitModel;
class CategorieProduitController
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

        $categorie_produit_liste = new CategorieProduitModel(Flight::db());
        $data = ['page' => "CRM/categorie_produit_liste", 'categorie_produit_liste' => $categorie_produit_liste->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $categorie_produit_liste = new CategorieProduitModel(Flight::db());
        $description = $_POST['description'];

        if (isset($description) && $description != '') {
            $categorie_produit_liste->create($description);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Categorie produit ajoutée avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'La description ne peut pas être vide!'
            ];
        }

        Flight::redirect('/CRM/categorie-produit');
    }
    public function modified()
    {
        $categorie_produit_liste = new CategorieProduitModel(Flight::db());
        $description = $_POST['description'];
        $id_categorie_produit = $_POST['id_categorie'];
        if (isset($description) && $description != '') {
            $categorie_produit_liste->update($description, $id_categorie_produit);
        } else {
            echo "vide";
        }
        Flight::redirect('/CRM/categorie-produit');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_categorie_produit'];
        try {
            $categorie_produit_liste = new CategorieProduitModel(Flight::db());
            $categorie_produit_liste->delete($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression du categorie produit effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression du categorie produit!'
            ];
        }

        Flight::redirect('/CRM/categorie-produit');
    }
}