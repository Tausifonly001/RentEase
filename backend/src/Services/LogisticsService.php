<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\Validator;

/**
 * Service for managing delivery and pickup logistics.
 * 
 * @package RentEase\Services
 */
final class LogisticsService extends BaseSupabaseService
{
    /**
     * Fetch all scheduled deliveries/pickups with related order and product info.
     * 
     * @return array<int, array<string, mixed>>
     */
    public function getAllDeliveries(): array
    {
        $path = '/rest/v1/deliveries?select=*,orders(total_amount,payment_status),rentals(id,status,products(name,image_url,sku))&order=scheduled_date.asc';
        
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch delivery logs: ' . json_encode($response['body']));
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * Fetch deliveries/pickups for a specific user.
     * 
     * @param string $userId The UUID of the user.
     * @param string $jwt The user's access token.
     * @return array<int, array<string, mixed>>
     */
    public function getUserDeliveries(string $userId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');

        $path = '/rest/v1/deliveries?select=*,orders(total_amount,payment_status),rentals(id,status,products(name,image_url,sku))';
        $path .= '&user_id=eq.' . rawurlencode($userId) . '&order=scheduled_date.asc';
        
        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch user deliveries: ' . json_encode($response['body']));
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * Fetch a specific delivery/pickup by ID.
     * 
     * @param int $deliveryId
     * @param string $jwt
     * @return array<string, mixed>
     */
    public function getDeliveryById(int $deliveryId, string $jwt): array
    {
        Validator::integer(['id' => $deliveryId], 'id');

        $path = '/rest/v1/deliveries?select=*,orders(id,total_amount),rentals(id,status,products(name,image_url,sku))';
        $path .= '&id=eq.' . $deliveryId;
        
        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300 || empty($response['body'])) {
            throw new \RuntimeException('Delivery not found or access denied.');
        }

        return is_array($response['body']) ? ($response['body'][0] ?? $response['body']) : $response['body'];
    }

    /**
     * Update the status of a specific delivery.
     * 
     * @param int $deliveryId
     * @param string $status
     * @param string|null $notes
     * @return array<string, mixed>
     */
    public function updateStatus(int $deliveryId, string $status, ?string $notes = null): array
    {
        Validator::integer(['id' => $deliveryId], 'id');
        
        $validStatuses = ['SCHEDULED', 'IN_TRANSIT', 'COMPLETED', 'FAILED'];
        if (!in_array($status, $validStatuses, true)) {
            throw new \InvalidArgumentException('Invalid delivery status.');
        }

        $payload = [
            'status' => $status,
            'updated_at' => date('c')
        ];
        
        if ($notes !== null) {
            $payload['agent_notes'] = $notes;
        }

        $response = $this->request(
            'PATCH',
            '/rest/v1/deliveries?id=eq.' . $deliveryId,
            $this->serviceHeaders(),
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to update delivery status: ' . json_encode($response['body']));
        }

        return ['success' => true];
    }

    /**
     * Reschedule a delivery/pickup.
     * 
     * @param int $deliveryId
     * @param string $newDate
     * @param string $newTimeSlot
     * @param string|null $reason
     * @param string $jwt
     * @return array<string, mixed>
     */
    public function rescheduleDelivery(int $deliveryId, string $newDate, string $newTimeSlot, ?string $reason, string $jwt): array
    {
        Validator::integer(['id' => $deliveryId], 'id');
        
        $payload = [
            'scheduled_date' => $newDate,
            'time_slot' => $newTimeSlot,
            'updated_at' => date('c')
        ];
        
        if ($reason !== null) {
            $payload['agent_notes'] = "Reschedule reason: " . $reason;
        }

        $response = $this->request(
            'PATCH',
            '/rest/v1/deliveries?id=eq.' . $deliveryId,
            $this->userHeaders($jwt),
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to reschedule: ' . json_encode($response['body']));
        }

        return ['success' => true];
    }

    /**
     * Schedule a return pickup.
     * 
     * @param int $rentalId
     * @param string $userId
     * @param string $date
     * @param string $timeSlot
     * @param string $condition
     * @param string $reason
     * @param string $jwt
     * @return array<string, mixed>
     */
    public function scheduleReturnPickup(int $rentalId, string $userId, string $date, string $timeSlot, string $condition, string $reason, string $jwt): array
    {
        $payload = [
            'rental_id' => $rentalId,
            'user_id' => $userId,
            'type' => 'PICKUP',
            'status' => 'SCHEDULED',
            'scheduled_date' => $date,
            'time_slot' => $timeSlot,
            'agent_notes' => "Return condition: $condition. Reason: $reason",
            'updated_at' => date('c')
        ];

        $response = $this->request(
            'POST',
            '/rest/v1/deliveries',
            $this->userHeaders($jwt),
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to schedule pickup: ' . json_encode($response['body']));
        }

        return ['success' => true];
    }

    /**
     * Submit customer feedback/survey.
     * 
     * @param array<string, mixed> $payload
     * @param string $jwt
     * @return array<string, mixed>
     */
    public function submitFeedback(array $payload, string $jwt): array
    {
        $response = $this->request(
            'POST',
            '/rest/v1/feedback',
            $this->userHeaders($jwt),
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to submit feedback: ' . json_encode($response['body']));
        }

        return ['success' => true];
    }
}


