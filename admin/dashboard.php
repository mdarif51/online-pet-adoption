<?php
/**
 * Admin Dashboard
 */
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../controllers/AdminController.php';

Session::start();

$adminController = new AdminController();
$stats = $adminController->getDashboardStats();

$pageTitle = 'Admin Dashboard - Pet Adoption System';
$pendingCount = count($adminController->getPendingPets());
include __DIR__ . '/../views/layouts/admin-header.php';
include __DIR__ . '/../views/admin/dashboard-view.php';
include __DIR__ . '/../views/layouts/admin-footer.php';

