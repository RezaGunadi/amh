<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteAccountRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFile = base_path('/old_db/delete_account_requests_rows.sql');
        
        if (!file_exists($sqlFile)) {
            $this->command->error('SQL file not found: ' . $sqlFile);
            return;
        }

        $sqlContent = file_get_contents($sqlFile);
        
        // Extract INSERT statement and parse the data
        if (preg_match('/INSERT INTO "public"\."delete_account_requests" \(([^)]+)\) VALUES (.+);/', $sqlContent, $matches)) {
            $columns = array_map('trim', explode(',', str_replace('"', '', $matches[1])));
            $valuesString = $matches[2];
            
            // Parse the values
            $values = $this->parseInsertValues($valuesString);
            
            $insertedCount = 0;
            $skippedCount = 0;
            
            foreach ($values as $valueRow) {
                $requestData = array_combine($columns, $valueRow);
                
                // Cari mapping UUID ke bigint ID
                $mapping = \DB::table('user_id_mapping')->where('uuid_id', $requestData['user_id'])->first();
                
                if ($mapping) {
                    // Convert to Laravel format
                    $laravelRequestData = [
                        'id' => $requestData['id'],
                        'user_id' => $mapping->bigint_id, // Gunakan mapped bigint ID
                        'reason' => $requestData['reason'],
                        'status' => $requestData['status'],
                        'processed_at' => $requestData['processed_at'],
                        'processed_by' => $requestData['processed_by'] === 'null' ? null : $requestData['processed_by'],
                        'created_at' => $requestData['created_at'],
                        'updated_at' => $requestData['created_at'], // Use created_at as updated_at
                    ];
                    
                    \DB::table('delete_account_requests')->insert($laravelRequestData);
                    $insertedCount++;
                } else {
                    $skippedCount++;
                    $this->command->warn("Skipping delete request for non-existent user_id: {$requestData['user_id']}");
                }
            }
            
            $this->command->info("Delete account requests seeding completed: {$insertedCount} inserted, {$skippedCount} skipped");
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
