<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyPaketSoal extends Command
{
    protected $signature = 'paket-soal:generate-monthly';
    protected $description = 'Trigger monthly package generation via API endpoint';

    public function handle()
    {
        try {
            $this->info('Triggering monthly package generation...');

            // Your API endpoint URL
            $url = config('app.url') . '/api/generate-monthly-paket';
            
            // Initialize cURL session
            $ch = curl_init($url);

            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-API-Key: ' . config('app.api_key') // If you're using API key authentication
            ]);

            // Execute cURL request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new \Exception('cURL Error: ' . curl_error($ch));
            }
            
            // Close cURL session
            curl_close($ch);

            // Check HTTP response code
            if ($httpCode !== 200) {
                throw new \Exception('API returned status code: ' . $httpCode . ' Response: ' . $response);
            }
            
            $this->info('Monthly package generation triggered successfully!');
            Log::info('Monthly package generation triggered successfully', [
                'response' => $response,
                'http_code' => $httpCode
            ]);
            
        } catch (\Exception $e) {
            $this->error('Error triggering monthly package generation: ' . $e->getMessage());
            Log::error('Error triggering monthly package generation: ' . $e->getMessage());
        }
    }
}
