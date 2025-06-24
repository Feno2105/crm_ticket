<?php
namespace App\Models\Ticket;
Use Flight;

class TicketModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    /**
     * Crée un nouveau ticket
     * @param array $data Données du ticket
     * @return int ID du ticket créé
     */
    public function create(array $data): int {
        $query = "INSERT INTO ticket (sujet, `desc`, priorite, file) 
                  VALUES (:sujet, :desc, :priorite, :file)";
        
        $stmt = $this->db->prepare($query);
        
        // Utilisation de bindParam pour lier les paramètres
        $stmt->bindParam(':sujet', $data['sujet']);
        $stmt->bindParam(':desc', $data['desc'] ?? null);
        $stmt->bindParam(':priorite', $data['priorite']);
        $stmt->bindParam(':file', $data['file'] ?? null);
        
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Met à jour un ticket existant
     * @param int $id ID du ticket
     * @param array $data Données à mettre à jour
     * @return bool True si la mise à jour a réussi
     */
    public function update(int $id, array $data): bool {
        $query = "UPDATE ticket SET 
                  sujet = :sujet,
                  `desc` = :desc,
                  priorite = :priorite,
                  file = :file
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        
        // Liaison des paramètres avec bindParam
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':sujet', $data['sujet']);
        $stmt->bindParam(':desc', $data['desc'] ?? null);
        $stmt->bindParam(':priorite', $data['priorite']);
        $stmt->bindParam(':file', $data['file'] ?? null);
        
        return $stmt->execute();
    }

    /**
     * Supprime un ticket
     * @param int $id ID du ticket à supprimer
     * @return bool True si la suppression a réussi
     */
    public function remove(int $id): bool {
        $query = "DELETE FROM ticket WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Récupère tous les tickets
     * @return array Liste des tickets
     */
    public function getAll(): array {
        $query = "SELECT * FROM ticket ORDER BY date_creation DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Récupère un ticket par son ID
     * @param int $id ID du ticket
     * @return array|null Données du ticket ou null si non trouvé
     */
    public function getById(int $id): ?array {
        $query = "SELECT * FROM ticket WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }

    
}
