<?php
/**
 * Pending Pets Approval View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Pending Pets Approval</h2>
        <p class="text-muted">Review and approve/reject pet listings submitted by owners</p>
        
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
            <div class="alert alert-info">No pending pets for approval.</div>
        </div>
    <?php else: ?>
        <?php foreach ($pets as $pet): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <?php if ($pet['picture']): ?>
                        <img src="../uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
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
                            <strong>Category:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span><br>
                            <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?><br>
                            <strong>Age:</strong> <?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?> years<br>
                            <strong>Gender:</strong> <?php echo htmlspecialchars($pet['gender']); ?><br>
                            <strong>Owner:</strong> <?php echo htmlspecialchars($pet['owner_name'] ?? 'N/A'); ?><br>
                            <?php if ($pet['description']): ?>
                                <strong>Description:</strong><br>
                                <?php echo nl2br(htmlspecialchars($pet['description'])); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                            <button type="submit" name="approve" class="btn btn-success">Approve</button>
                            <button type="submit" name="reject" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this pet?');">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

