<?php
/**
 * My Pets View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">My Pets</h2>
        <a href="add-pet.php" class="btn btn-primary mb-3">Add New Pet</a>
    </div>
</div>

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12">
            <div class="alert alert-info">You haven't added any pets yet.</div>
        </div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($pet['picture']): ?>
                        <img src="uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($pet['name']); ?>"
                             style="height: 250px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                            <span class="text-white">No Image</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                        <p class="card-text">
                            <strong>Status:</strong> 
                            <span class="badge bg-<?php echo $pet['adoption_status'] == 'Available' ? 'success' : 'secondary'; ?>">
                                <?php echo htmlspecialchars($pet['adoption_status']); ?>
                            </span><br>
                            <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?><br>
                            <strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-sm btn-info">View</a>
                        <a href="edit-pet.php?id=<?php echo $pet['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

