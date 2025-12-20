<?php
/**
 * User Model
 * Handles user-related database operations
 */

require_once __DIR__ . '/../core/Database.php';

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * Create new user
     * @param array $data
     * @return array
     */
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO users (name, email, phone, password, address, usertype, terms_accepted) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['phone'] ?? null,
                $hashedPassword,
                $data['address'] ?? null,
                $data['usertype'],
                $data['terms_accepted'] ?? 0
            ]);
            
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get user by ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get user by email
     * @param string $email
     * @return array|null
     */
    public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Update user
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if ($key === 'password') {
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                $fields[] = "$key = ?";
                $values[] = $value;
            }
            
            $values[] = $id;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            
            return ['success' => true];
        } catch(PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

