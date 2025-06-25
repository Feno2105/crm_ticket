<?php
namespace App\Models\Ticket;

use Flight;

class CommentaireModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function create($com,$id_Ticket): int
    {
        $query = "INSERT INTO commentaire_Ticket (commentaire , id_ticket_produit) 
                  VALUES (:com, :id)";

        $stmt = $this->db->prepare($query);

        // Utilisation de bindValue() au lieu de bindParam()
        $stmt->bindValue(':com', $com);
        $stmt->bindValue(':id', $id_Ticket);

        $stmt->execute();   
        return (int)$this->db->lastInsertId();
    }   

    public function update($com, $id_Ticket )
    {
        $query = "UPDATE commentaire_Ticket SET 
                 commentaire = :com, 
                 WHERE id_commentaire = :id ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':com', $com);
        $stmt->bindValue(':id ' , $id_Ticket);
        return $stmt->execute();
    }

     /**
     * Supprime un ticket
     * @param int $id ID du ticket à supprimer
     * @return bool True si la suppression a réussi
     */
    public function remove($id)
    {
        $sql = "DELETE FROM commentaire_Ticket WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([':id' => $id]);
        echo "Suppression réussie !";
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM commentaireTicket ";
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
        $query = "SELECT * FROM commentaire_Ticket WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }
    public function tableExistsAndNotEmpty() {
           // 1. Vérifier si la table existe
            $checkTable = $this->db->query("SHOW TABLES LIKE 'commentaire_Ticket'");
            if ($checkTable->rowCount() === 0) {
                return false;
            }
            
            // 2. Vérifier si la table contient des données
            $count = $this->db->query("SELECT COUNT(*) FROM commentaire_Ticket")->fetchColumn();
            return $count > 0;
    }


    
}