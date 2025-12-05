<?php
/**
 * Edit Pet View
 */
if (!isset($pet)) {
    header('Location: my-pets.php');
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Edit Pet</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="edit-pet.php?id=<?php echo $pet['id']; ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Pet Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($pet['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="breed" class="form-label">Breed</label>
                            <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($pet['breed'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="Male" <?php echo $pet['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $pet['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age (years)</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($pet['age'] ?? ''); ?>" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($pet['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Pet Picture</label>
                        <?php if ($pet['picture']): ?>
                            <div class="mb-2">
                                <img src="uploads/pets/<?php echo htmlspecialchars($pet['picture']); ?>" alt="Current picture" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="featured" name="featured" value="Yes" <?php echo $pet['featured'] == 'Yes' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="featured">
                            Feature this pet
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Pet</button>
                    <a href="my-pets.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

