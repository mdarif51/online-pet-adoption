<?php
/**
 * My Adoptions View
 */
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4">My Adoption History</h2>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (empty($adoptions)): ?>
            <div class="alert alert-info">You don't have any adoption history.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($adoptions as $adoption): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if ($adoption['pet_picture']): ?>
                                <img src="uploads/pets/<?php echo htmlspecialchars($adoption['pet_picture']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($adoption['pet_name']); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($adoption['pet_name']); ?></h5>
                                <p class="card-text">
                                    <?php if (isset($adoption['owner_name'])): ?>
                                        <strong>Owner:</strong> <?php echo htmlspecialchars($adoption['owner_name']); ?><br>
                                    <?php endif; ?>
                                    <?php if (isset($adoption['adopter_name'])): ?>
                                        <strong>Adopter:</strong> <?php echo htmlspecialchars($adoption['adopter_name']); ?><br>
                                    <?php endif; ?>
                                    <strong>Date:</strong> <?php echo date('M d, Y', strtotime($adoption['date'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

