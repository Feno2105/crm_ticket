<?php

namespace app\controllers;

use app\models\BudgetModel;
use app\models\DepartementModel;
use app\models\EmployerModel;
use Flight;

class EmployerController
{

    public function __construct() {}
    public function login()
    {
        $departementModel = new DepartementModel(Flight::db());
        $departements = $departementModel->getAll();
        $data = ['page' => "loginEmployer", 'departements' => $departements];
        Flight::render('template', $data);
    }
    public function validation()
    {
        $EmployerModel = new EmployerModel(Flight::db());
        $donne = array();
        $donne[0] = $_POST['nom'];
        $donne[1] = $_POST['mdp'];
        $donne[2] = $_POST['departement'];
        if ($Employer = $EmployerModel->getLogin($donne)) {
            $data = ['page' => "welcome", 'employer' => $Employer];
            Flight::render('template2', $data);
        } else {
            $departementModel = new DepartementModel(Flight::db());
            $departements = $departementModel->getAll();
            $data = ['page' => "loginEmployer", 'departements' => $departements];
            Flight::render('template', $data);
        }
    }
    function loginFinance()
    {
        $BudgetModel = new BudgetModel(Flight::db());
        $budget = $BudgetModel->getAll();
        $data = ['page' => "budget", 'budgets' => $budget];
        Flight::render('template', $data);
    }
}
