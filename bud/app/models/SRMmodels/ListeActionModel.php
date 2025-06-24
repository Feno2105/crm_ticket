<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class ListeActionModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM liste_action";
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
    public function findById($id_action)
    {
        $sql = "SELECT * FROM liste_action where id_action = :id_action";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_action' => $id_action]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($nom_action)
    {

        $sql = "INSERT INTO liste_action (nom_action)  VALUES (:nom_action)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom_action' => $nom_action
        ]);
        echo "Insertion réussie !";
    }
    public function update($nom_action, $id_action)
    {
        $sql = "UPDATE liste_action SET nom_action = :nom_action  WHERE id_action = :id_action";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom_action' => $nom_action,
            ':id_action' => $id_action
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_action)
    {
        $sql = "DELETE FROM liste_action WHERE id_action = :id_action";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id_action' => $id_action]);
        echo "Suppression réussie !";
    }
}