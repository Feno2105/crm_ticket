<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class ProductModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findPriceById($id_produit)
    {
        $price = $this->findById($id_produit);
        return $price["prix"];
    }
    public function findAll()
    {
        $sql = "SELECT p.* , cp.nom_categorie from produit p JOIN categorie_produit cp ON cp.id_categorie = p.id_categorie";
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
        $sql = "SELECT * FROM produit JOIN categorie_produit ON produit.id_categorie = categorie_produit.id_categorie  where id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_produit' => $id_produit]);
        $result = $stmt->fetch();

        return $result;
    }
    public function findNameById($id_produit)
    {
        $sql = "SELECT nom_produit FROM produit where id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_produit' => $id_produit]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($name, $marque, $prix, $id_categorie)
    {

        $sql = "INSERT INTO produit (nom_produit , marque , prix , id_categorie)  VALUES (:name, :marque,:prix, :id_categorie)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':marque' => $marque,
            ':prix' => $prix,
            ':id_categorie' => $id_categorie
        ]);
    }
    public function insertCRM($data)
    {

        $sql = "INSERT INTO CRM (id_produit , id_reaction , prix , mois,annee)  VALUES (?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }
    public function update($name, $marque, $prix, $id_categorie, $id_produit)
    {
        $sql = "UPDATE produit SET nom_produit = :name , marque = :marque , prix = :prix , id_categorie = :id_categorie WHERE id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':marque' => $marque,
            ':prix' => $prix,
            ':id_categorie' => $id_categorie,
            ':id_produit' => $id_produit
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