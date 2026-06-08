<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\Validator;

final class RentalService extends BaseSupabaseService
{
    /**
     * @return array<string, mixed>
     */
    public function availability(int $productId, string $startDate, string $endDate): array
    {
        Validator::integer(['product_id' => $productId], 'product_id');
        Validator::dateRange(['start_date' => $startDate, 'end_date' => $endDate]);

        $response = $this->request(
            'POST',
            '/rest/v1/rpc/get_available_stock',
            $this->anonHeaders(),
            [
                'p_product_id' => $productId,
                'p_start_date' => $startDate,
                'p_end_date' => $endDate,
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Could not calculate availability');
        }

        return [
            'available_stock' => (int) ($response['body'] ?? 0),
        ];
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function createBooking(array $payload, string $jwt): array
    {
        $userId = Validator::uuid($payload, 'user_id');
        $productId = Validator::integer($payload, 'product_id');
        [$startDate, $endDate] = Validator::dateRange($payload);

        $response = $this->request(
            'POST',
            '/rest/v1/rpc/create_rental_booking',
            $this->userHeaders($jwt),
            [
                'p_user_id' => $userId,
                'p_product_id' => $productId,
                'p_start_date' => $startDate,
                'p_end_date' => $endDate,
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            $hint = (string) ($response['body']['message'] ?? 'Booking failed');
            throw new \RuntimeException($hint);
        }

        return $response['body'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function activeRentalsForUser(string $userId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        $path = '/rest/v1/rentals?select=id,product_id,start_date,end_date,status,created_at,products(name,image_url,monthly_price)';
        $path .= '&user_id=eq.' . rawurlencode($userId) . '&status=eq.active&order=start_date.asc';

        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch active rentals');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * @return array<string, float|int>
     */
    public function pricingBreakdown(float $monthlyPrice, int $durationMonths, float $deliveryFee, float $taxRate): array
    {
        $durationMonths = max(1, $durationMonths);
        $dailyRate = round($monthlyPrice / 30, 2);
        $securityDeposit = round($monthlyPrice * 1.5, 2);
        $base = round($monthlyPrice * $durationMonths, 2);
        $tax = round(($base + $deliveryFee) * $taxRate, 2);
        $total = round($base + $securityDeposit + $deliveryFee + $tax, 2);

        return [
            'daily_rate' => $dailyRate,
            'security_deposit' => $securityDeposit,
            'rental_base' => $base,
            'delivery_fee' => $deliveryFee,
            'tax' => $tax,
            'cart_total' => $total,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function createBookingWithServiceRole(array $payload): array
    {
        $headers = array_merge($this->serviceHeaders(), [
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ]);

        $response = $this->request(
            'POST',
            '/rest/v1/rentals',
            $headers,
            [
                'user_id' => $payload['user_id'],
                'product_id' => $payload['product_id'],
                'start_date' => $payload['start_date'],
                'end_date' => $payload['end_date'],
                'status' => $payload['status'] ?? 'pending',
                'order_id' => $payload['order_id'] ?? null
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to create rental with service role: ' . json_encode($response['body']));
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUserRentals(string $userId): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        $path = '/rest/v1/rentals?select=*,products(name,image_url,monthly_price)';
        $path .= '&user_id=eq.' . rawurlencode($userId) . '&order=created_at.desc';

        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch user rentals: ' . json_encode($response['body']));
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * Request rental return
     */
    public function requestReturn(int $rentalId, string $userId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        $rentalId = filter_var($rentalId, FILTER_VALIDATE_INT);
        if ($rentalId === false || $rentalId < 1) {
            throw new \InvalidArgumentException('Invalid rental_id');
        }

        $response = $this->request(
            'PATCH',
            '/rest/v1/rentals?id=eq.' . $rentalId . '&user_id=eq.' . urlencode($userId),
            $this->userHeaders($jwt),
            [
                'status' => 'return_requested',
                'requested_return_date' => date('Y-m-d')
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Return request failed');
        }

        return ['success' => true, 'message' => 'Return requested successfully'];
    }

    /**
     * Extend lease by extra days
     */
    public function extendLease(int $rentalId, string $userId, int $extraDays, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        $rentalId = filter_var($rentalId, FILTER_VALIDATE_INT);
        if ($rentalId === false || $rentalId < 1) {
            throw new \InvalidArgumentException('Invalid rental_id');
        }

        // First get the rental to find its end_date
        $rentalUrl = '/rest/v1/rentals?id=eq.' . $rentalId . '&user_id=eq.' . urlencode($userId) . '&select=*';
        $getRental = $this->request('GET', $rentalUrl, $this->userHeaders($jwt));

        if ($getRental['status'] < 200 || $getRental['status'] >= 300 || empty($getRental['body'])) {
            throw new \RuntimeException("Rental not found or access denied.");
        }

        $rental = $getRental['body'][0] ?? $getRental['body'];
        $currentEndDate = new \DateTime($rental['end_date']);
        $newEndDate = clone $currentEndDate;
        $newEndDate->modify('+' . $extraDays . ' days');

        // Update rental end_date
        $updateResponse = $this->request(
            'PATCH',
            '/rest/v1/rentals?id=eq.' . $rentalId . '&user_id=eq.' . $userId,
            $this->userHeaders($jwt),
            [
                'end_date' => $newEndDate->format('Y-m-d'),
                'extension_count' => (int)($rental['extension_count'] ?? 0) + 1,
                'last_extended_at' => date('c')
            ]
        );

        if ($updateResponse['status'] < 200 || $updateResponse['status'] >= 300) {
            throw new \RuntimeException("Failed to extend lease.");
        }

        // Audit extension
        $auditPayload = [
            'rental_id' => $rentalId,
            'user_id' => $userId,
            'extension_days' => $extraDays,
            'new_end_date' => $newEndDate->format('Y-m-d')
        ];

        $this->request(
            'POST',
            '/rest/v1/rental_extensions',
            $this->userHeaders($jwt),
            $auditPayload
        );

        return ['success' => true, 'message' => 'Lease extended successfully.'];
    }

    /**
     * Create a delivery record using the service role.
     *
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    public function createDelivery(array $payload): array
    {
        $headers = array_merge($this->serviceHeaders(), [
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ]);

        $response = $this->request(
            'POST',
            '/rest/v1/deliveries',
            $headers,
            $payload
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to create delivery: ' . json_encode($response['body']));
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * Activate all rentals linked to an order after payment confirmation.
     */
    public function activateRentalsByOrder(string $orderId): array
    {
        $headers = array_merge($this->serviceHeaders(), [
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ]);

        return $this->request(
            'PATCH',
            '/rest/v1/rentals?order_id=eq.' . $orderId . '&status=eq.pending',
            $headers,
            ['status' => 'active']
        );
    }
}