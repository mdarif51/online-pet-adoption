<?php
/**
 * My Requests View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">My Adoption Requests</h2>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (empty($requests)): ?>
            <div class="alert alert-info">You don't have any adoption requests.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Owner</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td>
                                    <?php if ($request['pet_picture']): ?>
                                        <img src="uploads/pets/<?php echo htmlspecialchars($request['pet_picture']); ?>" 
                                             alt="<?php echo htmlspecialchars($request['pet_name']); ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($request['pet_name']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($request['owner_name'] ?? $request['adopter_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($request['date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $request['status'] == 'Approved' ? 'success' : 
                                            ($request['status'] == 'Rejected' ? 'danger' : 'warning'); 
                                    ?>">
                                        <?php echo htmlspecialchars($request['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="pet-details.php?id=<?php echo $request['pet_id']; ?>" class="btn btn-sm btn-info">View Pet</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

