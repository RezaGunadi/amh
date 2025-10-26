<?php

/**
 * Script untuk menjalankan seeder test data
 * 
 * Usage: php run_seeders.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 Starting seeder process...\n\n";

try {
    // Clear existing test data
    echo "🧹 Clearing existing test data...\n";
    DB::table('api_arduinos')->where('token_id', 'like', 'TEST%')->delete();
    DB::table('api_arduinos')->where('token_id', 'like', 'GOOGLE%')->delete();
    DB::table('api_arduinos')->where('token_id', 'like', 'ADMIN%')->delete();
    DB::table('api_arduinos')->where('token_id', 'like', 'DEMO%')->delete();
    DB::table('tools_address')->where('token', 'like', 'TEST%')->delete();
    DB::table('tools_address')->where('token', 'like', 'GOOGLE%')->delete();
    DB::table('tools_address')->where('token', 'like', 'ADMIN%')->delete();
    DB::table('tools_address')->where('token', 'like', 'DEMO%')->delete();
    DB::table('users')->where('email', 'like', '%@test.com')->delete();
    echo "✅ Test data cleared\n\n";

    // Run TestUserSeeder
    echo "👤 Creating test users and devices...\n";
    $testUserSeeder = new \Database\Seeders\TestUserSeeder();
    $testUserSeeder->run();
    echo "✅ Test users created\n\n";

    // Run GoogleConsoleSeeder
    echo "🌐 Creating Google Console test data...\n";
    $googleSeeder = new \Database\Seeders\GoogleConsoleSeeder();
    $googleSeeder->run();
    echo "✅ Google Console data created\n\n";

    echo "🎉 All seeders completed successfully!\n\n";
    
    echo "📋 Test Accounts Created:\n";
    echo "1. testuser@test.com / 123456 (Test User Google Console)\n";
    echo "2. admin@test.com / admin123 (Admin Test User)\n";
    echo "3. demo@test.com / demo123 (Demo User IoT)\n";
    echo "4. google.console@test.com / google123 (Google Console Test User)\n\n";
    
    echo "🔧 Test Device Tokens:\n";
    echo "General Test Devices:\n";
    echo "- TEST001: Test Device Temperature Monitor\n";
    echo "- TEST002: Test Device Humidity Sensor\n";
    echo "- TEST003: Test Device Heart Rate Monitor\n";
    echo "- ADMIN01: Admin IoT Device\n";
    echo "- DEMO01: Demo Smart Home Device\n\n";
    
    echo "Google Console Devices:\n";
    echo "- GOOGLE01: Google Console Temperature Sensor\n";
    echo "- GOOGLE02: Google Console Humidity Monitor\n";
    echo "- GOOGLE03: Google Console Heart Rate Monitor\n";
    echo "- GOOGLE04: Google Console Smart Home Hub\n";
    echo "- GOOGLE05: Google Console Weather Station\n\n";
    
    echo "📊 Data Summary:\n";
    $userCount = DB::table('users')->where('email', 'like', '%@test.com')->count();
    $deviceCount = DB::table('tools_address')->where('name', 'like', '%Test%')->count() + 
                   DB::table('tools_address')->where('name', 'like', '%Google%')->count();
    $sensorDataCount = DB::table('api_arduinos')->where('token_id', 'like', 'TEST%')->count() + 
                       DB::table('api_arduinos')->where('token_id', 'like', 'GOOGLE%')->count();
    
    echo "- Users: {$userCount}\n";
    echo "- Devices: {$deviceCount}\n";
    echo "- Sensor Data Points: {$sensorDataCount}\n\n";
    
    echo "🚀 Ready for testing!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
