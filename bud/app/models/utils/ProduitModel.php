<?php

namespace app\models\utils;

use Flight;
use PDO;

class ProduitModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM produit";
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
    public function findById($id_produit)
    {
        $sql = "SELECT * FROM produit where id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_produit' => $id_produit]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($name, $mark, $price, $id_categorie)
    {

        $sql = "INSERT INTO produit (nom_produit , marque , prix , id_categorie)  VALUES (:name, :mark,:price, :id_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':mark' => $mark,
            ':price' => $price,
            ':id_categorie' => $id_categorie
        ]);
        echo "Insertion réussie !";
    }
    public function update($name, $mark, $price, $id_categorie, $id_product)
    {
        $sql = "UPDATE produit SET nom_produit = :name , marque = :mark , prix = :price , id_categorie = :id_categorie WHERE id_product = :id_product";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':mark' => $mark,
            ':price' => $price,
            ':id_categorie' => $id_categorie,
            ':id_product' => $id_product
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_produit)
    {
        $sql = "DELETE FROM produit WHERE id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id_produit' => $id_produit]);
        echo "Suppression réussie !";
    }
}