<?php
require_once __DIR__ . '/../bootstrap.php';
$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT') ?: '5432';
$dbName = getenv('DB_NAME') ?: 'postgres';
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASSWORD');

$dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
$pdo = new PDO($dsn, $dbUser, $dbPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "🔄 Altering orders table...\n";

$sql = "
ALTER TABLE public.orders ADD COLUMN IF NOT EXISTS items jsonb DEFAULT '[]'::jsonb;
ALTER TABLE public.orders ADD COLUMN IF NOT EXISTS shipping_status text DEFAULT 'pending';
ALTER TABLE public.orders ADD COLUMN IF NOT EXISTS shipment_id text;
ALTER TABLE public.orders ADD COLUMN IF NOT EXISTS tracking_url text;
ALTER TABLE public.orders ADD COLUMN IF NOT EXISTS return_status text DEFAULT 'none';
";

$pdo->exec($sql);
echo "✅ Alterations complete!\n";
