<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateMissingUserMappingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating missing user mappings...');
        
        // Ambil semua UUID dari favorites yang tidak ada di mapping
        $favoritesFile = base_path('/old_db/favorites_rows.sql');
        if (!file_exists($favoritesFile)) {
            $this->command->error('Favorites file not found');
            return;
        }
        
        $sqlContent = file_get_contents($favoritesFile);
        if (preg_match('/INSERT INTO "public"\."favorites" \(([^)]+)\) VALUES (.+);/', $sqlContent, $matches)) {
            $columns = array_map('trim', explode(',', str_replace('"', '', $matches[1])));
            $valuesString = $matches[2];
            $values = $this->parseInsertValues($valuesString);
            
            $userIndex = array_search('user_id', $columns);
            $uniqueUserIds = [];
            
            foreach ($values as $valueRow) {
                if (isset($valueRow[$userIndex])) {
                    $uniqueUserIds[] = $valueRow[$userIndex];
                }
            }
            
            $uniqueUserIds = array_unique($uniqueUserIds);
            
            // Cek UUID mana yang tidak ada di mapping
            $missingUuids = [];
            foreach ($uniqueUserIds as $uuid) {
                $exists = DB::table('user_id_mapping')->where('uuid_id', $uuid)->exists();
                if (!$exists) {
                    $missingUuids[] = $uuid;
                }
            }
            
            $this->command->info('Found ' . count($missingUuids) . ' missing UUIDs');
            
            // Buat mapping untuk UUID yang tidak ada
            $nextUserId = DB::table('users')->max('id') + 1;
            foreach ($missingUuids as $uuid) {
                // Buat user dummy untuk UUID yang tidak ada
                $dummyUser = [
                    'name' => 'Migrated User ' . $nextUserId,
                    'email' => 'migrated_' . $nextUserId . '@example.com',
                    'password' => bcrypt('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $newUserId = DB::table('users')->insertGetId($dummyUser);
                
                // Buat mapping (gunakan updateOrInsert untuk menghindari duplicate)
                DB::table('user_id_mapping')->updateOrInsert(
                    ['uuid_id' => $uuid],
                    ['bigint_id' => $newUserId, 'created_at' => now()]
                );
                
                $this->command->info("Created mapping for UUID {$uuid} -> User ID {$newUserId}");
                $nextUserId++;
            }
        }
    }
    
    private function parseInsertValues($valuesString)
    {
        $values = [];
        $currentValue = '';
        $inQuotes = false;
        $quoteChar = '';
        $parenCount = 0;
        
        for ($i = 0; $i < strlen($valuesString); $i++) {
            $char = $valuesString[$i];
            
            if ($char === '(' && !$inQuotes) {
                $parenCount++;
                if ($parenCount === 1) {
                    $currentValue = '';
                    continue;
                }
            } elseif ($char === ')' && !$inQuotes) {
                $parenCount--;
                if ($parenCount === 0) {
                    $values[] = $this->parseValueRow($currentValue);
                    $currentValue = '';
                    continue;
                }
            } elseif (($char === '"' || $char === "'") && !$inQuotes) {
                $inQuotes = true;
                $quoteChar = $char;
            } elseif ($char === $quoteChar && $inQuotes) {
                $inQuotes = false;
                $quoteChar = '';
            }
            
            if ($parenCount > 0) {
                $currentValue .= $char;
            }
        }
        
        return $values;
    }
    
    private function parseValueRow($valueRow)
    {
        $values = [];
        $currentValue = '';
        $inQuotes = false;
        $quoteChar = '';
        
        for ($i = 0; $i < strlen($valueRow); $i++) {
            $char = $valueRow[$i];
            
            if (($char === '"' || $char === "'") && !$inQuotes) {
                $inQuotes = true;
                $quoteChar = $char;
            } elseif ($char === $quoteChar && $inQuotes) {
                $inQuotes = false;
                $quoteChar = '';
            } elseif ($char === ',' && !$inQuotes) {
                $values[] = trim($currentValue);
                $currentValue = '';
                continue;
            }
            
            $currentValue .= $char;
        }
        
        if ($currentValue !== '') {
            $values[] = trim($currentValue);
        }
        
        return $values;
    }
}
