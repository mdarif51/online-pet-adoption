<?php
/**
 * Adoption Controller
 * Handles adoption-related actions
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/AdoptionRequest.php';
require_once __DIR__ . '/../models/Adoption.php';
require_once __DIR__ . '/../models/Pet.php';

class AdoptionController {
    private $auth;
    private $adoptionRequest;
    private $adoption;
    private $pet;

    public function __construct() {
        $this->auth = new Auth();
        $this->adoptionRequest = new AdoptionRequest();
        $this->adoption = new Adoption();
        $this->pet = new Pet();
    }

    /**
     * Create adoption request
     */
    public function createRequest() {
        $this->auth->requireUserType('Adopter');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $petId = $_POST['pet_id'] ?? 0;
            $pet = $this->pet->getById($petId);

            if (!$pet) {
                return ['success' => false, 'message' => 'Pet not found'];
            }

            if ($pet['adoption_status'] !== 'Available') {
                return ['success' => false, 'message' => 'Pet is not available for adoption'];
            }

            if ($pet['approval_status'] !== 'Approved') {
                return ['success' => false, 'message' => 'Pet is not approved yet'];
            }

            $data = [
                'adopter_id' => $this->auth->getUserId(),
                'owner_id' => $pet['user_id'],
                'pet_id' => $petId,
                'date' => date('Y-m-d'),
                'status' => 'Pending'
            ];

            return $this->adoptionRequest->create($data);
        }
        return null;
    }

    /**
     * Update request status
     */
    public function updateRequestStatus($requestId, $status) {
        $this->auth->requireLogin();
        
        $request = $this->adoptionRequest->getByOwner($this->auth->getUserId());
        $requestExists = false;
        foreach ($request as $req) {
            if ($req['id'] == $requestId) {
                $requestExists = true;
                break;
            }
        }

        if (!$requestExists) {
            return ['success' => false, 'message' => 'Request not found'];
        }

        $result = $this->adoptionRequest->updateStatus($requestId, $status);

        // If approved, create adoption record and update pet status
        if ($result['success'] && $status === 'Approved') {
            $requestData = $this->adoptionRequest->getByOwner($this->auth->getUserId());
            foreach ($requestData as $req) {
                if ($req['id'] == $requestId) {
                    $this->adoption->create([
                        'adopter_id' => $req['adopter_id'],
                        'owner_id' => $req['owner_id'],
                        'pet_id' => $req['pet_id'],
                        'date' => date('Y-m-d')
                    ]);
                    $this->pet->update($req['pet_id'], ['adoption_status' => 'Adopted']);
                    break;
                }
            }
        }

        return $result;
    }
}

