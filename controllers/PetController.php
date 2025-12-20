<?php
/**
 * Pet Controller
 * Handles pet-related actions
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../core/Validator.php';

class PetController {
    private $auth;
    private $pet;

    public function __construct() {
        $this->auth = new Auth();
        $this->pet = new Pet();
    }

    /**
     * Get all pets
     */
    public function getAllPets($filters = []) {
        return $this->pet->getAll($filters);
    }

    /**
     * Get pet by ID
     */
    public function getPetById($id) {
        return $this->pet->getById($id);
    }

    /**
     * Create new pet
     */
    public function createPet() {
        $this->auth->requireUserType(['Owner', 'Shelter']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'breed' => Validator::sanitize($_POST['breed'] ?? ''),
                'category' => $_POST['category'] ?? 'Other',
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'gender' => $_POST['gender'] ?? '',
                'age' => $_POST['age'] ?? null,
                'featured' => 'No', // Owner cannot set featured, only admin can
                'approval_status' => 'Pending', // New pets need admin approval
                'user_id' => $this->auth->getUserId()
            ];

            // Handle file upload
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleFileUpload($_FILES['picture']);
                if ($uploadResult['success']) {
                    $data['picture'] = $uploadResult['filename'];
                } else {
                    return ['success' => false, 'message' => $uploadResult['message']];
                }
            }

            return $this->pet->create($data);
        }
        return null;
    }

    /**
     * Update pet
     */
    public function updatePet($id) {
        $this->auth->requireLogin();
        $pet = $this->pet->getById($id);
        
        if (!$pet || $pet['user_id'] != $this->auth->getUserId()) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => Validator::sanitize($_POST['name'] ?? ''),
                'breed' => Validator::sanitize($_POST['breed'] ?? ''),
                'category' => $_POST['category'] ?? 'Other',
                'description' => Validator::sanitize($_POST['description'] ?? ''),
                'gender' => $_POST['gender'] ?? '',
                'age' => $_POST['age'] ?? null
                // Owner cannot change featured or approval_status
            ];

            // Handle file upload
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleFileUpload($_FILES['picture']);
                if ($uploadResult['success']) {
                    $data['picture'] = $uploadResult['filename'];
                } else {
                    return ['success' => false, 'message' => $uploadResult['message']];
                }
            }

            return $this->pet->update($id, $data);
        }
        return null;
    }

    /**
     * Handle file upload
     */
    private function handleFileUpload($file) {
        $errors = Validator::validateFile($file);
        if (!empty($errors)) {
            return ['success' => false, 'message' => implode(', ', $errors)];
        }

        $uploadDir = __DIR__ . '/../uploads/pets/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'message' => 'Failed to upload file'];
        }
    }
}

