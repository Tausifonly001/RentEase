<?php

/**
 * RentEase Migration Script
 *
 * This script will automatically apply backend/database/schema.sql to your Supabase PostgreSQL Database.
 * You can run this script whenever you update your schema.sql file.
 *
 * Usage: php backend/scripts/migrate.php
 *
 * Note: Requires direct PostgreSQL connection details in your .env file!
 */

require __DIR__ . '/../bootstrap.php';

echo "🚀 RentEase Auto-Migration Script\n";
echo str_repeat('-', 40) . "\n";

// Parse additional DB variables from .env if they exist
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT') ?: '6543'; // Superbase default pooler port
$dbName = getenv('DB_NAME') ?: 'postgres';
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASSWORD');

if (!$dbHost || !$dbUser || !$dbPass) {
    echo "❌ Error: Missing PostgreSQL direct connection details in .env\n\n";
    echo "Please add the following to your .env file:\n";
    echo "DB_HOST=aws-0-[region].pooler.supabase.com (Find in Supabase -> Settings -> Database)\n";
    echo "DB_PORT=6543\n";
    echo "DB_NAME=postgres\n";
    echo "DB_USER=postgres.[your-project-ref]\n";
    echo "DB_PASSWORD=your_database_password\n";
    // Using simple substring to extract project ref if possible for helper text
    $ref = 'your-project-ref';
    $url = getenv('SUPABASE_URL');
    if ($url && preg_match('#https://([^.]+)\.supabase\.co#', $url, $matches)) {
        $ref = $matches[1];
        echo "\n💡 Hint: Your DB_USER is likely: postgres.{$ref}\n";
    }

    exit(1);
}

try {
    echo "🔄 Connecting to database at {$dbHost}...\n";
    $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo "✅ Connected to database!\n";

    $schemaPath = __DIR__ . '/../database/schema.sql';
    if (!file_exists($schemaPath)) {
        throw new Exception("Schema file not found at: {$schemaPath}");
    }

    echo "📖 Reading schema from backend/database/schema.sql...\n";
    $sql = file_get_contents($schemaPath);

    if (empty(trim($sql))) {
        throw new Exception("Schema file is empty!");
    }

    echo "⚡ Executing SQL statements...\n";

    // We execute the entire file. Supabase executes CREATE TABLE IF NOT EXISTS completely fine.
    $pdo->exec($sql);

    echo "✅ Migration completed successfully! Your tables and policies are up to date.\n";

} catch (PDOException $e) {
    echo "❌ Database Error:\n" . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error:\n" . $e->getMessage() . "\n";
    exit(1);
}
