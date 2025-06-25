<?php

namespace app\controllers\CRM;

use app\models\SRMmodels\CategorieProduitModel;
use app\models\SRMmodels\ProductModel;
use app\models\SRMmodels\VenteModel;
use app\models\SRMmodels\ListeReactionModel;
use app\models\SRMmodels\ClientModel;
use app\models\BudgetModel;

use Flight;

class ProductController
{
    private $liste_action_model;
    public function __construct() {}
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

        $products = new ProductModel(Flight::db());
        $product_categories = new CategorieProduitModel(Flight::db());
        $data = ['page' => "CRM/product", 'products' => $products->findAll(), 'product_categories' => $product_categories->findAll(), 'message' => $message];
        Flight::render('template2', $data);
    }
    public function getDahsboard()
    {
        $productsController = new ProductModel(Flight::db());
        $products = $productsController->findAll();
        if (isset($_POST['annee'])) {
            $data = array();
            $data[0] = $_POST['annee'];
            $VenteModel = new VenteModel(Flight::db());
            $moinsVendue = $VenteModel->findLast($data);
            $plusVendue = $VenteModel->findFirst($data);
            $quantite_products = array();
            if (isset($_POST['product'])) {
                $name = $productsController->findNameById($_POST['product']);
                $data2 = array();
                $data2[0] = $_POST['product'];
                $data2[1] = $_POST['annee'];
                for ($i = 1; $i <= 12; $i++) {
                    $data2[2] = $i;
                    $quantite_products[$i - 1] = $VenteModel->getQuantity($data2);
                }
                $ventes = array_map(function ($item) {
                    return (int) $item['total_vendue'];
                }, $quantite_products);
                $data = ['page' => "dash/dashboard", 'products' => $products, 'moinsVendues' => $moinsVendue, "plusVendues" => $plusVendue, 'quantity' => $ventes, 'name' => $name];
                Flight::render('template2', $data);
            } else {
                $data = ['page' => "dash/dashboard", 'products' => $products, 'moinsVendues' => $moinsVendue, "plusVendues" => $plusVendue];
                Flight::render('template2', $data);
            }
        } else {
            $data = ['page' => "dash/dashboard", 'products' => $products];
            Flight::render('template2', $data);
        }
    }
    public function setCRM()
    {
        $id = $_GET['id'];
        session_start();
        $_SESSION['idP'] = $id;
        $productsModel = new ProductModel(Flight::db());
        $products = $productsModel->findById($id);
        $reactionController = new ListeReactionModel(Flight::db());
        $reactions = $reactionController->findAll();
        $data = ['page' => "dash/ajoutcrm", 'products' => $products, 'reactions' => $reactions];
        Flight::render('template2', $data);
    }
    public function addCRM()
    {
        $productsController = new ProductModel(Flight::db());
        $products = $productsController->findAll();
        $data = array();
        session_start();
        $_SESSION['prix'] = $_POST['prix'];
        $_SESSION['annee'] = $_POST['annee'];
        $_SESSION['mois'] = $_POST['mois'];

        $data[0] = $_SESSION['idP'];
        $data[1] = $_POST['crm'];
        $data[2] = $_POST['prix'];
        $data[3] = $_POST['mois'];
        $data[4] = $_POST['annee'];

        $productsController->insertCRM($data);

        $BudgetModel = new BudgetModel(Flight::db());


        $data3 = array();
        $data3[0] = 1;
        $data3[1] = 5;
        $data3[2] = 4;
        $data3[3] = $_POST['prix'];
        $data3[4] = $_POST['prix'];

        $BudgetModel->insert($data3);

        $data = ['page' => "dash/dashboard", 'products' => $products];
        Flight::render('template2', $data);
    }
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $products = new ProductModel(Flight::db());
        $name = $_POST['name'];
        $marque = $_POST['marque'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];
        if (!isset($name) || $name == '' || !isset($marque) || $marque == '' || !isset($marque) || $marque == '' || $prix < 0 || !isset($prix) || $prix == '') {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Veillez completez tous les donnees!'
            ];
            echo "donner non complet";
        } else {
            $products->create($name, $marque, $prix, $id_categorie);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Produit ajoutée avec succès!'
            ];
            echo "donner complet";
        }

        Flight::redirect('/CRM/product');
    }
    public function modified()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $products = new ProductModel(Flight::db());
        $name = $_POST['name'];
        $marque = $_POST['marque'];
        $prix = $_POST['prix'];
        $id_categorie = $_POST['id_categorie'];
        $id_product = $_POST['id_produit'];
        if (isset($name) && $name != '') {
            $products->update($name, $marque, $prix, $id_categorie, $id_product);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Modification du produit reussi avec succès!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Au moin ajouter son nom!'
            ];
        }

        Flight::redirect('/CRM/product');
    }
    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_GET['id_produit'];
        try {
            $products = new ProductModel(Flight::db());
            $products->delete($id);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Suppression du produit effectuéee avec succès!'
            ];
        } catch (\Throwable $th) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => 'Erreur lors de la suppression de l\'action!'
            ];
        }

        Flight::redirect('/CRM/product');
    }
    public function liste_ticket()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = [];
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']); 
        }
    
        $client = $_GET['client_id'];
        $product = new ProductModel(Flight::db());
        $products_data= $product->findbyTicket($client);
    
        // Il manque ceci :
        $clients = (new ClientModel(Flight::db()))->findAll();
    
        $product_categories = new CategorieProduitModel(Flight::db());
    
        $data = [
            'page' => "ticket/commentaire",
            'products' => $products_data,
            'product_categories' => $product_categories->findAll(),
            'message' => $message,
            'clients' => $clients, // nécessaire pour la vue
        ];
        Flight::render('template2', $data);
    }
    
}
