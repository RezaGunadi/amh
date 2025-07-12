<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketSoal;
use App\Models\soal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaketSoalSeederLight extends Seeder
{
    protected $chunkSize = 5; // Jumlah paket per chunk (lebih kecil)
    protected $soalPerPaket = 10; // Jumlah soal per paket (lebih kecil)
    protected $soalChunkSize = 5; // Jumlah soal per chunk dalam satu paket

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Memulai seeding LIGHT dengan optimasi memory...');
        
        // Mata pelajaran per jenjang (hanya beberapa untuk testing)
        $mataPelajaran = [
            'SD' => [
                'Matematika',
                'Bahasa Indonesia'
            ],
            'SMP' => [
                'Matematika',
                'Bahasa Indonesia'
            ]
        ];

        $totalJenjang = count($mataPelajaran);
        $currentJenjang = 0;

        foreach ($mataPelajaran as $jenjang => $mapelList) {
            $currentJenjang++;
            $this->command->info("Processing jenjang {$jenjang} ({$currentJenjang}/{$totalJenjang})");
            
            $totalMapel = count($mapelList);
            $currentMapel = 0;
            
            foreach ($mapelList as $mapel) {
                $currentMapel++;
                $this->command->info("  Processing mapel {$mapel} ({$currentMapel}/{$totalMapel})");
                
                // Process dalam chunk untuk setiap mata pelajaran
                $this->processMapelInChunks($jenjang, $mapel);
                
                // Clear memory setelah setiap mata pelajaran
                gc_collect_cycles();
            }
        }
        
        $this->command->info('Seeding LIGHT selesai!');
    }

    /**
     * Process mata pelajaran dalam chunk untuk menghemat memory
     */
    private function processMapelInChunks($jenjang, $mapel)
    {
        $jumlahPaket = 5; // Total paket per mata pelajaran (lebih kecil untuk testing)
        $chunks = ceil($jumlahPaket / $this->chunkSize);
        
        for ($chunkIndex = 0; $chunkIndex < $chunks; $chunkIndex++) {
            $startIndex = $chunkIndex * $this->chunkSize;
            $endIndex = min(($chunkIndex + 1) * $this->chunkSize, $jumlahPaket);
            
            $this->command->info("    Processing chunk " . ($chunkIndex + 1) . "/{$chunks} (paket " . ($startIndex + 1) . "-{$endIndex})");
            
            // Process paket dalam chunk ini
            $this->processPaketChunk($jenjang, $mapel, $startIndex, $endIndex);
            
            // Clear memory setelah setiap chunk
            gc_collect_cycles();
        }
    }

    /**
     * Process chunk paket soal
     */
    private function processPaketChunk($jenjang, $mapel, $startIndex, $endIndex)
    {
        $tahunAjaran = ['2024'];
        
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $paketNumber = $i + 1;
            
            // Buat paket soal
            $paketSoal = PaketSoal::create([
                'user_id' => 1, // Admin ID
                'name' => "Paket Test {$paketNumber} {$mapel} {$jenjang}",
                'jenjang' => $jenjang,
                'mapel' => $mapel,
                'tahun' => $tahunAjaran[array_rand($tahunAjaran)],
                'is_public' => 1,
                'is_deleted' => 0
            ]);

            // Generate soal dalam chunk untuk paket ini
            $this->generateSoalInChunks($paketSoal->id, $mapel, $jenjang);
            
            // Clear memory setelah setiap paket
            unset($paketSoal);
            gc_collect_cycles();
        }
    }

    /**
     * Generate soal dalam chunk untuk menghemat memory
     */
    private function generateSoalInChunks($paketId, $mapel, $jenjang)
    {
        // Dapatkan kurikulum untuk mata pelajaran dan jenjang
        $kurikulum = $this->getKurikulum($mapel, $jenjang);

        // Hitung jumlah topik dan sub-topik
        $totalSubTopik = 0;
        foreach ($kurikulum as $topik => $subTopik) {
            $totalSubTopik += count($subTopik);
        }

        // Distribusikan soal berdasarkan topik dan sub-topik
        $soalPerSubTopik = ceil($this->soalPerPaket / $totalSubTopik);
        $soalTersisa = $this->soalPerPaket;

        foreach ($kurikulum as $topik => $subTopikList) {
            foreach ($subTopikList as $key => $subTopik) {
                $jumlahSoal = min($soalPerSubTopik, $soalTersisa);
                
                // Process soal dalam chunk
                $this->processSoalChunk($paketId, $mapel, $jenjang, $topik, $subTopik, $jumlahSoal);
                
                $soalTersisa -= $jumlahSoal;
            }
        }
    }

    /**
     * Process chunk soal
     */
    private function processSoalChunk($paketId, $mapel, $jenjang, $topik, $subTopik, $jumlahSoal)
    {
        $chunks = ceil($jumlahSoal / $this->soalChunkSize);
        
        for ($chunkIndex = 0; $chunkIndex < $chunks; $chunkIndex++) {
            $startIndex = $chunkIndex * $this->soalChunkSize;
            $endIndex = min(($chunkIndex + 1) * $this->soalChunkSize, $jumlahSoal);
            
            for ($i = $startIndex; $i < $endIndex; $i++) {
                // Generate template soal
                $template = $this->generateTemplateSoal($mapel, $jenjang, $topik, $subTopik, $i + 1);

                // Create the soal
                $this->createSoal($paketId, $template);
            }
            
            // Clear memory setelah setiap chunk soal
            gc_collect_cycles();
        }
    }

    /**
     * Generate template soal (versi sederhana)
     */
    private function generateTemplateSoal($mapel, $jenjang, $topik, $subTopik, $soalNumber)
    {
        // Template dasar untuk setiap jenis soal
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        // Generate soal berdasarkan mata pelajaran
        switch ($mapel) {
            case 'Matematika':
                $template = $this->generateSoalMatematika($jenjang, $topik, $subTopik, $soalNumber);
                break;
            case 'Bahasa Indonesia':
                $template = $this->generateSoalBahasaIndonesia($jenjang, $topik, $subTopik, $soalNumber);
                break;
            default:
                $template = $this->generateSoalDefault($mapel, $jenjang, $topik, $subTopik, $soalNumber);
                break;
        }

        return $template;
    }

    /**
     * Create soal dengan optimasi memory
     */
    private function createSoal($paketId, $template)
    {
        try {
            // Generate jawaban dengan optimasi
            $jawaban = $this->generateJawaban($template['jawaban']);
            $kunci = $template['benar'];

            // Buat soal
            $soal = soal::create([
                'paket_id' => $paketId,
                'soal' => $template['soal'],
                'jawaban_a' => $jawaban['jawaban']['a'] ?? 'Jawaban A',
                'jawaban_b' => $jawaban['jawaban']['b'] ?? 'Jawaban B',
                'jawaban_c' => $jawaban['jawaban']['c'] ?? 'Jawaban C',
                'jawaban_d' => $jawaban['jawaban']['d'] ?? 'Jawaban D',
                'jawaban_e' => $jawaban['jawaban']['e'] ?? 'Jawaban E',
                'kunci' => $kunci,
                'owner_id' => 1,
                'is_deleted' => 0
            ]);

            // Clear memory
            unset($soal, $jawaban, $template);
            
        } catch (\Exception $e) {
            Log::error("Error creating soal: " . $e->getMessage());
        }
    }

    /**
     * Generate jawaban dengan optimasi
     */
    private function generateJawaban($templateJawaban)
    {
        $jawaban = [];
        
        foreach ($templateJawaban as $key => $value) {
            if (is_array($value)) {
                $jawaban[$key] = $value[array_rand($value)];
            } else {
                $jawaban[$key] = $value;
            }
        }

        return [
            'jawaban' => $jawaban,
            'benar' => 'a'
        ];
    }

    // Method-methods generate soal yang dioptimalkan (versi sederhana)
    private function generateSoalMatematika($jenjang, $topik, $subTopik, $soalNumber)
    {
        $soalTemplates = [
            "Berapakah hasil dari 5 + 3?",
            "Berapakah hasil dari 10 - 4?",
            "Berapakah hasil dari 6 x 7?",
            "Berapakah hasil dari 20 ÷ 4?",
            "Berapakah hasil dari 15 + 25?",
            "Berapakah hasil dari 50 - 15?",
            "Berapakah hasil dari 8 x 9?",
            "Berapakah hasil dari 36 ÷ 6?",
            "Berapakah hasil dari 12 + 18?",
            "Berapakah hasil dari 100 - 30?"
        ];

        $soal = $soalTemplates[($soalNumber - 1) % count($soalTemplates)];
        
        return [
            'soal' => $soal,
            'jawaban' => [
                'a' => '8',
                'b' => '7',
                'c' => '9',
                'd' => '6',
                'e' => '10'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalBahasaIndonesia($jenjang, $topik, $subTopik, $soalNumber)
    {
        $soalTemplates = [
            "Apa arti kata 'membaca'?",
            "Apa arti kata 'menulis'?",
            "Apa arti kata 'berbicara'?",
            "Apa arti kata 'mendengarkan'?",
            "Apa arti kata 'belajar'?",
            "Apa arti kata 'mengajar'?",
            "Apa arti kata 'bermain'?",
            "Apa arti kata 'berolahraga'?",
            "Apa arti kata 'berkreasi'?",
            "Apa arti kata 'berdiskusi'?"
        ];

        $soal = $soalTemplates[($soalNumber - 1) % count($soalTemplates)];
        
        return [
            'soal' => $soal,
            'jawaban' => [
                'a' => 'Melihat dan memahami tulisan',
                'b' => 'Menulis huruf',
                'c' => 'Mendengarkan suara',
                'd' => 'Berbicara keras',
                'e' => 'Menggambar'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalDefault($mapel, $jenjang, $topik, $subTopik, $soalNumber)
    {
        return [
            'soal' => "Soal {$mapel} untuk {$jenjang} tentang {$topik} - {$subTopik} (No. {$soalNumber})",
            'jawaban' => [
                'a' => 'Jawaban A',
                'b' => 'Jawaban B',
                'c' => 'Jawaban C',
                'd' => 'Jawaban D',
                'e' => 'Jawaban E'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    /**
     * Get kurikulum (versi sederhana untuk menghemat memory)
     */
    private function getKurikulum($mapel, $jenjang)
    {
        return [
            'Umum' => [
                'Dasar' => 'Konsep dasar',
                'Menengah' => 'Konsep menengah'
            ]
        ];
    }
} 