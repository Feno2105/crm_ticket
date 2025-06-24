<?php

namespace app\models\SRMmodels;

use Flight;
use PDO;

class ActionReactionModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM action_reaction";
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
    public function findById($id_action, $id_reaction)
    {
        $sql = "SELECT * FROM action_reaction where id_action = :id_action AND id_reaction = :id_reaction";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_action' => $id_action,
            ':id_reaction' => $id_reaction
        ]);
        $result = $stmt->fetch();

        return $result;
    }


    public function create($id_action, $id_reaction, $comment)
    {

        $sql = "INSERT INTO action_reaction (id_action , id_reaction ,commentaire )  VALUES (:id_action, :id_reaction ,:comment )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_action' => $id_action,
            'id_reaction' => $id_reaction,
            ':comment' => $comment
        ]);
        echo "Insertion réussie !";
    }
    public function update($commentaire, $id_action, $id_reaction)
    {
        $sql = "UPDATE action_reaction SET commentaire = :comment WHERE id_action = :id_action AND id_reaction:id_action";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':commentaire' => $commentaire,
            ':id_action' => $id_action,
            ':id_reaction' => $id_reaction
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id_action, $id_reaction)
    {
        $sql = "DELETE FROM action_reaction WHERE id_action = :id_action AND id_reaction = :id_reaction";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id_action' => $id_action,
            ':id_reaction' => $id_reaction
        ]);
        echo "Suppression réussie !";
    }
}