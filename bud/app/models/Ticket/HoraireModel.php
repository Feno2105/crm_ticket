<?php
namespace app\models\Ticket;

use PDO;
use Flight;

class HoraireModel 
{
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function getCurrentRate()
    {
        $query = "SELECT * FROM horaire ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}