<?php
/**
 * Profile View
 */
if (!isset($user)) {
    header('Location: index.php');
    exit();
}
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <h2 class="mb-4">My Profile</h2>

        <!-- Profile Update Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Profile Information</h4>
            </div>
            <div class="card-body">
                <?php if ($updateResult && $updateResult['success']): ?>
                    <div class="alert alert-success">Profile updated successfully!</div>
                <?php elseif ($updateResult && !$updateResult['success']): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($updateResult['message']); ?></div>
                <?php endif; ?>

                <form method="POST" action="profile.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="usertype" class="form-label">User Type</label>
                            <input type="text" class="form-control" id="usertype" 
                                   value="<?php echo htmlspecialchars($user['usertype']); ?>" disabled>
                            <small class="text-muted">User type cannot be changed</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            Member since: <?php echo date('F d, Y', strtotime($user['created_at'])); ?>
                        </small>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card">
            <div class="card-header">
                <h4>Change Password</h4>
            </div>
            <div class="card-body">
                <?php if ($passwordResult && $passwordResult['success']): ?>
                    <div class="alert alert-success">Password changed successfully!</div>
                <?php elseif ($passwordResult && !$passwordResult['success']): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($passwordResult['message']); ?></div>
                <?php endif; ?>

                <form method="POST" action="profile.php" id="passwordForm">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <small class="text-muted">Must be at least 6 characters</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-warning">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('New passwords do not match!');
        return false;
    }
});
</script>

