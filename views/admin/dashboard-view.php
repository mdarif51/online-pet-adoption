<?php
/**
 * Admin Dashboard View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Admin Dashboard</h2>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2><?php echo $stats['total_users']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Pets</h5>
                <h2><?php echo $stats['total_pets']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Available Pets</h5>
                <h2><?php echo $stats['available_pets']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Featured Pets</h5>
                <h2><?php echo $stats['featured_pets']; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5 class="card-title">Adopted Pets</h5>
                <h2><?php echo $stats['adopted_pets']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Pending Requests</h5>
                <h2><?php echo $stats['pending_requests']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5 class="card-title">Total Adoptions</h5>
                <h2><?php echo $stats['total_adoptions']; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Pending Approval</h5>
                <h2><?php echo $stats['pending_pets'] ?? 0; ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="pending-pets.php" class="btn btn-warning btn-lg w-100 mb-2">
                    Pending Pets Approval 
                    <?php if (($stats['pending_pets'] ?? 0) > 0): ?>
                        <span class="badge bg-danger"><?php echo $stats['pending_pets']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="featured-pets.php" class="btn btn-primary btn-lg w-100 mb-2">Manage Featured Pets</a>
                <a href="all-pets.php" class="btn btn-success btn-lg w-100 mb-2">View All Pets</a>
                <a href="adopted-pets.php" class="btn btn-secondary btn-lg w-100 mb-2">Adopted Pets List</a>
                <a href="../browse-pets.php" class="btn btn-info btn-lg w-100">View Public Site</a>
            </div>
        </div>
    </div>
</div>

