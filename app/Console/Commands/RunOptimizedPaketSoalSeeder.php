<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PaketSoalSeeder;

class RunOptimizedPaketSoalSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeder:paket-soal-optimized';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run optimized PaketSoalSeeder with chunking mechanism for low memory usage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai PaketSoalSeeder dengan optimasi memory...');
        
        try {
            // Set memory limit untuk memastikan cukup memory
            ini_set('memory_limit', '512M');
            
            // Jalankan seeder
            $seeder = new PaketSoalSeeder();
            $seeder->setCommand($this);
            $seeder->run();
            
            $this->info('PaketSoalSeeder berhasil dijalankan dengan optimasi memory!');
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }
}
