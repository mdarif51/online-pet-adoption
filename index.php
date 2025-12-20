<?php
/**
 * Home Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'models/Pet.php';

Session::start();
$auth = new Auth();

// Redirect admin to admin panel
if ($auth->isLoggedIn() && $auth->getUserType() == 'Admin') {
    header('Location: admin/dashboard.php');
    exit();
}

$pet = new Pet();

// Get search and category filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Get featured pets (only approved and available)
$featuredFilters = [
    'featured' => 'Yes', 
    'adoption_status' => 'Available',
    'approval_status' => 'Approved'
];
$featuredPets = $pet->getAll($featuredFilters);

// Get recent pets (only approved and available, exclude featured ones)
$recentFilters = [
    'adoption_status' => 'Available',
    'approval_status' => 'Approved'
];
// Don't apply search/category filters for recent pets section
$allRecentPets = $pet->getAll($recentFilters);

// Exclude featured pets from recent pets
$featuredPetIds = array_column($featuredPets, 'id');
$recentPets = array_filter($allRecentPets, function($pet) use ($featuredPetIds) {
    return !in_array($pet['id'], $featuredPetIds);
});
$recentPets = array_slice($recentPets, 0, 6);

$pageTitle = 'Home - Pet Adoption System';
include 'views/layouts/header.php';
?>

<div class="hero-section bg-primary text-white text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-4">Welcome to Pet Adoption System</h1>
        <p class="lead">Find your perfect companion and give them a loving home</p>
        
        <!-- Search Form -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <form method="GET" action="index.php" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-lg" name="search" 
                               placeholder="Search pets..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control form-control-lg" name="category">
                            <option value="">All Categories</option>
                            <option value="Dog" <?php echo ($category == 'Dog') ? 'selected' : ''; ?>>Dog</option>
                            <option value="Cat" <?php echo ($category == 'Cat') ? 'selected' : ''; ?>>Cat</option>
                            <option value="Bird" <?php echo ($category == 'Bird') ? 'selected' : ''; ?>>Bird</option>
                            <option value="Rabbit" <?php echo ($category == 'Rabbit') ? 'selected' : ''; ?>>Rabbit</option>
                            <option value="Hamster" <?php echo ($category == 'Hamster') ? 'selected' : ''; ?>>Hamster</option>
                            <option value="Fish" <?php echo ($category == 'Fish') ? 'selected' : ''; ?>>Fish</option>
                            <option value="Other" <?php echo ($category == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-light btn-lg w-100">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="browse-pets.php" class="btn btn-outline-light btn-lg">Browse All Pets</a>
        </div>
    </div>
</div>

<?php if (!empty($featuredPets)): ?>
    <section class="mb-5">
        <h2 class="mb-4">⭐ Featured Pets</h2>
        <div class="row">
            <?php foreach (array_slice($featuredPets, 0, 3) as $pet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="pet-details.php?id=<?php echo $pet['id']; ?>" style="text-decoration: none; color: inherit;">
                            <?php if ($pet['picture']): ?>
                                <img src="uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($pet['name']); ?>"
                                     style="height: 250px; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                            <p class="card-text">
                                <span class="badge bg-info"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span><br>
                                <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($recentPets)): ?>
    <section>
        <h2 class="mb-4">🆕 Recently Added Pets</h2>
        <div class="row">
            <?php foreach ($recentPets as $pet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="pet-details.php?id=<?php echo $pet['id']; ?>" style="text-decoration: none; color: inherit;">
                            <?php if ($pet['picture']): ?>
                                <img src="uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($pet['name']); ?>"
                                     style="height: 200px; object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px; cursor: pointer;">
                                    <span class="text-white">No Image</span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                            <p class="card-text">
                                <span class="badge bg-info"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span><br>
                                <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?><br>
                                <strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="browse-pets.php" class="btn btn-primary btn-lg">Browse All Pets</a>
        </div>
    </section>
<?php endif; ?>

<?php include 'views/layouts/footer.php'; ?>

