<?php
namespace app\models;
use Flight;
use PDO;
class BudgetModel {
    private $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    /**
     * Crée une nouvelle prévision
     */
 public function createPrev(array $data): bool {
    $query = "INSERT INTO prevision (id_dept, valeur, id_type, mois, annee, propos) 
             VALUES (:id_dept, :valeur, :type, :mois, :annee, :propos)";
    $stmt = $this->db->prepare($query);

    $stmt->bindValue(':id_dept', $data['id_dept'], PDO::PARAM_INT);
    $stmt->bindValue(':valeur', $data['valeur'], PDO::PARAM_INT);
    $stmt->bindValue(':type', $data['type'], PDO::PARAM_INT);
    $stmt->bindValue(':mois', $data['mois'], PDO::PARAM_INT);
    $stmt->bindValue(':annee', $data['annee'], PDO::PARAM_INT);
    $stmt->bindValue(':propos', $data['propos'], PDO::PARAM_STR);
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
                 JOIN DEPARTEMENT d ON p.id_dept = d.id
                 JOIN TYPE t ON p.id_type = t.id
                 ORDER BY annee DESC, mois DESC";
        
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une prévision par son ID
     */
    public function getByDeptPrev(int $id): array {
        $query = "SELECT p.*, d.nom as departement, t.nom as type
                 FROM prevision p
                 JOIN DEPARTEMENT d ON p.id_dept = d.id
                 JOIN TYPE t ON p.id_type = t.id
                 WHERE d.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByPrev(int $id): array {
    $query = "SELECT * FROM prevision WHERE id = $id LIMIT 1";
    $stmt = $this->db->prepare($query);
    // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau vide si null
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
        $stmt->bindParam(':id_dept', $id_dept);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':annee', $annee);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Crée une nouvelle réalisation
     */
    public function create(array $data): int {
        $query = "INSERT INTO realisation 
                 (id_dept, valeur, id_prevision, mois, annee, propos) 
                 VALUES (:id_dept, :valeur, :id_prevision, :mois, :annee, :propos)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_dept', $data['id_dept'], PDO::PARAM_INT);
        $stmt->bindValue(':valeur', $data['valeur'], PDO::PARAM_INT);
        $stmt->bindValue(':id_prevision', $data['id_prevision'], PDO::PARAM_INT);
        $stmt->bindValue(':mois', $data['mois'], PDO::PARAM_INT);
        $stmt->bindValue(':annee', $data['annee'], PDO::PARAM_INT);
        $stmt->bindValue(':propos', $data['propos'], PDO::PARAM_STR);
        
        return $stmt->execute() ? $this->db->lastInsertId() : 0;
    }

    /**
     * Met à jour une réalisation existante
     */
    public function update(int $id, array $data): bool {
        $query = "UPDATE realisation SET 
                 id_dept = :id_dept,
                 valeur = :valeur,
                 id_prevision = :id_prevision,
                 mois = :mois,
                 annee = :annee,
                 propos = :propos
                 WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_dept', $data['id_dept']);
        $stmt->bindParam(':valeur', $data['valeur']);
        $stmt->bindParam(':id_prevision', $data['id_prevision']);
        $stmt->bindParam(':mois', $data['mois']);
        $stmt->bindParam(':annee', $data['annee']);
        $stmt->bindParam(':propos', $data['propos']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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
        $query = "SELECT r.*, d.nom as departement, p.valeur  as prevision_valeur ,p.propos as prevision_propos
                 FROM realisation r
                 JOIN DEPARTEMENT d ON r.id_dept = d.id
                 LEFT JOIN prevision p ON r.id_prevision = p.id
                 ORDER BY annee DESC, mois DESC";
        
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une réalisation par son ID dept
     */
    public function getRealByDept(int $id): array {
        $query = "SELECT r.*, d.nom as departement, p.valeur as prevision_valeur
                 FROM realisation r
                 JOIN DEPARTEMENT d ON r.id_dept = d.id
                 LEFT JOIN prevision p ON r.id_prevision = p.id
                 WHERE d.id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Récupère les réalisations associées à une prévision
     */
    public function getRealByPrevision(int $id_prevision): array {
        $query = "SELECT r.*, d.nom as departement
                 FROM realisation r
                 JOIN DEPARTEMENT d ON r.id_dept = d.id
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
     public function saveEcart(array $data): int
    {
        $query = "INSERT INTO ecart 
                 (id_dept, valeur, id_prevision, id_realisation, mois, annee) 
                 VALUES (:id_dept, :valeur, :id_prevision, :id_realisation, :mois, :annee)";

        $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(':id_dept', $data['id_dept'] , PDO::PARAM_INT);
        $stmt->bindValue(':valeur', $data['valeur'] , PDO::PARAM_INT);
        $stmt->bindValue(':id_prevision', $data['prevision_id'] , PDO::PARAM_INT);
        $stmt->bindValue(':id_realisation', $data['realisation'], PDO::PARAM_INT);
        $stmt->bindValue(':mois', $data['mois'] , PDO::PARAM_INT);
        $stmt->bindValue(':annee', $data['annee'] , PDO::PARAM_INT);

        $stmt->execute();
        
        return (int)$this->db->lastInsertId();
    }
         
    public function getAllEcart(): array
    {
        $query = "SELECT * FROM ecart";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les écarts par ID de département
     * 
     * @param int $idDept L'ID du département
     * @return array Liste des écarts pour ce département
     */
    public function getByIdDept(int $idDept): array
    {
        $query = "SELECT * FROM ecart WHERE id_dept = :id_dept";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_dept', $idDept, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}