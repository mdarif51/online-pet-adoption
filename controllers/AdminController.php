<?php
/**
 * Admin Controller
 * Handles admin-related actions
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Adoption.php';
require_once __DIR__ . '/../models/AdoptionRequest.php';

class AdminController {
    private $auth;
    private $pet;
    private $user;

    public function __construct() {
        $this->auth = new Auth();
        $this->pet = new Pet();
        $this->user = new User();
        $this->auth->requireUserType('Admin');
    }

    /**
     * Get dashboard statistics
     */
    public function getDashboardStats() {
        $db = new Database();
        $conn = $db->getConnection();

        $stats = [];

        // Total users
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users WHERE usertype != 'Admin'");
        $stats['total_users'] = $stmt->fetch()['count'];

        // Total pets
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pets");
        $stats['total_pets'] = $stmt->fetch()['count'];

        // Available pets
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pets WHERE adoption_status = 'Available'");
        $stats['available_pets'] = $stmt->fetch()['count'];

        // Adopted pets
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pets WHERE adoption_status = 'Adopted'");
        $stats['adopted_pets'] = $stmt->fetch()['count'];

        // Featured pets
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pets WHERE featured = 'Yes'");
        $stats['featured_pets'] = $stmt->fetch()['count'];

        // Pending pets for approval
        $stmt = $conn->query("SELECT COUNT(*) as count FROM pets WHERE approval_status = 'Pending'");
        $stats['pending_pets'] = $stmt->fetch()['count'];

        // Pending requests
        $stmt = $conn->query("SELECT COUNT(*) as count FROM adopt_request WHERE status = 'Pending'");
        $stats['pending_requests'] = $stmt->fetch()['count'];

        // Total adoptions
        $stmt = $conn->query("SELECT COUNT(*) as count FROM adoption");
        $stats['total_adoptions'] = $stmt->fetch()['count'];

        return $stats;
    }

    /**
     * Get all pets (admin view)
     */
    public function getAllPets($filters = []) {
        return $this->pet->getAll($filters);
    }

    /**
     * Get pending pets for approval
     */
    public function getPendingPets() {
        return $this->pet->getAll(['approval_status' => 'Pending']);
    }

    /**
     * Get adopted pets
     */
    public function getAdoptedPets() {
        return $this->pet->getAll(['adoption_status' => 'Adopted']);
    }

    /**
     * Approve pet
     */
    public function approvePet($petId) {
        $pet = $this->pet->getById($petId);
        if (!$pet) {
            return ['success' => false, 'message' => 'Pet not found'];
        }

        $result = $this->pet->update($petId, ['approval_status' => 'Approved']);
        
        if ($result['success']) {
            return ['success' => true, 'message' => 'Pet approved successfully'];
        }
        
        return $result;
    }

    /**
     * Reject pet
     */
    public function rejectPet($petId) {
        $pet = $this->pet->getById($petId);
        if (!$pet) {
            return ['success' => false, 'message' => 'Pet not found'];
        }

        $result = $this->pet->update($petId, ['approval_status' => 'Rejected']);
        
        if ($result['success']) {
            return ['success' => true, 'message' => 'Pet rejected'];
        }
        
        return $result;
    }

    /**
     * Toggle featured status of a pet (only approved pets can be featured)
     */
    public function toggleFeatured($petId) {
        $pet = $this->pet->getById($petId);
        if (!$pet) {
            return ['success' => false, 'message' => 'Pet not found'];
        }

        if ($pet['approval_status'] !== 'Approved') {
            return ['success' => false, 'message' => 'Only approved pets can be featured'];
        }

        $newStatus = $pet['featured'] === 'Yes' ? 'No' : 'Yes';
        $result = $this->pet->update($petId, ['featured' => $newStatus]);
        
        if ($result['success']) {
            return ['success' => true, 'message' => 'Featured status updated', 'featured' => $newStatus];
        }
        
        return $result;
    }

    /**
     * Delete pet (admin can delete any pet)
     */
    public function deletePet($petId) {
        return $this->pet->delete($petId);
    }

    /**
     * Get all users
     */
    public function getAllUsers() {
        $db = new Database();
        $conn = $db->getConnection();
        
        $stmt = $conn->query("SELECT id, name, email, phone, usertype, created_at FROM users WHERE usertype != 'Admin' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
}

