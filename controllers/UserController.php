<?php
/**
 * User Controller
 * Handles user profile actions
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Validator.php';

class UserController {
    private $auth;
    private $user;

    public function __construct() {
        $this->auth = new Auth();
        $this->user = new User();
    }

    /**
     * Get current user profile
     */
    public function getProfile() {
        $this->auth->requireLogin();
        $userId = $this->auth->getUserId();
        return $this->user->getById($userId);
    }

    /**
     * Update user profile
     */
    public function updateProfile() {
        $this->auth->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $this->auth->getUserId();
            $currentUser = $this->user->getById($userId);
            
            $data = [
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'phone' => Validator::sanitize($_POST['phone'] ?? ''),
                'address' => Validator::sanitize($_POST['address'] ?? '')
            ];

            // Validate email if changed
            $email = Validator::sanitize($_POST['email'] ?? '');
            if ($email !== $currentUser['email']) {
                if (!Validator::validateEmail($email)) {
                    return ['success' => false, 'message' => 'Invalid email format'];
                }
                
                // Check if email already exists
                $existingUser = $this->user->getByEmail($email);
                if ($existingUser && $existingUser['id'] != $userId) {
                    return ['success' => false, 'message' => 'Email already exists'];
                }
                
                $data['email'] = $email;
            }

            $result = $this->user->update($userId, $data);
            
            if ($result['success']) {
                // Update session if email or name changed
                if (isset($data['email'])) {
                    Session::set('user_email', $data['email']);
                }
                Session::set('user_name', $data['name']);
            }
            
            return $result;
        }
        return null;
    }

    /**
     * Change password
     */
    public function changePassword() {
        $this->auth->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $this->auth->getUserId();
            $currentUser = $this->user->getById($userId);
            
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate current password
            if (!password_verify($currentPassword, $currentUser['password'])) {
                return ['success' => false, 'message' => 'Current password is incorrect'];
            }

            // Validate new password
            if (empty($newPassword)) {
                return ['success' => false, 'message' => 'New password is required'];
            }

            if (!Validator::validatePassword($newPassword)) {
                return ['success' => false, 'message' => 'Password must be at least 6 characters'];
            }

            if ($newPassword !== $confirmPassword) {
                return ['success' => false, 'message' => 'New passwords do not match'];
            }

            if ($currentPassword === $newPassword) {
                return ['success' => false, 'message' => 'New password must be different from current password'];
            }

            $result = $this->user->update($userId, ['password' => $newPassword]);
            return $result;
        }
        return null;
    }
}

