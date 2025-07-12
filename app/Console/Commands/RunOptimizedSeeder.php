<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PaketSoalSeederOptimized;

class RunOptimizedSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:optimized {--chunk=10 : Jumlah paket per chunk} {--soal-chunk=10 : Jumlah soal per chunk} {--memory-limit=512M : Memory limit untuk PHP}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan seeder dengan optimasi memory menggunakan chunking';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Set memory limit
        $memoryLimit = $this->option('memory-limit');
        ini_set('memory_limit', $memoryLimit);
        
        $this->info("Memory limit diset ke: " . ini_get('memory_limit'));
        $this->info("Memulai seeding dengan optimasi...");
        
        try {
            // Buat instance seeder
            $seeder = new PaketSoalSeederOptimized();
            
            // Set chunk size dari option
            $chunkSize = (int) $this->option('chunk');
            $soalChunkSize = (int) $this->option('soal-chunk');
            
            $seeder->chunkSize = $chunkSize;
            $seeder->soalChunkSize = $soalChunkSize;
            
            $this->info("Chunk size: {$chunkSize} paket per chunk");
            $this->info("Soal chunk size: {$soalChunkSize} soal per chunk");
            
            // Jalankan seeder
            $seeder->run();
            
            $this->info('Seeding berhasil selesai!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
} 