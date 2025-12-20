<?php
/**
 * Pending Pets Approval (Admin)
 */
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../controllers/AdminController.php';

Session::start();

$adminController = new AdminController();

// Handle approve/reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petId = $_POST['pet_id'] ?? 0;
    
    if (isset($_POST['approve'])) {
        $result = $adminController->approvePet($petId);
        if ($result && $result['success']) {
            $success = 'Pet approved successfully!';
        } else {
            $error = $result['message'] ?? 'Failed to approve pet';
        }
    } elseif (isset($_POST['reject'])) {
        $result = $adminController->rejectPet($petId);
        if ($result && $result['success']) {
            $success = 'Pet rejected';
        } else {
            $error = $result['message'] ?? 'Failed to reject pet';
        }
    }
}

// Get pending pets
$pets = $adminController->getPendingPets();

$pageTitle = 'Pending Pets Approval - Admin';
$pendingCount = count($adminController->getPendingPets());
include __DIR__ . '/../views/layouts/admin-header.php';
include __DIR__ . '/../views/admin/pending-pets-view.php';
include __DIR__ . '/../views/layouts/admin-footer.php';

