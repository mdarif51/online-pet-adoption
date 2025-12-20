<?php
/**
 * Browse Pets View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Browse Available Pets</h2>
    </div>
</div>

<!-- Search and Filter Form -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="browse-pets.php" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Search by name, breed..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">All Categories</option>
                            <option value="Dog" <?php echo (isset($category) && $category == 'Dog') ? 'selected' : ''; ?>>Dog</option>
                            <option value="Cat" <?php echo (isset($category) && $category == 'Cat') ? 'selected' : ''; ?>>Cat</option>
                            <option value="Bird" <?php echo (isset($category) && $category == 'Bird') ? 'selected' : ''; ?>>Bird</option>
                            <option value="Rabbit" <?php echo (isset($category) && $category == 'Rabbit') ? 'selected' : ''; ?>>Rabbit</option>
                            <option value="Hamster" <?php echo (isset($category) && $category == 'Hamster') ? 'selected' : ''; ?>>Hamster</option>
                            <option value="Fish" <?php echo (isset($category) && $category == 'Fish') ? 'selected' : ''; ?>>Fish</option>
                            <option value="Other" <?php echo (isset($category) && $category == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="browse-pets.php" class="btn btn-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12">
            <div class="alert alert-info">No pets available at the moment.</div>
        </div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
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
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px; cursor: pointer;">
                                <span class="text-white">No Image</span>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                        <p class="card-text">
                            <span class="badge bg-info"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span><br>
                            <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?><br>
                            <strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years<br>
                            <strong>Gender:</strong> <?php echo htmlspecialchars($pet['gender']); ?>
                        </p>
                        <?php if ($pet['description']): ?>
                            <p class="card-text"><?php echo htmlspecialchars(substr($pet['description'], 0, 100)); ?>...</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        <a href="pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

