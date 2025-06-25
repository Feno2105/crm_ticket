<?php

use app\controllers\CRM\ActionController;
use app\controllers\CRM\CategorieClientController;
use app\controllers\CRM\CategorieProduitController;
use app\controllers\CRM\ClientController;
use app\controllers\CRM\ProductController;
use app\controllers\CRM\ReactionController;
use app\controllers\vente\VenteController;
use app\controllers\BudgetController;
use app\controllers\EmployerController;
use app\controllers\NatureFormController;
use app\controllers\TypeFormController;
use app\controllers\ticket\TicketController;
use app\controllers\ticket\NoteController;
use app\controllers\ticket\CommentaireController;
use flight\net\Router;
use flight\Engine;

// use Flight;

/**
 * @var Router $router
 * @var Engine $app
 */
$EmployerController = new EmployerController();

$router->get('/', [$EmployerController, 'login']);


$router->post('/validation', [$EmployerController, 'validation']);

// ========================== NATURE ROUTE =====================
$nature_form_controller = new NatureFormController();

$router->get('/natureForm', [$nature_form_controller, 'formPage']);
$router->get('/natureList', [$nature_form_controller, 'listePage']);

$router->post('/saveNature', [$nature_form_controller, 'save']);
$router->post('/updateNature', [$nature_form_controller, 'update']);
$router->get('/deleteNature', [$nature_form_controller, 'delete']);
//=============================Budget ROUTE =====================
$BudgetController = new BudgetController();
$router->get('/inserer', callback: [$BudgetController, 'entry']);
$router->post('/budget/create-prevision', callback: [$BudgetController, 'createPrevision']);
$router->post('/budget/create-realisation', callback: [$BudgetController, 'createRealisation']);

// ========================== TYPE ROUTE =====================
$type_form_controller = new TypeFormController();

$router->get('/typeForm', [$type_form_controller, 'formPage']);
$router->get('/typeList', [$type_form_controller, 'listePage']);

$router->post("/saveType", [$type_form_controller, 'save']);
$router->post("/updateType", [$type_form_controller, 'update']);
$router->get("/deleteType", [$type_form_controller, 'delete']);
$router->get("/bud", [$BudgetController, 'validate']);

$router->post('/saveType', [$type_form_controller, 'save']);
$router->post('/updateType', [$type_form_controller, 'update']);
$router->get('/deleteType', [$type_form_controller, 'delete']);

$router->group('/finance', function () use ($router) {
    $EmployerController = new EmployerController();
    $router->get('/', [$EmployerController, 'loginFinance']);
});

$router->group('/ticket', function () use ($router) {
    $ticket_controller = new TicketController();
    $router->get('/', [$ticket_controller, 'entry']);
    $router->post('/create', [$ticket_controller, 'add']);
    $router->get('/delete', [$ticket_controller, 'delete']);
    $router->post('/update', [$ticket_controller, 'modified']);
    $router->post('/assigner', [$ticket_controller, 'createAssignement']);
});

//==================commentaire=================
$router->group('/commentaire', function () use ($router) {
    $commentaire_controller = new CommentaireController();
    $note_controller = new NoteController();
    $client_controller = new ClientController();
    $produit_controller = new ProductController();
    $router->get('/', [$client_controller, 'liste']);
    $router->post('/', [$client_controller, 'liste']);
    $router->get('/avis', [$produit_controller, 'liste_ticket']);
    $router->post('/avis', [$produit_controller, 'liste_ticket']);
    $router->get('/evaluation', [$commentaire_controller, 'entry']);
    $router->post('/evaluation', [$commentaire_controller, 'entry']);
});

$router->group('/dashboard', function () use ($router) {
    $product_controller = new ProductController();
    $router->get('/', [$product_controller, 'getDahsboard']);
    $router->get('/crm', [$product_controller, 'setCRM']);
    $router->post('/', [$product_controller, 'getDahsboard']);
    $router->post('/ajoutcrm', [$product_controller, 'addCRM']);
});
$router->group('/vente', function () use ($router) {
    $vente_product = new VenteController();
    $router->get('/', [$vente_product, 'index']);
    $router->post('/index', [$vente_product, 'add']);
});

$router->group('/CRM', function () use ($router) {
    $action_controller = new ActionController();
    $reaction_controller = new ReactionController();
    $categorie_produit_controller = new CategorieProduitController();
    $categorie_client_controller = new CategorieClientController();
    $client_controller = new ClientController();
    $product_controller = new ProductController();

    $router->get('/action', [$action_controller, 'index']);
    $router->post('/add-action', [$action_controller, 'add']);
    $router->post('/update-action', [$action_controller, 'modified']);
    $router->get('/delete-action', [$action_controller, 'delete']);

    $router->get('/reaction', [$reaction_controller, 'index']);
    $router->post('/add-reaction', [$reaction_controller, 'add']);
    $router->post('/update-reaction', [$reaction_controller, 'modified']);
    $router->get('/delete-reaction', [$reaction_controller, 'delete']);

    $router->get('/categorie-produit', [$categorie_produit_controller, 'index']);
    $router->post('/add-categorie-produit', [$categorie_produit_controller, 'add']);
    $router->post('/update-categorie-produit', [$categorie_produit_controller, 'modified']);
    $router->get('/delete-categorie-produit', [$categorie_produit_controller, 'delete']);

    $router->get('/categorie-client', [$categorie_client_controller, 'index']);
    $router->post('/add-categorie-client', [$categorie_client_controller, 'add']);
    $router->post('/update-categorie-client', [$categorie_client_controller, 'modified']);
    $router->get('/delete-categorie-client', [$categorie_client_controller, 'delete']);

    $router->get('/client', [$client_controller, 'index']);
    $router->post('/add-client', [$client_controller, 'add']);
    $router->post('/update-client', [$client_controller, 'modified']);
    $router->get('/delete-client', [$client_controller, 'delete']);

    $router->get('/product', [$product_controller, 'index']);
    $router->post('/add-product', [$product_controller, 'add']);
    $router->post('/update-product', [$product_controller, 'modified']);
    $router->get('/delete-product', [$product_controller, 'delete']);
});
