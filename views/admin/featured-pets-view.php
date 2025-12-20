<?php
/**
 * Featured Pets Management View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Featured Pets Management</h2>
        <p class="text-muted">Manage which pets are featured on the home page</p>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>

<div class="row">
    <?php if (empty($pets)): ?>
        <div class="col-12">
            <div class="alert alert-info">No pets found.</div>
        </div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($pet['picture']): ?>
                        <img src="../uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($pet['name']); ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-white">No Image</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                        <p class="card-text">
                            <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?><br>
                            <strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years<br>
                            <strong>Status:</strong> 
                            <span class="badge bg-<?php echo $pet['adoption_status'] == 'Available' ? 'success' : 'secondary'; ?>">
                                <?php echo htmlspecialchars($pet['adoption_status']); ?>
                            </span><br>
                            <strong>Featured:</strong> 
                            <span class="badge bg-<?php echo $pet['featured'] == 'Yes' ? 'warning' : 'secondary'; ?>">
                                <?php echo htmlspecialchars($pet['featured']); ?>
                            </span><br>
                            <strong>Owner:</strong> <?php echo htmlspecialchars($pet['owner_name'] ?? 'N/A'); ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                            <button type="submit" name="toggle_featured" 
                                    class="btn btn-<?php echo $pet['featured'] == 'Yes' ? 'secondary' : 'warning'; ?>">
                                <?php echo $pet['featured'] == 'Yes' ? 'Remove from Featured' : 'Make Featured'; ?>
                            </button>
                        </form>
                        <a href="../pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-sm btn-info">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

