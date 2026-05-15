<?php
require 'backend/bootstrap.php';
$http = new RentEase\Support\HttpClient();
$serviceHeaders = [
    'apikey' => (string) $config['supabase_service_role_key'],
    'Authorization' => 'Bearer ' . $config['supabase_service_role_key'],
    'Accept' => 'application/json',
];

$res = $http->request('GET', $config['supabase_url'] . '/auth/v1/admin/users', $serviceHeaders);
echo "Status: " . $res['status'] . "\n";
if (isset($res['body']['users'])) {
    foreach ($res['body']['users'] as $u) {
        echo "- " . $u['id'] . " (" . $u['email'] . ")\n";
    }
} else {
    print_r($res['body']);
}
