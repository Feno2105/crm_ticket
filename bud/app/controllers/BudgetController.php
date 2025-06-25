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
        }
        else {
            $liste_previsions = $budgetModel->getByDeptPrev($_SESSION['idD']);
            $liste_realisations = $budgetModel->getRealByDept($_SESSION['idD']);
        }
        $liste_types = $TypeModel->findAll();
        $data = ['page' => "insertBudget",'liste_previsions' => $liste_previsions ,'liste_realisations' => $liste_realisations ,'liste_types'=>$liste_types
         ,'natures' => $natures];
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
    
    $realisationModel = new BudgetModel();
    $value = $realisationModel->getByPrev((int)$data['id_prevision']);
    if (!empty($value)) {
        
    if ($value[0]['valeur'] < $data['valeur']) {
         $_SESSION['flash_error'] = "La valeur de la réalisation ne peut pas dépasser la valeur de la prévision.";
         Flight::redirect('/inserer');
         return;
     }
     
     $success = $realisationModel->create($data);
     if ($success) {
         $_SESSION['flash_success'] = "Réalisation enregistrée avec succès.";
         $montant = $value[0]['valeur'] - $data['valeur'];
         $data2 = [
             'id_dept' => (string)$_POST['id_dept'] ,
             'valeur'  => (string) $montant ,
             'prevision_id' => (string)$_POST['prevision_id'],
             'mois'    => (string)$_POST['mois'] ,
             'annee'   => (string)$_POST['annee'] ,
             'realisation'  => (string)$success 
         ];
         // Ensure $data2 values are not null before calling saveEcar
         $realisationModel->saveEcart($data2);
         }
         Flight::redirect('/inserer');
    
    } else {
        $_SESSION['flash_error'] = "Aucune prévision trouvée pour l'ID donné.";
        Flight::redirect('/inserer');
         return;
    }
}
}

