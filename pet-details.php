<?php
/**
 * Pet Details Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'controllers/PetController.php';
require_once 'controllers/AdoptionController.php';

Session::start();

$auth = new Auth();
// Redirect admin to admin panel
if ($auth->isLoggedIn() && $auth->getUserType() == 'Admin') {
    header('Location: admin/dashboard.php');
    exit();
}

$petController = new PetController();
$adoptionController = new AdoptionController();

$petId = $_GET['id'] ?? 0;
$pet = $petController->getPetById($petId);

if (!$pet) {
    header('Location: browse-pets.php');
    exit();
}

// Handle adoption request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_adoption'])) {
    $result = $adoptionController->createRequest();
    if ($result && $result['success']) {
        $success = 'Adoption request submitted successfully!';
    } else {
        $error = $result['message'] ?? 'Failed to submit request';
    }
}

$pageTitle = $pet['name'] . ' - Pet Details';
include 'views/layouts/header.php';
?>

<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4"><?php echo htmlspecialchars($pet['name']); ?></h2>
        
        <!-- Pet Image -->
        <div class="mb-4">
            <?php if ($pet['picture']): ?>
                <img src="uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                     class="img-fluid rounded shadow" 
                     alt="<?php echo htmlspecialchars($pet['name']); ?>"
                     style="max-height: 500px; width: 100%; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <span class="text-white fs-4">No Image Available</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pet Details -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pet Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Category:</strong> <span class="badge bg-info fs-6"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gender:</strong> <?php echo htmlspecialchars($pet['gender']); ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?php echo $pet['adoption_status'] == 'Available' ? 'success' : 'secondary'; ?> fs-6">
                                <?php echo htmlspecialchars($pet['adoption_status']); ?>
                            </span>
                        </p>
                    </div>
                    <?php if (isset($pet['approval_status'])): ?>
                        <div class="col-md-6">
                            <p><strong>Approval:</strong> 
                                <span class="badge bg-<?php 
                                    echo $pet['approval_status'] == 'Approved' ? 'success' : 
                                        ($pet['approval_status'] == 'Rejected' ? 'danger' : 'warning'); 
                                ?> fs-6">
                                    <?php echo htmlspecialchars($pet['approval_status']); ?>
                                </span>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($pet['description']): ?>
                    <hr>
                    <h5>Description</h5>
                    <p class="text-muted"><?php echo nl2br(htmlspecialchars($pet['description'])); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Adoption Request Form -->
        <?php if ($auth->isLoggedIn() && $pet['adoption_status'] == 'Available' && $pet['approval_status'] == 'Approved' && $auth->getUserType() == 'Adopter' && $pet['user_id'] != $auth->getUserId()): ?>
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Interested in Adopting?</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                        <button type="submit" name="request_adoption" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-heart-fill"></i> Request Adoption
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Owner Contact Information Sidebar -->
    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📞 Contact</h5>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-3">Pet Owner Information</h6>
                
                <div class="mb-3">
                    <strong>Name:</strong><br>
                    <span class="text-primary"><?php echo htmlspecialchars($pet['owner_name']); ?></span>
                </div>
                
                <?php if ($pet['owner_phone']): ?>
                    <div class="mb-3">
                        <strong>Mobile Number:</strong><br>
                        <a href="tel:<?php echo htmlspecialchars($pet['owner_phone']); ?>" class="text-decoration-none">
                            <i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($pet['owner_phone']); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ($pet['owner_email']): ?>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        <a href="mailto:<?php echo htmlspecialchars($pet['owner_email']); ?>" class="text-decoration-none">
                            <i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($pet['owner_email']); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if ($pet['owner_address']): ?>
                    <div class="mb-3">
                        <strong>Address:</strong><br>
                        <span class="text-muted">
                            <i class="bi bi-geo-alt-fill"></i> <?php echo nl2br(htmlspecialchars($pet['owner_address'])); ?>
                        </span>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <strong>Address:</strong><br>
                        <span class="text-muted">Not provided</span>
                    </div>
                <?php endif; ?>
                
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-info-circle"></i> Contact the owner directly for more information about this pet.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>

