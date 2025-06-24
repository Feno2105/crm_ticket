<?php

namespace app\controllers\vente;

use app\models\SRMmodels\ClientModel;
use app\models\SRMmodels\ProductModel;
use app\models\vente\VenteModel;
use DateTime;
use Exception;
use Flight;
use \app\models\SRMmodels\ListeActionModel;

class VenteController
{
    private $liste_action_model;

    public function __construct() {}

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = [];

        $product_model = new ProductModel(Flight::db());
        $client_model = new ClientModel(Flight::db());

        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);  // Important: supprimer le message après l'avoir récupéré
        }
        try {
            $data = [
                'page' => 'vente/index',
                'message' => $message,
                'products' => $product_model->findAll(),
                'clients' => $client_model->findAll()
            ];
            Flight::render('template2', $data);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $vente_model = new VenteModel(Flight::db());

        try {
            // Récupérer et valider les données
            $client_id = $_POST['id_client'] ?? null;
            $sale_date = $_POST['sale_date'] ?? null;
            $products_json = $_POST['products_json'] ?? '[]';
            $products = json_decode($products_json, true);

            // Validation des données
            if (empty($client_id)) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'text' => 'Client non sélectionné'
                ];
                Flight::redirect('/vente/');
            }

            if (empty($sale_date)) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'text' => 'Date non spécifiée'
                ];
                Flight::redirect('/vente/');
            }

            if (empty($products)) {
                $_SESSION['flash_message'] = [
                    'type' => 'error',
                    'text' => 'Aucun produit sélectionné'
                ];
                Flight::redirect('/vente/');
            }

            // Extraire mois et année de la date
            $dateObj = new DateTime($sale_date);
            $mois = $dateObj->format('m');
            $annee = $dateObj->format('Y');

            // Commencer une transaction
            Flight::db()->beginTransaction();

            foreach ($products as $product) {
                // Valider chaque produit
                if (empty($product['id']) || empty($product['quantity']) || empty($product['totalPrice'])) {
                    $_SESSION['flash_message'] = [
                        'type' => 'error',
                        'text' => 'Données produit invalides'
                    ];
                    Flight::redirect('/vente/');
                }

                // Appeler la méthode create du modèle pour chaque produit
                $vente_model->create(
                    $client_id,
                    $product['id'],
                    $product['quantity'],
                    $product['totalPrice'],
                    $mois,
                    $annee
                );
            }

            // Valider la transaction si tout s'est bien passé
            Flight::db()->commit();
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Vente ajoutée avec succès!'
            ];
            // Message de succès et redirection
            Flight::redirect('/vente/');
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            if ( Flight::db()->inTransaction()) {
                Flight::db()->rollBack();
            }

            // Gérer l'erreur
            $_SESSION['flash_error'] = "Erreur lors de l'enregistrement : " . $e->getMessage();
            Flight::redirect('/vente/');
        }
    }
}
