<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class ListeReactionModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM liste_reaction";
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
    public function findById($id_reaction)
    {
        $sql = "SELECT * FROM liste_reaction where id_reaction = :id_reaction";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_reaction' => $id_reaction]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($nom_reaction, $type_reaction)
    {

        $sql = "INSERT INTO liste_reaction (nom_reaction , type_reaction)  VALUES (:nom_reaction, :type_reaction)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom_reaction' => $nom_reaction,
            ':type_reaction' => $type_reaction
        ]);
        echo "Insertion réussie !";
    }
    public function update($nom_reaction, $type_reaction, $id_reaction)
    {
        $sql = "UPDATE liste_reaction SET nom_reaction = :nom_reaction , type_reaction = :type_reaction  WHERE id_reaction = :id_reaction";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nom_reaction' => $nom_reaction,
            ':type_reaction' => $type_reaction,
            ':id_reaction' => $id_reaction
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_reaction)
    {
        $sql = "DELETE FROM liste_reaction WHERE id_reaction = :id_reaction";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id_reaction' => $id_reaction]);
        echo "Suppression réussie !";
    }
}