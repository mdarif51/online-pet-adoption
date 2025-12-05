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

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12">
            <div class="alert alert-info">No pets available at the moment.</div>
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

