<?php

declare(strict_types=1);

namespace RentEase\Services;

/**
 * Service for managing the referral program.
 */
final class ReferralService extends BaseSupabaseService
{
    /**
     * Get referral statistics for a user.
     * 
     * @param string $userId
     * @return array<string, mixed>
     */
    public function getReferralStats(string $userId): array
    {
        $path = '/rest/v1/referral_stats?user_id=eq.' . rawurlencode($userId) . '&select=*';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300) {
            $data = $response['body'][0] ?? null;
            if ($data) {
                return $data;
            }
        }

        // Default if not found
        return [
            'total_earned' => 0.00,
            'friends_invited' => 0,
            'successful_referrals' => 0,
            'pending_invitations' => 0,
            'referral_code' => $this->generateFallbackCode($userId)
        ];
    }

    /**
     * Generate a fallback referral code if one doesn't exist.
     * 
     * @param string $userId
     * @return string
     */
    private function generateFallbackCode(string $userId): string
    {
        return 'REF-' . substr(md5($userId), 0, 8);
    }

    /**
     * Get the referral history for a user.
     * 
     * @param string $userId
     * @return array<int, array<string, mixed>>
     */
    public function getReferralHistory(string $userId): array
    {
        $path = '/rest/v1/referrals?referrer_id=eq.' . rawurlencode($userId) . '&select=*&order=created_at.desc';
        $response = $this->request('GET', $path, $this->serviceHeaders());

        if ($response['status'] >= 200 && $response['status'] < 300) {
            return $response['body'];
        }

        return [];
    }
}
