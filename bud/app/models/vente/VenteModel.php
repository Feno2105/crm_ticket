<?php

namespace app\models\vente;

use Exception;
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
        $sql = 'SELECT * FROM Ventes';
        try {
            $pstmt = $this->db->prepare($sql);
            $pstmt->execute();

            $result_select = $pstmt->fetchAll();

            return $result_select;
        } catch (\Throwable $th) {
            echo 'error: ' . $th->getMessage();
        }
        return null;
    }

    public function findById($id_action, $id_reaction)
    {
        $sql = 'SELECT * FROM action_reaction where id_action = :id_action AND id_reaction = :id_reaction';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_action' => $id_action,
            ':id_reaction' => $id_reaction
        ]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($id_client, $id_produit, $quantite, $Valeur, $mois, $annee)
    {
        $sql = 'INSERT INTO Ventes (id_client, id_produit, quantite, Valeur, mois, annee) 
                VALUES (:id_client, :id_produit, :quantite, :Valeur, :mois, :annee)';

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':id_client' => $id_client,
            ':id_produit' => $id_produit,
            ':quantite' => $quantite,  // Correction: ajout du deux-points manquant
            ':Valeur' => $Valeur,
            ':mois' => $mois,
            ':annee' => $annee
        ]);

        if (!$result) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Erreur d'insertion: " . $errorInfo[2]);
        }
    }
}
