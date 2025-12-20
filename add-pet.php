<?php
/**
 * Add Pet Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/PetController.php';

Session::start();

$auth = new Auth();
$auth->requireUserType(['Owner', 'Shelter']);

$petController = new PetController();
$result = $petController->createPet();

if ($result && $result['success']) {
    header('Location: my-pets.php');
    exit();
}

$error = $result['message'] ?? null;
$success = null;
$pageTitle = 'Add Pet - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/pets/add-pet-view.php';
include 'views/layouts/footer.php';

