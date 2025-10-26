<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFile = base_path('/old_db/users_rows.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error('SQL file not found: ' . $sqlFile);
            return;
        }

        $sqlContent = file_get_contents($sqlFile);
        
        // Extract INSERT statement and parse the data
        if (preg_match('/INSERT INTO "public"\."users" \(([^)]+)\) VALUES (.+);/', $sqlContent, $matches)) {
            $columns = array_map('trim', explode(',', str_replace('"', '', $matches[1])));
            $valuesString = $matches[2];
            
            // Parse the values
            $values = $this->parseInsertValues($valuesString);
            
            $insertedCount = 0;
            $skippedCount = 0;
            
            foreach ($values as $valueRow) {
                $userData = array_combine($columns, $valueRow);
                
                // Skip ID karena akan auto-increment
                // Convert to Laravel format
                $laravelUserData = [
                    'name' => trim($userData['name'], "'\""),
                    'email' => trim($userData['email'], "'\""),
                    'school' => trim($userData['school'], "'\""),
                    'username' => trim($userData['username'], "'\""),
                    'deletion_requested_at' => $userData['deletion_requested_at'] === 'null' ? null : trim($userData['deletion_requested_at'], "'\""),
                    'created_at' => trim($userData['created_at'], "'\""),
                    'updated_at' => trim($userData['updated_at'], "'\""),
                ];
                
                // Cek apakah email sudah ada
                $existingUser = \DB::table('users')->where('email', $userData['email'])->first();
                
                if (!$existingUser) {
                    // Insert user baru dan dapatkan ID yang di-generate
                    $newUserId = \DB::table('users')->insertGetId($laravelUserData);
                    
                    // Simpan mapping UUID -> new ID
                    \DB::table('user_id_mapping')->insert([
                        'uuid_id' => $userData['id'],
                        'bigint_id' => $newUserId,
                        'created_at' => now()
                    ]);
                    
                    $insertedCount++;
                } else {
                    // Update mapping untuk user yang sudah ada
                    \DB::table('user_id_mapping')->updateOrInsert(
                        ['uuid_id' => $userData['id']],
                        ['bigint_id' => $existingUser->id, 'created_at' => now()]
                    );
                    $skippedCount++;
                }
            }
            
            $this->command->info("Users seeding completed: {$insertedCount} inserted, {$skippedCount} skipped");
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
