<?php
/**
 * Adopted Pets List (Admin)
 */
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../models/Adoption.php';

Session::start();

$adminController = new AdminController();
$adoption = new Adoption();

// Get adopted pets
$pets = $adminController->getAdoptedPets();

// Get adoption details for each pet
foreach ($pets as &$pet) {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("
        SELECT a.*, u.name as adopter_name, u.email as adopter_email 
        FROM adoption a 
        JOIN users u ON a.adopter_id = u.id 
        WHERE a.pet_id = ? 
        ORDER BY a.created_at DESC 
        LIMIT 1
    ");
    $stmt->execute([$pet['id']]);
    $pet['adoption_info'] = $stmt->fetch();
}

$pageTitle = 'Adopted Pets - Admin';
$pendingCount = count($adminController->getPendingPets());
include __DIR__ . '/../views/layouts/admin-header.php';
include __DIR__ . '/../views/admin/adopted-pets-view.php';
include __DIR__ . '/../views/layouts/admin-footer.php';

