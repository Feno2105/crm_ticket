<?php
namespace app\models\Ticket;

use PDO;
use Flight;

class AssignementModel 
{
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    /**
     * Crée une nouvelle assignation
     */
    public function create(int $ticketId, int $agentId): int {
        if ($this->isTicketAlreadyAssigned($ticketId)) {
            throw new \Exception("Ce ticket est déjà assigné à un agent");
        }

        $query = "INSERT INTO assignement (ticket_id, agent_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':t_id', $ticketId);
        $stmt->bindParam(':a_id', $agentId);
        $stmt->execute();

        return $stmt->insert_id;
    }

    /**
     * Vérifie si un ticket est déjà assigné
     */
    public function isTicketAlreadyAssigned(int $ticketId): bool {
        $query = "SELECT COUNT(*) as count FROM assignement WHERE ticket_id = :t_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':t_id', $ticketId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }

    /**
     * Récupère l'assignation d'un ticket
     */
    public function getAssignmentByTicket(int $ticketId): ?array {
        $query = "SELECT a.*, e.nom AS agent_nom 
        FROM assignement a
        JOIN EMPLOYER e ON a.agent_id = e.id
        WHERE a.ticket_id = :t_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':t_id', $ticketId);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result ? $result : null;
    }

    /**
     * Met à jour l'assignation d'un ticket
     */
    public function updateAssignment(int $ticketId, int $newAgentId): bool {
        $query = "UPDATE assignement SET agent_id = :a_id WHERE ticket_id = :t_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':a_id', $newAgentId);
        $stmt->bindParam(':t_id', $ticketId);
        return $stmt->execute();
    }

    /**
     * Supprime une assignation
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM assignement WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getAllAgents()
    {
        $query = "SELECT id, nom FROM EMPLOYER";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}