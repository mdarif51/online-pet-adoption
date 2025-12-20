<?php
/**
 * My Adoptions Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'models/Adoption.php';

Session::start();

$auth = new Auth();
$auth->requireUserType('Adopter'); // Only Adopter can view adoptions

$adoption = new Adoption();
$adoptions = $adoption->getByUser($auth->getUserId(), 'adopter');

$pageTitle = 'My Adoptions - Pet Adoption System';
include 'views/layouts/header.php';
include 'views/adoption/my-adoptions-view.php';
include 'views/layouts/footer.php';

