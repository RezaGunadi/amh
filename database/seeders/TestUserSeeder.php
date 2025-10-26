<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing test data
        DB::table('api_arduinos')->where('token_id', 'like', 'TEST%')->delete();
        DB::table('tools_address')->where('name', 'like', 'Test%')->delete();
        DB::table('users')->where('email', 'like', '%@test.com')->delete();

        // Create test users
        $testUsers = [
            [
                'name' => 'Test User Google Console',
                'email' => 'testuser@test.com',
                'password' => Hash::make('123456'),
                'passwords' => '123456',
                'role' => 'user',
                'hp' => '081234567890',
                'is_active' => 1,
                'remember_token' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Test User',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin123'),
                'passwords' => 'admin123',
                'role' => 'admin',
                'hp' => '081234567891',
                'is_active' => 1,
                'remember_token' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Demo User IoT',
                'email' => 'demo@test.com',
                'password' => Hash::make('demo123'),
                'passwords' => 'demo123',
                'role' => 'user',
                'hp' => '081234567892',
                'is_active' => 1,
                'remember_token' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $userIds = [];
        foreach ($testUsers as $user) {
            $userId = DB::table('users')->insertGetId($user);
            $userIds[] = $userId;
        }

        // Create test tools/devices
        $testTools = [
            [
                'user_id' => $userIds[0], // Test User Google Console
                'token' => 'TEST001',
                'name' => 'Test Device Temperature Monitor',
                'user_name' => 'Test User Google Console',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0], // Test User Google Console
                'token' => 'TEST002',
                'name' => 'Test Device Humidity Sensor',
                'user_name' => 'Test User Google Console',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[0], // Test User Google Console
                'token' => 'TEST003',
                'name' => 'Test Device Heart Rate Monitor',
                'user_name' => 'Test User Google Console',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[1], // Admin Test User
                'token' => 'ADMIN01',
                'name' => 'Admin IoT Device',
                'user_name' => 'Admin Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userIds[2], // Demo User IoT
                'token' => 'DEMO01',
                'name' => 'Demo Smart Home Device',
                'user_name' => 'Demo User IoT',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($testTools as $tool) {
            DB::table('tools_address')->insert($tool);
        }

        // Create test sensor data for api_arduinos
        $this->createSensorData();

        if ($this->command) {
            $this->command->info('Test users, devices, and sensor data created successfully!');
            $this->command->info('Test Accounts:');
            $this->command->info('1. testuser@test.com / 123456 (Google Console Test User)');
            $this->command->info('2. admin@test.com / admin123 (Admin User)');
            $this->command->info('3. demo@test.com / demo123 (Demo User)');
            $this->command->info('');
            $this->command->info('Test Device Tokens:');
            $this->command->info('- TEST001: Temperature Monitor');
            $this->command->info('- TEST002: Humidity Sensor');
            $this->command->info('- TEST003: Heart Rate Monitor');
            $this->command->info('- ADMIN01: Admin IoT Device');
            $this->command->info('- DEMO01: Demo Smart Home Device');
        }
    }

    private function createSensorData()
    {
        $tokens = ['TEST001', 'TEST002', 'TEST003', 'ADMIN01', 'DEMO01'];
        $sensorTypes = [
            'TEST001' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'],
            'TEST002' => ['humidity', 'temperatur', 'light', 'volt', 'ampere', 'gram', 'cm'],
            'TEST003' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'],
            'ADMIN01' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'],
            'DEMO01' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'],
        ];

        foreach ($tokens as $token) {
            // Create 50 sample data points for each device
            for ($i = 0; $i < 50; $i++) {
                $baseTime = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                
                $sensorData = [
                    'token_id' => $token,
                    'lat' => '-6.200000' + (rand(-100, 100) / 10000), // Jakarta area with small variations
                    'lng' => '106.816666' + (rand(-100, 100) / 10000),
                    'time' => $baseTime,
                    'port0' => $this->generateSensorValue($token, 0),
                    'port1' => $this->generateSensorValue($token, 1),
                    'port2' => $this->generateSensorValue($token, 2),
                    'port3' => $this->generateSensorValue($token, 3),
                    'port4' => $this->generateSensorValue($token, 4),
                    'port5' => $this->generateSensorValue($token, 5),
                    'port6' => $this->generateSensorValue($token, 6),
                    'value0' => $this->getUnit($sensorTypes[$token][0]),
                    'value1' => $this->getUnit($sensorTypes[$token][1]),
                    'value2' => $this->getUnit($sensorTypes[$token][2]),
                    'value3' => $this->getUnit($sensorTypes[$token][3]),
                    'value4' => $this->getUnit($sensorTypes[$token][4]),
                    'value5' => $this->getUnit($sensorTypes[$token][5]),
                    'value6' => $this->getUnit($sensorTypes[$token][6]),
                    'type0' => $sensorTypes[$token][0],
                    'type1' => $sensorTypes[$token][1],
                    'type2' => $sensorTypes[$token][2],
                    'type3' => $sensorTypes[$token][3],
                    'type4' => $sensorTypes[$token][4],
                    'type5' => $sensorTypes[$token][5],
                    'type6' => $sensorTypes[$token][6],
                    'created_at' => $baseTime,
                    'updated_at' => $baseTime,
                ];

                DB::table('api_arduinos')->insert($sensorData);
            }
        }
    }

    private function generateSensorValue($token, $port)
    {
        switch ($token) {
            case 'TEST001': // Temperature Monitor
                switch ($port) {
                    case 0: return round(20 + rand(0, 200) / 10, 1); // Temperature 20-40°C
                    case 1: return round(30 + rand(0, 700) / 10, 1); // Humidity 30-100%
                    case 2: return round(100 + rand(0, 900), 0); // Light 100-1000 lux
                    case 3: return round(3.0 + rand(0, 20) / 10, 1); // Voltage 3.0-5.0V
                    case 4: return round(0.1 + rand(0, 50) / 100, 2); // Current 0.1-0.6A
                    case 5: return round(50 + rand(0, 950), 0); // Weight 50-1000g
                    case 6: return round(5 + rand(0, 95), 0); // Distance 5-100cm
                }
                break;
            case 'TEST002': // Humidity Sensor
                switch ($port) {
                    case 0: return round(40 + rand(0, 600) / 10, 1); // Humidity 40-100%
                    case 1: return round(18 + rand(0, 220) / 10, 1); // Temperature 18-40°C
                    case 2: return round(200 + rand(0, 800), 0); // Light 200-1000 lux
                    case 3: return round(3.3 + rand(0, 17) / 10, 1); // Voltage 3.3-5.0V
                    case 4: return round(0.05 + rand(0, 45) / 100, 2); // Current 0.05-0.5A
                    case 5: return round(100 + rand(0, 900), 0); // Weight 100-1000g
                    case 6: return round(10 + rand(0, 90), 0); // Distance 10-100cm
                }
                break;
            case 'TEST003': // Heart Rate Monitor
                switch ($port) {
                    case 0: return round(60 + rand(0, 120), 0); // Heart Rate 60-180 BPM
                    case 1: return round(35 + rand(0, 650) / 10, 1); // Humidity 35-100%
                    case 2: return round(50 + rand(0, 950), 0); // Light 50-1000 lux
                    case 3: return round(3.7 + rand(0, 13) / 10, 1); // Voltage 3.7-5.0V
                    case 4: return round(0.02 + rand(0, 28) / 100, 2); // Current 0.02-0.3A
                    case 5: return round(20 + rand(0, 80), 0); // Weight 20-100g
                    case 6: return round(2 + rand(0, 8), 0); // Distance 2-10cm
                }
                break;
            case 'ADMIN01': // Admin IoT Device
                switch ($port) {
                    case 0: return round(22 + rand(0, 180) / 10, 1); // Temperature 22-40°C
                    case 1: return round(45 + rand(0, 550) / 10, 1); // Humidity 45-100%
                    case 2: return round(300 + rand(0, 700), 0); // Light 300-1000 lux
                    case 3: return round(4.0 + rand(0, 10) / 10, 1); // Voltage 4.0-5.0V
                    case 4: return round(0.1 + rand(0, 40) / 100, 2); // Current 0.1-0.5A
                    case 5: return round(200 + rand(0, 800), 0); // Weight 200-1000g
                    case 6: return round(15 + rand(0, 85), 0); // Distance 15-100cm
                }
                break;
            case 'DEMO01': // Demo Smart Home Device
                switch ($port) {
                    case 0: return round(25 + rand(0, 150) / 10, 1); // Temperature 25-40°C
                    case 1: return round(50 + rand(0, 500) / 10, 1); // Humidity 50-100%
                    case 2: return round(400 + rand(0, 600), 0); // Light 400-1000 lux
                    case 3: return round(4.2 + rand(0, 8) / 10, 1); // Voltage 4.2-5.0V
                    case 4: return round(0.08 + rand(0, 32) / 100, 2); // Current 0.08-0.4A
                    case 5: return round(150 + rand(0, 850), 0); // Weight 150-1000g
                    case 6: return round(8 + rand(0, 92), 0); // Distance 8-100cm
                }
                break;
        }
        return 0;
    }

    private function getUnit($type)
    {
        switch ($type) {
            case 'temperatur': return '°C';
            case 'humidity': return '%';
            case 'light': return ' lux';
            case 'volt': return 'V';
            case 'ampere': return 'A';
            case 'gram': return 'g';
            case 'cm': return 'cm';
            default: return '';
        }
    }
}