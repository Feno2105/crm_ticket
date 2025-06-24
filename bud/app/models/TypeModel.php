<?php

namespace app\models;

use Flight;
use PDO;

class TypeModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $sql = "SELECT * FROM TYPE";
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
        $sql = "SELECT * FROM TYPE where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();

        return $result;
    }

    public function create($idC, $libele)
    {
        $sql = "INSERT INTO TYPE (idC, libele) VALUES (:idc, :libele)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idc' => $idC,
            ':libele' => $libele
        ]);
        echo "Insertion réussie !";
    }
    public function update($id, $idC, $libele)
    {
        $sql = "UPDATE TYPE SET idC = :idC , libele = :libele WHERE id = :id";
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
        $sql = "DELETE FROM TYPE WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);
        echo "Suppression réussie !";
    }
}