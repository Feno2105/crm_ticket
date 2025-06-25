<?php

namespace app\models\Ticket;

use PDO;
use Flight;

class HoraireModel
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function getCurrentRate(): array
    {
        $query = "SELECT * FROM horaire ORDER BY id DESC LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result : []; // Garantit de toujours retourner un array
    }
}
