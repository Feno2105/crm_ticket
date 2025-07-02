<?php

namespace app\controllers;

use app\models\BudgetModel;
use app\models\TypeModel;
use app\models\NatureModel;
use Flight;
use app\models\SRMmodels\VenteModel;

class BudgetController
{

    public function __construct() {}
    public function entry()
    {
        $natureModel = new NatureModel(Flight::db());
        $natures = $natureModel->findAll();
        $TypeModel = new TypeModel(Flight::db());
        $budgetModel = new BudgetModel(Flight::db());
        if (session_status() === PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['idD'])) {
            Flight::redirect('/');
            return;
        }
        if($_SESSION['idD'] == 1){
            $liste_previsions = $budgetModel->getAllPrev();
            $liste_realisations = $budgetModel->getAll();
            $ecarts = $budgetModel->getAllEcart();
        }
        else {
            $liste_previsions = $budgetModel->getByDeptPrev($_SESSION['idD']);
            $liste_realisations = $budgetModel->getRealByDept($_SESSION['idD']);
        }
        
        $liste_types = $TypeModel->findAll();
        $data = ['page' => "insertBudget",'liste_previsions' => $liste_previsions ,'liste_realisations' => $liste_realisations ,'liste_types'=>$liste_types
         ,'natures' => $natures, 'ecarts' => $ecarts];
        Flight::render('template2', $data);
    }

    public function createPrevision() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['idD'])) {
        Flight::redirect('/');
        return;
    }
    $data = [
        'id_dept' => $_SESSION['idD'],
        'valeur'  => (string)$_POST['valeur'],
        'type'    => (string)$_POST['type'],
        'mois'    => (string)$_POST['mois'],
        'annee'   => (string)$_POST['annee'],
        'propos'  => (string)$_POST['propos']
    ];

    $previsionModel = new BudgetModel();
    $success = $previsionModel->createPrev($data);

    if ($success) {
        Flight::redirect('/inserer');
        $_SESSION['flash_success'] = "Prévision enregistrée avec succès.";
    } else {
     $_SESSION['flash_error'] = "Erreur lors de l'enregistrement de la prévision.";
    }
}
 public function createRealisation() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['idD'])) {
        Flight::redirect('/');
        return;
    }
    
    $data = [
        'id_dept' => (string)$_POST['id_dept'],
        'valeur'  => (string)$_POST['valeur'],
        'id_prevision' => (string)$_POST['prevision_id'],
        'mois'    => (string)$_POST['mois'],
        'annee'   => (string)$_POST['annee'],
        'propos'  => (string)$_POST['propos']
    ];
    
    $value_prevision = (new BudgetModel())->getByPrev($data['id_prevision']);
    if (empty($value_prevision)) {
        Flight::redirect('/');
        return;
    }
    $budgetModel = new BudgetModel();
    $existingEcart = $budgetModel->getEcartByIdPrevision($data['id_prevision']);
    $montant = !empty($existingEcart) ? (string)$existingEcart['valeur']  : (string)$value_prevision[0]['valeur'] ;

    if ((int)$montant < (int)$data['valeur']) {
      Flight::redirect('/');
        return;
    }
    $success = $budgetModel->createRealisation($data);
    if ($success) {
        $_SESSION['flash_success'] = "Réalisation enregistrée avec succès.";
            $data2 = [
                'id_dept' => (string)$_POST['id_dept'],
                'valeur'  => (string)($montant - $data['valeur']),
                'prevision_id' => (string)$_POST['prevision_id'],
                'mois'    => (string)$_POST['mois'],
                'annee'   => (string)$_POST['annee'],
                'realisation'  => (string)$success
            ];
            $budgetModel->saveEcart($data2);
    }
    else{
    Flight::redirect('/');
    return;
    }
    Flight::redirect('/inserer');
}
}

