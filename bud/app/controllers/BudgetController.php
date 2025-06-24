<?php

namespace app\controllers;

use app\models\TypeModel;
use app\models\NatureModel;
use app\models\BudgetModel;
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
        $types = $TypeModel->findAll();
        $liste_previsions = [];
        $liste_realisations = [];
        $liste_categories = [];
        $data = ['page' => "insertBudget",'liste_previsions' => $liste_previsions ,'liste_realisations' => $liste_realisations ,'liste_categories'=>$liste_categories
         ,'natures' => $natures, 'types' => $types];
        Flight::render('template2', $data);
    }
    public function validation()
    {
        $BudgetModel = new BudgetModel(Flight::db());
        $types = $BudgetModel->getAll();
        $data = ['page' => "insertBudget", 'types' => $types];
        Flight::render('template2', $data);
    }
    public function validate()
    {
        $BudgetModel = new BudgetModel(Flight::db());
        $data = array();
        $data[0] = $_GET['id'];
        $BudgetModel->valider($data);
        $budget = $BudgetModel->getAll();
        session_start();
        $rand = rand(1, 15);
        $data2[0]  = $_SESSION['idP'];
        $data2[1] = $rand;
        $data2[2] = $_SESSION['prix'] * $rand;
        $data2[4] = $_SESSION['annee'];
        $idT = 0;
        $bud = $BudgetModel->getById($data);
        $idT = $bud['idT'];

        if ($idT == 5) {
            $VenteModel = new VenteModel(Flight::db());
            for ($i = $_SESSION['mois']; $i < 12; $i++) {
                $data2[3] = $i;
                $VenteModel->insert($data2);
            }
            $data = ['page' => "budget", 'budgets' => $budget];
            Flight::render('template', $data);
        } else {
            $data = ['page' => "budget", 'budgets' => $budget];
            Flight::render('template', $data);
        }
    }
}
