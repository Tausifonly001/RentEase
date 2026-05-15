<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\Validator;

/**
 * MaintenanceService handles creating and retrieving maintenance requests.
 * 
 * @package RentEase\Services
 */
final class MaintenanceService extends BaseSupabaseService
{
    /**
     * Create a new maintenance request.
     * 
     * @param array<string, mixed> $payload
     * @param string $jwt The user's access token.
     * @return array<string, mixed>
     */
    public function createRequest(array $payload, string $jwt): array
    {
        $userId = Validator::uuid($payload, 'user_id');
        $rentalId = Validator::integer($payload, 'rental_id');
        $issueDescription = Validator::requiredString($payload, 'issue_description', 5);

        $response = $this->request(
            'POST',
            '/rest/v1/maintenance_requests',
            $this->userHeaders($jwt),
            [
                'user_id' => $userId,
                'rental_id' => $rentalId,
                'issue_description' => $issueDescription,
                'status' => 'OPEN'
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to create maintenance request: ' . json_encode($response['body']));
        }

        return ['success' => true, 'message' => 'Maintenance request submitted successfully'];
    }

    /**
     * Get maintenance requests for a specific user.
     * 
     * @param string $userId The UUID of the user.
     * @param string $jwt The user's access token.
     * @return array<int, array<string, mixed>>
     */
    public function getUserRequests(string $userId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');

        $path = '/rest/v1/maintenance_requests?select=*,rentals(products(name,image_url))';
        $path .= '&user_id=eq.' . rawurlencode($userId) . '&order=created_at.desc';
        
        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch maintenance requests');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }
    
    /**
     * Get all maintenance requests (Admin role required or service role).
     * 
     * @param string $jwt The user's access token (must have admin permissions) or service role.
     * @return array<int, array<string, mixed>>
     */
    public function getAllRequests(string $jwt): array
    {
        $path = '/rest/v1/maintenance_requests?select=*,rentals(id,start_date,end_date,products(name)),profiles(full_name,email)&order=created_at.desc';
        
        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch maintenance requests');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }
}

