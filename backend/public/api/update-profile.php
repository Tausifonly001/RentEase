<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

use RentEase\Middleware\ApiSecurity;
use RentEase\Middleware\AuthMiddleware;
use RentEase\Support\Csrf;
use RentEase\Support\Request;
use RentEase\Support\Session;
use RentEase\Support\HttpClient;

ApiSecurity::enforce($config);

try {
    $auth = AuthMiddleware::requireUser($config);
    $user = $auth['user'];

    if (!Csrf::validate(Request::post('csrf_token', ''))) {
        throw new \RuntimeException('Invalid CSRF token');
    }

    $fullName = Request::post('full_name');
    $phone = Request::post('phone');
    $address = Request::post('address');

    $http = new HttpClient();
    $headers = [
        'apikey' => $config['supabase_anon_key'],
        'Authorization' => 'Bearer ' . $auth['token']
    ];

    $payload = [
        'data' => [
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address
        ]
    ];

    $res = $http->request('PUT', $config['supabase_url'] . '/auth/v1/user', $headers, $payload);

    if ($res['status'] >= 200 && $res['status'] < 300) {
        // Also update profiles table
        $profilePayload = [
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address
        ];
        $http->request('PATCH', $config['supabase_url'] . '/rest/v1/profiles?id=eq.' . $user['id'], $headers, $profilePayload);

        Session::flash('success', 'Profile updated successfully.');
    } else {
        Session::flash('error', 'Failed to update profile.');
    }

    header('Location: ' . baseUrl('/settings'));
    exit;

} catch (\Exception $e) {
    Session::flash('error', $e->getMessage());
    header('Location: ' . baseUrl('/settings'));
    exit;
}