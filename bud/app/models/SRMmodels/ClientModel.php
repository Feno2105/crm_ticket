<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class ClientModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT client.* , categorie_client.nom_categorie FROM client JOIN categorie_client ON categorie_client.id_categorie = client.id_categorie";
        try {

            $pstmt = $this->db->prepare($sql);
            $pstmt->execute();

            $result_select = $pstmt->fetchAll();

            return $result_select;
        } catch (\Throwable $th) {
            echo "error: " . $th->getMessage();
        }
        return null;
    }
    public function findById($id_client)
    {
        $sql = "SELECT * FROM client where id_client = :id_client";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_client' => $id_client]);
        $result = $stmt->fetch();

        return $result;
    }


    public function create($name, $email, $tel, $id_categorie)
    {


        if ($email == null || $email == '') {
            $email = "aucun";
        }
        if ($tel == null || $tel == '') {
            $tel = "aucun";
        }
        if ($id_categorie == null || $id_categorie == '' || !isset($id_categorie)) {
            $id_categorie = 1;
        }

        $sql = "INSERT INTO client (nom , email , telephone , id_categorie)  VALUES (:name, :email,:tel, :id_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':tel' => $tel,
            ':id_categorie' => $id_categorie
        ]);
    }
    public function update($name, $email, $tel, $id_categorie, $id_client)
    {
        if ($email == null || $email == '') {
            $email = "aucun";
        }
        if ($tel == null || $tel == '') {
            $tel = "aucun";
        }
        if ($id_categorie == null || $id_categorie == '' || !isset($id_categorie)) {
            $id_categorie = 1;
        }
        $sql = "UPDATE client SET nom = :name , email = :email , telephone = :tel , id_categorie = :id_categorie WHERE id_client = :id_client";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':tel' => $tel,
            ':id_categorie' => $id_categorie,
            ':id_client' => $id_client
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_client)
    {
        $sql = "DELETE FROM client WHERE id_client = :id_client";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id_client' => $id_client]);
        echo "Suppression réussie !";
    }
}