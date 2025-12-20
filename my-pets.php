<?php
/**
 * My Pets Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/PetController.php';

Session::start();

$auth = new Auth();
$auth->requireUserType(['Owner', 'Shelter']);

$petController = new PetController();
$pets = $petController->getAllPets(['user_id' => $auth->getUserId()]);

$pageTitle = 'My Pets - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/pets/my-pets-view.php';
include 'views/layouts/footer.php';

