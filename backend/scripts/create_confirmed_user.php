<?php
require_once __DIR__ . '/../bootstrap.php';
$http = new RentEase\Support\HttpClient();
$serviceHeaders = [
    'apikey' => (string) $config['supabase_service_role_key'],
    'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
    'Accept' => 'application/json',
    'Content-Type' => 'application/json'
];

// Fetch users
$res = $http->request('GET', $config['supabase_url'] . '/auth/v1/admin/users', $serviceHeaders);
if (isset($res['body']['users'])) {
    foreach ($res['body']['users'] as $u) {
        if ($u['email'] === 'testuser@gmail.com') {
            echo "Deleting user ID: " . $u['id'] . "\n";
            $delRes = $http->request('DELETE', $config['supabase_url'] . '/auth/v1/admin/users/' . $u['id'], $serviceHeaders);
            echo "Delete Status: " . $delRes['status'] . "\n";
        }
    }
}

$payload = [
    'email' => 'testuser@gmail.com',
    'password' => 'Test123456!',
    'email_confirm' => true,
    'user_metadata' => ['full_name' => 'Test User']
];

$res = $http->request('POST', $config['supabase_url'] . '/auth/v1/admin/users', $serviceHeaders, $payload);
echo "Creation Status: " . $res['status'] . "\n";
echo json_encode($res['body'], JSON_PRETTY_PRINT) . "\n";
