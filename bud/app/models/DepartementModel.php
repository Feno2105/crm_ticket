<?php

namespace app\models;

use Flight;
use PDO;

class DepartementModel
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function update($donne)
    {
        $sql = "UPDATE DEPARTEMENT SET nom = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }

    public  function getAll()
    {
        $sql = "SELECT * FROM DEPARTEMENT";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public  function getById($id)
    {
        $sql = "SELECT * FROM DEPARTEMENT WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
    }

    public  function delete($id)
    {
        $sql = "DELETE FROM DEPARTEMENT WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($id);
    }
    public function insert($donne)
    {
        $sql = "INSERT INTO DEPARTEMENT (nom) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }
}
