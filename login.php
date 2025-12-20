<?php
/**
 * Login Page
 */
require_once 'core/Session.php';
require_once 'controllers/AuthController.php';

Session::start();

$auth = new Auth();
if ($auth->isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$authController = new AuthController();
$result = $authController->login();

if ($result && $result['success']) {
    header('Location: index.php');
    exit();
}

$error = $result['message'] ?? null;
$pageTitle = 'Login - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/auth/login-view.php';
include 'views/layouts/footer.php';

