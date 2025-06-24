<?php
namespace app\models;
use Flight;

class BudgetModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    /**
     * Crée une nouvelle prévision
     */
  public function createPrev(array $data, $id_dept): int {
    $query = "INSERT INTO prevision (id_dept, valeur, id_type, mois, annee, propos) 
             VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    
    // Casting des types
    $id_dept = (int)$id_dept;
    $valeur = (int)$data['valeur'];
    $type = (int)$data['type'];
    $mois = (int)$data['mois'];
    $annee = (int)$data['annee'];
    
    $stmt->bindValue(1, $id_dept);
    $stmt->bindValue(2, $valeur);
    $stmt->bindValue(3, $type);
    $stmt->bindValue(4, $mois);
    $stmt->bindValue(5, $annee);
    $stmt->bindValue(6, $data['propos']); // Pas de conversion pour 'propos'
    
    return $stmt->execute();
}

    /**
     * Met à jour une prévision existante
     */
    public function updatePrev(int $id, array $data): bool {
        $query = "UPDATE prevision SET 
                 id_dept = ?,
                 valeur = ?,
                 id_type = ?,
                 mois = ?,
                 annee = ?,
                 propos = ?
                 WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['id_dept'],
            $data['valeur'],
            $data['id_type'],
            $data['mois'],
            $data['annee'],
            $data['propos'],
            $id
        ]);
    }

    /**
     * Supprime une prévision
     */
    public function deletePrev(int $id): bool {
        $query = "DELETE FROM prevision WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Récupère toutes les prévisions
     */
    public function getAllPrev(): array {
        $query = "SELECT p.*, d.nom as departement, t.nom as type
                 FROM prevision p
                 JOIN departement d ON p.id_dept = d.id
                 JOIN type t ON p.id_type = t.id
                 ORDER BY annee DESC, mois DESC";
        
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupère une prévision par son ID
     */
    public function getByDeptPrev(int $id): ?array {
        $query = "SELECT p.*, d.nom as departement, t.nom as type
                 FROM prevision p
                 JOIN DEPARTEMENT d ON p.id_dept = d.id
                 JOIN type t ON p.id_type = t.id
                 WHERE d.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Récupère les prévisions par département et période
     */
    public function getByDeptAndPeriod(int $id_dept, int $mois, int $annee): array {
        $query = "SELECT p.*, d.nom as departement, t.nom as type
                 FROM prevision p
                 JOIN departement d ON p.id_dept = d.id
                 JOIN type t ON p.id_type = t.id
                 WHERE p.id_dept = ? AND p.mois = ? AND p.annee = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $id_dept, $mois, $annee);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    /**
     * Crée une nouvelle réalisation
     */
    public function create(array $data): int {
        $query = "INSERT INTO realisation 
                 (id_dept, valeur, id_prevision, mois, annee, propos) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(
            $data['id_dept'],
            $data['valeur'],
            $data['id_prevision'],
            $data['mois'],
            $data['annee'],
            $data['propos']
        );
        
        $stmt->execute();
        return $stmt->insert_id;
    }

    /**
     * Met à jour une réalisation existante
     */
    public function update(int $id, array $data): bool {
        $query = "UPDATE realisation SET 
                 id_dept = ?,
                 valeur = ?,
                 id_prevision = ?,
                 mois = ?,
                 annee = ?,
                 propos = ?
                 WHERE id = ?";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['id_dept'],
            $data['valeur'],
            $data['id_prevision'],
            $data['mois'],
            $data['annee'],
            $data['propos'],
            $id
        ]);
    }

    /**
     * Supprime une réalisation
     */
    public function delete(int $id): bool {
        $query = "DELETE FROM realisation WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Récupère toutes les réalisations
     */
    public function getAll(): array {
        $query = "SELECT r.*, d.nom as departement, p.valeur as prevision_valeur
                 FROM realisation r
                 JOIN departement d ON r.id_dept = d.id
                 LEFT JOIN prevision p ON r.id_prevision = p.id
                 ORDER BY annee DESC, mois DESC";
        
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupère une réalisation par son ID
     */
    public function getById(int $id): ?array {
        $query = "SELECT r.*, d.nom as departement, p.valeur as prevision_valeur
                 FROM realisation r
                 JOIN departement d ON r.id_dept = d.id
                 LEFT JOIN prevision p ON r.id_prevision = p.id
                 WHERE r.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Récupère les réalisations associées à une prévision
     */
    public function getByPrevision(int $id_prevision): array {
        $query = "SELECT r.*, d.nom as departement
                 FROM realisation r
                 JOIN departement d ON r.id_dept = d.id
                 WHERE r.id_prevision = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_prevision);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupère le total des réalisations par département et période
     */
    public function getTotalByDeptAndPeriod(int $id_dept, int $mois, int $annee): int {
        $query = "SELECT SUM(valeur) as total
                 FROM realisation
                 WHERE id_dept = ? AND mois = ? AND annee = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $id_dept, $mois, $annee);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
}