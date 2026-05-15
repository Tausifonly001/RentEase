<?php

declare(strict_types=1);

namespace RentEase\Services;

/**
 * SupportService handles support tickets and contact requests.
 * 
 * @package RentEase\Services
 */
final class SupportService extends BaseSupabaseService
{
    /**
     * Create a new support ticket.
     * 
     * @param array<string, mixed> $payload
     * @param string $jwt
     * @return array<string, mixed>
     */
    public function createTicket(array $payload, string $jwt): array
    {
        $response = $this->request(
            'POST',
            '/rest/v1/support_tickets',
            $this->userHeaders($jwt),
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to create ticket: ' . json_encode($response['body']));
        }

        return ['success' => true];
    }

    /**
     * Get tickets for a specific user.
     * 
     * @param string $userId
     * @param string $jwt
     * @return array<int, array<string, mixed>>
     */
    public function getUserTickets(string $userId, string $jwt): array
    {
        $path = '/rest/v1/support_tickets?user_id=eq.' . rawurlencode($userId) . '&order=created_at.desc';
        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch tickets');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }
}
