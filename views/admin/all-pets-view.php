<?php
/**
 * All Pets Management View (Admin)
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">All Pets Management</h2>
        <p class="text-muted">View and manage all pets in the system</p>
        
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
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Owner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pets)): ?>
                        <tr>
                            <td colspan="10" class="text-center">No pets found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pets as $pet): ?>
                            <tr>
                                <td><?php echo $pet['id']; ?></td>
                                <td>
                                    <?php if ($pet['picture']): ?>
                                        <img src="../uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" 
                                             alt="<?php echo htmlspecialchars($pet['name']); ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($pet['name']); ?></td>
                                <td><?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($pet['age'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $pet['adoption_status'] == 'Available' ? 'success' : 'secondary'; ?>">
                                        <?php echo htmlspecialchars($pet['adoption_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                        <button type="submit" name="toggle_featured" 
                                                class="btn btn-sm btn-<?php echo $pet['featured'] == 'Yes' ? 'warning' : 'secondary'; ?>">
                                            <?php echo $pet['featured'] == 'Yes' ? 'Featured' : 'Not Featured'; ?>
                                        </button>
                                    </form>
                                </td>
                                <td><?php echo htmlspecialchars($pet['owner_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="../pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-sm btn-info">View</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                        <input type="hidden" name="pet_id" value="<?php echo $pet['id']; ?>">
                                        <button type="submit" name="delete_pet" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

