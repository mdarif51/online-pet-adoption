<?php
/**
 * Authentication Controller
 * Handles authentication actions
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Validator.php';

class AuthController {
    private $auth;
    private $user;

    public function __construct() {
        $this->auth = new Auth();
        $this->user = new User();
    }

    /**
     * Handle login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Validator::sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return ['success' => false, 'message' => 'Email and password are required'];
            }

            if (!Validator::validateEmail($email)) {
                return ['success' => false, 'message' => 'Invalid email format'];
            }

            $result = $this->auth->login($email, $password);
            return $result;
        }
        return null;
    }

    /**
     * Handle registration
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'email' => Validator::sanitize($_POST['email'] ?? ''),
                'phone' => Validator::sanitize($_POST['phone'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'address' => Validator::sanitize($_POST['address'] ?? ''),
                'usertype' => $_POST['usertype'] ?? 'Adopter',
                'terms_accepted' => isset($_POST['terms']) ? 1 : 0
            ];

            $required = ['name', 'email', 'password', 'usertype'];
            $errors = Validator::validateRequired($data, $required);

            if (!empty($errors)) {
                return ['success' => false, 'message' => implode(', ', $errors)];
            }

            if (!Validator::validateEmail($data['email'])) {
                return ['success' => false, 'message' => 'Invalid email format'];
            }

            if (!Validator::validatePassword($data['password'])) {
                return ['success' => false, 'message' => 'Password must be at least 6 characters'];
            }

            if ($this->user->getByEmail($data['email'])) {
                return ['success' => false, 'message' => 'Email already exists'];
            }

            $result = $this->user->create($data);
            if ($result['success']) {
                $this->auth->login($data['email'], $_POST['password']);
            }
            return $result;
        }
        return null;
    }
}

