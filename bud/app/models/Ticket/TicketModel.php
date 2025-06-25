<?php

namespace App\Models\Ticket;

use PDO;
use Flight;

class TicketModel
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    /**
     * Crée un nouveau ticket
     * @param array $data Données du ticket
     * @return int ID du ticket créé
     */
    public function create(array $data): int
    {
        $query = "INSERT INTO ticket (sujet, `desc`, priorite, file) 
                  VALUES (:sujet, :desc, :priorite, :file)";

        $stmt = $this->db->prepare($query);

        // Utilisation de bindValue() au lieu de bindParam()
        $stmt->bindValue(':sujet', $data['sujet']);
        $stmt->bindValue(':desc', $data['desc'] ?? null);
        $stmt->bindValue(':priorite', $data['priorite']);
        $stmt->bindValue(':file', $data['file'] ?? null);

        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    /**
     * Met à jour un ticket existant
     * @param int $id ID du ticket
     * @param array $data Données à mettre à jour
     * @return bool True si la mise à jour a réussi
     */
    public function update(array $data)
    {
        $query = "UPDATE ticket SET 
                 sujet = :sujet, 
                 `desc` = :desc, 
                 priorite = :priorite, 
                 file = :file 
                 WHERE id = :id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Supprime un ticket
     * @param int $id ID du ticket à supprimer
     * @return bool True si la suppression a réussi
     */
    public function remove($id)
    {
        $sql = "DELETE FROM ticket WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);
        echo "Suppression réussie !";
    }

    /**
     * Récupère tous les tickets
     * @return array Liste des tickets
     */
    public function getAll(): array
    {
        $query = "SELECT * FROM ticket ORDER BY date_creation DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getpriorite(): array
    {
        $query = "SELECT * FROM priorite";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**
     * Récupère un ticket par son ID
     * @param int $id ID du ticket
     * @return array|null Données du ticket ou null si non trouvé
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM ticket WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }
    public function updateStatut(int $ticketId, int $newStatutId): bool
{
    $query = "UPDATE ticket SET id_statut = :statut WHERE id = :id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        ':statut' => $newStatutId,
        ':id' => $ticketId
    ]);
}
public function getAllWithDetails()
{
    $query = "SELECT t.*, p.nom as priorite_nom, s.desc as statut_nom 
              FROM ticket t
              JOIN priorite p ON t.priorite = p.id
              JOIN statut s ON t.id_statut = s.id
              ORDER BY t.date_creation DESC";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
