<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class CategorieClientModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM categorie_client";
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
    public function findById($id_categorie)
    {
        $sql = "SELECT * FROM categorie_client where id_categorie = :id_categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_categorie' => $id_categorie]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($nom_categorie)
    {

        $sql = "INSERT INTO categorie_client (nom_categorie)  VALUES (:nom_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom_categorie' => $nom_categorie
        ]);
        echo "Insertion réussie !";
    }
    public function update($nom_categorie, $id_categorie)
    {
        $sql = "UPDATE categorie_client SET nom_categorie = :nom_categorie  WHERE id_categorie = :id_categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom_categorie' => $nom_categorie,
            ':id_categorie' => $id_categorie
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_categorie)
    {
        $sql = "DELETE FROM categorie_client WHERE id_categorie = :id_categorie";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id_categorie' => $id_categorie]);
        echo "Suppression réussie !";
    }
}