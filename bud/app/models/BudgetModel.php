<?php

namespace app\models;

use Flight;
use PDO;

class BudgetModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function update($donne)
    {
        $sql = "UPDATE Budget SET prevision = ? ,realisation = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }
    public function valider($id)
    {
        $sql = "UPDATE Budget SET valider = TRUE WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($id);
    }
    public  function getAll()
    {
        $sql = "SELECT *,Budget.id AS idB FROM Budget JOIN TYPE ON Budget.idT = TYPE.id WHERE valider = 0";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public  function getById($id)
    {
        $sql = "SELECT * FROM Budget WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetch();
    }

    public  function delete($id)
    {
        $sql = "DELETE FROM Budget WHERE id = ?";
        $stmt = $this->db->prepare($sql);
    }
    public function insert($donne)
    {
        $sql = "INSERT INTO Budget (idDep,idT,idN,prevision,realisation,valider) VALUES (?,?,?,?,?,0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($donne);
    }
}
