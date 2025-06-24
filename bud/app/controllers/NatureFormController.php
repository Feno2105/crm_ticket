<?php

namespace app\controllers;

use app\models\CategorieModel;

use app\models\NatureModel;
use Flight;

class NatureFormController
{
    public function __construct()
    {
    }
    public function delete()
    {
        $nature_model = new NatureModel(Flight::db());

        $id = $_GET['id'];
        echo "id : " . $id;
        try {
            $nature_model->delete($id);
            Flight::redirect('/natureList');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function update()
    {
        $nature_model = new NatureModel(Flight::db());
        $id = $_POST['id'];
        $idC = $_POST['idC'];
        echo "idC : " . $idC;
        $libele = $_POST['libele'];

        try {
            $nature_model->update($id, $idC, $libele);
            Flight::redirect('/natureList');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function save()
    {
        $nature_model = new NatureModel(Flight::db());
        $idC = $_POST['idC'];
        $libele = $_POST['libele'];

        try {
            $nature_model->create($idC, $libele);
            echo "enregistrement reussi";
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function formPage()
    {
        $nature_model = new NatureModel(Flight::db());
        $categoriModel = new CategorieModel(Flight::db());
        $categories = $categoriModel->getAll();
        $data = ['page' => "nature/formulaire", 'categories' => $categories];
        if (isset($_GET['id'])) {
            $nature = $nature_model->findById($_GET['id']);
            $data['nature'] = $nature;
        } else {
            $data = ['page' => "nature/formulaire", 'categories' => $categories];
        }
        Flight::render('template2', $data);
    }
    public function listePage()
    {
        $nature_model = new NatureModel(Flight::db());
        try {
            $nature_listes = $nature_model->findAll();
            $data = ['page' => "nature/liste", 'natures' => $nature_listes];

            Flight::render('template2', $data);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
