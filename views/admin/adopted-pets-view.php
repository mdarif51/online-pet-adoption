<?php
/**
 * Adopted Pets View (Admin)
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Adopted Pets</h2>
        <p class="text-muted">List of all adopted pets</p>
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
                        <th>Category</th>
                        <th>Breed</th>
                        <th>Owner</th>
                        <th>Adopter</th>
                        <th>Adoption Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pets)): ?>
                        <tr>
                            <td colspan="8" class="text-center">No adopted pets found</td>
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
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($pet['category'] ?? 'Other'); ?></span></td>
                                <td><?php echo htmlspecialchars($pet['breed'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($pet['owner_name'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if (isset($pet['adoption_info'])): ?>
                                        <?php echo htmlspecialchars($pet['adoption_info']['adopter_name']); ?><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($pet['adoption_info']['adopter_email']); ?></small>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (isset($pet['adoption_info'])): ?>
                                        <?php echo date('M d, Y', strtotime($pet['adoption_info']['date'])); ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

