<?php
/**
 * Pet Model
 * Handles pet-related database operations
 */

require_once __DIR__ . '/../core/Database.php';

class Pet {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Create new pet
     * @param array $data
     * @return array
     */
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO pets (name, breed, category, picture, description, featured, gender, user_id, age, approval_status, adoption_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['name'],
                $data['breed'] ?? null,
                $data['category'] ?? 'Other',
                $data['picture'] ?? null,
                $data['description'] ?? null,
                $data['featured'] ?? 'No',
                $data['gender'],
                $data['user_id'],
                $data['age'] ?? null,
                $data['approval_status'] ?? 'Pending',
                $data['adoption_status'] ?? 'Available'
            ]);
            
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get pet by ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, u.name as owner_name, u.email as owner_email, u.phone as owner_phone, u.address as owner_address 
            FROM pets p 
            LEFT JOIN users u ON p.user_id = u.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get all pets
     * @param array $filters
     * @return array
     */
    public function getAll($filters = []) {
        $sql = "SELECT p.*, u.name as owner_name FROM pets p LEFT JOIN users u ON p.user_id = u.id WHERE 1=1";
        $params = [];
        
        if (isset($filters['adoption_status'])) {
            $sql .= " AND p.adoption_status = ?";
            $params[] = $filters['adoption_status'];
        }
        
        if (isset($filters['approval_status'])) {
            $sql .= " AND p.approval_status = ?";
            $params[] = $filters['approval_status'];
        }
        
        if (isset($filters['featured'])) {
            $sql .= " AND p.featured = ?";
            $params[] = $filters['featured'];
        }
        
        if (isset($filters['category'])) {
            $sql .= " AND p.category = ?";
            $params[] = $filters['category'];
        }
        
        if (isset($filters['user_id'])) {
            $sql .= " AND p.user_id = ?";
            $params[] = $filters['user_id'];
        }
        
        if (isset($filters['search'])) {
            $sql .= " AND (p.name LIKE ? OR p.breed LIKE ? OR p.description LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Update pet
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
            
            $values[] = $id;
            $sql = "UPDATE pets SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            
            return ['success' => true];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete pet
     * @param int $id
     * @return array
     */
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM pets WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

