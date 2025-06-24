<?php

namespace app\models;

use Flight;
use PDO;

class NatureModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM NATURE";
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
    public function findById($id)
    {
        $sql = "SELECT * FROM NATURE where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($idC, $libele)
    {

        $sql = "INSERT INTO NATURE (idC, libele) VALUES (:idC, :libele)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idC' => $idC,
            ':libele' => $libele
        ]);
        echo "Insertion réussie !";
    }
    public function update($id, $idC, $libele)
    {
        $sql = "UPDATE NATURE SET idC = :idC , libele = :libele WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idC' => $idC,
            ':libele' => $libele,
            ':id' => $id
        ]);
        echo "Mise à jour réussie !";
    }
    public function delete($id)
    {
        $sql = "DELETE FROM NATURE WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);
        echo "Suppression réussie !";
    }
}