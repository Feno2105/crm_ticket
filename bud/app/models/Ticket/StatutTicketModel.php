<?php
namespace app\models\Ticket;

use PDO;
use Flight;

class StatutTicketModel 
{
    private $db;

    public function __construct($db = null) {
        $this->db = $db ?? Flight::db();
    }

    /**
     * Crée une nouvelle entrée de statut pour un ticket
     */
    public function create(int $ticketId, int $statutId): int {
        $query = "INSERT INTO statut_ticket (ticket_id, statut_id) VALUES (?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $ticketId, $statutId);
        $stmt->execute();
        
        return $stmt->insert_id;
    }

    /**
     * Met à jour le statut d'un ticket
     */
    public function update(int $id, int $statutId): bool {
        $query = "UPDATE statut_ticket SET statut_id = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $statutId, $id);
        return $stmt->execute();
    }

    /**
     * Supprime une entrée de statut
     */
    public function remove(int $id): bool {
        $query = "DELETE FROM statut_ticket WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    /**
     * Récupère tous les statuts d'un ticket
     */
    public function getAllForTicket(int $ticketId): array {
        $query = "SELECT st.*, s.nom as statut_nom 
                 FROM statut_ticket st
                 JOIN statut s ON st.statut_id = s.id
                 WHERE st.ticket_id = ?
                 ORDER BY st.id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ticketId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupère le statut actuel d'un ticket
     */
    public function getCurrentForTicket(int $ticketId): ?array {
        $query = "SELECT st.*, s.nom as statut_nom 
                 FROM statut_ticket st
                 JOIN statut s ON st.statut_id = s.id
                 WHERE st.ticket_id = ?
                 ORDER BY st.id DESC
                 LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $ticketId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }
    
    public function getAll()
    {
        $query = "SELECT * FROM statut";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}