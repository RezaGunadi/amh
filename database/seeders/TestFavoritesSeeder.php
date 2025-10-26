<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestFavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Testing favorites seeding...');
        
        // Test dengan beberapa UUID yang sudah ada di mapping
        $testUuids = [
            'ae94e84e-0dab-4ae9-b378-c232117c4e12',
            'f9f97c06-3ebe-4598-851d-6add07e1da5b',
            '4721cfb9-e32b-4954-8c01-c578987af234'
        ];
        
        foreach ($testUuids as $uuid) {
            $mapping = DB::table('user_id_mapping')->where('uuid_id', $uuid)->first();
            
            if ($mapping) {
                $this->command->info("UUID {$uuid} -> BigInt {$mapping->bigint_id} - MAPPING FOUND");
                
                // Test insert favorites
                $testFavorite = [
                    'id' => rand(1000, 9999),
                    'user_id' => $mapping->bigint_id,
                    'food_id' => 'test-food-id',
                    'food_name' => 'Test Food',
                    'image_url' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                try {
                    DB::table('favorites')->insert($testFavorite);
                    $this->command->info("Successfully inserted test favorite for UUID {$uuid}");
                } catch (\Exception $e) {
                    $this->command->error("Failed to insert test favorite for UUID {$uuid}: " . $e->getMessage());
                }
            } else {
                $this->command->error("UUID {$uuid} - MAPPING NOT FOUND");
            }
        }
    }
}
