<?php

declare(strict_types=1);

namespace RentEase\Services;

use RentEase\Support\Validator;

/**
 * WishlistService handles the user's saved items.
 *
 * @package RentEase\Services
 */
final class WishlistService extends BaseSupabaseService
{
    /**
     * Fetch all wishlist items for a specific user.
     *
     * @param string $userId The UUID of the user.
     * @param string $jwt The user's access token.
     * @return array<int, array<string, mixed>>
     */
    public function getItems(string $userId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');

        $path = '/rest/v1/wishlists?select=*,products(id,name,category,monthly_price,image_url)';
        $path .= '&user_id=eq.' . rawurlencode($userId) . '&order=created_at.desc';

        $response = $this->request('GET', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to fetch wishlist items');
        }

        return is_array($response['body']) ? $response['body'] : [];
    }

    /**
     * Add an item to the wishlist.
     *
     * @param string $userId The UUID of the user.
     * @param int $productId The ID of the product.
     * @param string $jwt The user's access token.
     * @return array<string, mixed>
     */
    public function addItem(string $userId, int $productId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        Validator::integer(['product_id' => $productId], 'product_id');

        $response = $this->request(
            'POST',
            '/rest/v1/wishlists',
            $this->userHeaders($jwt),
            [
                'user_id' => $userId,
                'product_id' => $productId
            ]
        );

        if ($response['status'] < 200 || $response['status'] >= 300) {
            // Check if it's a unique constraint violation (item already in wishlist)
            if (isset($response['body']['code']) && $response['body']['code'] === '23505') {
                return ['success' => true, 'message' => 'Item already in wishlist'];
            }
            throw new \RuntimeException('Failed to add item to wishlist: ' . json_encode($response['body']));
        }

        return ['success' => true, 'message' => 'Item added to wishlist'];
    }

    /**
     * Remove an item from the wishlist.
     *
     * @param string $userId The UUID of the user.
     * @param int $productId The ID of the product.
     * @param string $jwt The user's access token.
     * @return array<string, mixed>
     */
    public function removeItem(string $userId, int $productId, string $jwt): array
    {
        Validator::uuid(['user_id' => $userId], 'user_id');
        Validator::integer(['product_id' => $productId], 'product_id');

        $path = '/rest/v1/wishlists?user_id=eq.' . rawurlencode($userId) . '&product_id=eq.' . $productId;

        $response = $this->request('DELETE', $path, $this->userHeaders($jwt));

        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Failed to remove item from wishlist');
        }

        return ['success' => true, 'message' => 'Item removed from wishlist'];
    }

    /**
     * Toggle an item in the wishlist.
     *
     * @param string $userId The UUID of the user.
     * @param int $productId The ID of the product.
     * @param string $jwt The user's access token.
     * @return array<string, mixed>
     */
    public function toggleItem(string $userId, int $productId, string $jwt): array
    {
        $items = $this->getItems($userId, $jwt);
        $exists = false;
        foreach ($items as $item) {
            if ((int)$item['product_id'] === $productId) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            return $this->removeItem($userId, $productId, $jwt);
        } else {
            return $this->addItem($userId, $productId, $jwt);
        }
    }
}
