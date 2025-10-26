<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating user ID mapping...');
        
        // Buat mapping table untuk menyimpan relasi UUID -> bigint
        if (!DB::getSchemaBuilder()->hasTable('user_id_mapping')) {
            DB::statement('CREATE TABLE user_id_mapping (
                uuid_id VARCHAR(36) PRIMARY KEY,
                bigint_id BIGINT UNSIGNED,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )');
        }
        
        // Ambil semua users yang sudah di-import
        $users = DB::table('users')->select('id', 'email')->get();
        
        $mappingCount = 0;
        foreach ($users as $user) {
            // Simpan mapping (asumsi UUID di kolom id)
            DB::table('user_id_mapping')->updateOrInsert(
                ['uuid_id' => $user->id],
                ['bigint_id' => $user->id, 'created_at' => now()]
            );
            $mappingCount++;
        }
        
        $this->command->info("Created {$mappingCount} user ID mappings");
        
        // Tampilkan beberapa contoh mapping
        $sampleMappings = DB::table('user_id_mapping')->limit(5)->get();
        $this->command->info('Sample mappings:');
        foreach ($sampleMappings as $mapping) {
            $this->command->info("UUID: {$mapping->uuid_id} -> BigInt: {$mapping->bigint_id}");
        }
    }
}
