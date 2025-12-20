<?php
/**
 * Delete Pet Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'models/Pet.php';

Session::start();

$auth = new Auth();
$auth->requireUserType(['Owner', 'Shelter']); // Only Owner/Shelter can delete

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petId = $_POST['pet_id'] ?? 0;
    
    $pet = new Pet();
    $petData = $pet->getById($petId);
    
    // Check if pet belongs to current user
    if ($petData && $petData['user_id'] == $auth->getUserId()) {
        $result = $pet->delete($petId);
        if ($result && $result['success']) {
            header('Location: my-pets.php?deleted=1');
            exit();
        } else {
            header('Location: my-pets.php?error=' . urlencode($result['message'] ?? 'Failed to delete pet'));
            exit();
        }
    } else {
        header('Location: my-pets.php?error=Unauthorized');
        exit();
    }
} else {
    header('Location: my-pets.php');
    exit();
}

