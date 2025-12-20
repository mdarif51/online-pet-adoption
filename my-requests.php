<?php
/**
 * My Requests Page
 */
require_once 'core/Session.php';
require_once 'core/Auth.php';
require_once 'models/AdoptionRequest.php';
require_once 'controllers/AdoptionController.php';

Session::start();

$auth = new Auth();
$auth->requireLogin();

$adoptionRequest = new AdoptionRequest();
$adoptionController = new AdoptionController();

// Handle status update (only Owner/Shelter can approve/reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $userType = $auth->getUserType();
    if ($userType == 'Owner' || $userType == 'Shelter') {
        $requestId = $_POST['request_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $result = $adoptionController->updateRequestStatus($requestId, $status);
        if ($result && $result['success']) {
            $success = 'Request status updated successfully!';
        } else {
            $error = $result['message'] ?? 'Failed to update status';
        }
    } else {
        $error = 'You do not have permission to update request status';
    }
}

// Get requests based on user type
if ($auth->getUserType() == 'Adopter') {
    $requests = $adoptionRequest->getByAdopter($auth->getUserId());
} elseif ($auth->getUserType() == 'Owner' || $auth->getUserType() == 'Shelter') {
    $requests = $adoptionRequest->getByOwner($auth->getUserId());
} else {
    $requests = [];
}

$pageTitle = 'My Requests - Pet Adoption System';
include 'views/layouts/header.php';
?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4"><?php echo ($auth->getUserType() == 'Adopter') ? 'My Adoption Requests' : 'Adoption Requests'; ?></h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
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
                            <?php if ($auth->getUserType() == 'Owner' || $auth->getUserType() == 'Shelter'): ?>
                                <th>Adopter</th>
                                <th>Adopter Email</th>
                                <th>Adopter Phone</th>
                            <?php else: ?>
                                <th>Owner</th>
                            <?php endif; ?>
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
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($request['pet_name']); ?>
                                </td>
                                <?php if ($auth->getUserType() == 'Owner' || $auth->getUserType() == 'Shelter'): ?>
                                    <td><?php echo htmlspecialchars($request['adopter_name']); ?></td>
                                    <td><?php echo htmlspecialchars($request['adopter_email'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($request['adopter_phone'] ?? 'N/A'); ?></td>
                                <?php else: ?>
                                    <td><?php echo htmlspecialchars($request['owner_name']); ?></td>
                                <?php endif; ?>
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
                                    <?php if (($auth->getUserType() == 'Owner' || $auth->getUserType() == 'Shelter') && $request['status'] == 'Pending'): ?>
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                            <input type="hidden" name="status" value="Approved">
                                            <button type="submit" name="update_status" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form method="POST" style="display: inline-block;">
                                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" name="update_status" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>

