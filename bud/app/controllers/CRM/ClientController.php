<?php

namespace app\controllers\CRM;

use app\models\SRMmodels\CategorieClientModel;
use app\models\SRMmodels\ClientModel;
use Flight;
use \app\models\SRMmodels\ListeActionModel;
class ClientController
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

        $clients = new ClientModel(Flight::db());
        $client_categories = new CategorieClientModel(Flight::db());
        $data = ['page' => "CRM/client", 'clients' => $clients->findAll(), 'client_categories' => $client_categories->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $clients = new ClientModel(Flight::db());
        $name = $_POST['name'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $id_categorie = $_POST['id_categorie'];
        if (isset($name) && $name != '') {
            $clients->create($name, $email, $tel, $id_categorie);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Action ajoutée avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Au moin ajouter son nom!'
            ];
        }

        Flight::redirect('/CRM/client');
    }
    public function modified()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $clients = new ClientModel(Flight::db());
        $name = $_POST['name'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $id_categorie = $_POST['id_categorie'];
        $id_client = $_POST['id_client'];
        if (isset($name) && $name != '') {
            $clients->update($name, $email, $tel, $id_categorie, $id_client);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Modification du client reussi avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Au moin ajouter son nom!'
            ];
        }

        Flight::redirect('/CRM/client');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_client'];
        try {
            $clients = new ClientModel(Flight::db());
            $clients->delete($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression du client effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de l\'action!'
            ];
        }

        Flight::redirect('/CRM/client');
    }
    public function liste(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = [];
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']); // Important: supprimer le message après l'avoir récupéré
        }
        $clients = new ClientModel(Flight::db());
        $clients->findAll();
        $data = ['page' => "ticket/commentaire", 'clients' => $clients->findAll(),  'message' => $message];
        Flight::render('template2', $data);
    }

    public function avis(){
        
    }
}