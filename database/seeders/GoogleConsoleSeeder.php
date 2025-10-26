<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleConsoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Google Console Test User
        $googleUser = [
            'name' => 'Google Console Test User',
            'email' => 'google.console@test.com',
            'password' => Hash::make('google123'),
            'passwords' => 'google123',
            'role' => 'user',
            'hp' => '081234567899',
            'is_active' => 1,
            'remember_token' => Str::random(20),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $userId = DB::table('users')->insertGetId($googleUser);

        // Create Google Console IoT Devices
        $googleDevices = [
            [
                'user_id' => $userId,
                'token' => 'GOOGLE01',
                'name' => 'Google Console Temperature Sensor',
                'user_name' => 'Google Console Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'token' => 'GOOGLE02',
                'name' => 'Google Console Humidity Monitor',
                'user_name' => 'Google Console Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'token' => 'GOOGLE03',
                'name' => 'Google Console Heart Rate Monitor',
                'user_name' => 'Google Console Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'token' => 'GOOGLE04',
                'name' => 'Google Console Smart Home Hub',
                'user_name' => 'Google Console Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'token' => 'GOOGLE05',
                'name' => 'Google Console Weather Station',
                'user_name' => 'Google Console Test User',
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($googleDevices as $device) {
            DB::table('tools_address')->insert($device);
        }

        // Create realistic sensor data for Google Console devices
        $this->createGoogleConsoleSensorData();

        if ($this->command) {
            $this->command->info('Google Console test data created successfully!');
            $this->command->info('Google Console Account: google.console@test.com / google123');
            $this->command->info('');
            $this->command->info('Google Console Device Tokens:');
            $this->command->info('- GOOGLE01: Temperature Sensor');
            $this->command->info('- GOOGLE02: Humidity Monitor');
            $this->command->info('- GOOGLE03: Heart Rate Monitor');
            $this->command->info('- GOOGLE04: Smart Home Hub');
            $this->command->info('- GOOGLE05: Weather Station');
        }
    }

    private function createGoogleConsoleSensorData()
    {
        $googleTokens = ['GOOGLE01', 'GOOGLE02', 'GOOGLE03', 'GOOGLE04', 'GOOGLE05'];
        
        foreach ($googleTokens as $token) {
            // Create 100 sample data points for each Google device
            for ($i = 0; $i < 100; $i++) {
                $baseTime = Carbon::now()->subDays(rand(0, 7))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                
                $sensorData = [
                    'token_id' => $token,
                    'lat' => $this->getGoogleLocation($token)['lat'],
                    'lng' => $this->getGoogleLocation($token)['lng'],
                    'time' => $baseTime,
                    'port0' => $this->generateGoogleSensorValue($token, 0),
                    'port1' => $this->generateGoogleSensorValue($token, 1),
                    'port2' => $this->generateGoogleSensorValue($token, 2),
                    'port3' => $this->generateGoogleSensorValue($token, 3),
                    'port4' => $this->generateGoogleSensorValue($token, 4),
                    'port5' => $this->generateGoogleSensorValue($token, 5),
                    'port6' => $this->generateGoogleSensorValue($token, 6),
                    'value0' => $this->getGoogleUnit($token, 0),
                    'value1' => $this->getGoogleUnit($token, 1),
                    'value2' => $this->getGoogleUnit($token, 2),
                    'value3' => $this->getGoogleUnit($token, 3),
                    'value4' => $this->getGoogleUnit($token, 4),
                    'value5' => $this->getGoogleUnit($token, 5),
                    'value6' => $this->getGoogleUnit($token, 6),
                    'type0' => $this->getGoogleSensorType($token, 0),
                    'type1' => $this->getGoogleSensorType($token, 1),
                    'type2' => $this->getGoogleSensorType($token, 2),
                    'type3' => $this->getGoogleSensorType($token, 3),
                    'type4' => $this->getGoogleSensorType($token, 4),
                    'type5' => $this->getGoogleSensorType($token, 5),
                    'type6' => $this->getGoogleSensorType($token, 6),
                    'created_at' => $baseTime,
                    'updated_at' => $baseTime,
                ];

                DB::table('api_arduinos')->insert($sensorData);
            }
        }
    }

    private function getGoogleLocation($token)
    {
        // Google office locations with small variations
        $locations = [
            'GOOGLE01' => ['lat' => -6.200000 + (rand(-50, 50) / 10000), 'lng' => 106.816666 + (rand(-50, 50) / 10000)], // Jakarta
            'GOOGLE02' => ['lat' => -6.200000 + (rand(-50, 50) / 10000), 'lng' => 106.816666 + (rand(-50, 50) / 10000)], // Jakarta
            'GOOGLE03' => ['lat' => -6.200000 + (rand(-50, 50) / 10000), 'lng' => 106.816666 + (rand(-50, 50) / 10000)], // Jakarta
            'GOOGLE04' => ['lat' => -6.200000 + (rand(-50, 50) / 10000), 'lng' => 106.816666 + (rand(-50, 50) / 10000)], // Jakarta
            'GOOGLE05' => ['lat' => -6.200000 + (rand(-50, 50) / 10000), 'lng' => 106.816666 + (rand(-50, 50) / 10000)], // Jakarta
        ];
        
        return $locations[$token];
    }

    private function getGoogleSensorType($token, $port)
    {
        $sensorTypes = [
            'GOOGLE01' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'], // Temperature Sensor
            'GOOGLE02' => ['humidity', 'temperatur', 'light', 'volt', 'ampere', 'gram', 'cm'], // Humidity Monitor
            'GOOGLE03' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'], // Heart Rate Monitor
            'GOOGLE04' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'], // Smart Home Hub
            'GOOGLE05' => ['temperatur', 'humidity', 'light', 'volt', 'ampere', 'gram', 'cm'], // Weather Station
        ];
        
        return $sensorTypes[$token][$port] ?? 'temperatur';
    }

    private function generateGoogleSensorValue($token, $port)
    {
        switch ($token) {
            case 'GOOGLE01': // Temperature Sensor
                switch ($port) {
                    case 0: return round(22 + rand(0, 180) / 10, 1); // Temperature 22-40°C
                    case 1: return round(35 + rand(0, 650) / 10, 1); // Humidity 35-100%
                    case 2: return round(200 + rand(0, 800), 0); // Light 200-1000 lux
                    case 3: return round(3.3 + rand(0, 17) / 10, 1); // Voltage 3.3-5.0V
                    case 4: return round(0.05 + rand(0, 45) / 100, 2); // Current 0.05-0.5A
                    case 5: return round(100 + rand(0, 900), 0); // Weight 100-1000g
                    case 6: return round(10 + rand(0, 90), 0); // Distance 10-100cm
                }
                break;
            case 'GOOGLE02': // Humidity Monitor
                switch ($port) {
                    case 0: return round(40 + rand(0, 600) / 10, 1); // Humidity 40-100%
                    case 1: return round(20 + rand(0, 200) / 10, 1); // Temperature 20-40°C
                    case 2: return round(150 + rand(0, 850), 0); // Light 150-1000 lux
                    case 3: return round(3.0 + rand(0, 20) / 10, 1); // Voltage 3.0-5.0V
                    case 4: return round(0.1 + rand(0, 40) / 100, 2); // Current 0.1-0.5A
                    case 5: return round(80 + rand(0, 920), 0); // Weight 80-1000g
                    case 6: return round(5 + rand(0, 95), 0); // Distance 5-100cm
                }
                break;
            case 'GOOGLE03': // Heart Rate Monitor
                switch ($port) {
                    case 0: return round(65 + rand(0, 115), 0); // Heart Rate 65-180 BPM
                    case 1: return round(30 + rand(0, 700) / 10, 1); // Humidity 30-100%
                    case 2: return round(100 + rand(0, 900), 0); // Light 100-1000 lux
                    case 3: return round(3.7 + rand(0, 13) / 10, 1); // Voltage 3.7-5.0V
                    case 4: return round(0.02 + rand(0, 28) / 100, 2); // Current 0.02-0.3A
                    case 5: return round(25 + rand(0, 75), 0); // Weight 25-100g
                    case 6: return round(3 + rand(0, 7), 0); // Distance 3-10cm
                }
                break;
            case 'GOOGLE04': // Smart Home Hub
                switch ($port) {
                    case 0: return round(24 + rand(0, 160) / 10, 1); // Temperature 24-40°C
                    case 1: return round(45 + rand(0, 550) / 10, 1); // Humidity 45-100%
                    case 2: return round(300 + rand(0, 700), 0); // Light 300-1000 lux
                    case 3: return round(4.0 + rand(0, 10) / 10, 1); // Voltage 4.0-5.0V
                    case 4: return round(0.1 + rand(0, 40) / 100, 2); // Current 0.1-0.5A
                    case 5: return round(200 + rand(0, 800), 0); // Weight 200-1000g
                    case 6: return round(15 + rand(0, 85), 0); // Distance 15-100cm
                }
                break;
            case 'GOOGLE05': // Weather Station
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

    private function getGoogleUnit($token, $port)
    {
        $type = $this->getGoogleSensorType($token, $port);
        
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
