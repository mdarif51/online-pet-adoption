<?php
/**
 * Profile Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/UserController.php';

Session::start();

$auth = new Auth();
// Admin cannot access profile page (they have separate admin panel)
if ($auth->getUserType() == 'Admin') {
    header('Location: admin/dashboard.php');
    exit();
}

$userController = new UserController();

// Handle profile update
$updateResult = null;
$passwordResult = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $updateResult = $userController->updateProfile();
    } elseif (isset($_POST['change_password'])) {
        $passwordResult = $userController->changePassword();
    }
}

$user = $userController->getProfile();

$pageTitle = 'My Profile - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/user/profile-view.php';
include 'views/layouts/footer.php';

