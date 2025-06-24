<?php
namespace App\Models\Ticket;

use Flight;

class AssignementModel {
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
        $stmt->bind_param('ii', $ticketId, $agentId);
        $stmt->execute();

        return $stmt->insert_id;
    }

    /**
     * Vérifie si un ticket est déjà assigné
     */
    public function isTicketAlreadyAssigned(int $ticketId): bool {
        $query = "SELECT COUNT(*) as count FROM assignement WHERE ticket_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ticketId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'] > 0;
    }

    /**
     * Récupère l'assignation d'un ticket
     */
    public function getAssignmentByTicket(int $ticketId): ?array {
        $query = "SELECT a.*, e.nom as agent_nom, e.prenom as agent_prenom 
                 FROM assignement a
                 JOIN employer e ON a.agent_id = e.id
                 WHERE a.ticket_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ticketId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Met à jour l'assignation d'un ticket
     */
    public function updateAssignment(int $ticketId, int $newAgentId): bool {
        $query = "UPDATE assignement SET agent_id = ? WHERE ticket_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $newAgentId, $ticketId);
        return $stmt->execute();
    }

    /**
     * Supprime une assignation
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM assignement WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}