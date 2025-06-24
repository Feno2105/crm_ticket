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
        $liste_previsions = [];
        $liste_realisations = [];
        $liste_types = $TypeModel->findAll();
        $data = ['page' => "insertBudget",'liste_previsions' => $liste_previsions ,'liste_realisations' => $liste_realisations ,'liste_types'=>$liste_types
         ,'natures' => $natures];
        Flight::render('template2', $data);
    }
    public function createPrevision()
    {
        $previsionModel = new BudgetModel();
        $data = Flight::request()->data->getData();
        $id_dept = "1"; // Assuming id_dept is 1 for this example, you might want to change this based on your logic
        $id = $previsionModel->createPrev($data,$id_dept); // Assuming id_dept is 1 for this example
        if ($id) {
            Flight::redirect('/inserer');
        } else {
            Flight::render('error', ['message' => 'Erreur lors de la création de la prévision']);
        }
    }
}
