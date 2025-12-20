<?php
/**
 * Edit Pet Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/PetController.php';

Session::start();

$auth = new Auth();
$auth->requireUserType(['Owner', 'Shelter']); // Only Owner/Shelter can edit

$petController = new PetController();
$petId = $_GET['id'] ?? 0;
$pet = $petController->getPetById($petId);

if (!$pet || $pet['user_id'] != $auth->getUserId()) {
    header('Location: my-pets.php');
    exit();
}

$result = $petController->updatePet($petId);

if ($result && $result['success']) {
    $pet = $petController->getPetById($petId); // Refresh pet data
    $success = 'Pet updated successfully!';
} else {
    $error = $result['message'] ?? null;
}

$pageTitle = 'Edit Pet - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/pets/edit-pet-view.php';
include 'views/layouts/footer.php';

