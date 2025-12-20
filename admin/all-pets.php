<?php
/**
 * All Pets Management (Admin)
 */
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../controllers/AdminController.php';

Session::start();

$adminController = new AdminController();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pet'])) {
    $petId = $_POST['pet_id'] ?? 0;
    $result = $adminController->deletePet($petId);
    if ($result && $result['success']) {
        $success = 'Pet deleted successfully';
    } else {
        $error = $result['message'] ?? 'Failed to delete pet';
    }
}

// Handle featured toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_featured'])) {
    $petId = $_POST['pet_id'] ?? 0;
    $result = $adminController->toggleFeatured($petId);
    if ($result && $result['success']) {
        $success = $result['message'];
    } else {
        $error = $result['message'] ?? 'Failed to update featured status';
    }
}

// Get all pets
$pets = $adminController->getAllPets();

$pageTitle = 'All Pets Management - Admin';
$pendingCount = count($adminController->getPendingPets());
include __DIR__ . '/../views/layouts/admin-header.php';
include __DIR__ . '/../views/admin/all-pets-view.php';
include __DIR__ . '/../views/layouts/admin-footer.php';

