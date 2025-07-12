<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PaketSoalSeederLight;

class RunLightSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:light {--chunk=5 : Jumlah paket per chunk} {--soal-chunk=5 : Jumlah soal per chunk} {--memory-limit=256M : Memory limit untuk PHP}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan seeder LIGHT dengan data minimal untuk testing';

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
        $this->info("Memulai seeding LIGHT dengan optimasi...");
        
        try {
            // Buat instance seeder
            $seeder = new PaketSoalSeederLight();
            
            // Set chunk size dari option
            $chunkSize = (int) $this->option('chunk');
            $soalChunkSize = (int) $this->option('soal-chunk');
            
            $seeder->chunkSize = $chunkSize;
            $seeder->soalChunkSize = $soalChunkSize;
            
            $this->info("Chunk size: {$chunkSize} paket per chunk");
            $this->info("Soal chunk size: {$soalChunkSize} soal per chunk");
            $this->info("Total data yang akan dibuat:");
            $this->info("- 2 jenjang (SD, SMP)");
            $this->info("- 2 mata pelajaran per jenjang");
            $this->info("- 5 paket per mata pelajaran");
            $this->info("- 10 soal per paket");
            $this->info("Total: 2 x 2 x 5 x 10 = 200 soal");
            
            // Jalankan seeder
            $seeder->run();
            
            $this->info('Seeding LIGHT berhasil selesai!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
} 