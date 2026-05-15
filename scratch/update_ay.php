<?php
require_once __DIR__ . '/../app/Config/Constants.php';
require_once __DIR__ . '/../vendor/codeigniter4/framework/system/Common.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables if .env exists
if (file_exists(__DIR__ . '/../.env')) {
    $env = file_get_contents(__DIR__ . '/../.env');
}

$db = \Config\Database::connect();
$db->table('academic_years')->update(['status' => 'inactive'], ['status' => 'active']);
$db->table('academic_years')->insert([
    'year' => '2025/2026',
    'semester' => '2',
    'status' => 'active',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
]);
echo "Success: 2025/2026 Semester 2 is now active.";
