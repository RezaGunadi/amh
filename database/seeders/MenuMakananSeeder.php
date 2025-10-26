<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MenuMakanan;

class MenuMakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('/menu_makanan.csv');
        
        if (!file_exists($csvFile)) {
            $this->command->error('CSV file not found: ' . $csvFile);
            return;
        }

        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle); // Skip header row
        
        while (($data = fgetcsv($handle)) !== false) {
            $menuData = [
                // 'id' => \Str::uuid(),
                'nama_makanan' => $data[0] ?? null,
                'foto' => $data[1] ?? null,
                'deskripsi_menu' => $data[2] ?? null,
                'komposisi' => $data[3] ?? null,
                'berat_g' => is_numeric($data[4]) ? (int)$data[4] : null,
                'energi_kkal' => is_numeric($data[5]) ? (float)$data[5] : null,
                'protein_gram' => is_numeric($data[6]) ? (float)$data[6] : null,
                'lemak_gram' => is_numeric($data[7]) ? (float)$data[7] : null,
                'karbohidrat_gram' => is_numeric($data[8]) ? (float)$data[8] : null,
                'gula_gram' => is_numeric($data[9]) ? (float)$data[9] : null,
                'natrium_mg' => is_numeric($data[10]) ? (float)$data[10] : null,
                'serat_gram' => is_numeric($data[11]) ? (float)$data[11] : null,
                'zat_besi_mg' => is_numeric($data[12]) ? (float)$data[12] : null,
                'kalsium_mg' => is_numeric($data[13]) ? (float)$data[13] : null,
                'protein_persen' => is_numeric($data[14]) ? (int)$data[14] : null,
                'lemak_persen' => is_numeric($data[15]) ? (int)$data[15] : null,
                'gula_persen' => is_numeric($data[16]) ? (int)$data[16] : null,
                'garam_persen' => is_numeric($data[17]) ? (int)$data[17] : null,
                'serat_persen' => is_numeric($data[18]) ? (int)$data[18] : null,
                'zat_besi_persen' => is_numeric($data[19]) ? (int)$data[19] : null,
                'kalsium_persen' => is_numeric($data[20]) ? (int)$data[20] : null,
                'skor_zat_gizi' => is_numeric($data[21]) ? (int)$data[21] : null,
                'kategori' => $data[22] ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            MenuMakanan::create($menuData);
        }
        
        fclose($handle);
    }
}
