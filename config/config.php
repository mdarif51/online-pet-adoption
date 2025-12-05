<?php


// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pet_adoption');

// Site configuration
define('SITE_URL', 'http://localhost/pet-adoption-system');
define('UPLOAD_PATH', __DIR__ . '/../uploads/pets/');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Dhaka');

