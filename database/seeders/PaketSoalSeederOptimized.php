<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketSoal;
use App\Models\soal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaketSoalSeederOptimized extends Seeder
{
    protected $chunkSize = 10; // Jumlah paket per chunk
    protected $soalPerPaket = 50; // Jumlah soal per paket
    protected $soalChunkSize = 10; // Jumlah soal per chunk dalam satu paket

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Memulai seeding dengan optimasi memory...');
        
        // Mata pelajaran per jenjang
        $mataPelajaran = [
            'SD' => [
                'Matematika',
                'Bahasa Indonesia',
                'IPA',
                'IPS',
                'Bahasa Inggris',
                'PKn'
            ],
            'SMP' => [
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'IPA',
                'IPS',
                'PKn',
                'Seni Budaya',
                'PJOK'
            ],
            'SMA' => [
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'Fisika',
                'Kimia',
                'Biologi',
                'Sejarah',
                'Geografi',
                'Ekonomi',
                'Sosiologi'
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
        
        $this->command->info('Seeding selesai!');
    }

    /**
     * Process mata pelajaran dalam chunk untuk menghemat memory
     */
    private function processMapelInChunks($jenjang, $mapel)
    {
        $jumlahPaket = 50; // Total paket per mata pelajaran
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
        $tahunAjaran = ['2022', '2023', '2024'];
        
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $paketNumber = $i + 1;
            
            // Buat paket soal
            $paketSoal = PaketSoal::create([
                'user_id' => 1, // Admin ID
                'name' => "Paket {$paketNumber} {$mapel} {$jenjang}",
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
                $template = $this->generateTemplateSoal($mapel, $jenjang, $topik, $subTopik);

                // Create the soal
                $this->createSoal($paketId, $template);
            }
            
            // Clear memory setelah setiap chunk soal
            gc_collect_cycles();
        }
    }

    /**
     * Generate template soal (sama seperti sebelumnya)
     */
    private function generateTemplateSoal($mapel, $jenjang, $topik, $subTopik)
    {
        // Template dasar untuk setiap jenis soal
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        // Generate soal berdasarkan topik dan sub-topik
        switch ($mapel) {
            case 'Matematika':
                $template = $this->generateSoalMatematika($jenjang, $topik, $subTopik);
                break;
            case 'Bahasa Indonesia':
                $template = $this->generateSoalBahasaIndonesia($jenjang, $topik, $subTopik);
                break;
            case 'IPA':
                $template = $this->generateSoalIPA($jenjang, $topik, $subTopik);
                break;
            case 'IPS':
                $template = $this->generateSoalIPS($jenjang, $topik, $subTopik);
                break;
            case 'Bahasa Inggris':
                $template = $this->generateSoalBahasaInggris($jenjang, $topik, $subTopik);
                break;
            case 'PKn':
                $template = $this->generateSoalPKn($jenjang, $topik, $subTopik);
                break;
            case 'Seni Budaya':
                $template = $this->generateSoalSeniBudaya($jenjang, $topik, $subTopik);
                break;
            case 'PJOK':
                $template = $this->generateSoalPJOK($jenjang, $topik, $subTopik);
                break;
            case 'Fisika':
                $template = $this->generateSoalFisika($jenjang, $topik, $subTopik);
                break;
            case 'Kimia':
                $template = $this->generateSoalKimia($jenjang, $topik, $subTopik);
                break;
            case 'Biologi':
                $template = $this->generateSoalBiologi($jenjang, $topik, $subTopik);
                break;
            case 'Sejarah':
                $template = $this->generateSoalSejarah($jenjang, $topik, $subTopik);
                break;
            case 'Geografi':
                $template = $this->generateSoalGeografi($jenjang, $topik, $subTopik);
                break;
            case 'Ekonomi':
                $template = $this->generateSoalEkonomi($jenjang, $topik, $subTopik);
                break;
            case 'Sosiologi':
                $template = $this->generateSoalSosiologi($jenjang, $topik, $subTopik);
                break;
        }

        // Ensure template has valid content
        if (empty($template['soal']) || empty($template['jawaban']) || empty($template['benar'])) {
            // Fallback template jika generate gagal
            $template = [
                'soal' => "Soal {$mapel} untuk {$jenjang} tentang {$topik} - {$subTopik}",
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

            // Skip gambar generation untuk menghemat memory
            // if ($template['perlu_gambar']) {
            //     $this->generateGambarSoal($soal->id);
            // }

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
    private function generateSoalMatematika($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Berapakah hasil dari 5 + 3?",
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

    private function generateSoalBahasaIndonesia($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa arti kata 'membaca'?",
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

    private function generateSoalIPA($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa nama planet terdekat dengan matahari?",
            'jawaban' => [
                'a' => 'Merkurius',
                'b' => 'Venus',
                'c' => 'Bumi',
                'd' => 'Mars',
                'e' => 'Jupiter'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalIPS($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Kapan Indonesia merdeka?",
            'jawaban' => [
                'a' => '17 Agustus 1945',
                'b' => '17 Agustus 1946',
                'c' => '17 Agustus 1944',
                'd' => '17 Agustus 1947',
                'e' => '17 Agustus 1943'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalBahasaInggris($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "What is the meaning of 'hello'?",
            'jawaban' => [
                'a' => 'Halo',
                'b' => 'Selamat tinggal',
                'c' => 'Terima kasih',
                'd' => 'Maaf',
                'e' => 'Ya'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalPKn($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa lambang negara Indonesia?",
            'jawaban' => [
                'a' => 'Garuda Pancasila',
                'b' => 'Bendera Merah Putih',
                'c' => 'Lagu Indonesia Raya',
                'd' => 'Bhinneka Tunggal Ika',
                'e' => 'Pancasila'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalSeniBudaya($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa nama tarian tradisional dari Jawa?",
            'jawaban' => [
                'a' => 'Tari Pendet',
                'b' => 'Tari Saman',
                'c' => 'Tari Piring',
                'd' => 'Tari Tor-tor',
                'e' => 'Tari Jaipong'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalPJOK($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa manfaat olahraga?",
            'jawaban' => [
                'a' => 'Menjaga kesehatan tubuh',
                'b' => 'Membuat lelah',
                'c' => 'Membuat lapar',
                'd' => 'Membuat mengantuk',
                'e' => 'Membuat sakit'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalFisika($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa satuan SI untuk massa?",
            'jawaban' => [
                'a' => 'Kilogram',
                'b' => 'Meter',
                'c' => 'Sekon',
                'd' => 'Kelvin',
                'e' => 'Ampere'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalKimia($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa simbol kimia untuk emas?",
            'jawaban' => [
                'a' => 'Au',
                'b' => 'Ag',
                'c' => 'Fe',
                'd' => 'Cu',
                'e' => 'Al'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalBiologi($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa fungsi jantung?",
            'jawaban' => [
                'a' => 'Memompa darah',
                'b' => 'Mencerna makanan',
                'c' => 'Menyaring udara',
                'd' => 'Mengeluarkan keringat',
                'e' => 'Mengatur suhu'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalSejarah($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Siapa presiden pertama Indonesia?",
            'jawaban' => [
                'a' => 'Ir. Soekarno',
                'b' => 'Soeharto',
                'c' => 'B.J. Habibie',
                'd' => 'Abdurrahman Wahid',
                'e' => 'Megawati'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalGeografi($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa ibu kota Indonesia?",
            'jawaban' => [
                'a' => 'Jakarta',
                'b' => 'Bandung',
                'c' => 'Surabaya',
                'd' => 'Medan',
                'e' => 'Semarang'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalEkonomi($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa fungsi uang?",
            'jawaban' => [
                'a' => 'Alat tukar',
                'b' => 'Alat bermain',
                'c' => 'Alat hiasan',
                'd' => 'Alat pancing',
                'e' => 'Alat masak'
            ],
            'benar' => 'a',
            'perlu_gambar' => false
        ];
    }

    private function generateSoalSosiologi($jenjang, $topik, $subTopik)
    {
        return [
            'soal' => "Apa yang dimaksud dengan norma?",
            'jawaban' => [
                'a' => 'Aturan yang mengatur tingkah laku',
                'b' => 'Hukum tertulis',
                'c' => 'Kebiasaan makan',
                'd' => 'Cara berpakaian',
                'e' => 'Gaya rambut'
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
                'Menengah' => 'Konsep menengah',
                'Lanjutan' => 'Konsep lanjutan'
            ]
        ];
    }
} 