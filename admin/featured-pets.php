<?php
/**
 * Featured Pets Management (Admin)
 */
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../controllers/AdminController.php';

Session::start();

$adminController = new AdminController();

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

// Get only approved pets for featured management
$pets = $adminController->getAllPets(['approval_status' => 'Approved']);

$pageTitle = 'Featured Pets Management - Admin';
$pendingCount = count($adminController->getPendingPets());
include __DIR__ . '/../views/layouts/admin-header.php';
include __DIR__ . '/../views/admin/featured-pets-view.php';
include __DIR__ . '/../views/layouts/admin-footer.php';

