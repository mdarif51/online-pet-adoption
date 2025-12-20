<?php
/**
 * Admin User Creation Script
 * Run this file once to create an admin user
 * IMPORTANT: Delete this file after creating admin for security!
 */

require_once 'config/config.php';
require_once 'core/Database.php';

// Security: Check if admin already exists (optional check)
// You can comment this out if you want to create multiple admins

$db = new Database();
$conn = $db->getConnection();

// Check if admin exists
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE usertype = 'Admin'");
$stmt->execute();
$result = $stmt->fetch();

if ($result['count'] > 0 && !isset($_GET['force'])) {
    die("Admin user already exists. Add ?force=1 to URL to create another admin.");
}

// Admin credentials (CHANGE THESE!)
$adminName = 'Admin User';
$adminEmail = 'admin@example.com';
$adminPassword = 'admin123';  // CHANGE THIS PASSWORD!
$adminPhone = '1234567890';
$adminAddress = 'Admin Address';

// Validate inputs
if (empty($adminEmail) || empty($adminPassword)) {
    die("Please set admin email and password in create_admin.php file");
}

try {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);
    if ($stmt->fetch()) {
        die("Email already exists. Please use a different email.");
    }

    // Hash password
    $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

    // Insert admin user
    $stmt = $conn->prepare("
        INSERT INTO users (name, email, phone, password, address, usertype, terms_accepted) 
        VALUES (?, ?, ?, ?, ?, 'Admin', 1)
    ");
    
    $stmt->execute([
        $adminName,
        $adminEmail,
        $adminPhone,
        $hashedPassword,
        $adminAddress
    ]);

    $adminId = $conn->lastInsertId();
    
    echo "✅ Admin user created successfully!<br>";
    echo "Admin ID: $adminId<br>";
    echo "Email: $adminEmail<br>";
    echo "Password: $adminPassword<br><br>";
    echo "⚠️ <strong>IMPORTANT:</strong> Please delete this file (create_admin.php) for security!<br>";
    echo "⚠️ Change your password after first login!<br>";
    
} catch(PDOException $e) {
    die("Error creating admin: " . $e->getMessage());
}

