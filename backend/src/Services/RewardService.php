<?php

declare(strict_types=1);

namespace RentEase\Services;

/**
 * Service for managing loyalty rewards and points.
 */
final class RewardService extends BaseSupabaseService
{
    /**
     * Get the reward points balance and tier for a user.
     *
     * @param string $userId
     * @return array<string, mixed>
     */
    public function getUserRewards(string $userId): array
    {
        $path = '/rest/v1/user_rewards?user_id=eq.' . rawurlencode($userId) . '&select=*';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300) {
            $data = $response['body'][0] ?? null;
            if ($data) {
                return $data;
            }
        }

        // Default if not found
        return [
            'points_balance' => 0,
            'tier' => 'Bronze',
            'next_tier' => 'Silver',
            'points_to_next_tier' => 1000,
            'tier_progress' => 0
        ];
    }

    /**
     * Get the catalog of available rewards.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRewardsCatalog(): array
    {
        $path = '/rest/v1/rewards_catalog?select=*&order=points_required.asc';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300) {
            return $response['body'];
        }

        // Mock data if table doesn't exist or is empty
        return [
            [
                'id' => 1,
                'name' => '$50 Off Next Rental',
                'description' => 'Apply this credit to any furniture or appliance rental over $200.',
                'points_required' => 5000,
                'category' => 'RENTAL BENEFIT',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCW0RGGQqHc88pqHJkfA9tnh8DdsIWJDiryIQlD8XqyLpKfKJvf0KMRJTfzmj6gB7guDmqZubcC9rB9zrFGOMTUadHWbfu85vkGQhzhyIIIHLLms-1l6OPxpWWLJUB0mF46iI7gPTxOTAwgI4hPlRInTTnDgvRqwUVKgcf0vfrwKspEWf5jYh9p0bEEag943Rk9QwnRh-bXG74lZdvAwSjQa1wymBS44qy04otgvxd78rqtMk0jJVi3xhz8a4dP4A0LWdQkJv3NL1ic'
            ],
            [
                'id' => 2,
                'name' => 'Free White Glove Delivery',
                'description' => 'Professional assembly and placement of your new items at no cost.',
                'points_required' => 2500,
                'category' => 'SERVICE',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBi0JOYJcPuTMRieMQrtVGZzNPqJ0NQ36pZnV3cffTxlfEjSGYNacr1rjAcGszh6ltZvnQWbzxaikHxo9zvMruTd2ol2rp2Z2k0PW0GRpI3PiUSdm1WssDlpcARyu7jfx32ZCdmZDLF3PqtP14AAg8XKBI0ugMTnDJ28LFb_5hraWtk-h5304ApMlxicPeI9E68KvHI_udeyClq0L79BswSpIhdXpj6LGYlOAGEd9zoZl06myzDZnE8u4_qge21dFRHkFKRigejZ1qF'
            ],
            [
                'id' => 3,
                'name' => 'Modern Table Lamp',
                'description' => 'Keep this designer piece permanently. Free shipping included.',
                'points_required' => 8500,
                'category' => 'LIFESTYLE',
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuKtAORCbi-DXwhqzhFwFgcwivh7_K1NQenR3d1es_1RiUXCezpyuI-KnP7SY-NYY9zIcwGsmTw9wCuM3TWMI0VRyW8YpNmoZZFOjEo9qjxrQ_q8MHW2VYxDSKDQpB6KdwJzkVik4AQhcnEuM7sG72mmEK3YXAK5xvud8XJb6LU2vh7RxwXMAfELbmSMfIoE-IdbGFhoG6wrfYu2mGe-hVhYo8chDe_g_EicMyhXvf0RI2tcHtauJUW4cEVpZE80T77m_KNyyIsdV-'
            ]
        ];
    }

    /**
     * Get redemption history for a user.
     *
     * @param string $userId
     * @return array<int, array<string, mixed>>
     */
    public function getRedemptionHistory(string $userId): array
    {
        $path = '/rest/v1/reward_redemptions?user_id=eq.' . rawurlencode($userId) . '&select=*&order=created_at.desc';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300) {
            return $response['body'];
        }

        return [];
    }
}
