<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFile = base_path('/old_db/favorites_rows.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error('SQL file not found: ' . $sqlFile);
            return;
        }

        $sqlContent = file_get_contents($sqlFile);
        
        // Extract INSERT statement and parse the data
        if (preg_match('/INSERT INTO "public"\."favorites" \(([^)]+)\) VALUES (.+);/', $sqlContent, $matches)) {
            $columns = array_map('trim', explode(',', str_replace('"', '', $matches[1])));
            $valuesString = $matches[2];
            
            // Parse the values
            $values = $this->parseInsertValues($valuesString);
            
            $insertedCount = 0;
            $skippedCount = 0;
            
            foreach ($values as $valueRow) {
                $favoriteData = array_combine($columns, $valueRow);
                
                // Cari mapping UUID ke bigint ID (hilangkan quotes jika ada)
                $userId = trim($favoriteData['user_id'], "'\"");
                $mapping = \DB::table('user_id_mapping')->where('uuid_id', $userId)->first();
                
                if ($mapping) {
                    // Cek apakah food_id ada di menu_makanan (hilangkan quotes jika ada)
                    $foodId = trim($favoriteData['food_id'], "'\"");
                    $foodExists = \DB::table('menu_makanan')->where('id', $foodId)->exists();
                    
                    if ($foodExists) {
                        // Convert to Laravel format
                        $laravelFavoriteData = [
                            'id' => trim($favoriteData['id'], "'\""),
                            'user_id' => $mapping->bigint_id, // Gunakan mapped bigint ID
                            'food_id' => $foodId, // Gunakan food_id yang sudah di-trim
                            'food_name' => trim($favoriteData['food_name'], "'\""),
                            'image_url' => $favoriteData['image_url'] === 'null' ? null : trim($favoriteData['image_url'], "'\""),
                            'created_at' => trim($favoriteData['created_at'], "'\""),
                            'updated_at' => trim($favoriteData['created_at'], "'\""), // Use created_at as updated_at
                        ];
                        
                        \DB::table('favorites')->insert($laravelFavoriteData);
                        $insertedCount++;
                    } else {
                        $skippedCount++;
                        $this->command->warn("Skipping favorite for non-existent food_id: {$favoriteData['food_id']}");
                    }
                } else {
                    $skippedCount++;
                    $this->command->warn("Skipping favorite for non-existent user_id: {$favoriteData['user_id']}");
                }
            }
            
            $this->command->info("Favorites seeding completed: {$insertedCount} inserted, {$skippedCount} skipped");
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
