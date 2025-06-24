<?php

namespace app\models;

use Flight;
use PDO;

class EmployerModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    function getLogin($donne)
    {
        $sql = "SELECT * FROM EMPLOYER where nom = ? and mdp = ? and idD = ?";
        echo "<pre>";
        // echo print_r($donnee);
        echo "</pre>";
        try {
            $pstmt = $this->db->prepare($sql);
            $pstmt->execute($donne);

            $result_select = $pstmt->fetchAll();
            if (count($result_select) == 1) {
                session_start();
                $_SESSION['id_utilisateur'] = $result_select[0]["id"];
                return true;
            }
        } catch (\Throwable $th) {
            echo "erreur : " . $th->getMessage();
        }
        return false;
    }

    public function update($donne)
    {
        $sql = "UPDATE EMPLOYER SET idD = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }

    public  function getAll()
    {
        $sql = "SELECT * FROM EMPLOYER";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public  function getById($id)
    {
        $sql = "SELECT * FROM EMPLOYER WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
    }

    public  function delete($id)
    {
        $sql = "DELETE FROM EMPLOYER WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($id);
    }
    public function insert($donne)
    {
        $sql = "INSERT INTO EMPLOYER (idD,nom,mdp) VALUES (?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }
}
