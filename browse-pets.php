<?php
/**
 * Browse Pets Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/PetController.php';

Session::start();

$auth = new Auth();
// Redirect admin to admin panel
if ($auth->isLoggedIn() && $auth->getUserType() == 'Admin') {
    header('Location: admin/dashboard.php');
    exit();
}

$petController = new PetController();

// Get filters
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

$filters = [
    'adoption_status' => 'Available',
    'approval_status' => 'Approved' // Only show approved pets
];

if ($category) {
    $filters['category'] = $category;
}

if ($search) {
    $filters['search'] = $search;
}

$pets = $petController->getAllPets($filters);

$pageTitle = 'Browse Pets - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/pets/browse-view.php';
include 'views/layouts/footer.php';

