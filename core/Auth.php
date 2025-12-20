<?php
/**
 * Authentication Class
 * Handles login/logout and user authentication
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';

class Auth {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        Session::start();
    }

    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', $user['id']);
                Session::set('user_name', $user['name']);
                Session::set('user_email', $user['email']);
                Session::set('user_type', $user['usertype']);
                
                return ['success' => true, 'message' => 'Login successful', 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'Invalid email or password'];
            }
        } catch(PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public function isLoggedIn() {
        return Session::has('user_id');
    }

    /**
     * Get current user ID
     * @return int|null
     */
    public function getUserId() {
        return Session::get('user_id');
    }

    /**
     * Get current user type
     * @return string|null
     */
    public function getUserType() {
        return Session::get('user_type');
    }

    /**
     * Logout user
     */
    public function logout() {
        Session::destroy();
    }

    /**
     * Require login - redirect if not logged in
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit();
        }
    }

    /**
     * Require specific user type
     * @param string|array $userTypes
     */
    public function requireUserType($userTypes) {
        $this->requireLogin();
        
        if (!is_array($userTypes)) {
            $userTypes = [$userTypes];
        }
        
        if (!in_array($this->getUserType(), $userTypes)) {
            header('Location: index.php');
            exit();
        }
    }
}

