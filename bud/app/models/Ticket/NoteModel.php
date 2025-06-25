<?php
namespace App\Models\Ticket;

use Flight;

class NoteModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function create(array $data): int
    {
        $query = "INSERT INTO note_Ticket (note , id_Ticket) 
                  VALUES (:note, :id)";

        $stmt = $this->db->prepare($query);

        // Utilisation de bindValue() au lieu de bindParam()
        $stmt->bindValue(':note', $data['note']);
        $stmt->bindValue(':id', $data['id']);

        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function update(array $data)
    {
        $query = "UPDATE note_Ticket SET 
                 commentaire = :com, 
                 WHERE id_commentaire = :id";

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
        $sql = "DELETE FROM note_Ticket WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);
        echo "Suppression réussie !";
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM note_Ticket ";
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
        $query = "SELECT * FROM note_Ticket WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }


    
}