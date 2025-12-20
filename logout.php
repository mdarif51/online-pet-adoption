<?php
/**
 * Logout Script
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';

Session::start();
$auth = new Auth();
$auth->logout();

header('Location: index.php');
exit();

