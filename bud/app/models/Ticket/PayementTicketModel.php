<?php
namespace app\models\Ticket;

use PDO;
use Flight;

class PayementTicketModel 
{
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function create(array $data): int
    {
        $query = "INSERT INTO payement_ticket 
                  (ticket_id, dure, agent_id, amount) 
                  VALUES (:ticket_id, :dure, :agent_id, :amount)";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':ticket_id' => $data['ticket_id'],
            ':dure' => $data['dure'],
            ':agent_id' => $data['agent_id'],
            ':amount' => $data['amount']
        ]);
        
        return $this->db->lastInsertId();
    }
}