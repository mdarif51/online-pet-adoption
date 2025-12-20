<?php
/**
 * Adoption Model
 * Handles adoption history database operations
 */

require_once __DIR__ . '/../core/Database.php';

class Adoption {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Create adoption record
     * @param array $data
     * @return array
     */
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO adoption (adopter_id, owner_id, pet_id, date) 
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['adopter_id'],
                $data['owner_id'],
                $data['pet_id'],
                $data['date']
            ]);
            
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get adoption history for user
     * @param int $userId
     * @param string $role (adopter or owner)
     * @return array
     */
    public function getByUser($userId, $role = 'adopter') {
        if ($role === 'adopter') {
            $sql = "SELECT a.*, p.name as pet_name, p.picture as pet_picture, u.name as owner_name 
                    FROM adoption a 
                    JOIN pets p ON a.pet_id = p.id 
                    JOIN users u ON a.owner_id = u.id 
                    WHERE a.adopter_id = ? 
                    ORDER BY a.created_at DESC";
        } else {
            $sql = "SELECT a.*, p.name as pet_name, p.picture as pet_picture, u.name as adopter_name 
                    FROM adoption a 
                    JOIN pets p ON a.pet_id = p.id 
                    JOIN users u ON a.adopter_id = u.id 
                    WHERE a.owner_id = ? 
                    ORDER BY a.created_at DESC";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}

