<?php

namespace app\controllers;

use app\models\TypeModel;
use app\models\CategorieModel;
use Flight;

class TypeFormController
{
    public function __construct()
    {
    }
    public function delete()
    {
        $type_model = new TypeModel(Flight::db());

        $id = $_GET['id'];
        echo "id : " . $id;
        try {
            $type_model->delete($id);
            Flight::redirect('/typeList');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function update()
    {
        $type_model = new TypeModel(Flight::db());
        $id = $_POST['id'];
        $idC = $_POST['idC'];
        echo "idC : " . $idC;
        $libele = $_POST['libele'];

        try {
            $type_model->update($id, $idC, $libele);
            Flight::redirect('/typeList');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function save()
    {
        $type_model = new TypeModel(Flight::db());
        $idC = $_POST['idC'];
        $libele = $_POST['libele'];

        try {
            $type_model->create($idC, $libele);
            Flight::redirect('/formList');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function formPage()
    {
        $type_model = new TypeModel(Flight::db());
        $categoriModel = new CategorieModel(Flight::db());
        $categories = $categoriModel->getAll();
        $data = ['page' => "type/formulaire", 'categories' => $categories];
        if (isset($_GET['id'])) {
            $type = $type_model->findById($_GET['id']);
            $data['type'] = $type;
        } else {
            $data = ['page' => "type/formulaire", 'categories' => $categories];
        }
        Flight::render('template2', $data);
    }
    public function listePage()
    {
        $type_model = new TypeModel(Flight::db());
        try {
            $type_listes = $type_model->findAll();
            $data = ['page' => "type/liste", 'types' => $type_listes];

            Flight::render('template2', $data);
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
