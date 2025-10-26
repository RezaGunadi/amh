<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFile = base_path('/old_db/history_rows.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error('SQL file not found: ' . $sqlFile);
            return;
        }

        $this->command->info('Processing history data... This may take a while due to large file size.');
        
        $sqlContent = file_get_contents($sqlFile);
        
        // Extract INSERT statement and parse the data
        if (preg_match('/INSERT INTO "public"\."history" \(([^)]+)\) VALUES (.+);/', $sqlContent, $matches)) {
            $columns = array_map('trim', explode(',', str_replace('"', '', $matches[1])));
            $valuesString = $matches[2];
            
            // Parse the values
            $values = $this->parseInsertValues($valuesString);
            
            $batchSize = 1000; // Process in batches to avoid memory issues
            $batches = array_chunk($values, $batchSize);
            
            $totalInserted = 0;
            $totalSkipped = 0;
            
            foreach ($batches as $batchIndex => $batch) {
                $this->command->info("Processing batch " . ($batchIndex + 1) . " of " . count($batches));
                
                $batchInserted = 0;
                $batchSkipped = 0;
                
                foreach ($batch as $valueRow) {
                    $historyData = array_combine($columns, $valueRow);
                    
                    // Cari mapping UUID ke bigint ID
                    $mapping = \DB::table('user_id_mapping')->where('uuid_id', $historyData['user_id'])->first();
                    
                    if ($mapping) {
                        // Convert to Laravel format
                        $laravelHistoryData = [
                            'id' => $historyData['id'],
                            'user_id' => $mapping->bigint_id, // Gunakan mapped bigint ID
                            'food_id' => $historyData['food_id'],
                            'food_name' => $historyData['food_name'],
                            'image_url' => $historyData['image_url'],
                            'consumed_at' => $historyData['consumed_at'],
                            'created_at' => $historyData['created_at'],
                            'updated_at' => $historyData['created_at'], // Use created_at as updated_at
                        ];
                        
                        \DB::table('history')->insert($laravelHistoryData);
                        $batchInserted++;
                    } else {
                        $batchSkipped++;
                    }
                }
                
                $totalInserted += $batchInserted;
                $totalSkipped += $batchSkipped;
                
                $this->command->info("Batch " . ($batchIndex + 1) . " completed: {$batchInserted} inserted, {$batchSkipped} skipped");
            }
            
            $this->command->info("History seeding completed: {$totalInserted} total inserted, {$totalSkipped} total skipped");
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
