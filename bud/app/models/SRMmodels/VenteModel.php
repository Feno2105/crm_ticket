<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class VenteModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT p.nom_produit,* FROM Ventes AS V JOIN produit AS P ON P.id_produit = V.id_produit";
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
    public function findById($id_ventes)
    {
        $sql = "SELECT p.nom_produit,* FROM Ventes AS V JOIN produit AS P ON P.id_produit = V.id_produit WHERE id_ventes = :id_ventes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_ventes' => $id_ventes]);
        $result = $stmt->fetch();

        return $result;
    }
    public function getQuantity($data)
    {
        $sql = "SELECT SUM(v.quantite) AS total_vendue FROM produit p JOIN Ventes v ON p.id_produit = v.id_produit WHERE v.id_produit = ? AND  v.annee = ? AND v.mois = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch();

        return $result;
    }
    public function findLast($annee)
    {
        $sql = "SELECT p.id_produit, p.nom_produit, p.prix, COALESCE(SUM(v.quantite), 0) AS total_vendue FROM produit p LEFT JOIN Ventes v ON p.id_produit = v.id_produit AND v.annee = ? GROUP BY p.id_produit, p.nom_produit, p.prix ORDER BY total_vendue ASC LIMIT 3";
        try {

            $pstmt = $this->db->prepare($sql);
            $pstmt->execute($annee);

            $result_select = $pstmt->fetchAll();

            return $result_select;
        } catch (\Throwable $th) {
            echo "error: " . $th->getMessage();
        }
        return null;
    }
    public function findFirst($annee)
    {
        $sql = "SELECT p.id_produit, p.nom_produit, p.prix, COALESCE(SUM(v.quantite), 0) AS total_vendue FROM produit p LEFT JOIN Ventes v ON p.id_produit = v.id_produit AND v.annee = ? GROUP BY p.id_produit, p.nom_produit, p.prix ORDER BY total_vendue DESC LIMIT 3";
        try {

            $pstmt = $this->db->prepare($sql);
            $pstmt->execute($annee);

            $result_select = $pstmt->fetchAll();

            return $result_select;
        } catch (\Throwable $th) {
            echo "error: " . $th->getMessage();
        }
        return null;
    }

    public function create($id_produit, $quantite, $somme)
    {

        $sql = "INSERT INTO Ventes (id_produit , quantite , Valeur)  VALUES (:idP, :quantite,:somme)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idP' => $id_produit,
            ':quantite' => $quantite,
            ':somme' => $somme,
        ]);
    }
    public function insert($data)
    {

        $sql = "INSERT INTO Ventes (id_produit , quantite , Valeur,mois,annee)  VALUES (?, ?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
    }
    // public function update($name, $marque, $prix, $id_categorie, $id_produit)
    // {
    //     $sql = "UPDATE produit SET nom_produit = :name , marque = :marque , prix = :prix , id_categorie = :id_categorie WHERE id_produit = :id_produit";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([
    //         ':name' => $name,
    //         ':marque' => $marque,
    //         ':prix' => $prix,
    //         ':id_categorie' => $id_categorie,
    //         ':id_produit' => $id_produit
    //     ]);
    //     echo "Mise à jour réussie !";
    // }
    // public function delete($id_produit)
    // {
    //     $sql = "DELETE FROM produit WHERE id_produit = :id_produit";
    //     $stmt = $this->db->prepare($sql);

    //     $stmt->execute([':id_produit' => $id_produit]);
    //     echo "Suppression réussie !";
    // }
}
