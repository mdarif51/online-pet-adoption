<?php
/**
 * Adoption Request Model
 * Handles adoption request database operations
 */

require_once __DIR__ . '/../core/Database.php';

class AdoptionRequest {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Create adoption request
     * @param array $data
     * @return array
     */
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO adopt_request (adopter_id, owner_id, pet_id, status, date) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['adopter_id'],
                $data['owner_id'],
                $data['pet_id'],
                $data['status'] ?? 'Pending',
                $data['date']
            ]);
            
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get requests for adopter
     * @param int $adopterId
     * @return array
     */
    public function getByAdopter($adopterId) {
        $stmt = $this->conn->prepare("
            SELECT ar.*, p.name as pet_name, p.picture as pet_picture, u.name as owner_name 
            FROM adopt_request ar 
            JOIN pets p ON ar.pet_id = p.id 
            JOIN users u ON ar.owner_id = u.id 
            WHERE ar.adopter_id = ? 
            ORDER BY ar.created_at DESC
        ");
        $stmt->execute([$adopterId]);
        return $stmt->fetchAll();
    }

    /**
     * Get requests for owner
     * @param int $ownerId
     * @return array
     */
    public function getByOwner($ownerId) {
        $stmt = $this->conn->prepare("
            SELECT ar.*, p.name as pet_name, p.picture as pet_picture, u.name as adopter_name, u.email as adopter_email, u.phone as adopter_phone 
            FROM adopt_request ar 
            JOIN pets p ON ar.pet_id = p.id 
            JOIN users u ON ar.adopter_id = u.id 
            WHERE ar.owner_id = ? 
            ORDER BY ar.created_at DESC
        ");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll();
    }

    /**
     * Update request status
     * @param int $id
     * @param string $status
     * @return array
     */
    public function updateStatus($id, $status) {
        try {
            $stmt = $this->conn->prepare("UPDATE adopt_request SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            return ['success' => true];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

