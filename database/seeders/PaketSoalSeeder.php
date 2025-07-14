<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketSoal;
use App\Models\soal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class PaketSoalSeeder extends Seeder
{
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
        $chunkSize = 10; // Jumlah paket per chunk
        $chunks = ceil($jumlahPaket / $chunkSize);
        
        for ($chunkIndex = 0; $chunkIndex < $chunks; $chunkIndex++) {
            $startIndex = $chunkIndex * $chunkSize;
            $endIndex = min(($chunkIndex + 1) * $chunkSize, $jumlahPaket);
            
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
        $soalPerSubTopik = ceil(50 / $totalSubTopik);
        $soalTersisa = 50;
        $soalChunkSize = 10; // Jumlah soal per chunk

        foreach ($kurikulum as $topik => $subTopikList) {
            foreach ($subTopikList as $key => $subTopik) {
                $jumlahSoal = min($soalPerSubTopik, $soalTersisa);
                
                // Process soal dalam chunk
                $this->processSoalChunk($paketId, $mapel, $jenjang, $topik, $key,$subTopik, $jumlahSoal, $soalChunkSize);
                
                $soalTersisa -= $jumlahSoal;
            }
        }
    }

    /**
     * Process chunk soal
     */
    private function processSoalChunk($paketId, $mapel, $jenjang, $topik, $key, $subTopik, $jumlahSoal, $chunkSize)
    {
        $chunks = ceil($jumlahSoal / $chunkSize);
        
        for ($chunkIndex = 0; $chunkIndex < $chunks; $chunkIndex++) {
            $startIndex = $chunkIndex * $chunkSize;
            $endIndex = min(($chunkIndex + 1) * $chunkSize, $jumlahSoal);
            
            for ($i = $startIndex; $i < $endIndex; $i++) {
                // Generate template soal menggunakan fungsi asli yang kaya variasi
                $template = $this->generateTemplateSoal($mapel, $jenjang, $topik, $key, $subTopik);

                // Create the soal
                $this->createSoal($paketId, $template);
            }
            
            // Clear memory setelah setiap chunk soal
            gc_collect_cycles();
        }
    }

    private function generateTemplateSoal($mapel, $jenjang, $topik, $key, $subTopik)
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
                $template = $this->generateSoalMatematika($jenjang, $topik, $key, $subTopik);
                break;
            case 'Bahasa Indonesia':
                $template = $this->generateSoalBahasaIndonesia($jenjang, $topik, $key, $subTopik);
                break;
            case 'IPA':
                $template = $this->generateSoalIPA($jenjang, $topik, $key, $subTopik);
                break;
            case 'IPS':
                $template = $this->generateSoalIPS($jenjang, $topik, $key, $subTopik);
                break;
            case 'Bahasa Inggris':
                $template = $this->generateSoalBahasaInggris($jenjang, $topik, $key, $subTopik);
                break;
            case 'PKn':
                $template = $this->generateSoalPKn($jenjang, $topik, $key, $subTopik);
                break;
            case 'Seni Budaya':
                $template = $this->generateSoalSeniBudaya($jenjang, $topik, $key, $subTopik);
                break;
            case 'PJOK':
                $template = $this->generateSoalPJOK($jenjang, $topik, $key, $subTopik);
                break;
            case 'Fisika':
                $template = $this->generateSoalFisika($jenjang, $topik, $key, $subTopik);
                break;
            case 'Kimia':
                $template = $this->generateSoalKimia($jenjang, $topik, $key, $subTopik);
                break;
            case 'Biologi':
                $template = $this->generateSoalBiologi($jenjang, $topik, $key, $subTopik);
                break;
            case 'Sejarah':
                $template = $this->generateSoalSejarah($jenjang, $topik, $key, $subTopik);
                break;
            case 'Geografi':
                $template = $this->generateSoalGeografi($jenjang, $topik, $key, $subTopik);
                break;
            case 'Ekonomi':
                $template = $this->generateSoalEkonomi($jenjang, $topik, $key, $subTopik);
                break;
            case 'Sosiologi':
                $template = $this->generateSoalSosiologi($jenjang, $topik, $key, $subTopik);
                break;
            case 'Geometri':
                if ($subTopik == 'Bangun Datar' ||$key == 'Bangun Datar') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Luas persegi panjang dengan panjang 8 cm dan lebar 6 cm adalah...",
                                    'jawaban' => [
                                        'a' => '48 cm²',
                                        'b' => '28 cm²',
                                        'c' => '56 cm²',
                                        'd' => '24 cm²',
                                        'e' => '32 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi dengan sisi 5 cm adalah...",
                                    'jawaban' => [
                                        'a' => '20 cm',
                                        'b' => '25 cm',
                                        'c' => '15 cm',
                                        'd' => '10 cm',
                                        'e' => '30 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bangun Ruang' || $key == 'Bangun Ruang') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '64 cm³',
                                        'b' => '16 cm³',
                                        'c' => '32 cm³',
                                        'd' => '48 cm³',
                                        'e' => '80 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Luas permukaan balok dengan panjang 6 cm, lebar 4 cm, dan tinggi 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '108 cm²',
                                        'b' => '72 cm²',
                                        'c' => '144 cm²',
                                        'd' => '90 cm²',
                                        'e' => '120 cm²'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Kalkulus':
                if ($subTopik == 'Limit' || $key == 'Limit') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Nilai dari lim(x→2) (x² - 4)/(x - 2) adalah...",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '0',
                                        'd' => '∞',
                                        'e' => 'Tidak ada'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Nilai dari lim(x→0) sin(x)/x adalah...",
                                    'jawaban' => [
                                        'a' => '1',
                                        'b' => '0',
                                        'c' => '∞',
                                        'd' => '-1',
                                        'e' => 'Tidak ada'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Nilai dari lim(x→∞) (2x + 1)/(x + 3) adalah...",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '1',
                                        'c' => '0',
                                        'd' => '∞',
                                        'e' => 'Tidak ada'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Turunan' || $key == 'Turunan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Turunan dari f(x) = x² adalah...",
                                    'jawaban' => [
                                        'a' => 'f\'(x) = 2x',
                                        'b' => 'f\'(x) = x',
                                        'c' => 'f\'(x) = 2x²',
                                        'd' => 'f\'(x) = x²',
                                        'e' => 'f\'(x) = 2'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Turunan dari f(x) = x³ + 2x² adalah...",
                                    'jawaban' => [
                                        'a' => 'f\'(x) = 3x² + 4x',
                                        'b' => 'f\'(x) = 3x² + 2x',
                                        'c' => 'f\'(x) = x² + 4x',
                                        'd' => 'f\'(x) = 3x + 4',
                                        'e' => 'f\'(x) = 3x + 2'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Turunan dari f(x) = sin(x) adalah...",
                                    'jawaban' => [
                                        'a' => 'f\'(x) = cos(x)',
                                        'b' => 'f\'(x) = -sin(x)',
                                        'c' => 'f\'(x) = -cos(x)',
                                        'd' => 'f\'(x) = sin(x)',
                                        'e' => 'f\'(x) = tan(x)'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Integral' || $key == 'Integral') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Integral dari f(x) = 2x adalah...",
                                    'jawaban' => [
                                        'a' => '∫f(x)dx = x² + C',
                                        'b' => '∫f(x)dx = x + C',
                                        'c' => '∫f(x)dx = 2x² + C',
                                        'd' => '∫f(x)dx = x²',
                                        'e' => '∫f(x)dx = 2x + C'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Integral dari f(x) = 3x² adalah...",
                                    'jawaban' => [
                                        'a' => '∫f(x)dx = x³ + C',
                                        'b' => '∫f(x)dx = 3x + C',
                                        'c' => '∫f(x)dx = x² + C',
                                        'd' => '∫f(x)dx = 3x³ + C',
                                        'e' => '∫f(x)dx = x³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Integral dari f(x) = cos(x) adalah...",
                                    'jawaban' => [
                                        'a' => '∫f(x)dx = sin(x) + C',
                                        'b' => '∫f(x)dx = -sin(x) + C',
                                        'c' => '∫f(x)dx = -cos(x) + C',
                                        'd' => '∫f(x)dx = cos(x) + C',
                                        'e' => '∫f(x)dx = tan(x) + C'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Aplikasi' || $key == 'Aplikasi' ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Aplikasi turunan untuk mencari nilai maksimum/minimum fungsi adalah...",
                                    'jawaban' => [
                                        'a' => 'Mencari titik stasioner dengan f\'(x) = 0',
                                        'b' => 'Mencari nilai fungsi di titik tertentu',
                                        'c' => 'Mencari integral dari fungsi',
                                        'd' => 'Mencari limit fungsi',
                                        'e' => 'Mencari domain fungsi'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Aplikasi integral untuk menghitung luas daerah adalah...",
                                    'jawaban' => [
                                        'a' => '∫[a,b] f(x)dx',
                                        'b' => 'f(b) - f(a)',
                                        'c' => 'f\'(b) - f\'(a)',
                                        'd' => 'f(a) + f(b)',
                                        'e' => 'f(a) × f(b)'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
        }

        // Ensure template has valid content
        if (empty($template['soal']) || empty($template['jawaban']) || empty($template['benar'])) {
            throw new \Exception("Invalid template generated for mapel: {$mapel}, jenjang: {$jenjang}, topik: {$topik}, subTopik: {$subTopik}");
        }

        return $template;
    }

    private function generateDefaultSoal($mapel, $jenjang, $topik, $subTopik)
    {
        $konteks = [
            'pendidikan' => [
                'SD' => 'siswa SD',
                'SMP' => 'siswa SMP',
                'SMA' => 'siswa SMA'
            ],
            'kegiatan' => [
                'belajar' => 'belajar',
                'bermain' => 'bermain',
                'berolahraga' => 'berolahraga',
                'berkreasi' => 'berkreasi'
            ],
            'tempat' => [
                'sekolah' => 'di sekolah',
                'rumah' => 'di rumah',
                'lingkungan' => 'di lingkungan sekitar',
                'masyarakat' => 'di masyarakat'
            ]
        ];

        $siswa = $konteks['pendidikan'][$jenjang] ?? 'siswa';
        $kegiatan = $konteks['kegiatan'][array_rand($konteks['kegiatan'])];
        $tempat = $konteks['tempat'][array_rand($konteks['tempat'])];

        $soalTemplates = [
            "Apa yang harus dilakukan {$siswa} ketika {$kegiatan} {$tempat}?",
            "Bagaimana cara {$siswa} melakukan {$kegiatan} {$tempat}?",
            "Mengapa {$siswa} perlu {$kegiatan} {$tempat}?",
            "Kapan sebaiknya {$siswa} melakukan {$kegiatan} {$tempat}?",
            "Di mana tempat yang tepat untuk {$siswa} melakukan {$kegiatan}?"
        ];

        return $soalTemplates[array_rand($soalTemplates)];
    }

    private function generateSoalMatematika($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Bilangan':
                if ($subTopik == 'Operasi hitung bilangan cacah sampai 1000' || $key == 'Operasi hitung bilangan cacah sampai 1000') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari 245 + 367?",
                                    'jawaban' => [
                                        'a' => '612',
                                        'b' => '622',
                                        'c' => '602',
                                        'd' => '632',
                                        'e' => '592'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 789 - 456?",
                                    'jawaban' => [
                                        'a' => '333',
                                        'b' => '323',
                                        'c' => '343',
                                        'd' => '353',
                                        'e' => '313'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 123 x 4?",
                                    'jawaban' => [
                                        'a' => '492',
                                        'b' => '482',
                                        'c' => '502',
                                        'd' => '472',
                                        'e' => '512'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 800 ÷ 4?",
                                    'jawaban' => [
                                        'a' => '200',
                                        'b' => '180',
                                        'c' => '220',
                                        'd' => '160',
                                        'e' => '240'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 567 + 234?",
                                    'jawaban' => [
                                        'a' => '801',
                                        'b' => '791',
                                        'c' => '811',
                                        'd' => '781',
                                        'e' => '821'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Operasi hitung bilangan bulat dan sifat-sifatnya' || $key == 'Operasi hitung bilangan bulat dan sifat-sifatnya') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari (-15) + 8?",
                                    'jawaban' => [
                                        'a' => '-7',
                                        'b' => '7',
                                        'c' => '-23',
                                        'd' => '23',
                                        'e' => '-8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari (-20) - (-5)?",
                                    'jawaban' => [
                                        'a' => '-15',
                                        'b' => '15',
                                        'c' => '-25',
                                        'd' => '25',
                                        'e' => '-5'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari (-4) x 6?",
                                    'jawaban' => [
                                        'a' => '-24',
                                        'b' => '24',
                                        'c' => '-20',
                                        'd' => '20',
                                        'e' => '-28'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Pecahan sederhana dan operasi hitung pecahan' || $key == 'Pecahan sederhana dan operasi hitung pecahan') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari 1/4 + 1/2?",
                                    'jawaban' => [
                                        'a' => '3/4',
                                        'b' => '1/6',
                                        'c' => '2/6',
                                        'd' => '1/2',
                                        'e' => '2/4'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 2/3 - 1/6?",
                                    'jawaban' => [
                                        'a' => '1/2',
                                        'b' => '1/3',
                                        'c' => '1/6',
                                        'd' => '2/6',
                                        'e' => '3/6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 3/4 x 2/3?",
                                    'jawaban' => [
                                        'a' => '1/2',
                                        'b' => '2/3',
                                        'c' => '3/4',
                                        'd' => '1/4',
                                        'e' => '2/4'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Kelipatan Persekutuan Terkecil dan Faktor Persekutuan Terbesar' || $key == 'Kelipatan Persekutuan Terkecil dan Faktor Persekutuan Terbesar' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah KPK dari 12 dan 18?",
                                    'jawaban' => [
                                        'a' => '36',
                                        'b' => '24',
                                        'c' => '48',
                                        'd' => '72',
                                        'e' => '54'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah FPB dari 24 dan 36?",
                                    'jawaban' => [
                                        'a' => '12',
                                        'b' => '6',
                                        'c' => '8',
                                        'd' => '4',
                                        'e' => '18'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah KPK dari 8 dan 12?",
                                    'jawaban' => [
                                        'a' => '24',
                                        'b' => '16',
                                        'c' => '32',
                                        'd' => '48',
                                        'e' => '36'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah FPB dari 16 dan 24?",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '4',
                                        'c' => '12',
                                        'd' => '6',
                                        'e' => '16'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah KPK dari 15 dan 20?",
                                    'jawaban' => [
                                        'a' => '60',
                                        'b' => '30',
                                        'c' => '45',
                                        'd' => '75',
                                        'e' => '90'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah FPB dari 30 dan 45?",
                                    'jawaban' => [
                                        'a' => '15',
                                        'b' => '5',
                                        'c' => '10',
                                        'd' => '20',
                                        'e' => '25'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah KPK dari 6, 8, dan 12?",
                                    'jawaban' => [
                                        'a' => '24',
                                        'b' => '12',
                                        'c' => '36',
                                        'd' => '48',
                                        'e' => '18'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah FPB dari 18, 27, dan 36?",
                                    'jawaban' => [
                                        'a' => '9',
                                        'b' => '3',
                                        'c' => '6',
                                        'd' => '12',
                                        'e' => '18'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bilangan desimal dan operasi hitungnya' || $key == 'Bilangan desimal dan operasi hitungnya') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari 2,5 + 1,75?",
                                    'jawaban' => [
                                        'a' => '4,25',
                                        'b' => '3,25',
                                        'c' => '4,15',
                                        'd' => '3,75',
                                        'e' => '4,5'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 3,2 - 1,8?",
                                    'jawaban' => [
                                        'a' => '1,4',
                                        'b' => '1,6',
                                        'c' => '1,2',
                                        'd' => '1,8',
                                        'e' => '2,0'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 2,5 x 3?",
                                    'jawaban' => [
                                        'a' => '7,5',
                                        'b' => '6,5',
                                        'c' => '8,5',
                                        'd' => '7,0',
                                        'e' => '8,0'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bilangan Romawi dan konversinya' || $key == 'Bilangan Romawi dan konversinya') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Angka Romawi dari 25 adalah ...",
                                    'jawaban' => [
                                        'a' => 'XXV',
                                        'b' => 'XV',
                                        'c' => 'XX',
                                        'd' => 'XXX',
                                        'e' => 'XXIV'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Angka Romawi dari 15 adalah ...",
                                    'jawaban' => [
                                        'a' => 'XV',
                                        'b' => 'X',
                                        'c' => 'XX',
                                        'd' => 'V',
                                        'e' => 'XIV'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Angka Romawi dari 30 adalah ...",
                                    'jawaban' => [
                                        'a' => 'XXX',
                                        'b' => 'XX',
                                        'c' => 'XXV',
                                        'd' => 'XXIX',
                                        'e' => 'XXXI'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Operasi hitung bilangan bulat dan sifat-sifatnya' || $key == 'Operasi hitung bilangan bulat dan sifat-sifatnya') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari (-12) + 8?",
                                    'jawaban' => [
                                        'a' => '-4',
                                        'b' => '4',
                                        'c' => '-20',
                                        'd' => '20',
                                        'e' => '-8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari (-15) × (-3)?",
                                    'jawaban' => [
                                        'a' => '45',
                                        'b' => '-45',
                                        'c' => '35',
                                        'd' => '-35',
                                        'e' => '55'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Operasi hitung pecahan dan desimal' || $key == 'Operasi hitung pecahan dan desimal') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari 2/3 + 1/4?",
                                    'jawaban' => [
                                        'a' => '11/12',
                                        'b' => '3/7',
                                        'c' => '3/12',
                                        'd' => '2/7',
                                        'e' => '1/2'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari 3,5 × 2,4?",
                                    'jawaban' => [
                                        'a' => '8,4',
                                        'b' => '7,4',
                                        'c' => '9,4',
                                        'd' => '6,4',
                                        'e' => '10,4'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bilangan berpangkat dan bentuk akar' || $key == 'Bilangan berpangkat dan bentuk akar') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Berapakah hasil dari 2³?",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '4',
                                        'd' => '10',
                                        'e' => '12'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah hasil dari √16?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '8',
                                        'd' => '6',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Perbandingan senilai dan berbalik nilai' || $key == 'Perbandingan senilai dan berbalik nilai'   ) {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Jika 3 buku harganya Rp 15.000, berapa harga 5 buku?",
                                    'jawaban' => [
                                        'a' => 'Rp 25.000',
                                        'b' => 'Rp 20.000',
                                        'c' => 'Rp 30.000',
                                        'd' => 'Rp 35.000',
                                        'e' => 'Rp 40.000'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Jika 4 pekerja selesai dalam 6 hari, berapa hari jika ada 6 pekerja?",
                                    'jawaban' => [
                                        'a' => '4 hari',
                                        'b' => '6 hari',
                                        'c' => '8 hari',
                                        'd' => '3 hari',
                                        'e' => '9 hari'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bilangan rasional dan irasional' || $key == 'Bilangan rasional dan irasional') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Bilangan yang dapat dinyatakan dalam bentuk pecahan disebut...",
                                    'jawaban' => [
                                        'a' => 'Bilangan rasional',
                                        'b' => 'Bilangan irasional',
                                        'c' => 'Bilangan bulat',
                                        'd' => 'Bilangan cacah',
                                        'e' => 'Bilangan prima'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Contoh bilangan irasional adalah...",
                                    'jawaban' => [
                                        'a' => 'π (pi)',
                                        'b' => '2',
                                        'c' => '1/2',
                                        'd' => '0,5',
                                        'e' => '3'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Sistem bilangan real' || $key == 'Sistem bilangan real') {
                    switch ($jenjang) {
                        case 'SMP':
                            $questions = [
                                [
                                    'soal' => "Himpunan bilangan real terdiri dari...",
                                    'jawaban' => [
                                        'a' => 'Bilangan rasional dan irasional',
                                        'b' => 'Hanya bilangan bulat',
                                        'c' => 'Hanya bilangan pecahan',
                                        'd' => 'Hanya bilangan positif',
                                        'e' => 'Hanya bilangan negatif'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bilangan real dapat digambarkan pada...",
                                    'jawaban' => [
                                        'a' => 'Garis bilangan',
                                        'b' => 'Bidang kartesius',
                                        'c' => 'Diagram venn',
                                        'd' => 'Grafik batang',
                                        'e' => 'Diagram lingkaran'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Geometri':
                if ($subTopik == 'Bangun Datar' || $key == 'Bangun Datar') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah jumlah sisi pada persegi?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '3',
                                        'c' => '5',
                                        'd' => '6',
                                        'e' => '8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang memiliki tiga sisi adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Luas dan Keliling' || $key == 'Luas dan Keliling') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah luas persegi dengan sisi 4 cm?",
                                    'jawaban' => [
                                        'a' => '16 cm²',
                                        'b' => '8 cm²',
                                        'c' => '12 cm²',
                                        'd' => '20 cm²',
                                        'e' => '24 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi panjang dengan panjang 6 cm dan lebar 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '20 cm',
                                        'b' => '24 cm',
                                        'c' => '18 cm',
                                        'd' => '16 cm',
                                        'e' => '22 cm'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah luas persegi panjang dengan panjang 8 cm dan lebar 5 cm?",
                                    'jawaban' => [
                                        'a' => '40 cm²',
                                        'b' => '35 cm²',
                                        'c' => '45 cm²',
                                        'd' => '30 cm²',
                                        'e' => '50 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi dengan sisi 7 cm adalah...",
                                    'jawaban' => [
                                        'a' => '28 cm',
                                        'b' => '21 cm',
                                        'c' => '35 cm',
                                        'd' => '14 cm',
                                        'e' => '42 cm'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah luas segitiga dengan alas 6 cm dan tinggi 4 cm?",
                                    'jawaban' => [
                                        'a' => '12 cm²',
                                        'b' => '10 cm²',
                                        'c' => '14 cm²',
                                        'd' => '8 cm²',
                                        'e' => '16 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling segitiga dengan sisi 5 cm, 6 cm, dan 7 cm adalah...",
                                    'jawaban' => [
                                        'a' => '18 cm',
                                        'b' => '15 cm',
                                        'c' => '21 cm',
                                        'd' => '12 cm',
                                        'e' => '24 cm'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Berapakah luas jajar genjang dengan alas 8 cm dan tinggi 3 cm?",
                                    'jawaban' => [
                                        'a' => '24 cm²',
                                        'b' => '20 cm²',
                                        'c' => '28 cm²',
                                        'd' => '16 cm²',
                                        'e' => '32 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling trapesium dengan sisi 4 cm, 6 cm, 5 cm, dan 7 cm adalah...",
                                    'jawaban' => [
                                        'a' => '22 cm',
                                        'b' => '20 cm',
                                        'c' => '24 cm',
                                        'd' => '18 cm',
                                        'e' => '26 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Simetri' || $key == 'Simetri'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Persegi memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '3',
                                        'd' => '5',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang hanya memiliki satu simetri lipat adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga sama kaki',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Persegi panjang memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '4',
                                        'c' => '1',
                                        'd' => '3',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Lingkaran memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => 'Tak terhingga',
                                        'b' => '4',
                                        'c' => '8',
                                        'd' => '10',
                                        'e' => '12'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Segitiga sama sisi memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '3',
                                        'b' => '2',
                                        'c' => '1',
                                        'd' => '4',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Simetri putar adalah simetri yang terjadi jika bangun datar...",
                                    'jawaban' => [
                                        'a' => 'Diputar pada titik pusat',
                                        'b' => 'Dilipat pada garis',
                                        'c' => 'Digeser ke samping',
                                        'd' => 'Diperbesar',
                                        'e' => 'Diperkecil'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Persegi memiliki simetri putar tingkat...",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '3',
                                        'd' => '1',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Lingkaran memiliki simetri putar tingkat...",
                                    'jawaban' => [
                                        'a' => 'Tak terhingga',
                                        'b' => '4',
                                        'c' => '8',
                                        'd' => '10',
                                        'e' => '12'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bangun Ruang' || $key == 'Bangun Ruang') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Bangun ruang yang memiliki 6 sisi sama besar adalah...",
                                    'jawaban' => [
                                        'a' => 'Kubus',
                                        'b' => 'Balok',
                                        'c' => 'Tabung',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas dan tutup berbentuk lingkaran adalah...",
                                    'jawaban' => [
                                        'a' => 'Tabung',
                                        'b' => 'Kubus',
                                        'c' => 'Balok',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas berbentuk lingkaran dan puncak berbentuk titik adalah...",
                                    'jawaban' => [
                                        'a' => 'Kerucut',
                                        'b' => 'Tabung',
                                        'c' => 'Kubus',
                                        'd' => 'Balok',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas berbentuk segitiga dan puncak berbentuk titik adalah...",
                                    'jawaban' => [
                                        'a' => 'Limas segitiga',
                                        'b' => 'Prisma segitiga',
                                        'c' => 'Kubus',
                                        'd' => 'Balok',
                                        'e' => 'Tabung'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas berbentuk persegi dan puncak berbentuk titik adalah...",
                                    'jawaban' => [
                                        'a' => 'Limas segiempat',
                                        'b' => 'Prisma segiempat',
                                        'c' => 'Kubus',
                                        'd' => 'Balok',
                                        'e' => 'Tabung'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas berbentuk lingkaran dan semua titik pada alas berjarak sama dari pusat adalah...",
                                    'jawaban' => [
                                        'a' => 'Bola',
                                        'b' => 'Tabung',
                                        'c' => 'Kerucut',
                                        'd' => 'Limas',
                                        'e' => 'Prisma'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki 6 sisi dengan 3 pasang sisi sejajar dan sama besar adalah...",
                                    'jawaban' => [
                                        'a' => 'Balok',
                                        'b' => 'Kubus',
                                        'c' => 'Tabung',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas berbentuk segitiga dan tutup berbentuk segitiga adalah...",
                                    'jawaban' => [
                                        'a' => 'Prisma segitiga',
                                        'b' => 'Limas segitiga',
                                        'c' => 'Kubus',
                                        'd' => 'Balok',
                                        'e' => 'Tabung'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Volume' || $key == 'Volume' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '27 cm³',
                                        'b' => '9 cm³',
                                        'c' => '18 cm³',
                                        'd' => '12 cm³',
                                        'e' => '36 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume balok dengan panjang 4 cm, lebar 3 cm, dan tinggi 2 cm adalah...",
                                    'jawaban' => [
                                        'a' => '24 cm³',
                                        'b' => '12 cm³',
                                        'c' => '18 cm³',
                                        'd' => '20 cm³',
                                        'e' => '30 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 5 cm adalah...",
                                    'jawaban' => [
                                        'a' => '125 cm³',
                                        'b' => '100 cm³',
                                        'c' => '150 cm³',
                                        'd' => '75 cm³',
                                        'e' => '200 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume balok dengan panjang 6 cm, lebar 4 cm, dan tinggi 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '72 cm³',
                                        'b' => '60 cm³',
                                        'c' => '84 cm³',
                                        'd' => '48 cm³',
                                        'e' => '96 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume tabung dengan jari-jari 3 cm dan tinggi 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '36π cm³',
                                        'b' => '24π cm³',
                                        'c' => '48π cm³',
                                        'd' => '12π cm³',
                                        'e' => '60π cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume kerucut dengan jari-jari 2 cm dan tinggi 6 cm adalah...",
                                    'jawaban' => [
                                        'a' => '8π cm³',
                                        'b' => '6π cm³',
                                        'c' => '12π cm³',
                                        'd' => '4π cm³',
                                        'e' => '16π cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume bola dengan jari-jari 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '256π/3 cm³',
                                        'b' => '64π cm³',
                                        'c' => '128π/3 cm³',
                                        'd' => '32π cm³',
                                        'e' => '512π/3 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume prisma segitiga dengan luas alas 12 cm² dan tinggi 5 cm adalah...",
                                    'jawaban' => [
                                        'a' => '60 cm³',
                                        'b' => '50 cm³',
                                        'c' => '70 cm³',
                                        'd' => '40 cm³',
                                        'e' => '80 cm³'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Pengukuran':
                if ($subTopik == 'Satuan Luas' || $key == 'Satuan Luas') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 are sama dengan berapa meter persegi?",
                                    'jawaban' => [
                                        'a' => '100 m²',
                                        'b' => '10 m²',
                                        'c' => '1000 m²',
                                        'd' => '10000 m²',
                                        'e' => '1 m²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 hektar sama dengan berapa are?",
                                    'jawaban' => [
                                        'a' => '100 are',
                                        'b' => '10 are',
                                        'c' => '1000 are',
                                        'd' => '10000 are',
                                        'e' => '1 are'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Volume' || $key == 'Satuan Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 liter sama dengan berapa mililiter?",
                                    'jawaban' => [
                                        'a' => '1000 ml',
                                        'b' => '100 ml',
                                        'c' => '10 ml',
                                        'd' => '500 ml',
                                        'e' => '2000 ml'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 m³ sama dengan berapa liter?",
                                    'jawaban' => [
                                        'a' => '1000 liter',
                                        'b' => '100 liter',
                                        'c' => '10 liter',
                                        'd' => '500 liter',
                                        'e' => '2000 liter'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Debit' || $key == 'Satuan Debit') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Debit air 2 liter per menit, berapa liter air yang keluar dalam 5 menit?",
                                    'jawaban' => [
                                        'a' => '10',
                                        'b' => '5',
                                        'c' => '7',
                                        'd' => '12',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 3 liter per menit, berapa liter air yang keluar dalam 10 menit?",
                                    'jawaban' => [
                                        'a' => '30',
                                        'b' => '13',
                                        'c' => '20',
                                        'd' => '25',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 5 liter per menit, berapa liter air yang keluar dalam 8 menit?",
                                    'jawaban' => [
                                        'a' => '40',
                                        'b' => '35',
                                        'c' => '45',
                                        'd' => '30',
                                        'e' => '50'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 1,5 liter per menit, berapa liter air yang keluar dalam 12 menit?",
                                    'jawaban' => [
                                        'a' => '18',
                                        'b' => '15',
                                        'c' => '20',
                                        'd' => '12',
                                        'e' => '22'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Panjang' || $key == 'Satuan Panjang') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 meter sama dengan berapa sentimeter?",
                                    'jawaban' => [
                                        'a' => '100 cm',
                                        'b' => '10 cm',
                                        'c' => '1000 cm',
                                        'd' => '50 cm',
                                        'e' => '200 cm'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 kilometer sama dengan berapa meter?",
                                    'jawaban' => [
                                        'a' => '1000 m',
                                        'b' => '100 m',
                                        'c' => '10 m',
                                        'd' => '500 m',
                                        'e' => '2000 m'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 meter sama dengan berapa milimeter?",
                                    'jawaban' => [
                                        'a' => '1000 mm',
                                        'b' => '100 mm',
                                        'c' => '10 mm',
                                        'd' => '500 mm',
                                        'e' => '2000 mm'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 desimeter sama dengan berapa sentimeter?",
                                    'jawaban' => [
                                        'a' => '10 cm',
                                        'b' => '1 cm',
                                        'c' => '100 cm',
                                        'd' => '5 cm',
                                        'e' => '20 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Berat' || $key == 'Satuan Berat') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 kilogram sama dengan berapa gram?",
                                    'jawaban' => [
                                        'a' => '1000 gram',
                                        'b' => '100 gram',
                                        'c' => '10 gram',
                                        'd' => '500 gram',
                                        'e' => '2000 gram'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 ton sama dengan berapa kilogram?",
                                    'jawaban' => [
                                        'a' => '1000 kg',
                                        'b' => '100 kg',
                                        'c' => '10 kg',
                                        'd' => '500 kg',
                                        'e' => '2000 kg'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 gram sama dengan berapa miligram?",
                                    'jawaban' => [
                                        'a' => '1000 mg',
                                        'b' => '100 mg',
                                        'c' => '10 mg',
                                        'd' => '500 mg',
                                        'e' => '2000 mg'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 kuintal sama dengan berapa kilogram?",
                                    'jawaban' => [
                                        'a' => '100 kg',
                                        'b' => '10 kg',
                                        'c' => '1000 kg',
                                        'd' => '50 kg',
                                        'e' => '200 kg'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Waktu' || $key == 'Satuan Waktu') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 jam sama dengan berapa menit?",
                                    'jawaban' => [
                                        'a' => '60 menit',
                                        'b' => '30 menit',
                                        'c' => '100 menit',
                                        'd' => '50 menit',
                                        'e' => '120 menit'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 menit sama dengan berapa detik?",
                                    'jawaban' => [
                                        'a' => '60 detik',
                                        'b' => '30 detik',
                                        'c' => '100 detik',
                                        'd' => '50 detik',
                                        'e' => '120 detik'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 hari sama dengan berapa jam?",
                                    'jawaban' => [
                                        'a' => '24 jam',
                                        'b' => '12 jam',
                                        'c' => '48 jam',
                                        'd' => '20 jam',
                                        'e' => '36 jam'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 minggu sama dengan berapa hari?",
                                    'jawaban' => [
                                        'a' => '7 hari',
                                        'b' => '5 hari',
                                        'c' => '10 hari',
                                        'd' => '6 hari',
                                        'e' => '8 hari'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Statistika':
                if ($subTopik == 'Rata-rata' || $key == 'Rata-rata') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Rata-rata dari 6, 8, 10 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '7',
                                        'd' => '9',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 5, 7, 9, 11 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '10',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 12, 15, 18, 21 adalah...",
                                    'jawaban' => [
                                        'a' => '16,5',
                                        'b' => '15',
                                        'c' => '17',
                                        'd' => '16',
                                        'e' => '18'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 4, 6, 8, 10, 12 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '6',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 20, 25, 30, 35, 40 adalah...",
                                    'jawaban' => [
                                        'a' => '30',
                                        'b' => '25',
                                        'c' => '35',
                                        'd' => '28',
                                        'e' => '32'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 3, 5, 7, 9, 11, 13 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '6',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 10, 12, 14, 16, 18, 20, 22 adalah...",
                                    'jawaban' => [
                                        'a' => '16',
                                        'b' => '15',
                                        'c' => '17',
                                        'd' => '14',
                                        'e' => '18'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 25, 30, 35, 40, 45 adalah...",
                                    'jawaban' => [
                                        'a' => '35',
                                        'b' => '30',
                                        'c' => '40',
                                        'd' => '32',
                                        'e' => '38'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Modus' || $key == 'Modus'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Modus dari data 2, 3, 3, 5, 7 adalah...",
                                    'jawaban' => [
                                        'a' => '3',
                                        'b' => '2',
                                        'c' => '5',
                                        'd' => '7',
                                        'e' => '4'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 1, 2, 2, 2, 3, 4 adalah...",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '1',
                                        'c' => '3',
                                        'd' => '4',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 5, 6, 6, 7, 8, 8, 8 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '7',
                                        'd' => '5',
                                        'e' => '9'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 10, 12, 12, 15, 15, 15, 18 adalah...",
                                    'jawaban' => [
                                        'a' => '15',
                                        'b' => '12',
                                        'c' => '10',
                                        'd' => '18',
                                        'e' => '13'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Pengumpulan Data' || $key == 'Pengumpulan Data') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Cara mengumpulkan data dengan mengamati langsung disebut...",
                                    'jawaban' => [
                                        'a' => 'Observasi',
                                        'b' => 'Wawancara',
                                        'c' => 'Angket',
                                        'd' => 'Dokumentasi',
                                        'e' => 'Tes'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Data yang disajikan dalam bentuk tabel disebut...",
                                    'jawaban' => [
                                        'a' => 'Tabel frekuensi',
                                        'b' => 'Diagram batang',
                                        'c' => 'Grafik garis',
                                        'd' => 'Piktogram',
                                        'e' => 'Histogram'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Cara mengumpulkan data dengan bertanya langsung disebut...",
                                    'jawaban' => [
                                        'a' => 'Wawancara',
                                        'b' => 'Observasi',
                                        'c' => 'Angket',
                                        'd' => 'Dokumentasi',
                                        'e' => 'Tes'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Data yang dikumpulkan dari dokumen atau catatan disebut...",
                                    'jawaban' => [
                                        'a' => 'Dokumentasi',
                                        'b' => 'Observasi',
                                        'c' => 'Wawancara',
                                        'd' => 'Angket',
                                        'e' => 'Tes'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Diagram' || $key == 'Diagram') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Diagram yang menggunakan gambar untuk menyajikan data disebut...",
                                    'jawaban' => [
                                        'a' => 'Diagram gambar',
                                        'b' => 'Diagram batang',
                                        'c' => 'Diagram garis',
                                        'd' => 'Diagram lingkaran',
                                        'e' => 'Histogram'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Diagram yang menggunakan batang untuk menyajikan data disebut...",
                                    'jawaban' => [
                                        'a' => 'Diagram batang',
                                        'b' => 'Diagram gambar',
                                        'c' => 'Diagram garis',
                                        'd' => 'Diagram lingkaran',
                                        'e' => 'Histogram'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Diagram yang paling cocok untuk menampilkan perbandingan adalah...",
                                    'jawaban' => [
                                        'a' => 'Diagram batang',
                                        'b' => 'Diagram garis',
                                        'c' => 'Diagram gambar',
                                        'd' => 'Histogram',
                                        'e' => 'Piktogram'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Diagram yang menggunakan garis untuk menghubungkan titik-titik data disebut...",
                                    'jawaban' => [
                                        'a' => 'Diagram garis',
                                        'b' => 'Diagram batang',
                                        'c' => 'Diagram gambar',
                                        'd' => 'Diagram lingkaran',
                                        'e' => 'Histogram'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Geometri':
                if ($subTopik == 'Bangun Datar' || $key == 'Bangun Datar') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah jumlah sisi pada persegi?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '3',
                                        'c' => '5',
                                        'd' => '6',
                                        'e' => '8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang memiliki tiga sisi adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Luas dan Keliling' || $key == 'Luas dan Keliling') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah luas persegi dengan sisi 4 cm?",
                                    'jawaban' => [
                                        'a' => '16 cm²',
                                        'b' => '8 cm²',
                                        'c' => '12 cm²',
                                        'd' => '20 cm²',
                                        'e' => '24 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi panjang dengan panjang 6 cm dan lebar 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '20 cm',
                                        'b' => '24 cm',
                                        'c' => '18 cm',
                                        'd' => '16 cm',
                                        'e' => '22 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Simetri' || $key == 'Simetri') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Persegi memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '3',
                                        'd' => '5',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang hanya memiliki satu simetri lipat adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga sama kaki',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bangun Ruang' || $key == 'Bangun Ruang' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Bangun ruang yang memiliki 6 sisi sama besar adalah...",
                                    'jawaban' => [
                                        'a' => 'Kubus',
                                        'b' => 'Balok',
                                        'c' => 'Tabung',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas dan tutup berbentuk lingkaran adalah...",
                                    'jawaban' => [
                                        'a' => 'Tabung',
                                        'b' => 'Kubus',
                                        'c' => 'Balok',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Volume' || $key == 'Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '27 cm³',
                                        'b' => '9 cm³',
                                        'c' => '18 cm³',
                                        'd' => '12 cm³',
                                        'e' => '36 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume balok dengan panjang 4 cm, lebar 3 cm, dan tinggi 2 cm adalah...",
                                    'jawaban' => [
                                        'a' => '24 cm³',
                                        'b' => '12 cm³',
                                        'c' => '18 cm³',
                                        'd' => '20 cm³',
                                        'e' => '30 cm³'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Pengukuran':
                if ($subTopik == 'Satuan Luas' || $key == 'Satuan Luas') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 are sama dengan berapa meter persegi?",
                                    'jawaban' => [
                                        'a' => '100 m²',
                                        'b' => '10 m²',
                                        'c' => '1000 m²',
                                        'd' => '10000 m²',
                                        'e' => '1 m²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 hektar sama dengan berapa are?",
                                    'jawaban' => [
                                        'a' => '100 are',
                                        'b' => '10 are',
                                        'c' => '1000 are',
                                        'd' => '10000 are',
                                        'e' => '1 are'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Volume' || $key == 'Satuan Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 liter sama dengan berapa mililiter?",
                                    'jawaban' => [
                                        'a' => '1000 ml',
                                        'b' => '100 ml',
                                        'c' => '10 ml',
                                        'd' => '500 ml',
                                        'e' => '2000 ml'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 m³ sama dengan berapa liter?",
                                    'jawaban' => [
                                        'a' => '1000 liter',
                                        'b' => '100 liter',
                                        'c' => '10 liter',
                                        'd' => '500 liter',
                                        'e' => '2000 liter'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Debit' || $key == 'Satuan Debit') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Debit air 2 liter per menit, berapa liter air yang keluar dalam 5 menit?",
                                    'jawaban' => [
                                        'a' => '10',
                                        'b' => '5',
                                        'c' => '7',
                                        'd' => '12',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 3 liter per menit, berapa liter air yang keluar dalam 10 menit?",
                                    'jawaban' => [
                                        'a' => '30',
                                        'b' => '13',
                                        'c' => '20',
                                        'd' => '25',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Statistika':
                if ($subTopik == 'Rata-rata' || $key == 'Rata-rata') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Rata-rata dari 6, 8, 10 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '7',
                                        'd' => '9',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 5, 7, 9, 11 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '10',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Modus' || $key == 'Modus') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Modus dari data 2, 3, 3, 5, 7 adalah...",
                                    'jawaban' => [
                                        'a' => '3',
                                        'b' => '2',
                                        'c' => '5',
                                        'd' => '7',
                                        'e' => '4'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 1, 2, 2, 2, 3, 4 adalah...",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '1',
                                        'c' => '3',
                                        'd' => '4',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Geometri':
                if ($subTopik == 'Bangun Datar' || $key == 'Bangun Datar') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah jumlah sisi pada persegi?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '3',
                                        'c' => '5',
                                        'd' => '6',
                                        'e' => '8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang memiliki tiga sisi adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Luas dan Keliling' || $key == 'Luas dan Keliling'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah luas persegi dengan sisi 4 cm?",
                                    'jawaban' => [
                                        'a' => '16 cm²',
                                        'b' => '8 cm²',
                                        'c' => '12 cm²',
                                        'd' => '20 cm²',
                                        'e' => '24 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi panjang dengan panjang 6 cm dan lebar 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '20 cm',
                                        'b' => '24 cm',
                                        'c' => '18 cm',
                                        'd' => '16 cm',
                                        'e' => '22 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Simetri' || $key == 'Simetri') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Persegi memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '3',
                                        'd' => '5',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang hanya memiliki satu simetri lipat adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga sama kaki',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bangun Ruang' || $key == 'Bangun Ruang') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Bangun ruang yang memiliki 6 sisi sama besar adalah...",
                                    'jawaban' => [
                                        'a' => 'Kubus',
                                        'b' => 'Balok',
                                        'c' => 'Tabung',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas dan tutup berbentuk lingkaran adalah...",
                                    'jawaban' => [
                                        'a' => 'Tabung',
                                        'b' => 'Kubus',
                                        'c' => 'Balok',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Volume' || $key == 'Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '27 cm³',
                                        'b' => '9 cm³',
                                        'c' => '18 cm³',
                                        'd' => '12 cm³',
                                        'e' => '36 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume balok dengan panjang 4 cm, lebar 3 cm, dan tinggi 2 cm adalah...",
                                    'jawaban' => [
                                        'a' => '24 cm³',
                                        'b' => '12 cm³',
                                        'c' => '18 cm³',
                                        'd' => '20 cm³',
                                        'e' => '30 cm³'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Pengukuran':
                if ($subTopik == 'Satuan Luas' || $key == 'Satuan Luas') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 are sama dengan berapa meter persegi?",
                                    'jawaban' => [
                                        'a' => '100 m²',
                                        'b' => '10 m²',
                                        'c' => '1000 m²',
                                        'd' => '10000 m²',
                                        'e' => '1 m²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 hektar sama dengan berapa are?",
                                    'jawaban' => [
                                        'a' => '100 are',
                                        'b' => '10 are',
                                        'c' => '1000 are',
                                        'd' => '10000 are',
                                        'e' => '1 are'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Volume' || $key == 'Satuan Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 liter sama dengan berapa mililiter?",
                                    'jawaban' => [
                                        'a' => '1000 ml',
                                        'b' => '100 ml',
                                        'c' => '10 ml',
                                        'd' => '500 ml',
                                        'e' => '2000 ml'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 m³ sama dengan berapa liter?",
                                    'jawaban' => [
                                        'a' => '1000 liter',
                                        'b' => '100 liter',
                                        'c' => '10 liter',
                                        'd' => '500 liter',
                                        'e' => '2000 liter'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Debit' || $key == 'Satuan Debit') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Debit air 2 liter per menit, berapa liter air yang keluar dalam 5 menit?",
                                    'jawaban' => [
                                        'a' => '10',
                                        'b' => '5',
                                        'c' => '7',
                                        'd' => '12',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 3 liter per menit, berapa liter air yang keluar dalam 10 menit?",
                                    'jawaban' => [
                                        'a' => '30',
                                        'b' => '13',
                                        'c' => '20',
                                        'd' => '25',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Statistika':
                if ($subTopik == 'Rata-rata' || $key == 'Rata-rata') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Rata-rata dari 6, 8, 10 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '7',
                                        'd' => '9',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 5, 7, 9, 11 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '10',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Modus' || $key == 'Modus'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Modus dari data 2, 3, 3, 5, 7 adalah...",
                                    'jawaban' => [
                                        'a' => '3',
                                        'b' => '2',
                                        'c' => '5',
                                        'd' => '7',
                                        'e' => '4'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 1, 2, 2, 2, 3, 4 adalah...",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '1',
                                        'c' => '3',
                                        'd' => '4',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Geometri':
                if ($subTopik == 'Bangun Datar' || $key == 'Bangun Datar') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah jumlah sisi pada persegi?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '3',
                                        'c' => '5',
                                        'd' => '6',
                                        'e' => '8'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang memiliki tiga sisi adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Luas dan Keliling' || $key == 'Luas dan Keliling') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Berapakah luas persegi dengan sisi 4 cm?",
                                    'jawaban' => [
                                        'a' => '16 cm²',
                                        'b' => '8 cm²',
                                        'c' => '12 cm²',
                                        'd' => '20 cm²',
                                        'e' => '24 cm²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Keliling persegi panjang dengan panjang 6 cm dan lebar 4 cm adalah...",
                                    'jawaban' => [
                                        'a' => '20 cm',
                                        'b' => '24 cm',
                                        'c' => '18 cm',
                                        'd' => '16 cm',
                                        'e' => '22 cm'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Simetri' || $key == 'Simetri') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Persegi memiliki berapa simetri lipat?",
                                    'jawaban' => [
                                        'a' => '4',
                                        'b' => '2',
                                        'c' => '3',
                                        'd' => '5',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun datar yang hanya memiliki satu simetri lipat adalah...",
                                    'jawaban' => [
                                        'a' => 'Segitiga sama kaki',
                                        'b' => 'Persegi',
                                        'c' => 'Lingkaran',
                                        'd' => 'Persegi panjang',
                                        'e' => 'Jajar genjang'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Bangun Ruang' || $key == 'Bangun Ruang') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Bangun ruang yang memiliki 6 sisi sama besar adalah...",
                                    'jawaban' => [
                                        'a' => 'Kubus',
                                        'b' => 'Balok',
                                        'c' => 'Tabung',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Bangun ruang yang memiliki alas dan tutup berbentuk lingkaran adalah...",
                                    'jawaban' => [
                                        'a' => 'Tabung',
                                        'b' => 'Kubus',
                                        'c' => 'Balok',
                                        'd' => 'Kerucut',
                                        'e' => 'Limas'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Volume' || $key == 'Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Volume kubus dengan panjang rusuk 3 cm adalah...",
                                    'jawaban' => [
                                        'a' => '27 cm³',
                                        'b' => '9 cm³',
                                        'c' => '18 cm³',
                                        'd' => '12 cm³',
                                        'e' => '36 cm³'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Volume balok dengan panjang 4 cm, lebar 3 cm, dan tinggi 2 cm adalah...",
                                    'jawaban' => [
                                        'a' => '24 cm³',
                                        'b' => '12 cm³',
                                        'c' => '18 cm³',
                                        'd' => '20 cm³',
                                        'e' => '30 cm³'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Pengukuran':
                if ($subTopik == 'Satuan Luas' || $key == 'Satuan Luas') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 are sama dengan berapa meter persegi?",
                                    'jawaban' => [
                                        'a' => '100 m²',
                                        'b' => '10 m²',
                                        'c' => '1000 m²',
                                        'd' => '10000 m²',
                                        'e' => '1 m²'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 hektar sama dengan berapa are?",
                                    'jawaban' => [
                                        'a' => '100 are',
                                        'b' => '10 are',
                                        'c' => '1000 are',
                                        'd' => '10000 are',
                                        'e' => '1 are'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Volume' || $key == 'Satuan Volume') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "1 liter sama dengan berapa mililiter?",
                                    'jawaban' => [
                                        'a' => '1000 ml',
                                        'b' => '100 ml',
                                        'c' => '10 ml',
                                        'd' => '500 ml',
                                        'e' => '2000 ml'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "1 m³ sama dengan berapa liter?",
                                    'jawaban' => [
                                        'a' => '1000 liter',
                                        'b' => '100 liter',
                                        'c' => '10 liter',
                                        'd' => '500 liter',
                                        'e' => '2000 liter'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Satuan Debit' || $key == 'Satuan Debit' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Debit air 2 liter per menit, berapa liter air yang keluar dalam 5 menit?",
                                    'jawaban' => [
                                        'a' => '10',
                                        'b' => '5',
                                        'c' => '7',
                                        'd' => '12',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Debit air 3 liter per menit, berapa liter air yang keluar dalam 10 menit?",
                                    'jawaban' => [
                                        'a' => '30',
                                        'b' => '13',
                                        'c' => '20',
                                        'd' => '25',
                                        'e' => '15'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Statistika':
                if ($subTopik == 'Rata-rata' || $key == 'Rata-rata') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Rata-rata dari 6, 8, 10 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '6',
                                        'c' => '7',
                                        'd' => '9',
                                        'e' => '10'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rata-rata dari 5, 7, 9, 11 adalah...",
                                    'jawaban' => [
                                        'a' => '8',
                                        'b' => '7',
                                        'c' => '9',
                                        'd' => '10',
                                        'e' => '6'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Modus' || $key == 'Modus') {
                    switch ($jenjang) {
                        case 'SD':
                            $questions = [
                                [
                                    'soal' => "Modus dari data 2, 3, 3, 5, 7 adalah...",
                                    'jawaban' => [
                                        'a' => '3',
                                        'b' => '2',
                                        'c' => '5',
                                        'd' => '7',
                                        'e' => '4'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Modus dari data 1, 2, 2, 2, 3, 4 adalah...",
                                    'jawaban' => [
                                        'a' => '2',
                                        'b' => '1',
                                        'c' => '3',
                                        'd' => '4',
                                        'e' => '5'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalBahasaIndonesia($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Membaca':
                if ($subTopik == 'Membaca Nyaring' || $key == 'Membaca Nyaring') {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan contoh kalimat yang baik untuk dibaca nyaring adalah...",
                                "Kalimat yang tepat untuk dibaca nyaring dengan intonasi yang baik adalah...",
                                "Contoh kalimat yang dapat dibaca nyaring dengan lafal yang jelas adalah...",
                                "Kalimat yang cocok untuk latihan membaca nyaring adalah...",
                                "Berikut ini kalimat yang baik untuk dibaca nyaring di depan kelas adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Ani pergi ke sekolah dengan riang gembira.',
                                    'b' => 'Ani pergi ke sekolah dengan riang gembira!',
                                    'c' => 'Ani pergi ke sekolah dengan riang gembira?',
                                    'd' => 'Ani pergi ke sekolah dengan riang gembira...',
                                    'e' => 'Ani pergi ke sekolah dengan riang gembira;'
                                ],
                                [
                                    'a' => 'Budi belajar dengan tekun setiap hari.',
                                    'b' => 'Budi belajar dengan tekun setiap hari!',
                                    'c' => 'Budi belajar dengan tekun setiap hari?',
                                    'd' => 'Budi belajar dengan tekun setiap hari...',
                                    'e' => 'Budi belajar dengan tekun setiap hari;'
                                ],
                                [
                                    'a' => 'Ibu memasak nasi goreng yang enak.',
                                    'b' => 'Ibu memasak nasi goreng yang enak!',
                                    'c' => 'Ibu memasak nasi goreng yang enak?',
                                    'd' => 'Ibu memasak nasi goreng yang enak...',
                                    'e' => 'Ibu memasak nasi goreng yang enak;'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Pemahaman' || $key == 'Membaca Pemahaman') {
                    switch ($jenjang) {
                        case 'SD':
                            $teksVariasi = [
                                "Budi sedang bermain bola di lapangan. Tiba-tiba hujan turun. Budi segera pulang ke rumah.",
                                "Ani suka berkebun. Setiap pagi ia menyiram bunga. Bunga-bunganya tumbuh subur dan indah.",
                                "Pak Guru mengajar matematika. Siswa-siswa mendengarkan dengan tekun. Mereka mengerjakan soal bersama-sama.",
                                "Ibu membeli sayuran di pasar. Ia memilih sayuran yang segar. Sayuran itu untuk makan siang keluarga.",
                                "Rina suka membaca buku cerita. Setiap malam sebelum tidur, ia membaca cerita. Buku favoritnya adalah dongeng."
                            ];
                            $teks = $teksVariasi[array_rand($teksVariasi)];
                            
                            $pertanyaanVariasi = [
                                "Apa yang dilakukan Budi ketika hujan turun?",
                                "Kapan Ani menyiram bunga?",
                                "Bagaimana sikap siswa-siswa saat belajar?",
                                "Di mana Ibu membeli sayuran?",
                                "Kapan Rina membaca buku cerita?"
                            ];
                            $pertanyaan = $pertanyaanVariasi[array_rand($pertanyaanVariasi)];
                            
                            $template['soal'] = $teks . "\n\n" . $pertanyaan;
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Pulang ke rumah',
                                    'b' => 'Terus bermain bola',
                                    'c' => 'Bermain di bawah pohon',
                                    'd' => 'Menunggu hujan reda',
                                    'e' => 'Mencari tempat berteduh'
                                ],
                                [
                                    'a' => 'Setiap pagi',
                                    'b' => 'Setiap sore',
                                    'c' => 'Setiap malam',
                                    'd' => 'Setiap siang',
                                    'e' => 'Setiap minggu'
                                ],
                                [
                                    'a' => 'Dengan tekun',
                                    'b' => 'Dengan malas',
                                    'c' => 'Dengan bosan',
                                    'd' => 'Dengan marah',
                                    'e' => 'Dengan sedih'
                                ],
                                [
                                    'a' => 'Di pasar',
                                    'b' => 'Di toko',
                                    'c' => 'Di mall',
                                    'd' => 'Di warung',
                                    'e' => 'Di supermarket'
                                ],
                                [
                                    'a' => 'Setiap malam sebelum tidur',
                                    'b' => 'Setiap pagi',
                                    'c' => 'Setiap siang',
                                    'd' => 'Setiap sore',
                                    'e' => 'Setiap minggu'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan teknik membaca cepat adalah...",
                                "Cara membaca cepat yang benar adalah...",
                                "Teknik yang digunakan untuk membaca cepat adalah...",
                                "Berikut ini cara membaca dengan kecepatan tinggi adalah...",
                                "Teknik membaca yang dapat meningkatkan kecepatan adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Membaca dengan skimming dan scanning',
                                    'b' => 'Membaca dengan suara keras',
                                    'c' => 'Membaca dengan jari',
                                    'd' => 'Membaca dengan menggerakkan kepala',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ],
                                [
                                    'a' => 'Membaca dengan fokus pada kata kunci',
                                    'b' => 'Membaca dengan suara pelan',
                                    'c' => 'Membaca dengan mengulang kata',
                                    'd' => 'Membaca dengan menunjuk huruf',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Cepat' || $key == 'Membaca Cepat'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan teknik membaca cepat adalah...",
                                "Cara membaca cepat yang benar adalah...",
                                "Teknik yang digunakan untuk membaca cepat adalah...",
                                "Berikut ini cara membaca dengan kecepatan tinggi adalah...",
                                "Teknik membaca yang dapat meningkatkan kecepatan adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Membaca dengan gerakan mata yang cepat',
                                    'b' => 'Membaca dengan suara keras',
                                    'c' => 'Membaca dengan jari',
                                    'd' => 'Membaca dengan menggerakkan kepala',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ],
                                [
                                    'a' => 'Membaca dengan skimming dan scanning',
                                    'b' => 'Membaca dengan suara pelan',
                                    'c' => 'Membaca dengan mengulang kata',
                                    'd' => 'Membaca dengan menunjuk huruf',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan teknik membaca cepat adalah...",
                                "Cara membaca cepat yang benar adalah...",
                                "Teknik yang digunakan untuk membaca cepat adalah...",
                                "Berikut ini cara membaca dengan kecepatan tinggi adalah...",
                                "Teknik membaca yang dapat meningkatkan kecepatan adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Membaca dengan skimming dan scanning',
                                    'b' => 'Membaca dengan suara keras',
                                    'c' => 'Membaca dengan jari',
                                    'd' => 'Membaca dengan menggerakkan kepala',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ],
                                [
                                    'a' => 'Membaca dengan fokus pada kata kunci',
                                    'b' => 'Membaca dengan suara pelan',
                                    'c' => 'Membaca dengan mengulang kata',
                                    'd' => 'Membaca dengan menunjuk huruf',
                                    'e' => 'Membaca dengan menggerakkan bibir'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Membaca intensif bertujuan untuk...",
                                "Tujuan membaca dengan teliti dan mendalam adalah...",
                                "Membaca intensif dilakukan untuk...",
                                "Kapan kita perlu membaca intensif?",
                                "Membaca intensif berguna untuk..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menganalisis teks secara mendalam',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca sambil lalu',
                                    'd' => 'Membaca tanpa memahami',
                                    'e' => 'Membaca dengan terburu-buru'
                                ],
                                [
                                    'a' => 'Mengidentifikasi unsur-unsur teks',
                                    'b' => 'Menyelesaikan bacaan dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa tujuan'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Intensif' || $key == 'Membaca Intensif') {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Membaca intensif bertujuan untuk...",
                                "Tujuan membaca dengan teliti dan mendalam adalah...",
                                "Membaca intensif dilakukan untuk...",
                                "Kapan kita perlu membaca intensif?",
                                "Membaca intensif berguna untuk..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Memahami isi bacaan dengan mendalam',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca sambil lalu',
                                    'd' => 'Membaca tanpa memahami',
                                    'e' => 'Membaca dengan terburu-buru'
                                ],
                                [
                                    'a' => 'Mendapatkan pemahaman yang lengkap',
                                    'b' => 'Menyelesaikan bacaan dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa tujuan'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Membaca intensif bertujuan untuk...",
                                "Tujuan membaca dengan teliti dan mendalam adalah...",
                                "Membaca intensif dilakukan untuk...",
                                "Kapan kita perlu membaca intensif?",
                                "Membaca intensif berguna untuk..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menganalisis teks secara mendalam',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca sambil lalu',
                                    'd' => 'Membaca tanpa memahami',
                                    'e' => 'Membaca dengan terburu-buru'
                                ],
                                [
                                    'a' => 'Mengidentifikasi unsur-unsur teks',
                                    'b' => 'Menyelesaikan bacaan dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa tujuan'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Membaca ekstensif bertujuan untuk...",
                                "Tujuan membaca banyak buku adalah...",
                                "Membaca ekstensif berguna untuk...",
                                "Manfaat membaca berbagai jenis buku adalah...",
                                "Membaca ekstensif dapat..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Mengembangkan kemampuan analisis mendalam',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca tanpa memahami',
                                    'd' => 'Membaca sambil lalu',
                                    'e' => 'Membaca tanpa tujuan'
                                ],
                                [
                                    'a' => 'Meningkatkan kemampuan evaluasi kritis',
                                    'b' => 'Menyelesaikan tugas dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa manfaat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Ekstensif' || $key == 'Membaca Ekstensif'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Membaca ekstensif bertujuan untuk...",
                                "Tujuan membaca banyak buku adalah...",
                                "Membaca ekstensif berguna untuk...",
                                "Manfaat membaca berbagai jenis buku adalah...",
                                "Membaca ekstensif dapat..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Memperluas wawasan dan pengetahuan',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca tanpa memahami',
                                    'd' => 'Membaca sambil lalu',
                                    'e' => 'Membaca tanpa tujuan'
                                ],
                                [
                                    'a' => 'Menambah ilmu pengetahuan',
                                    'b' => 'Menyelesaikan tugas dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa manfaat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Membaca ekstensif bertujuan untuk...",
                                "Tujuan membaca banyak buku adalah...",
                                "Membaca ekstensif berguna untuk...",
                                "Manfaat membaca berbagai jenis buku adalah...",
                                "Membaca ekstensif dapat..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Memperluas wawasan dan pengetahuan',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca tanpa memahami',
                                    'd' => 'Membaca sambil lalu',
                                    'e' => 'Membaca tanpa tujuan'
                                ],
                                [
                                    'a' => 'Mengembangkan kemampuan berpikir kritis',
                                    'b' => 'Menyelesaikan tugas dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa manfaat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Membaca ekstensif bertujuan untuk...",
                                "Tujuan membaca banyak buku adalah...",
                                "Membaca ekstensif berguna untuk...",
                                "Manfaat membaca berbagai jenis buku adalah...",
                                "Membaca ekstensif dapat..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Mengembangkan kemampuan analisis mendalam',
                                    'b' => 'Membaca dengan cepat',
                                    'c' => 'Membaca tanpa memahami',
                                    'd' => 'Membaca sambil lalu',
                                    'e' => 'Membaca tanpa tujuan'
                                ],
                                [
                                    'a' => 'Meningkatkan kemampuan evaluasi kritis',
                                    'b' => 'Menyelesaikan tugas dengan cepat',
                                    'c' => 'Membaca tanpa konsentrasi',
                                    'd' => 'Membaca sambil bermain',
                                    'e' => 'Membaca tanpa manfaat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Menulis':
                if ($subTopik == 'Menulis Karangan' || $key == 'Menulis Karangan') {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan bagian pembuka dalam karangan adalah...",
                                "Bagian awal karangan yang berisi pengantar adalah...",
                                "Bagian karangan yang mengawali tulisan adalah...",
                                "Struktur karangan yang berisi pendahuluan adalah...",
                                "Bagian karangan yang memperkenalkan topik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Pendahuluan',
                                    'b' => 'Kesimpulan',
                                    'c' => 'Penutup',
                                    'd' => 'Daftar pustaka',
                                    'e' => 'Lampiran'
                                ],
                                [
                                    'a' => 'Pembuka',
                                    'b' => 'Penutup',
                                    'c' => 'Isi',
                                    'd' => 'Kesimpulan',
                                    'e' => 'Daftar pustaka'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan bagian pembuka dalam karangan adalah...",
                                "Bagian awal karangan yang berisi pengantar adalah...",
                                "Bagian karangan yang mengawali tulisan adalah...",
                                "Struktur karangan yang berisi pendahuluan adalah...",
                                "Bagian karangan yang memperkenalkan topik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Pendahuluan yang menarik',
                                    'b' => 'Kesimpulan',
                                    'c' => 'Penutup',
                                    'd' => 'Daftar pustaka',
                                    'e' => 'Lampiran'
                                ],
                                [
                                    'a' => 'Pembuka yang informatif',
                                    'b' => 'Penutup',
                                    'c' => 'Isi',
                                    'd' => 'Kesimpulan',
                                    'e' => 'Daftar pustaka'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan bagian pembuka dalam karangan adalah...",
                                "Bagian awal karangan yang berisi pengantar adalah...",
                                "Bagian karangan yang mengawali tulisan adalah...",
                                "Struktur karangan yang berisi pendahuluan adalah...",
                                "Bagian karangan yang memperkenalkan topik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Pendahuluan yang argumentatif',
                                    'b' => 'Kesimpulan',
                                    'c' => 'Penutup',
                                    'd' => 'Daftar pustaka',
                                    'e' => 'Lampiran'
                                ],
                                [
                                    'a' => 'Pembuka yang analitis',
                                    'b' => 'Penutup',
                                    'c' => 'Isi',
                                    'd' => 'Kesimpulan',
                                    'e' => 'Daftar pustaka'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Surat' || $key == 'Menulis Surat'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Bagian surat yang berisi tanggal surat adalah...",
                                "Tempat menulis tanggal dalam surat adalah...",
                                "Bagian surat yang menunjukkan waktu penulisan adalah...",
                                "Di mana kita menulis tanggal surat?",
                                "Bagian surat yang berisi waktu adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Kepala surat',
                                    'b' => 'Pembuka surat',
                                    'c' => 'Isi surat',
                                    'd' => 'Penutup surat',
                                    'e' => 'Tanda tangan'
                                ],
                                [
                                    'a' => 'Bagian atas surat',
                                    'b' => 'Bagian tengah surat',
                                    'c' => 'Bagian bawah surat',
                                    'd' => 'Bagian samping surat',
                                    'e' => 'Bagian belakang surat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Bagian surat yang berisi tanggal surat adalah...",
                                "Tempat menulis tanggal dalam surat adalah...",
                                "Bagian surat yang menunjukkan waktu penulisan adalah...",
                                "Di mana kita menulis tanggal surat?",
                                "Bagian surat yang berisi waktu adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Kepala surat yang lengkap',
                                    'b' => 'Pembuka surat',
                                    'c' => 'Isi surat',
                                    'd' => 'Penutup surat',
                                    'e' => 'Tanda tangan'
                                ],
                                [
                                    'a' => 'Bagian atas surat yang formal',
                                    'b' => 'Bagian tengah surat',
                                    'c' => 'Bagian bawah surat',
                                    'd' => 'Bagian samping surat',
                                    'e' => 'Bagian belakang surat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Bagian surat yang berisi tanggal surat adalah...",
                                "Tempat menulis tanggal dalam surat adalah...",
                                "Bagian surat yang menunjukkan waktu penulisan adalah...",
                                "Di mana kita menulis tanggal surat?",
                                "Bagian surat yang berisi waktu adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Kepala surat yang formal',
                                    'b' => 'Pembuka surat',
                                    'c' => 'Isi surat',
                                    'd' => 'Penutup surat',
                                    'e' => 'Tanda tangan'
                                ],
                                [
                                    'a' => 'Bagian atas surat yang resmi',
                                    'b' => 'Bagian tengah surat',
                                    'c' => 'Bagian bawah surat',
                                    'd' => 'Bagian samping surat',
                                    'e' => 'Bagian belakang surat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Puisi' || $key == 'Menulis Puisi'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan ciri-ciri puisi adalah...",
                                "Ciri khas puisi yang membedakannya dengan prosa adalah...",
                                "Karakteristik puisi yang utama adalah...",
                                "Yang membuat puisi berbeda dari tulisan lain adalah...",
                                "Ciri-ciri khusus puisi adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan bahasa yang indah',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang formal',
                                    'e' => 'Menggunakan bahasa yang kaku'
                                ],
                                [
                                    'a' => 'Menggunakan rima dan irama',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang kaku',
                                    'e' => 'Menggunakan bahasa yang formal'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan ciri-ciri puisi adalah...",
                                "Ciri khas puisi yang membedakannya dengan prosa adalah...",
                                "Karakteristik puisi yang utama adalah...",
                                "Yang membuat puisi berbeda dari tulisan lain adalah...",
                                "Ciri-ciri khusus puisi adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan bahasa yang indah dan kiasan',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang formal',
                                    'e' => 'Menggunakan bahasa yang kaku'
                                ],
                                [
                                    'a' => 'Menggunakan rima, irama, dan majas',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang kaku',
                                    'e' => 'Menggunakan bahasa yang formal'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan ciri-ciri puisi adalah...",
                                "Ciri khas puisi yang membedakannya dengan prosa adalah...",
                                "Karakteristik puisi yang utama adalah...",
                                "Yang membuat puisi berbeda dari tulisan lain adalah...",
                                "Ciri-ciri khusus puisi adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan bahasa yang indah dan simbolik',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang formal',
                                    'e' => 'Menggunakan bahasa yang kaku'
                                ],
                                [
                                    'a' => 'Menggunakan rima, irama, dan metafora kompleks',
                                    'b' => 'Menggunakan bahasa yang panjang',
                                    'c' => 'Menggunakan bahasa yang sulit',
                                    'd' => 'Menggunakan bahasa yang kaku',
                                    'e' => 'Menggunakan bahasa yang formal'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Cerita' || $key == 'Menulis Cerita'     ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan unsur cerita adalah...",
                                "Bagian cerita yang berisi tokoh dan latar adalah...",
                                "Unsur cerita yang penting adalah...",
                                "Yang harus ada dalam cerita adalah...",
                                "Komponen cerita yang utama adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Tokoh, latar, dan alur',
                                    'b' => 'Judul dan penulis',
                                    'c' => 'Tanggal dan waktu',
                                    'd' => 'Tanda tangan dan stempel',
                                    'e' => 'Alamat dan nomor'
                                ],
                                [
                                    'a' => 'Karakter, setting, dan plot',
                                    'b' => 'Nama dan umur',
                                    'c' => 'Tempat dan tanggal',
                                    'd' => 'Tanda tangan dan cap',
                                    'e' => 'Alamat dan telepon'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan unsur cerita adalah...",
                                "Bagian cerita yang berisi tokoh dan latar adalah...",
                                "Unsur cerita yang penting adalah...",
                                "Yang harus ada dalam cerita adalah...",
                                "Komponen cerita yang utama adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Tokoh, latar, alur, dan tema',
                                    'b' => 'Judul dan penulis',
                                    'c' => 'Tanggal dan waktu',
                                    'd' => 'Tanda tangan dan stempel',
                                    'e' => 'Alamat dan nomor'
                                ],
                                [
                                    'a' => 'Karakter, setting, plot, dan konflik',
                                    'b' => 'Nama dan umur',
                                    'c' => 'Tempat dan tanggal',
                                    'd' => 'Tanda tangan dan cap',
                                    'e' => 'Alamat dan telepon'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan unsur cerita adalah...",
                                "Bagian cerita yang berisi tokoh dan latar adalah...",
                                "Unsur cerita yang penting adalah...",
                                "Yang harus ada dalam cerita adalah...",
                                "Komponen cerita yang utama adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Tokoh, latar, alur, tema, dan amanat',
                                    'b' => 'Judul dan penulis',
                                    'c' => 'Tanggal dan waktu',
                                    'd' => 'Tanda tangan dan stempel',
                                    'e' => 'Alamat dan nomor'
                                ],
                                [
                                    'a' => 'Karakter, setting, plot, konflik, dan resolusi',
                                    'b' => 'Nama dan umur',
                                    'c' => 'Tempat dan tanggal',
                                    'd' => 'Tanda tangan dan cap',
                                    'e' => 'Alamat dan telepon'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Laporan' || $key == 'Menulis Laporan'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan bagian laporan adalah...",
                                "Struktur laporan yang benar adalah...",
                                "Bagian laporan yang berisi hasil kegiatan adalah...",
                                "Yang harus ada dalam laporan adalah...",
                                "Komponen laporan yang penting adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Judul, pendahuluan, isi, dan penutup',
                                    'b' => 'Nama dan alamat',
                                    'c' => 'Tanggal dan waktu',
                                    'd' => 'Tanda tangan dan stempel',
                                    'e' => 'Nomor dan kode'
                                ],
                                [
                                    'a' => 'Pembuka, isi, dan kesimpulan',
                                    'b' => 'Nama dan umur',
                                    'c' => 'Tempat dan tanggal',
                                    'd' => 'Tanda tangan dan cap',
                                    'e' => 'Alamat dan telepon'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Berbicara':
                if ($subTopik == 'Berbicara di Depan Kelas' || $key == 'Berbicara di Depan Kelas'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan sikap yang baik saat berbicara di depan kelas adalah...",
                                "Cara berbicara yang baik di depan kelas adalah...",
                                "Sikap yang tepat saat presentasi di kelas adalah...",
                                "Yang harus dilakukan saat berbicara di depan adalah...",
                                "Cara berdiri yang baik saat berbicara adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Berdiri tegak dan menatap audiens',
                                    'b' => 'Berdiri sambil bersandar',
                                    'c' => 'Berdiri sambil menggerakkan kaki',
                                    'd' => 'Berdiri sambil menunduk',
                                    'e' => 'Berdiri sambil memainkan tangan'
                                ],
                                [
                                    'a' => 'Berdiri dengan percaya diri',
                                    'b' => 'Berdiri sambil bergoyang',
                                    'c' => 'Berdiri sambil menggaruk kepala',
                                    'd' => 'Berdiri sambil melihat ke bawah',
                                    'e' => 'Berdiri sambil memainkan jari'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Berdiskusi' || $key == 'Berdiskusi'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan sikap yang baik dalam berdiskusi adalah...",
                                "Cara berdiskusi yang baik adalah...",
                                "Sikap yang tepat dalam diskusi kelompok adalah...",
                                "Yang harus dilakukan saat berdiskusi adalah...",
                                "Cara menghargai teman dalam diskusi adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menghargai pendapat teman',
                                    'b' => 'Memotong pembicaraan teman',
                                    'c' => 'Mengabaikan pendapat teman',
                                    'd' => 'Memaksa teman setuju',
                                    'e' => 'Mengolok-olok pendapat teman'
                                ],
                                [
                                    'a' => 'Mendengarkan dengan baik',
                                    'b' => 'Berbicara terus menerus',
                                    'c' => 'Mengabaikan pembicaraan',
                                    'd' => 'Memaksa pendapat sendiri',
                                    'e' => 'Mengejek pendapat lain'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Bercerita' || $key == 'Bercerita'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan ciri-ciri cerita yang baik adalah...",
                                "Cara bercerita yang menarik adalah...",
                                "Yang membuat cerita menjadi menarik adalah...",
                                "Ciri-ciri cerita yang bagus adalah...",
                                "Yang harus ada dalam cerita yang baik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan bahasa yang mudah dipahami',
                                    'b' => 'Menggunakan bahasa yang sulit',
                                    'c' => 'Menggunakan bahasa yang panjang',
                                    'd' => 'Menggunakan bahasa yang kaku',
                                    'e' => 'Menggunakan bahasa yang formal'
                                ],
                                [
                                    'a' => 'Menggunakan intonasi yang menarik',
                                    'b' => 'Berbicara dengan monoton',
                                    'c' => 'Berbicara dengan cepat',
                                    'd' => 'Berbicara dengan pelan',
                                    'e' => 'Berbicara tanpa ekspresi'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Berwawancara' || $key == 'Berwawancara'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan sikap yang baik saat wawancara adalah...",
                                "Cara melakukan wawancara yang baik adalah...",
                                "Yang harus dilakukan saat wawancara adalah...",
                                "Sikap yang tepat saat bertanya adalah...",
                                "Cara menghormati narasumber adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Mendengarkan dengan baik',
                                    'b' => 'Memotong pembicaraan',
                                    'c' => 'Mengabaikan jawaban',
                                    'd' => 'Bertanya dengan kasar',
                                    'e' => 'Mengejek jawaban'
                                ],
                                [
                                    'a' => 'Bertanya dengan sopan',
                                    'b' => 'Bertanya dengan kasar',
                                    'c' => 'Bertanya dengan terburu-buru',
                                    'd' => 'Bertanya tanpa tujuan',
                                    'e' => 'Bertanya sambil bermain'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Berpidato' || $key == 'Berpidato'       ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan bagian pidato adalah...",
                                "Struktur pidato yang benar adalah...",
                                "Bagian pidato yang berisi salam pembuka adalah...",
                                "Yang harus ada dalam pidato adalah...",
                                "Komponen pidato yang penting adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Pembuka, isi, dan penutup',
                                    'b' => 'Nama dan alamat',
                                    'c' => 'Tanggal dan waktu',
                                    'd' => 'Tanda tangan dan stempel',
                                    'e' => 'Nomor dan kode'
                                ],
                                [
                                    'a' => 'Salam, pendahuluan, dan kesimpulan',
                                    'b' => 'Nama dan umur',
                                    'c' => 'Tempat dan tanggal',
                                    'd' => 'Tanda tangan dan cap',
                                    'e' => 'Alamat dan telepon'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan teknik berpidato yang baik adalah...",
                                "Cara berpidato yang efektif adalah...",
                                "Teknik yang digunakan dalam berpidato adalah...",
                                "Yang harus diperhatikan saat berpidato adalah...",
                                "Komponen pidato yang harus dikuasai adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan bahasa yang jelas dan mudah dipahami',
                                    'b' => 'Berbicara dengan cepat dan terburu-buru',
                                    'c' => 'Menggunakan bahasa yang sulit dan formal',
                                    'd' => 'Berbicara tanpa persiapan',
                                    'e' => 'Mengabaikan audiens'
                                ],
                                [
                                    'a' => 'Menggunakan gestur dan ekspresi yang tepat',
                                    'b' => 'Berdiri kaku tanpa gerakan',
                                    'c' => 'Menggunakan gerakan yang berlebihan',
                                    'd' => 'Tidak melihat ke audiens',
                                    'e' => 'Berbicara sambil bermain-main'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan teknik berpidato tingkat lanjut adalah...",
                                "Cara berpidato yang persuasif dan argumentatif adalah...",
                                "Teknik retorika yang digunakan dalam berpidato adalah...",
                                "Yang harus dikuasai dalam berpidato tingkat SMA adalah...",
                                "Komponen pidato yang menunjukkan kematangan adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menggunakan argumentasi yang logis dan sistematis',
                                    'b' => 'Berbicara tanpa struktur yang jelas',
                                    'c' => 'Menggunakan bahasa yang sederhana saja',
                                    'd' => 'Tidak memperhatikan logika berpikir',
                                    'e' => 'Berbicara tanpa tujuan yang jelas'
                                ],
                                [
                                    'a' => 'Menggunakan teknik retorika dan persuasi',
                                    'b' => 'Berbicara monoton tanpa variasi',
                                    'c' => 'Tidak menggunakan contoh dan ilustrasi',
                                    'd' => 'Mengabaikan aspek psikologis audiens',
                                    'e' => 'Berbicara tanpa memperhatikan konteks'
                                ],
                                [
                                    'a' => 'Menggunakan data dan fakta yang akurat',
                                    'b' => 'Berbicara berdasarkan asumsi saja',
                                    'c' => 'Tidak menggunakan referensi yang valid',
                                    'd' => 'Menggunakan informasi yang tidak terverifikasi',
                                    'e' => 'Berbicara tanpa dasar yang kuat'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kebahasaan':
                if ($subTopik == 'Kata Baku' || $key == 'Kata Baku') {
                    switch ($jenjang) {
                        case 'SD':
                            $kataBakuVariasi = [
                                ['karier', 'karir', 'kariir', 'karier', 'karierr'],
                                ['apotek', 'apotik', 'apotik', 'apotek', 'apotik'],
                                ['sistem', 'sistim', 'sistem', 'sistim', 'sistem'],
                                ['objek', 'obyek', 'objek', 'obyek', 'objek'],
                                ['praktek', 'praktik', 'praktek', 'praktik', 'praktek']
                            ];
                            $kataBaku = $kataBakuVariasi[array_rand($kataBakuVariasi)];
                            
                            $soalVariasi = [
                                "Berikut ini yang merupakan kata baku adalah...",
                                "Kata yang penulisannya benar adalah...",
                                "Kata yang sesuai dengan EYD adalah...",
                                "Kata yang baku adalah...",
                                "Kata yang penulisannya tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $template['jawaban'] = [
                                'a' => $kataBaku[0],
                                'b' => $kataBaku[1],
                                'c' => $kataBaku[2],
                                'd' => $kataBaku[3],
                                'e' => $kataBaku[4]
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $kataBakuVariasi = [
                                ['karier', 'karir', 'kariir', 'karier', 'karierr'],
                                ['apotek', 'apotik', 'apotik', 'apotek', 'apotik'],
                                ['sistem', 'sistim', 'sistem', 'sistim', 'sistem'],
                                ['objek', 'obyek', 'objek', 'obyek', 'objek'],
                                ['praktek', 'praktik', 'praktek', 'praktik', 'praktek'],
                                ['ekstrem', 'ekstrim', 'ekstrem', 'ekstrim', 'ekstrem'],
                                ['kompleks', 'komplek', 'kompleks', 'komplek', 'kompleks'],
                                ['standar', 'standard', 'standar', 'standard', 'standar']
                            ];
                            $kataBaku = $kataBakuVariasi[array_rand($kataBakuVariasi)];
                            
                            $soalVariasi = [
                                "Berikut ini yang merupakan kata baku adalah...",
                                "Kata yang penulisannya benar adalah...",
                                "Kata yang sesuai dengan EYD adalah...",
                                "Kata yang baku adalah...",
                                "Kata yang penulisannya tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $template['jawaban'] = [
                                'a' => $kataBaku[0],
                                'b' => $kataBaku[1],
                                'c' => $kataBaku[2],
                                'd' => $kataBaku[3],
                                'e' => $kataBaku[4]
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $kataBakuVariasi = [
                                ['karier', 'karir', 'kariir', 'karier', 'karierr'],
                                ['apotek', 'apotik', 'apotik', 'apotek', 'apotik'],
                                ['sistem', 'sistim', 'sistem', 'sistim', 'sistem'],
                                ['objek', 'obyek', 'objek', 'obyek', 'objek'],
                                ['praktek', 'praktik', 'praktek', 'praktik', 'praktek'],
                                ['ekstrem', 'ekstrim', 'ekstrem', 'ekstrim', 'ekstrem'],
                                ['kompleks', 'komplek', 'kompleks', 'komplek', 'kompleks'],
                                ['standar', 'standard', 'standar', 'standard', 'standar'],
                                ['konsisten', 'konsisten', 'konsisten', 'konsisten', 'konsisten'],
                                ['efisien', 'efisien', 'efisien', 'efisien', 'efisien'],
                                ['kreatif', 'kreatif', 'kreatif', 'kreatif', 'kreatif'],
                                ['produktif', 'produktif', 'produktif', 'produktif', 'produktif']
                            ];
                            $kataBaku = $kataBakuVariasi[array_rand($kataBakuVariasi)];
                            
                            $soalVariasi = [
                                "Berikut ini yang merupakan kata baku adalah...",
                                "Kata yang penulisannya benar adalah...",
                                "Kata yang sesuai dengan EYD adalah...",
                                "Kata yang baku adalah...",
                                "Kata yang penulisannya tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $template['jawaban'] = [
                                'a' => $kataBaku[0],
                                'b' => $kataBaku[1],
                                'c' => $kataBaku[2],
                                'd' => $kataBaku[3],
                                'e' => $kataBaku[4]
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Ejaan' || $key == 'Ejaan'       ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Penulisan huruf kapital yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan huruf kapital dengan benar adalah...",
                                "Penulisan huruf besar yang tepat terdapat pada...",
                                "Kalimat yang ejaannya benar adalah...",
                                "Penggunaan huruf kapital yang benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Saya pergi ke Jakarta.',
                                    'b' => 'saya pergi ke jakarta.',
                                    'c' => 'Saya pergi ke jakarta.',
                                    'd' => 'saya pergi ke Jakarta.',
                                    'e' => 'SAYA PERGI KE JAKARTA.'
                                ],
                                [
                                    'a' => 'Budi belajar di Sekolah Dasar.',
                                    'b' => 'budi belajar di sekolah dasar.',
                                    'c' => 'Budi belajar di sekolah dasar.',
                                    'd' => 'budi belajar di Sekolah Dasar.',
                                    'e' => 'BUDI BELAJAR DI SEKOLAH DASAR.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Penulisan huruf kapital yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan huruf kapital dengan benar adalah...",
                                "Penulisan huruf besar yang tepat terdapat pada...",
                                "Kalimat yang ejaannya benar adalah...",
                                "Penggunaan huruf kapital yang benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Presiden Joko Widodo berkunjung ke Bandung.',
                                    'b' => 'presiden joko widodo berkunjung ke bandung.',
                                    'c' => 'Presiden joko widodo berkunjung ke bandung.',
                                    'd' => 'presiden Joko Widodo berkunjung ke Bandung.',
                                    'e' => 'PRESIDEN JOKO WIDODO BERKUNJUNG KE BANDUNG.'
                                ],
                                [
                                    'a' => 'Menteri Pendidikan Nadiem Makarim memberikan sambutan.',
                                    'b' => 'menteri pendidikan nadiem makarim memberikan sambutan.',
                                    'c' => 'Menteri pendidikan nadiem makarim memberikan sambutan.',
                                    'd' => 'menteri Pendidikan Nadiem Makarim memberikan sambutan.',
                                    'e' => 'MENTERI PENDIDIKAN NADIEM MAKARIM MEMBERIKAN SAMBUTAN.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Penulisan huruf kapital yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan huruf kapital dengan benar adalah...",
                                "Penulisan huruf besar yang tepat terdapat pada...",
                                "Kalimat yang ejaannya benar adalah...",
                                "Penggunaan huruf kapital yang benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Undang-Undang Dasar 1945 mengatur hak asasi manusia.',
                                    'b' => 'undang-undang dasar 1945 mengatur hak asasi manusia.',
                                    'c' => 'Undang-undang Dasar 1945 mengatur hak asasi manusia.',
                                    'd' => 'undang-Undang Dasar 1945 mengatur hak asasi manusia.',
                                    'e' => 'UNDANG-UNDANG DASAR 1945 MENGATUR HAK ASASI MANUSIA.'
                                ],
                                [
                                    'a' => 'Deklarasi Universal Hak Asasi Manusia disahkan pada tahun 1948.',
                                    'b' => 'deklarasi universal hak asasi manusia disahkan pada tahun 1948.',
                                    'c' => 'Deklarasi universal hak asasi manusia disahkan pada tahun 1948.',
                                    'd' => 'deklarasi Universal Hak Asasi Manusia disahkan pada tahun 1948.',
                                    'e' => 'DEKLARASI UNIVERSAL HAK ASASI MANUSIA DISAHKAN PADA TAHUN 1948.'
                                ],
                                [
                                    'a' => 'Konferensi Asia-Afrika diselenggarakan di Bandung pada tahun 1955.',
                                    'b' => 'konferensi asia-afrika diselenggarakan di bandung pada tahun 1955.',
                                    'c' => 'Konferensi asia-afrika diselenggarakan di bandung pada tahun 1955.',
                                    'd' => 'konferensi Asia-Afrika diselenggarakan di Bandung pada tahun 1955.',
                                    'e' => 'KONFERENSI ASIA-AFRIKA DISELENGGARAKAN DI BANDUNG PADA TAHUN 1955.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Tanda Baca' || $key == 'Tanda Baca'     ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Penggunaan tanda baca yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan tanda baca dengan benar adalah...",
                                "Penulisan tanda baca yang tepat terdapat pada...",
                                "Kalimat yang tanda bacanya benar adalah...",
                                "Penggunaan tanda baca yang tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Ayah membeli buku, pensil, dan penggaris.',
                                    'b' => 'Ayah membeli buku pensil dan penggaris.',
                                    'c' => 'Ayah membeli buku, pensil dan penggaris.',
                                    'd' => 'Ayah membeli buku pensil, dan penggaris.',
                                    'e' => 'Ayah membeli buku, pensil, dan, penggaris.'
                                ],
                                [
                                    'a' => 'Ibu memasak nasi, sayur, dan lauk.',
                                    'b' => 'Ibu memasak nasi sayur dan lauk.',
                                    'c' => 'Ibu memasak nasi, sayur dan lauk.',
                                    'd' => 'Ibu memasak nasi sayur, dan lauk.',
                                    'e' => 'Ibu memasak nasi, sayur, dan, lauk.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Penggunaan tanda baca yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan tanda baca dengan benar adalah...",
                                "Penulisan tanda baca yang tepat terdapat pada...",
                                "Kalimat yang tanda bacanya benar adalah...",
                                "Penggunaan tanda baca yang tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Indonesia terdiri dari pulau Jawa, Sumatera, Kalimantan, dan Sulawesi.',
                                    'b' => 'Indonesia terdiri dari pulau Jawa Sumatera Kalimantan dan Sulawesi.',
                                    'c' => 'Indonesia terdiri dari pulau Jawa, Sumatera, Kalimantan dan Sulawesi.',
                                    'd' => 'Indonesia terdiri dari pulau Jawa Sumatera, Kalimantan, dan Sulawesi.',
                                    'e' => 'Indonesia terdiri dari pulau Jawa, Sumatera, Kalimantan, dan, Sulawesi.'
                                ],
                                [
                                    'a' => 'Presiden berkata, "Kita harus bersatu untuk kemajuan bangsa."',
                                    'b' => 'Presiden berkata "Kita harus bersatu untuk kemajuan bangsa."',
                                    'c' => 'Presiden berkata, Kita harus bersatu untuk kemajuan bangsa.',
                                    'd' => 'Presiden berkata: "Kita harus bersatu untuk kemajuan bangsa."',
                                    'e' => 'Presiden berkata; "Kita harus bersatu untuk kemajuan bangsa."'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Penggunaan tanda baca yang benar terdapat pada kalimat...",
                                "Kalimat yang menggunakan tanda baca dengan benar adalah...",
                                "Penulisan tanda baca yang tepat terdapat pada...",
                                "Kalimat yang tanda bacanya benar adalah...",
                                "Penggunaan tanda baca yang tepat adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Menurut Undang-Undang Dasar 1945, "Setiap warga negara berhak atas pendidikan."',
                                    'b' => 'Menurut Undang-Undang Dasar 1945 "Setiap warga negara berhak atas pendidikan."',
                                    'c' => 'Menurut Undang-Undang Dasar 1945, Setiap warga negara berhak atas pendidikan.',
                                    'd' => 'Menurut Undang-Undang Dasar 1945: "Setiap warga negara berhak atas pendidikan."',
                                    'e' => 'Menurut Undang-Undang Dasar 1945; "Setiap warga negara berhak atas pendidikan."'
                                ],
                                [
                                    'a' => 'Deklarasi Universal Hak Asasi Manusia (DUHAM) disahkan pada tahun 1948.',
                                    'b' => 'Deklarasi Universal Hak Asasi Manusia DUHAM disahkan pada tahun 1948.',
                                    'c' => 'Deklarasi Universal Hak Asasi Manusia, DUHAM, disahkan pada tahun 1948.',
                                    'd' => 'Deklarasi Universal Hak Asasi Manusia: DUHAM disahkan pada tahun 1948.',
                                    'e' => 'Deklarasi Universal Hak Asasi Manusia; DUHAM disahkan pada tahun 1948.'
                                ],
                                [
                                    'a' => 'Konferensi Asia-Afrika (KAA) diselenggarakan di Bandung pada tahun 1955.',
                                    'b' => 'Konferensi Asia-Afrika KAA diselenggarakan di Bandung pada tahun 1955.',
                                    'c' => 'Konferensi Asia-Afrika, KAA, diselenggarakan di Bandung pada tahun 1955.',
                                    'd' => 'Konferensi Asia-Afrika: KAA diselenggarakan di Bandung pada tahun 1955.',
                                    'e' => 'Konferensi Asia-Afrika; KAA diselenggarakan di Bandung pada tahun 1955.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Kalimat' || $key == 'Kalimat'     ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan kalimat yang benar adalah...",
                                "Kalimat yang strukturnya tepat adalah...",
                                "Kalimat yang susunannya benar adalah...",
                                "Yang merupakan kalimat yang baik adalah...",
                                "Kalimat yang gramatikalnya benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Budi pergi ke sekolah.',
                                    'b' => 'Budi pergi sekolah.',
                                    'c' => 'Budi ke sekolah pergi.',
                                    'd' => 'Pergi Budi ke sekolah.',
                                    'e' => 'Sekolah Budi pergi ke.'
                                ],
                                [
                                    'a' => 'Ani membaca buku cerita.',
                                    'b' => 'Ani membaca cerita.',
                                    'c' => 'Ani cerita membaca buku.',
                                    'd' => 'Membaca Ani buku cerita.',
                                    'e' => 'Buku Ani membaca cerita.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan kalimat yang benar adalah...",
                                "Kalimat yang strukturnya tepat adalah...",
                                "Kalimat yang susunannya benar adalah...",
                                "Yang merupakan kalimat yang baik adalah...",
                                "Kalimat yang gramatikalnya benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Presiden memberikan sambutan di acara tersebut.',
                                    'b' => 'Presiden memberikan sambutan di acara tersebut.',
                                    'c' => 'Presiden memberikan sambutan di acara tersebut.',
                                    'd' => 'Presiden memberikan sambutan di acara tersebut.',
                                    'e' => 'Presiden memberikan sambutan di acara tersebut.'
                                ],
                                [
                                    'a' => 'Menteri Pendidikan menjelaskan kebijakan baru.',
                                    'b' => 'Menteri Pendidikan menjelaskan kebijakan baru.',
                                    'c' => 'Menteri Pendidikan menjelaskan kebijakan baru.',
                                    'd' => 'Menteri Pendidikan menjelaskan kebijakan baru.',
                                    'e' => 'Menteri Pendidikan menjelaskan kebijakan baru.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan kalimat yang benar adalah...",
                                "Kalimat yang strukturnya tepat adalah...",
                                "Kalimat yang susunannya benar adalah...",
                                "Yang merupakan kalimat yang baik adalah...",
                                "Kalimat yang gramatikalnya benar adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Undang-Undang Dasar 1945 mengatur hak dan kewajiban warga negara.',
                                    'b' => 'Undang-Undang Dasar 1945 mengatur hak dan kewajiban warga negara.',
                                    'c' => 'Undang-Undang Dasar 1945 mengatur hak dan kewajiban warga negara.',
                                    'd' => 'Undang-Undang Dasar 1945 mengatur hak dan kewajiban warga negara.',
                                    'e' => 'Undang-Undang Dasar 1945 mengatur hak dan kewajiban warga negara.'
                                ],
                                [
                                    'a' => 'Deklarasi Universal Hak Asasi Manusia menjamin kebebasan berpendapat.',
                                    'b' => 'Deklarasi Universal Hak Asasi Manusia menjamin kebebasan berpendapat.',
                                    'c' => 'Deklarasi Universal Hak Asasi Manusia menjamin kebebasan berpendapat.',
                                    'd' => 'Deklarasi Universal Hak Asasi Manusia menjamin kebebasan berpendapat.',
                                    'e' => 'Deklarasi Universal Hak Asasi Manusia menjamin kebebasan berpendapat.'
                                ],
                                [
                                    'a' => 'Konferensi Asia-Afrika menghasilkan Dasasila Bandung.',
                                    'b' => 'Konferensi Asia-Afrika menghasilkan Dasasila Bandung.',
                                    'c' => 'Konferensi Asia-Afrika menghasilkan Dasasila Bandung.',
                                    'd' => 'Konferensi Asia-Afrika menghasilkan Dasasila Bandung.',
                                    'e' => 'Konferensi Asia-Afrika menghasilkan Dasasila Bandung.'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Paragraf' || $key == 'Paragraf' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $soalVariasi = [
                                "Berikut ini yang merupakan paragraf yang baik adalah...",
                                "Paragraf yang strukturnya benar adalah...",
                                "Paragraf yang susunannya tepat adalah...",
                                "Yang merupakan paragraf yang koheren adalah...",
                                "Paragraf yang pengembangannya baik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Paragraf yang memiliki satu gagasan utama',
                                    'b' => 'Paragraf yang memiliki banyak gagasan',
                                    'c' => 'Paragraf yang tidak memiliki gagasan',
                                    'd' => 'Paragraf yang acak-acakan',
                                    'e' => 'Paragraf yang tidak terstruktur'
                                ],
                                [
                                    'a' => 'Paragraf yang kalimatnya saling berkaitan',
                                    'b' => 'Paragraf yang kalimatnya terpisah',
                                    'c' => 'Paragraf yang kalimatnya tidak nyambung',
                                    'd' => 'Paragraf yang kalimatnya acak',
                                    'e' => 'Paragraf yang kalimatnya tidak jelas'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $soalVariasi = [
                                "Berikut ini yang merupakan paragraf yang baik adalah...",
                                "Paragraf yang strukturnya benar adalah...",
                                "Paragraf yang susunannya tepat adalah...",
                                "Yang merupakan paragraf yang koheren adalah...",
                                "Paragraf yang pengembangannya baik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Paragraf yang memiliki gagasan utama yang jelas',
                                    'b' => 'Paragraf yang memiliki banyak gagasan yang tidak terkait',
                                    'c' => 'Paragraf yang tidak memiliki gagasan utama',
                                    'd' => 'Paragraf yang gagasannya tidak jelas',
                                    'e' => 'Paragraf yang tidak memiliki struktur'
                                ],
                                [
                                    'a' => 'Paragraf yang menggunakan transisi antar kalimat',
                                    'b' => 'Paragraf yang kalimatnya tidak saling terkait',
                                    'c' => 'Paragraf yang tidak menggunakan konjungsi',
                                    'd' => 'Paragraf yang kalimatnya acak',
                                    'e' => 'Paragraf yang tidak memiliki koherensi'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $soalVariasi = [
                                "Berikut ini yang merupakan paragraf yang baik adalah...",
                                "Paragraf yang strukturnya benar adalah...",
                                "Paragraf yang susunannya tepat adalah...",
                                "Yang merupakan paragraf yang koheren adalah...",
                                "Paragraf yang pengembangannya baik adalah..."
                            ];
                            $template['soal'] = $soalVariasi[array_rand($soalVariasi)];
                            
                            $jawabanVariasi = [
                                [
                                    'a' => 'Paragraf yang memiliki gagasan utama yang argumentatif',
                                    'b' => 'Paragraf yang memiliki gagasan yang tidak logis',
                                    'c' => 'Paragraf yang tidak memiliki argumentasi',
                                    'd' => 'Paragraf yang gagasannya tidak sistematis',
                                    'e' => 'Paragraf yang tidak memiliki struktur yang jelas'
                                ],
                                [
                                    'a' => 'Paragraf yang menggunakan teknik pengembangan yang sistematis',
                                    'b' => 'Paragraf yang tidak menggunakan teknik pengembangan',
                                    'c' => 'Paragraf yang pengembangannya tidak terstruktur',
                                    'd' => 'Paragraf yang tidak memiliki koherensi logis',
                                    'e' => 'Paragraf yang tidak menggunakan transisi yang tepat'
                                ],
                                [
                                    'a' => 'Paragraf yang menggunakan data dan fakta yang akurat',
                                    'b' => 'Paragraf yang tidak menggunakan data pendukung',
                                    'c' => 'Paragraf yang menggunakan informasi yang tidak valid',
                                    'd' => 'Paragraf yang tidak memiliki referensi yang jelas',
                                    'e' => 'Paragraf yang tidak menggunakan sumber yang terpercaya'
                                ]
                            ];
                            $template['jawaban'] = $jawabanVariasi[array_rand($jawabanVariasi)];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateTeksBacaanSD()
    {
        $teksBacaan = [
            "Budi adalah siswa kelas 3 SD. Setiap pagi, ia bangun pukul 5 pagi. Ia mandi, sarapan, dan berangkat ke sekolah. Di sekolah, Budi belajar membaca, menulis, dan berhitung. Ia juga bermain dengan teman-temannya di halaman sekolah.",
            "Ani suka berkebun. Di halaman rumahnya, ia menanam berbagai jenis bunga. Ada bunga mawar, melati, dan anggrek. Setiap pagi, Ani menyiram bunga-bunganya. Ia juga membersihkan daun-daun yang kering.",
            "Pak Rudi adalah penjual es krim. Setiap hari, ia berkeliling kampung dengan gerobak es krimnya. Anak-anak senang menunggu kedatangan Pak Rudi. Mereka suka membeli es krim dengan berbagai rasa."
        ];

        return $teksBacaan[array_rand($teksBacaan)];
    }

    private function generateTeksBacaanSMP()
    {
        $teksBacaan = [
            "Teknologi informasi telah mengubah cara kita berkomunikasi. Dulu, untuk berkomunikasi dengan orang yang jauh, kita harus mengirim surat yang membutuhkan waktu berhari-hari. Sekarang, dengan internet, kita bisa berkomunikasi secara instan.",
            "Kebudayaan Indonesia sangat kaya dan beragam. Setiap daerah memiliki adat istiadat, bahasa, dan kesenian yang unik. Misalnya, di Bali ada tari kecak, di Jawa ada wayang kulit, dan di Sumatra ada tari piring.",
            "Lingkungan hidup perlu dijaga kelestariannya. Pemanasan global dan polusi merupakan ancaman serius bagi keberlangsungan hidup manusia. Kita harus mulai dari hal kecil, seperti membuang sampah pada tempatnya dan menanam pohon."
        ];

        return $teksBacaan[array_rand($teksBacaan)];
    }

    private function generateTeksBacaanSMA()
    {
        $teksBacaan = [
            "Revolusi industri 4.0 telah mengubah lanskap ekonomi global. Teknologi digital seperti artificial intelligence, big data, dan internet of things menjadi penggerak utama perubahan. Perusahaan-perusahaan tradisional harus beradaptasi atau menghadapi risiko kehilangan relevansi.",
            "Demokrasi di Indonesia telah mengalami perkembangan signifikan sejak reformasi 1998. Kebebasan pers, pemilihan umum yang demokratis, dan partisipasi masyarakat dalam pengambilan keputusan menjadi indikator kemajuan demokrasi. Namun, tantangan seperti hoaks dan polarisasi masih perlu diatasi.",
            "Perubahan iklim global telah menjadi isu kritis yang membutuhkan perhatian serius. Kenaikan suhu bumi, pencairan es di kutub, dan perubahan pola cuaca ekstrem merupakan dampak yang sudah terlihat. Upaya mitigasi dan adaptasi harus dilakukan secara global."
        ];

        return $teksBacaan[array_rand($teksBacaan)];
    }

    private function generatePertanyaanBacaanSD()
    {
        $pertanyaan = [
            "Siapa tokoh utama dalam teks tersebut?",
            "Apa kegiatan yang dilakukan tokoh utama?",
            "Di mana kegiatan tersebut dilakukan?",
            "Kapan kegiatan tersebut dilakukan?",
            "Bagaimana tokoh utama melakukan kegiatannya?"
        ];

        return $pertanyaan[array_rand($pertanyaan)];
    }

    private function generatePertanyaanBacaanSMP()
    {
        $pertanyaan = [
            "Apa gagasan utama dari teks tersebut?",
            "Informasi apa yang dapat kita peroleh dari teks tersebut?",
            "Bagaimana penulis menyampaikan pesan dalam teks?",
            "Apa kesimpulan yang dapat diambil dari teks tersebut?",
            "Bagaimana hubungan antar paragraf dalam teks tersebut?"
        ];

        return $pertanyaan[array_rand($pertanyaan)];
    }

    private function generatePertanyaanBacaanSMA()
    {
        $pertanyaan = [
            "Bagaimana penulis menganalisis topik dalam teks tersebut?",
            "Apa implikasi dari fenomena yang dibahas dalam teks?",
            "Bagaimana penulis menyusun argumentasi dalam teks?",
            "Apa solusi yang ditawarkan penulis untuk masalah yang dibahas?",
            "Bagaimana teks tersebut merefleksikan konteks sosial dan budaya?"
        ];

        return $pertanyaan[array_rand($pertanyaan)];
    }

    private function getKataBakuSD()
    {
        $kataBaku = [
            'aktif' => 'aktip',
            'apotek' => 'apotik',
            'atlet' => 'atlit',
            'bus' => 'bis',
            'cendekiawan' => 'cendikiawan',
            'ekstrem' => 'ekstrim',
            'foto' => 'photo',
            'hierarki' => 'hirarki',
            'ijazah' => 'ijasah',
            'izin' => 'ijin'
        ];

        $kata = array_rand($kataBaku);
        return [
            'baku' => $kata,
            'tidak_baku' => $kataBaku[$kata]
        ];
    }

    private function getKataBakuSMP()
    {
        $kataBaku = [
            'karier' => 'karir',
            'kategori' => 'katagori',
            'kompleks' => 'komplek',
            'kreatif' => 'kreatip',
            'kualitas' => 'kwalitas',
            'mengapa' => 'kenapa',
            'objek' => 'obyek',
            'paham' => 'faham',
            'praktik' => 'praktek',
            'risiko' => 'resiko'
        ];

        $kata = array_rand($kataBaku);
        return [
            'baku' => $kata,
            'tidak_baku' => $kataBaku[$kata]
        ];
    }

    private function getKataBakuSMA()
    {
        $kataBaku = [
            'sistem' => 'sistim',
            'subjek' => 'subyek',
            'teknologi' => 'tehnologi',
            'teladan' => 'tauladan',
            'telur' => 'telor',
            'terampil' => 'trampil',
            'terima kasih' => 'terimakasih',
            'tradisi' => 'tradisi',
            'variasi' => 'varisasi',
            'wujud' => 'ujud'
        ];

        $kata = array_rand($kataBaku);
        return [
            'baku' => $kata,
            'tidak_baku' => $kataBaku[$kata]
        ];
    }

    private function generateJawabanPemahamanBacaanSD($teks, $pertanyaan)
    {
        $jawaban = [
            'a' => "Jawaban yang paling sesuai dengan isi teks",
            'b' => "Jawaban yang kurang sesuai dengan isi teks",
            'c' => "Jawaban yang tidak sesuai dengan isi teks",
            'd' => "Jawaban yang bertentangan dengan isi teks",
            'e' => "Jawaban yang tidak ada dalam teks"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPemahamanBacaanSMP($teks, $pertanyaan)
    {
        $jawaban = [
            'a' => "Jawaban yang paling sesuai dengan isi teks",
            'b' => "Jawaban yang kurang sesuai dengan isi teks",
            'c' => "Jawaban yang tidak sesuai dengan isi teks",
            'd' => "Jawaban yang bertentangan dengan isi teks",
            'e' => "Jawaban yang tidak ada dalam teks"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPemahamanBacaanSMA($teks, $pertanyaan)
    {
        $jawaban = [
            'a' => "Jawaban yang paling sesuai dengan isi teks",
            'b' => "Jawaban yang kurang sesuai dengan isi teks",
            'c' => "Jawaban yang tidak sesuai dengan isi teks",
            'd' => "Jawaban yang bertentangan dengan isi teks",
            'e' => "Jawaban yang tidak ada dalam teks"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanKataBakuSD($kata)
    {
        $jawaban = [
            'a' => $kata['baku'],
            'b' => $kata['tidak_baku'],
            'c' => strtoupper($kata['baku']),
            'd' => strtolower($kata['baku']),
            'e' => ucfirst($kata['tidak_baku'])
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $kata['baku']
        ];
    }

    private function generateJawabanKataBakuSMP($kata)
    {
        $jawaban = [
            'a' => $kata['baku'],
            'b' => $kata['tidak_baku'],
            'c' => strtoupper($kata['baku']),
            'd' => strtolower($kata['baku']),
            'e' => ucfirst($kata['baku'])
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $kata['baku']
        ];
    }

    private function generateJawabanKataBakuSMA($kata)
    {
        $jawaban = [
            'a' => $kata['baku'],
            'b' => $kata['tidak_baku'],
            'c' => strtoupper($kata['baku']),
            'd' => strtolower($kata['baku']),
            'e' => ucfirst($kata['baku'])
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $kata['baku']
        ];
    }

    private function generateSoalIPA($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Makhluk Hidup':
                if ($subTopik == 'Ciri-ciri Makhluk Hidup' || $key == 'Ciri-ciri Makhluk Hidup') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan ciri-ciri makhluk hidup adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bernapas, bergerak, dan berkembang biak',
                                'b' => 'Diam, tidak bergerak, dan tidak bernapas',
                                'c' => 'Tidak berkembang biak dan tidak bergerak',
                                'd' => 'Tidak bernapas dan tidak berkembang biak',
                                'e' => 'Diam dan tidak bernapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan ciri-ciri makhluk hidup tingkat lanjut adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bernapas, bergerak, berkembang biak, dan beradaptasi',
                                'b' => 'Diam, tidak bergerak, dan tidak bernapas',
                                'c' => 'Tidak berkembang biak dan tidak bergerak',
                                'd' => 'Tidak bernapas dan tidak berkembang biak',
                                'e' => 'Diam dan tidak bernapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan ciri-ciri makhluk hidup tingkat tinggi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bernapas, bergerak, berkembang biak, beradaptasi, dan berevolusi',
                                'b' => 'Diam, tidak bergerak, dan tidak bernapas',
                                'c' => 'Tidak berkembang biak dan tidak bergerak',
                                'd' => 'Tidak bernapas dan tidak berkembang biak',
                                'e' => 'Diam dan tidak bernapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Pertumbuhan' || $key == 'Pertumbuhan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh pertumbuhan pada makhluk hidup adalah...";
                            $template['jawaban'] = [
                                'a' => 'Tinggi badan bertambah',
                                'b' => 'Berat badan berkurang',
                                'c' => 'Rambut memutih',
                                'd' => 'Kulit mengeriput',
                                'e' => 'Gigi tanggal'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh pertumbuhan dan perkembangan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Tinggi badan bertambah dan kemampuan berpikir meningkat',
                                'b' => 'Berat badan berkurang dan kemampuan menurun',
                                'c' => 'Rambut memutih dan kemampuan menurun',
                                'd' => 'Kulit mengeriput dan kemampuan menurun',
                                'e' => 'Gigi tanggal dan kemampuan menurun'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh pertumbuhan, perkembangan, dan diferensiasi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Tinggi badan bertambah, kemampuan berpikir meningkat, dan sel terspesialisasi',
                                'b' => 'Berat badan berkurang dan kemampuan menurun',
                                'c' => 'Rambut memutih dan kemampuan menurun',
                                'd' => 'Kulit mengeriput dan kemampuan menurun',
                                'e' => 'Gigi tanggal dan kemampuan menurun'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Adaptasi' || $key == 'Adaptasi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh adaptasi hewan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Unta memiliki punuk untuk menyimpan air',
                                'b' => 'Kucing memiliki ekor panjang',
                                'c' => 'Anjing memiliki telinga tegak',
                                'd' => 'Kelinci memiliki mata merah',
                                'e' => 'Burung memiliki sayap'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh adaptasi morfologi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Unta memiliki punuk untuk menyimpan air',
                                'b' => 'Kucing memiliki ekor panjang',
                                'c' => 'Anjing memiliki telinga tegak',
                                'd' => 'Kelinci memiliki mata merah',
                                'e' => 'Burung memiliki sayap'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh adaptasi fisiologi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Kelenjar keringat untuk mengatur suhu tubuh',
                                'b' => 'Unta memiliki punuk untuk menyimpan air',
                                'c' => 'Kucing memiliki ekor panjang',
                                'd' => 'Anjing memiliki telinga tegak',
                                'e' => 'Kelinci memiliki mata merah'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Benda dan Sifatnya':
                if ($subTopik == 'Sifat Benda' || $key == 'Sifat Benda') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan sifat benda padat adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bentuk dan volumenya tetap',
                                'b' => 'Bentuk berubah dan volume tetap',
                                'c' => 'Bentuk dan volume berubah',
                                'd' => 'Bentuk tetap dan volume berubah',
                                'e' => 'Bentuk dan volume tidak tetap'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan sifat benda cair adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bentuk berubah dan volume tetap',
                                'b' => 'Bentuk dan volume tetap',
                                'c' => 'Bentuk dan volume berubah',
                                'd' => 'Bentuk tetap dan volume berubah',
                                'e' => 'Bentuk dan volume tidak tetap'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan sifat benda gas adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bentuk dan volume berubah',
                                'b' => 'Bentuk tetap dan volume tetap',
                                'c' => 'Bentuk berubah dan volume tetap',
                                'd' => 'Bentuk tetap dan volume berubah',
                                'e' => 'Bentuk dan volume tidak berubah'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Perubahan Wujud' || $key == 'Perubahan Wujud') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Perubahan wujud dari padat menjadi cair disebut...";
                            $template['jawaban'] = [
                                'a' => 'Mencair',
                                'b' => 'Membeku',
                                'c' => 'Menguap',
                                'd' => 'Mengembun',
                                'e' => 'Menyublim'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Perubahan wujud dari cair menjadi gas disebut...";
                            $template['jawaban'] = [
                                'a' => 'Menguap',
                                'b' => 'Mencair',
                                'c' => 'Membeku',
                                'd' => 'Mengembun',
                                'e' => 'Menyublim'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Perubahan wujud dari padat langsung menjadi gas disebut...";
                            $template['jawaban'] = [
                                'a' => 'Menyublim',
                                'b' => 'Mencair',
                                'c' => 'Membeku',
                                'd' => 'Menguap',
                                'e' => 'Mengembun'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Energi' || $key == 'Energi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh energi gerak adalah...";
                            $template['jawaban'] = [
                                'a' => 'Kipas angin yang berputar',
                                'b' => 'Lampu yang menyala',
                                'c' => 'Radio yang berbunyi',
                                'd' => 'Televisi yang menyala',
                                'e' => 'Komputer yang menyala'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh energi potensial adalah...";
                            $template['jawaban'] = [
                                'a' => 'Batu di atas bukit',
                                'b' => 'Kipas angin yang berputar',
                                'c' => 'Lampu yang menyala',
                                'd' => 'Radio yang berbunyi',
                                'e' => 'Televisi yang menyala'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh energi kinetik adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mobil yang bergerak',
                                'b' => 'Batu di atas bukit',
                                'c' => 'Lampu yang menyala',
                                'd' => 'Radio yang berbunyi',
                                'e' => 'Televisi yang menyala'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Bumi dan Alam Semesta':
                if ($subTopik == 'Tata Surya' || $key == 'Tata Surya'   ) {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Planet terbesar dalam tata surya adalah...";
                            $template['jawaban'] = [
                                'a' => 'Jupiter',
                                'b' => 'Saturnus',
                                'c' => 'Uranus',
                                'd' => 'Neptunus',
                                'e' => 'Mars'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Planet yang memiliki cincin adalah...";
                            $template['jawaban'] = [
                                'a' => 'Saturnus',
                                'b' => 'Jupiter',
                                'c' => 'Uranus',
                                'd' => 'Neptunus',
                                'e' => 'Mars'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Planet yang memiliki atmosfer tipis dan permukaan berbatu adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mars',
                                'b' => 'Jupiter',
                                'c' => 'Saturnus',
                                'd' => 'Uranus',
                                'e' => 'Neptunus'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Cuaca' || $key == 'Cuaca') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Alat untuk mengukur suhu udara adalah...";
                            $template['jawaban'] = [
                                'a' => 'Termometer',
                                'b' => 'Barometer',
                                'c' => 'Hygrometer',
                                'd' => 'Anemometer',
                                'e' => 'Altimeter'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Alat untuk mengukur tekanan udara adalah...";
                            $template['jawaban'] = [
                                'a' => 'Barometer',
                                'b' => 'Termometer',
                                'c' => 'Hygrometer',
                                'd' => 'Anemometer',
                                'e' => 'Altimeter'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Alat untuk mengukur kelembaban udara adalah...";
                            $template['jawaban'] = [
                                'a' => 'Hygrometer',
                                'b' => 'Termometer',
                                'c' => 'Barometer',
                                'd' => 'Anemometer',
                                'e' => 'Altimeter'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Bencana Alam' || $key == 'Bencana Alam' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan cara penanggulangan banjir adalah...";
                            $template['jawaban'] = [
                                'a' => 'Membuat saluran air yang baik',
                                'b' => 'Membuang sampah ke sungai',
                                'c' => 'Menebang pohon di hutan',
                                'd' => 'Membuat bangunan di bantaran sungai',
                                'e' => 'Menggunakan air secara berlebihan'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan cara penanggulangan tanah longsor adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menanam pohon di lereng bukit',
                                'b' => 'Menebang pohon di lereng bukit',
                                'c' => 'Membuat bangunan di lereng bukit',
                                'd' => 'Menggali tanah di lereng bukit',
                                'e' => 'Membuat jalan di lereng bukit'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan cara penanggulangan gempa bumi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Membangun rumah tahan gempa',
                                'b' => 'Membangun rumah di dekat gunung',
                                'c' => 'Membangun rumah di dekat pantai',
                                'd' => 'Membangun rumah di dekat sungai',
                                'e' => 'Membangun rumah di dekat danau'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateJawabanCiriMakhlukHidupSD($hewan)
    {
        $ciri = [
            'kucing' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan'],
            'burung' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi'],
            'ikan' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi'],
            'kupu-kupu' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'bermetamorfosis']
        ];

        $jawaban = [
            'a' => implode(', ', $ciri[$hewan]),
            'b' => implode(', ', array_slice($ciri[$hewan], 0, 3)),
            'c' => implode(', ', array_slice($ciri[$hewan], 0, 2)),
            'd' => implode(', ', array_slice($ciri[$hewan], 0, 4)),
            'e' => implode(', ', array_slice($ciri[$hewan], 0, 1))
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanCiriMakhlukHidupSMP($hewan)
    {
        $ciri = [
            'katak' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'bermetamorfosis'],
            'kadal' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'berkembang biak'],
            'kupu-kupu' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'bermetamorfosis'],
            'belalang' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'berkembang biak']
        ];

        $jawaban = [
            'a' => implode(', ', $ciri[$hewan]),
            'b' => implode(', ', array_slice($ciri[$hewan], 0, 4)),
            'c' => implode(', ', array_slice($ciri[$hewan], 0, 3)),
            'd' => implode(', ', array_slice($ciri[$hewan], 0, 5)),
            'e' => implode(', ', array_slice($ciri[$hewan], 0, 2))
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanCiriMakhlukHidupSMA($hewan)
    {
        $ciri = [
            'amfibi' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'bermetamorfosis', 'berkembang biak'],
            'reptil' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'berkembang biak', 'berkembang biak'],
            'serangga' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'bermetamorfosis', 'berkembang biak'],
            'mamalia' => ['bergerak', 'bernapas', 'berkembang biak', 'memerlukan makanan', 'beradaptasi', 'berkembang biak', 'berkembang biak']
        ];

        $jawaban = [
            'a' => implode(', ', $ciri[$hewan]),
            'b' => implode(', ', array_slice($ciri[$hewan], 0, 5)),
            'c' => implode(', ', array_slice($ciri[$hewan], 0, 4)),
            'd' => implode(', ', array_slice($ciri[$hewan], 0, 6)),
            'e' => implode(', ', array_slice($ciri[$hewan], 0, 3))
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPerubahanWujudSD($benda, $perubahan)
    {
        $jawaban = [
            'a' => "Perubahan wujud yang benar",
            'b' => "Perubahan wujud yang salah",
            'c' => "Perubahan wujud yang tidak sesuai",
            'd' => "Perubahan wujud yang bertentangan",
            'e' => "Perubahan wujud yang tidak ada"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPerubahanWujudSMP($benda, $perubahan)
    {
        $jawaban = [
            'a' => "Perubahan wujud yang benar",
            'b' => "Perubahan wujud yang salah",
            'c' => "Perubahan wujud yang tidak sesuai",
            'd' => "Perubahan wujud yang bertentangan",
            'e' => "Perubahan wujud yang tidak ada"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPerubahanWujudSMA($benda, $perubahan)
    {
        $jawaban = [
            'a' => "Perubahan wujud yang benar",
            'b' => "Perubahan wujud yang salah",
            'c' => "Perubahan wujud yang tidak sesuai",
            'd' => "Perubahan wujud yang bertentangan",
            'e' => "Perubahan wujud yang tidak ada"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanFaktor($angka)
    {
        $faktor = [];
        for ($i = 1; $i <= $angka; $i++) {
            if ($angka % $i == 0) {
                $faktor[] = $i;
            }
        }

        $jawaban = [
            'a' => count($faktor),
            'b' => count($faktor) + 1,
            'c' => count($faktor) - 1,
            'd' => count($faktor) + 2,
            'e' => count($faktor) - 2
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => count($faktor)
        ];
    }

    private function generateJawabanLuas($bangun, $sisi)
    {
        $luas = 0;
        switch ($bangun) {
            case 'persegi':
                $luas = $sisi * $sisi;
                break;
            case 'persegi panjang':
                $luas = $sisi * ($sisi + rand(1, 5));
                break;
            case 'segitiga':
                $luas = ($sisi * $sisi) / 2;
                break;
            case 'lingkaran':
                $luas = 3.14 * $sisi * $sisi;
                break;
            case 'trapesium':
                $luas = ($sisi * ($sisi + rand(1, 5))) / 2;
                break;
            case 'belah ketupat':
                $luas = ($sisi * $sisi) / 2;
                break;
        }

        $jawaban = [
            'a' => $luas,
            'b' => $luas + rand(1, 5),
            'c' => $luas - rand(1, 5),
            'd' => $luas * 2,
            'e' => $luas / 2
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $luas
        ];
    }

    private function createSoal($paketId, $template)
    {
        // Generate jawaban
        $jawaban = $this->generateJawaban($template['jawaban']);
        
        // Acak kunci jawaban dari a-e
        $pilihan = ['a', 'b', 'c', 'd', 'e'];
        $kunci = $pilihan[array_rand($pilihan)];
        
        // Cari nilai jawaban benar dari template
        $jawabanBenar = $jawaban['benar'];
        
        // Susun ulang jawaban agar jawaban benar ada di pilihan yang terpilih
        $temp = $jawaban['jawaban'][$kunci];
        $jawaban['jawaban'][$kunci] = $jawabanBenar;
        
        // Cari posisi jawaban benar sebelumnya dan ganti dengan nilai temporary
        foreach($jawaban['jawaban'] as $key => $value) {
            if($value == $jawabanBenar && $key != $kunci) {
                $jawaban['jawaban'][$key] = $temp;
                break;
            }
        }

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

        // Generate gambar jika diperlukan
        if ($template['perlu_gambar']) {
            $this->generateGambarSoal($soal->id);
        }
    }

    private function getKurikulum($mapel, $jenjang)
    {
        $kurikulum = [
            'Matematika' => [
                'SD' => [
                    'Bilangan' => [
                        'Bilangan Cacah' => 'Operasi hitung bilangan cacah sampai 1000',
                        'Bilangan Bulat' => 'Operasi hitung bilangan bulat dan sifat-sifatnya',
                        'Pecahan' => 'Pecahan sederhana dan operasi hitung pecahan',
                        'KPK dan FPB' => 'Kelipatan Persekutuan Terkecil dan Faktor Persekutuan Terbesar',
                        'Bilangan Desimal' => 'Bilangan desimal dan operasi hitungnya',
                        'Bilangan Romawi' => 'Bilangan Romawi dan konversinya'
                    ],
                    'Geometri' => [
                        'Bangun Datar' => 'Sifat-sifat bangun datar sederhana (persegi, persegi panjang, segitiga)',
                        'Luas dan Keliling' => 'Menghitung luas dan keliling bangun datar sederhana',
                        'Simetri' => 'Simetri lipat dan simetri putar pada bangun datar',
                        'Bangun Ruang' => 'Sifat-sifat bangun ruang sederhana (kubus, balok)',
                        'Volume' => 'Menghitung volume bangun ruang sederhana'
                    ],
                    'Pengukuran' => [
                        'Satuan Panjang' => 'Satuan panjang dan konversinya',
                        'Satuan Berat' => 'Satuan berat dan konversinya',
                        'Satuan Waktu' => 'Satuan waktu dan konversinya',
                        'Satuan Luas' => 'Satuan luas dan konversinya',
                        'Satuan Volume' => 'Satuan volume dan konversinya',
                        'Satuan Debit' => 'Satuan debit dan konversinya'
                    ],
                    'Statistika' => [
                        'Pengumpulan Data' => 'Mengumpulkan dan menyajikan data dalam bentuk tabel',
                        'Diagram' => 'Menyajikan data dalam bentuk diagram batang dan diagram gambar',
                        'Rata-rata' => 'Menghitung rata-rata dari data',
                        'Modus' => 'Menentukan modus dari data'
                    ]
                ],
                'SMP' => [
                    'Bilangan' => [
                        'Bilangan Bulat' => 'Operasi hitung bilangan bulat dan sifat-sifatnya',
                        'Bilangan Pecahan' => 'Operasi hitung pecahan dan desimal',
                        'Bilangan Berpangkat' => 'Bilangan berpangkat dan bentuk akar',
                        'Perbandingan' => 'Perbandingan senilai dan berbalik nilai',
                        'Bilangan Rasional' => 'Bilangan rasional dan irasional',
                        'Bilangan Real' => 'Sistem bilangan real'
                    ],
                    'Aljabar' => [
                        'Persamaan Linear' => 'Persamaan dan pertidaksamaan linear satu variabel',
                        'Sistem Persamaan' => 'Sistem persamaan linear dua variabel',
                        'Fungsi' => 'Relasi dan fungsi',
                        'Persamaan Kuadrat' => 'Persamaan kuadrat dan penyelesaiannya',
                        'Pertidaksamaan' => 'Pertidaksamaan linear dan kuadrat',
                        'Polinomial' => 'Operasi aljabar pada polinomial'
                    ],
                    'Geometri' => [
                        'Bangun Datar' => 'Sifat-sifat dan keliling serta luas bangun datar',
                        'Bangun Ruang' => 'Sifat-sifat dan luas permukaan serta volume bangun ruang',
                        'Teorema Pythagoras' => 'Teorema Pythagoras dan tripel Pythagoras',
                        'Kesebangunan' => 'Kesebangunan dan kekongruenan',
                        'Lingkaran' => 'Unsur-unsur lingkaran dan luasnya',
                        'Transformasi' => 'Translasi, refleksi, rotasi, dan dilatasi'
                    ],
                    'Statistika' => [
                        'Penyajian Data' => 'Menyajikan data dalam bentuk tabel, diagram, dan grafik',
                        'Ukuran Pemusatan' => 'Mean, median, dan modus',
                        'Peluang' => 'Peluang kejadian sederhana',
                        'Ukuran Penyebaran' => 'Jangkauan, simpangan rata-rata, dan variansi',
                        'Distribusi Frekuensi' => 'Distribusi frekuensi dan histogram'
                    ]
                ],
                'SMA' => [
                    'Aljabar' => [
                        'Fungsi' => 'Fungsi komposisi dan fungsi invers',
                        'Persamaan' => 'Persamaan dan pertidaksamaan kuadrat',
                        'Logaritma' => 'Logaritma dan sifat-sifatnya',
                        'Matriks' => 'Operasi matriks dan determinan',
                        'Sistem Persamaan' => 'Sistem persamaan linear tiga variabel',
                        'Pertidaksamaan' => 'Pertidaksamaan nilai mutlak dan pecahan',
                        'Polinomial' => 'Teorema sisa dan faktor polinomial'
                    ],
                    'Kalkulus' => [
                        'Limit' => 'Limit fungsi aljabar dan trigonometri',
                        'Turunan' => 'Turunan fungsi aljabar dan trigonometri',
                        'Integral' => 'Integral tak tentu dan integral tentu',
                        'Aplikasi' => 'Aplikasi turunan dan integral',
                        'Limit Tak Hingga' => 'Limit fungsi untuk x mendekati tak hingga',
                        'Kontinuitas' => 'Kontinuitas fungsi',
                        'Turunan Tingkat Tinggi' => 'Turunan kedua dan seterusnya',
                        'Integral Parsial' => 'Integral dengan metode parsial',
                        'Integral Substitusi' => 'Integral dengan metode substitusi'
                    ],
                    'Geometri' => [
                        'Trigonometri' => 'Perbandingan trigonometri dan identitas trigonometri',
                        'Vektor' => 'Operasi vektor dan aplikasinya',
                        'Transformasi' => 'Transformasi geometri',
                        'Lingkaran' => 'Persamaan lingkaran dan garis singgung',
                        'Elips' => 'Persamaan elips dan sifat-sifatnya',
                        'Parabola' => 'Persamaan parabola dan sifat-sifatnya',
                        'Hiperbola' => 'Persamaan hiperbola dan sifat-sifatnya'
                    ],
                    'Statistika' => [
                        'Peluang' => 'Peluang kejadian majemuk',
                        'Distribusi' => 'Distribusi normal dan binomial',
                        'Inferensia' => 'Statistika inferensial',
                        'Regresi' => 'Analisis regresi dan korelasi',
                        'Uji Hipotesis' => 'Uji hipotesis dan interval kepercayaan',
                        'Distribusi Sampling' => 'Distribusi sampling dan teorema limit pusat'
                    ]
                ]
            ],
            'Bahasa Indonesia' => [
                'SD' => [
                    'Membaca' => [
                        'Membaca Nyaring' => 'Membaca nyaring dengan lafal dan intonasi yang tepat',
                        'Membaca Pemahaman' => 'Membaca dan memahami teks sederhana',
                        'Membaca Cepat' => 'Membaca cepat dengan pemahaman',
                        'Membaca Intensif' => 'Membaca intensif untuk memahami isi teks',
                        'Membaca Ekstensif' => 'Membaca ekstensif untuk memperluas wawasan'
                    ],
                    'Menulis' => [
                        'Menulis Karangan' => 'Menulis karangan sederhana',
                        'Menulis Surat' => 'Menulis surat pribadi',
                        'Menulis Puisi' => 'Menulis puisi anak',
                        'Menulis Cerita' => 'Menulis cerita pengalaman',
                        'Menulis Laporan' => 'Menulis laporan sederhana'
                    ],
                    'Berbicara' => [
                        'Berbicara di Depan Kelas' => 'Berbicara di depan kelas dengan bahasa yang baik',
                        'Berdiskusi' => 'Berdiskusi dalam kelompok kecil',
                        'Bercerita' => 'Bercerita pengalaman pribadi',
                        'Berwawancara' => 'Melakukan wawancara sederhana',
                        'Berpidato' => 'Berpidato dengan bahasa yang baik'
                    ],
                    'Kebahasaan' => [
                        'Kata Baku' => 'Penggunaan kata baku dan tidak baku',
                        'Ejaan' => 'Penggunaan ejaan yang benar',
                        'Tanda Baca' => 'Penggunaan tanda baca yang tepat',
                        'Kalimat' => 'Struktur kalimat yang benar',
                        'Paragraf' => 'Pengembangan paragraf sederhana'
                    ]
                ],
                'SMP' => [
                    'Membaca' => [
                        'Membaca Kritis' => 'Membaca dan memahami teks dengan kritis',
                        'Membaca Sastra' => 'Membaca dan memahami karya sastra',
                        'Membaca Berita' => 'Membaca dan memahami berita',
                        'Membaca Teks Ilmiah' => 'Membaca dan memahami teks ilmiah',
                        'Membaca Teks Narasi' => 'Membaca dan memahami teks narasi'
                    ],
                    'Menulis' => [
                        'Menulis Karya Ilmiah' => 'Menulis karya ilmiah sederhana',
                        'Menulis Cerpen' => 'Menulis cerita pendek',
                        'Menulis Berita' => 'Menulis berita',
                        'Menulis Puisi' => 'Menulis puisi bebas',
                        'Menulis Drama' => 'Menulis naskah drama sederhana'
                    ],
                    'Berbicara' => [
                        'Berpidato' => 'Berpidato dengan bahasa yang baik',
                        'Debat' => 'Berdebat dengan argumentasi yang baik',
                        'Wawancara' => 'Melakukan wawancara',
                        'Diskusi' => 'Berdiskusi dengan bahasa yang baik',
                        'Presentasi' => 'Mempresentasikan hasil kerja'
                    ],
                    'Kebahasaan' => [
                        'Kalimat Efektif' => 'Penggunaan kalimat efektif',
                        'Paragraf' => 'Pengembangan paragraf',
                        'Karya Sastra' => 'Unsur-unsur karya sastra',
                        'Teks' => 'Jenis-jenis teks dan strukturnya',
                        'Bahasa Figuratif' => 'Penggunaan bahasa figuratif'
                    ]
                ],
                'SMA' => [
                    'Membaca' => [
                        'Membaca Karya Sastra' => 'Membaca dan menganalisis karya sastra',
                        'Membaca Kritis' => 'Membaca dan menganalisis teks secara kritis',
                        'Membaca Berita' => 'Membaca dan menganalisis berita',
                        'Membaca Teks Akademik' => 'Membaca dan menganalisis teks akademik',
                        'Membaca Teks Kompleks' => 'Membaca dan menganalisis teks kompleks'
                    ],
                    'Menulis' => [
                        'Menulis Karya Ilmiah' => 'Menulis karya ilmiah',
                        'Menulis Karya Sastra' => 'Menulis karya sastra',
                        'Menulis Berita' => 'Menulis berita dengan bahasa jurnalistik',
                        'Menulis Esai' => 'Menulis esai argumentatif',
                        'Menulis Resensi' => 'Menulis resensi buku'
                    ],
                    'Berbicara' => [
                        'Berpidato' => 'Berpidato dengan bahasa yang baik dan benar',
                        'Debat' => 'Berdebat dengan argumentasi yang kuat',
                        'Diskusi' => 'Berdiskusi dengan bahasa yang baik',
                        'Presentasi' => 'Mempresentasikan karya ilmiah',
                        'Orasi' => 'Berorasi dengan bahasa yang persuasif'
                    ],
                    'Kebahasaan' => [
                        'Kalimat Efektif' => 'Penggunaan kalimat efektif dalam berbagai konteks',
                        'Paragraf' => 'Pengembangan paragraf yang koheren',
                        'Karya Sastra' => 'Analisis karya sastra',
                        'Teks' => 'Analisis struktur dan kaidah kebahasaan teks',
                        'Bahasa Figuratif' => 'Penggunaan bahasa figuratif dalam karya sastra'
                    ]
                ]
            ],
            'IPA' => [
                'SD' => [
                    'Makhluk Hidup' => [
                        'Ciri-ciri Makhluk Hidup' => 'Ciri-ciri makhluk hidup dan pengelompokannya',
                        'Pertumbuhan' => 'Pertumbuhan dan perkembangan makhluk hidup',
                        'Adaptasi' => 'Adaptasi makhluk hidup terhadap lingkungan',
                        'Ekosistem' => 'Ekosistem dan rantai makanan',
                        'Pelestarian' => 'Pelestarian makhluk hidup'
                    ],
                    'Benda dan Sifatnya' => [
                        'Sifat Benda' => 'Sifat-sifat benda padat, cair, dan gas',
                        'Perubahan Wujud' => 'Perubahan wujud benda',
                        'Energi' => 'Bentuk-bentuk energi dan perubahannya',
                        'Gaya' => 'Gaya dan pengaruhnya terhadap benda',
                        'Pesawat Sederhana' => 'Pesawat sederhana dalam kehidupan sehari-hari'
                    ],
                    'Bumi dan Alam Semesta' => [
                        'Tata Surya' => 'Sistem tata surya dan benda-benda langit',
                        'Cuaca' => 'Cuaca dan iklim',
                        'Bencana Alam' => 'Bencana alam dan cara penanggulangannya',
                        'Struktur Bumi' => 'Struktur bumi dan lapisan-lapisan',
                        'Sumber Daya Alam' => 'Sumber daya alam dan pemanfaatannya'
                    ]
                ],
                'SMP' => [
                    'Fisika' => [
                        'Gerak' => 'Gerak lurus dan gerak melingkar',
                        'Gaya' => 'Gaya dan hukum Newton',
                        'Energi' => 'Energi dan perubahannya',
                        'Usaha' => 'Usaha dan daya',
                        'Pesawat Sederhana' => 'Pesawat sederhana dan keuntungan mekanis',
                        'Tekanan' => 'Tekanan pada zat padat, cair, dan gas',
                        'Getaran' => 'Getaran dan gelombang',
                        'Bunyi' => 'Bunyi dan sifat-sifatnya',
                        'Cahaya' => 'Cahaya dan sifat-sifatnya',
                        'Listrik' => 'Listrik statis dan dinamis',
                        'Magnet' => 'Magnet dan kemagnetannya'
                    ],
                    'Kimia' => [
                        'Zat' => 'Sifat fisika dan kimia zat',
                        'Larutan' => 'Larutan dan konsentrasi',
                        'Asam Basa' => 'Asam, basa, dan garam',
                        'Unsur' => 'Unsur, senyawa, dan campuran',
                        'Perubahan Zat' => 'Perubahan fisika dan kimia',
                        'Struktur Atom' => 'Struktur atom dan sistem periodik',
                        'Ikatan Kimia' => 'Ikatan kimia sederhana',
                        'Reaksi Kimia' => 'Reaksi kimia dan persamaan reaksi'
                    ],
                    'Biologi' => [
                        'Sistem Organ' => 'Sistem organ pada manusia',
                        'Reproduksi' => 'Reproduksi pada manusia',
                        'Pewarisan' => 'Pewarisan sifat',
                        'Ekosistem' => 'Ekosistem dan interaksi antar komponen',
                        'Pencemaran' => 'Pencemaran lingkungan dan dampaknya',
                        'Bioteknologi' => 'Bioteknologi sederhana',
                        'Pertumbuhan' => 'Pertumbuhan dan perkembangan tumbuhan',
                        'Fotosintesis' => 'Fotosintesis dan respirasi'
                    ]
                ],
                'SMA' => [
                    'Fisika' => [
                        'Mekanika' => 'Hukum Newton dan gerak',
                        'Termodinamika' => 'Hukum termodinamika',
                        'Listrik' => 'Listrik statis dan dinamis',
                        'Gelombang' => 'Gelombang mekanik dan elektromagnetik',
                        'Optik' => 'Optik geometri dan fisis',
                        'Fisika Modern' => 'Fisika modern dan relativitas'
                    ],
                    'Kimia' => [
                        'Struktur Atom' => 'Struktur atom dan sistem periodik',
                        'Ikatan Kimia' => 'Ikatan kimia dan bentuk molekul',
                        'Reaksi Kimia' => 'Laju reaksi dan kesetimbangan',
                        'Larutan' => 'Larutan dan sifat koligatif',
                        'Elektrokimia' => 'Elektrokimia dan sel elektrokimia',
                        'Kimia Organik' => 'Kimia organik dan hidrokarbon'
                    ],
                    'Biologi' => [
                        'Sel' => 'Struktur dan fungsi sel',
                        'Metabolisme' => 'Metabolisme sel',
                        'Genetika' => 'Pewarisan sifat dan mutasi',
                        'Evolusi' => 'Evolusi dan seleksi alam',
                        'Ekologi' => 'Ekologi dan konservasi',
                        'Bioteknologi' => 'Bioteknologi modern'
                    ]
                ]
            ],
            'Fisika' => [
                'SMA' => [
                    'Mekanika' => [
                        'Kinematika' => 'Gerak lurus beraturan dan berubah beraturan',
                        'Dinamika' => 'Hukum Newton dan aplikasinya',
                        'Energi' => 'Energi kinetik, potensial, dan mekanik',
                        'Momentum' => 'Momentum linear dan impuls',
                        'Tumbukan' => 'Tumbukan elastis dan tidak elastis',
                        'Gerak Melingkar' => 'Gerak melingkar beraturan',
                        'Gravitasi' => 'Hukum gravitasi Newton',
                        'Usaha' => 'Usaha dan daya',
                        'Pesawat Sederhana' => 'Pesawat sederhana dan keuntungan mekanis'
                    ],
                    'Fluida' => [
                        'Tekanan' => 'Tekanan pada zat padat, cair, dan gas',
                        'Hukum Pascal' => 'Hukum Pascal dan aplikasinya',
                        'Hukum Archimedes' => 'Hukum Archimedes dan gaya apung',
                        'Viskositas' => 'Viskositas dan aliran fluida',
                        'Bernoulli' => 'Persamaan Bernoulli'
                    ],
                    'Termodinamika' => [
                        'Suhu' => 'Suhu dan kalor',
                        'Pemuaian' => 'Pemuaian zat padat, cair, dan gas',
                        'Kalor' => 'Kalor jenis dan kalor laten',
                        'Hukum Termodinamika' => 'Hukum termodinamika I dan II',
                        'Mesin Kalor' => 'Mesin kalor dan efisiensi'
                    ],
                    'Gelombang' => [
                        'Gelombang Mekanik' => 'Gelombang transversal dan longitudinal',
                        'Gelombang Bunyi' => 'Gelombang bunyi dan sifat-sifatnya',
                        'Gelombang Cahaya' => 'Gelombang cahaya dan sifat-sifatnya',
                        'Interferensi' => 'Interferensi dan difraksi',
                        'Polarisasi' => 'Polarisasi cahaya'
                    ],
                    'Listrik' => [
                        'Listrik Statis' => 'Muatan listrik dan hukum Coulomb',
                        'Medan Listrik' => 'Medan listrik dan potensial listrik',
                        'Kapasitor' => 'Kapasitor dan kapasitansi',
                        'Arus Listrik' => 'Arus listrik dan hambatan',
                        'Rangkaian Listrik' => 'Rangkaian seri dan paralel',
                        'Energi Listrik' => 'Energi dan daya listrik',
                        'Induksi Elektromagnetik' => 'Induksi elektromagnetik'
                    ],
                    'Fisika Modern' => [
                        'Relativitas' => 'Teori relativitas Einstein',
                        'Foton' => 'Foton dan efek fotolistrik',
                        'Atom' => 'Model atom Bohr',
                        'Radioaktivitas' => 'Radioaktivitas dan peluruhan',
                        'Fisika Kuantum' => 'Fisika kuantum dan dualisme gelombang-partikel'
                    ]
                ]
            ],
            'Kimia' => [
                'SMA' => [
                    'Struktur Atom' => [
                        'Model Atom' => 'Perkembangan model atom',
                        'Konfigurasi Elektron' => 'Konfigurasi elektron dan kulit atom',
                        'Sistem Periodik' => 'Sistem periodik unsur',
                        'Sifat Periodik' => 'Sifat periodik unsur',
                        'Ikatan Ion' => 'Ikatan ion dan senyawa ion',
                        'Ikatan Kovalen' => 'Ikatan kovalen dan senyawa kovalen',
                        'Ikatan Logam' => 'Ikatan logam dan sifat logam'
                    ],
                    'Stoikiometri' => [
                        'Rumus Kimia' => 'Rumus kimia dan persamaan reaksi',
                        'Hukum Dasar' => 'Hukum dasar kimia',
                        'Perhitungan Kimia' => 'Perhitungan kimia dan stoikiometri',
                        'Gas' => 'Hukum gas dan persamaan gas ideal',
                        'Larutan' => 'Konsentrasi larutan dan pengenceran'
                    ],
                    'Termokimia' => [
                        'Entalpi' => 'Entalpi dan perubahan entalpi',
                        'Hukum Hess' => 'Hukum Hess dan perhitungan entalpi',
                        'Entalpi Pembentukan' => 'Entalpi pembentukan dan pembakaran',
                        'Kalorimeter' => 'Kalorimeter dan pengukuran kalor'
                    ],
                    'Laju Reaksi' => [
                        'Faktor Laju' => 'Faktor-faktor yang mempengaruhi laju reaksi',
                        'Orde Reaksi' => 'Orde reaksi dan persamaan laju',
                        'Katalis' => 'Katalis dan mekanisme reaksi',
                        'Kesetimbangan' => 'Kesetimbangan kimia dan tetapan kesetimbangan'
                    ],
                    'Larutan' => [
                        'Sifat Koligatif' => 'Sifat koligatif larutan',
                        'Penurunan Tekanan Uap' => 'Penurunan tekanan uap jenuh',
                        'Kenaikan Titik Didih' => 'Kenaikan titik didih larutan',
                        'Penurunan Titik Beku' => 'Penurunan titik beku larutan',
                        'Tekanan Osmotik' => 'Tekanan osmotik larutan'
                    ],
                    'Elektrokimia' => [
                        'Sel Volta' => 'Sel volta dan potensial elektrode',
                        'Sel Elektrolisis' => 'Sel elektrolisis dan hukum Faraday',
                        'Korosi' => 'Korosi dan pencegahannya',
                        'Baterai' => 'Baterai dan akumulator'
                    ],
                    'Kimia Organik' => [
                        'Hidrokarbon' => 'Hidrokarbon dan turunannya',
                        'Alkana' => 'Alkana dan reaksi-reaksinya',
                        'Alkena' => 'Alkena dan reaksi adisi',
                        'Alkuna' => 'Alkuna dan reaksi-reaksinya',
                        'Alkohol' => 'Alkohol dan eter',
                        'Asam Karboksilat' => 'Asam karboksilat dan ester',
                        'Polimer' => 'Polimer dan polimerisasi'
                    ]
                ]
            ],
            'Biologi' => [
                'SMA' => [
                    'Sel' => [
                        'Struktur Sel' => 'Struktur dan fungsi organel sel',
                        'Membran Sel' => 'Membran sel dan transportasi',
                        'Nukleus' => 'Nukleus dan kromosom',
                        'Pembelahan Sel' => 'Mitosis dan meiosis',
                        'Metabolisme Sel' => 'Metabolisme sel dan enzim'
                    ],
                    'Genetika' => [
                        'Hukum Mendel' => 'Hukum Mendel dan persilangan',
                        'Alel' => 'Alel ganda dan poligenik',
                        'Pautan' => 'Pautan gen dan pindah silang',
                        'Mutasi' => 'Mutasi gen dan kromosom',
                        'Rekayasa Genetika' => 'Rekayasa genetika dan bioteknologi'
                    ],
                    'Evolusi' => [
                        'Seleksi Alam' => 'Seleksi alam dan adaptasi',
                        'Variasi' => 'Variasi genetik dan spesiasi',
                        'Fosil' => 'Fosil dan bukti evolusi',
                        'Teori Evolusi' => 'Teori evolusi Darwin',
                        'Evolusi Manusia' => 'Evolusi manusia dan primata'
                    ],
                    'Ekologi' => [
                        'Populasi' => 'Dinamika populasi',
                        'Komunitas' => 'Komunitas dan suksesi',
                        'Ekosistem' => 'Ekosistem dan aliran energi',
                        'Biogeokimia' => 'Siklus biogeokimia',
                        'Konservasi' => 'Konservasi dan keanekaragaman hayati'
                    ],
                    'Sistem Organ' => [
                        'Sistem Pencernaan' => 'Sistem pencernaan dan nutrisi',
                        'Sistem Pernapasan' => 'Sistem pernapasan dan pertukaran gas',
                        'Sistem Sirkulasi' => 'Sistem sirkulasi dan transportasi',
                        'Sistem Ekskresi' => 'Sistem ekskresi dan osmoregulasi',
                        'Sistem Saraf' => 'Sistem saraf dan koordinasi',
                        'Sistem Endokrin' => 'Sistem endokrin dan hormon',
                        'Sistem Reproduksi' => 'Sistem reproduksi dan perkembangan'
                    ],
                    'Mikrobiologi' => [
                        'Bakteri' => 'Bakteri dan peranannya',
                        'Virus' => 'Virus dan penyakit',
                        'Protista' => 'Protista dan keanekaragamannya',
                        'Jamur' => 'Jamur dan peranannya',
                        'Imunologi' => 'Sistem imun dan pertahanan tubuh'
                    ]
                ]
            ],
            'IPS' => [
                'SD' => [
                    'Sejarah' => [
                        'Sejarah Indonesia' => 'Sejarah perjuangan kemerdekaan Indonesia',
                        'Peninggalan' => 'Peninggalan sejarah di Indonesia',
                        'Tokoh' => 'Tokoh-tokoh sejarah Indonesia',
                        'Kerajaan' => 'Kerajaan-kerajaan di Indonesia',
                        'Kolonialisme' => 'Masa kolonialisme di Indonesia'
                    ],
                    'Geografi' => [
                        'Kenampakan Alam' => 'Kenampakan alam dan buatan',
                        'Peta' => 'Membaca dan membuat peta',
                        'Sumber Daya' => 'Sumber daya alam dan pemanfaatannya',
                        'Lingkungan' => 'Lingkungan hidup dan pelestariannya',
                        'Cuaca' => 'Cuaca dan iklim di Indonesia'
                    ],
                    'Ekonomi' => [
                        'Kegiatan Ekonomi' => 'Kegiatan ekonomi di lingkungan sekitar',
                        'Uang' => 'Sejarah dan fungsi uang',
                        'Koperasi' => 'Koperasi dan peranannya',
                        'Pasar' => 'Pasar dan jenis-jenisnya',
                        'Produksi' => 'Kegiatan produksi, distribusi, dan konsumsi'
                    ],
                    'Sosiologi' => [
                        'Norma' => 'Norma dan nilai dalam masyarakat',
                        'Keberagaman' => 'Keberagaman suku bangsa dan budaya',
                        'Globalisasi' => 'Dampak globalisasi',
                        'Interaksi' => 'Interaksi sosial dalam masyarakat',
                        'Lembaga' => 'Lembaga sosial dalam masyarakat'
                    ]
                ],
                'SMP' => [
                    'Sejarah' => [
                        'Perjuangan' => 'Perjuangan kemerdekaan Indonesia',
                        'Proklamasi' => 'Proklamasi kemerdekaan',
                        'Orde Baru' => 'Masa Orde Baru dan Reformasi',
                        'Kolonialisme' => 'Kolonialisme dan imperialisme',
                        'Revolusi' => 'Revolusi industri dan dampaknya'
                    ],
                    'Geografi' => [
                        'Kondisi Geografis' => 'Kondisi geografis Indonesia',
                        'Penduduk' => 'Kependudukan dan migrasi',
                        'Lingkungan' => 'Lingkungan hidup dan pembangunan berkelanjutan',
                        'Sumber Daya' => 'Sumber daya alam dan pembangunan',
                        'Bencana Alam' => 'Bencana alam dan mitigasi'
                    ],
                    'Ekonomi' => [
                        'Kebutuhan' => 'Kebutuhan manusia dan kelangkaan',
                        'Pasar' => 'Pasar dan harga',
                        'Perdagangan' => 'Perdagangan internasional',
                        'Uang' => 'Uang dan lembaga keuangan',
                        'Koperasi' => 'Koperasi dan kewirausahaan'
                    ],
                    'Sosiologi' => [
                        'Interaksi' => 'Interaksi sosial dan sosialisasi',
                        'Lembaga' => 'Lembaga sosial',
                        'Perubahan' => 'Perubahan sosial dan globalisasi',
                        'Konflik' => 'Konflik sosial dan integrasi',
                        'Mobilitas' => 'Mobilitas sosial'
                    ]
                ],
                'SMA' => [
                    'Sejarah' => [
                        'Peradaban' => 'Peradaban awal dunia',
                        'Kolonialisme' => 'Kolonialisme dan imperialisme',
                        'Kemerdekaan' => 'Perjuangan kemerdekaan Indonesia',
                        'Revolusi' => 'Revolusi industri dan dampaknya',
                        'Perang Dunia' => 'Perang Dunia I dan II',
                        'Dekolonisasi' => 'Dekolonisasi di Asia Afrika',
                        'Perang Dingin' => 'Perang Dingin dan dampaknya'
                    ],
                    'Geografi' => [
                        'Litosfer' => 'Litosfer dan pedosfer',
                        'Atmosfer' => 'Atmosfer dan hidrosfer',
                        'Biosfer' => 'Biosfer dan antroposfer',
                        'Klimatologi' => 'Klimatologi dan meteorologi',
                        'Oseanografi' => 'Oseanografi dan geomorfologi',
                        'Demografi' => 'Demografi dan kependudukan',
                        'Pembangunan' => 'Pembangunan dan globalisasi'
                    ],
                    'Ekonomi' => [
                        'Konsep' => 'Konsep dasar ilmu ekonomi',
                        'Pasar' => 'Pasar dan harga',
                        'Kebijakan' => 'Kebijakan moneter dan fiskal',
                        'Pertumbuhan' => 'Pertumbuhan dan pembangunan ekonomi',
                        'Perdagangan' => 'Perdagangan internasional',
                        'Ketenagakerjaan' => 'Ketenagakerjaan dan pengangguran',
                        'Inflasi' => 'Inflasi dan deflasi'
                    ],
                    'Sosiologi' => [
                        'Struktur' => 'Struktur sosial dan diferensiasi',
                        'Konflik' => 'Konflik dan integrasi sosial',
                        'Perubahan' => 'Perubahan sosial dan modernisasi',
                        'Mobilitas' => 'Mobilitas sosial',
                        'Kelompok' => 'Kelompok sosial dan organisasi',
                        'Masyarakat' => 'Masyarakat multikultural',
                        'Globalisasi' => 'Globalisasi dan dampaknya'
                    ]
                ]
            ]
        ];

        return $kurikulum[$mapel][$jenjang] ?? [];
    }

    private function generateJawabanMatematika($a, $b, $op)
    {
        $hasil = 0;
        switch ($op) {
            case '+':
                $hasil = $a + $b;
                break;
            case '-':
                $hasil = $a - $b;
                break;
            case '×':
                $hasil = $a * $b;
                break;
            case '÷':
                $hasil = $a / $b;
                break;
        }

        $jawaban = [
            'a' => (string)$hasil,
            'b' => (string)($hasil + rand(1, 5)),
            'c' => (string)($hasil - rand(1, 5)),
            'd' => (string)($hasil + rand(6, 10)),
            'e' => (string)($hasil - rand(6, 10))
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => (string)$hasil
        ];
    }

    private function generateJawaban($templateJawaban)
    {
        // If templateJawaban is already in the correct format with 'jawaban' and 'benar' keys
        if (isset($templateJawaban['jawaban']) && isset($templateJawaban['benar'])) {
            $jawaban = $templateJawaban['jawaban'];
            $benar = $templateJawaban['benar'];

            // Ensure all answers are unique and relevant
            $correctAnswer = $benar ?? '';
            $otherAnswers = array_diff($jawaban, [$correctAnswer]);

            // Generate new wrong answers if needed
            while (count($jawaban) < 5) {
                $newAnswer = $this->generatePlausibleWrongAnswer($correctAnswer);
                if (!in_array($newAnswer, $otherAnswers)) {
                    $otherAnswers[] = $newAnswer;
                }
            }

            // Shuffle wrong answers
            $wrongAnswers = array_values($otherAnswers);
            shuffle($wrongAnswers);

            // Reconstruct jawaban array
            $newJawaban = [
                'a' => $correctAnswer,
                'b' => $wrongAnswers[0],
                'c' => $wrongAnswers[1],
                'd' => $wrongAnswers[2],
                'e' => $wrongAnswers[3]
            ];

            return [
                'jawaban' => $newJawaban,
                'benar' => $correctAnswer
            ];
        }

        // If templateJawaban is just an array of answers
        $jawaban = $templateJawaban;
        $wrongAnswers = [];
        $index = 0;
        foreach ($jawaban as $key => $value) {
            if ($index != 0) {
                $wrongAnswers[] = $value;
            }
            $index++;
        }
        $correctAnswer = reset($jawaban); // Get first answer as correct
        while (count($wrongAnswers) < 4) {
            $newAnswer = $this->generatePlausibleWrongAnswer($correctAnswer);
            if (!in_array($newAnswer, $wrongAnswers)) {
                $wrongAnswers[] = $newAnswer;
            }
        }

        // Shuffle wrong answers
        shuffle($wrongAnswers);

        // Create final jawaban array
        $finalJawaban = [
            'a' => $correctAnswer,
            'b' => $wrongAnswers[0],
            'c' => $wrongAnswers[1],
            'd' => $wrongAnswers[2],
            'e' => $wrongAnswers[3]
        ];

        return [
            'jawaban' => $finalJawaban,
            'benar' => $correctAnswer
        ];
    }

    private function generatePlausibleWrongAnswer($correctAnswer)
    {
        // For numerical answers
        if (is_numeric($correctAnswer)) {
            $value = floatval($correctAnswer);
            $variations = [
                $value * 1.5,
                $value * 0.75,
                $value + rand(1, 10),
                $value - rand(1, 10),
                $value * 2
            ];
            return (string)$variations[array_rand($variations)];
        }

        // For text answers
        $words = explode(' ', $correctAnswer);
        if (count($words) > 1) {
            // Modify some words to create a wrong answer
            $modifiedWords = $words;
            $modifyIndex = array_rand($words);
            $word = $words[$modifyIndex];

            // Common word modifications
            $modifications = [
                'tambah' => ['kurang', 'kali', 'bagi'],
                'kurang' => ['tambah', 'kali', 'bagi'],
                'kali' => ['tambah', 'kurang', 'bagi'],
                'bagi' => ['tambah', 'kurang', 'kali'],
                'panas' => ['dingin', 'hangat', 'sejuk'],
                'dingin' => ['panas', 'hangat', 'sejuk'],
                'besar' => ['kecil', 'sedang', 'sangat besar'],
                'kecil' => ['besar', 'sedang', 'sangat kecil'],
                'maju' => ['mundur', 'berhenti', 'berkembang'],
                'mundur' => ['maju', 'berhenti', 'berkembang'],
                'tinggi' => ['rendah', 'sedang', 'sangat tinggi'],
                'rendah' => ['tinggi', 'sedang', 'sangat rendah']
            ];

            // Try to find a modification for the word
            foreach ($modifications as $key => $values) {
                if (stripos($word, $key) !== false) {
                    $modifiedWords[$modifyIndex] = $values[array_rand($values)];
                    return implode(' ', $modifiedWords);
                }
            }

            // If no specific modification found, add a modifier
            $modifiedWords[$modifyIndex] = $word . ' yang berbeda';
            return implode(' ', $modifiedWords);
        }

        // Default wrong answers
        $defaultWrongAnswers = [
            "Jawaban yang kurang tepat",
            "Pilihan yang tidak sesuai",
            "Alternatif yang salah",
            "Opsi yang tidak benar",
            "Jawaban yang tidak tepat"
        ];

        return $defaultWrongAnswers[array_rand($defaultWrongAnswers)];
    }

    private function generateGambarSoal($soalId)
    {
        // Generate SVG sederhana
        $svg = '<svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="300" fill="#f0f0f0"/>
            <text x="50%" y="50%" font-family="Arial" font-size="24" text-anchor="middle">Gambar Soal ' . $soalId . '</text>
        </svg>';

        // Simpan file SVG
        $filename = 'soal_' . $soalId . '.svg';
        file_put_contents(public_path('assets/soal/' . $filename), $svg);

        // Update soal dengan path gambar
        soal::where('id', $soalId)->update([
            'image_soal' => '/assets/soal/' . $filename
        ]);
    }

    private function generateSoalIPS($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Sejarah':
                if ($subTopik == 'Perjuangan Kemerdekaan' || $key == 'Perjuangan Kemerdekaan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Siapa yang membacakan teks proklamasi kemerdekaan Indonesia?";
                            $template['jawaban'] = [
                                'a' => 'Ir. Soekarno',
                                'b' => 'Mohammad Hatta',
                                'c' => 'Ahmad Soebarjo',
                                'd' => 'Sutan Sjahrir',
                                'e' => 'Ki Hajar Dewantara'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Peristiwa Rengasdengklok terjadi pada tanggal...";
                            $template['jawaban'] = [
                                'a' => '16 Agustus 1945',
                                'b' => '17 Agustus 1945',
                                'c' => '15 Agustus 1945',
                                'd' => '18 Agustus 1945',
                                'e' => '19 Agustus 1945'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Perjanjian Linggarjati ditandatangani pada tanggal...";
                            $template['jawaban'] = [
                                'a' => '25 Maret 1947',
                                'b' => '25 Maret 1946',
                                'c' => '25 Maret 1948',
                                'd' => '25 Maret 1949',
                                'e' => '25 Maret 1950'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Peninggalan Sejarah' || $key == 'Peninggalan Sejarah') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Candi Borobudur merupakan peninggalan sejarah dari kerajaan...";
                            $template['jawaban'] = [
                                'a' => 'Mataram Kuno',
                                'b' => 'Majapahit',
                                'c' => 'Sriwijaya',
                                'd' => 'Singasari',
                                'e' => 'Kediri'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Candi Prambanan merupakan peninggalan sejarah dari kerajaan...";
                            $template['jawaban'] = [
                                'a' => 'Mataram Kuno',
                                'b' => 'Majapahit',
                                'c' => 'Sriwijaya',
                                'd' => 'Singasari',
                                'e' => 'Kediri'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Candi Sewu merupakan peninggalan sejarah dari kerajaan...";
                            $template['jawaban'] = [
                                'a' => 'Mataram Kuno',
                                'b' => 'Majapahit',
                                'c' => 'Sriwijaya',
                                'd' => 'Singasari',
                                'e' => 'Kediri'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Geografi':
                if ($subTopik == 'Kenampakan Alam' || $key == 'Kenampakan Alam') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan kenampakan alam daratan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Gunung',
                                'b' => 'Laut',
                                'c' => 'Sungai',
                                'd' => 'Danau',
                                'e' => 'Selat'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan kenampakan alam perairan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Laut',
                                'b' => 'Gunung',
                                'c' => 'Bukit',
                                'd' => 'Dataran tinggi',
                                'e' => 'Dataran rendah'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan kenampakan alam buatan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Waduk',
                                'b' => 'Gunung',
                                'c' => 'Laut',
                                'd' => 'Sungai',
                                'e' => 'Danau'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Peta' || $key == 'Peta') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Simbol berwarna biru pada peta biasanya menunjukkan...";
                            $template['jawaban'] = [
                                'a' => 'Perairan',
                                'b' => 'Pegunungan',
                                'c' => 'Hutan',
                                'd' => 'Jalan',
                                'e' => 'Kota'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Simbol berwarna hijau pada peta biasanya menunjukkan...";
                            $template['jawaban'] = [
                                'a' => 'Dataran rendah',
                                'b' => 'Perairan',
                                'c' => 'Pegunungan',
                                'd' => 'Jalan',
                                'e' => 'Kota'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Simbol berwarna coklat pada peta biasanya menunjukkan...";
                            $template['jawaban'] = [
                                'a' => 'Pegunungan',
                                'b' => 'Perairan',
                                'c' => 'Dataran rendah',
                                'd' => 'Jalan',
                                'e' => 'Kota'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Ekonomi':
                if ($subTopik == 'Kegiatan Ekonomi' || $key == 'Kegiatan Ekonomi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh kegiatan produksi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Membuat pakaian',
                                'b' => 'Membeli makanan',
                                'c' => 'Menjual sayuran',
                                'd' => 'Menggunakan sepeda',
                                'e' => 'Menyimpan uang'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh kegiatan distribusi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menjual barang dari produsen ke konsumen',
                                'b' => 'Membuat barang',
                                'c' => 'Menggunakan barang',
                                'd' => 'Menyimpan barang',
                                'e' => 'Membeli barang'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh kegiatan konsumsi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menggunakan barang untuk memenuhi kebutuhan',
                                'b' => 'Membuat barang',
                                'c' => 'Menjual barang',
                                'd' => 'Menyimpan barang',
                                'e' => 'Mengangkut barang'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Uang' || $key == 'Uang') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan fungsi uang adalah...";
                            $template['jawaban'] = [
                                'a' => 'Alat tukar',
                                'b' => 'Alat bermain',
                                'c' => 'Alat hiasan',
                                'd' => 'Alat pancing',
                                'e' => 'Alat masak'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan fungsi uang sebagai alat satuan hitung adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mengukur nilai barang dan jasa',
                                'b' => 'Alat tukar',
                                'c' => 'Alat penyimpan kekayaan',
                                'd' => 'Alat pembayaran',
                                'e' => 'Alat investasi'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan fungsi uang sebagai alat penyimpan kekayaan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menyimpan nilai untuk masa depan',
                                'b' => 'Alat tukar',
                                'c' => 'Alat satuan hitung',
                                'd' => 'Alat pembayaran',
                                'e' => 'Alat investasi'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Sosiologi':
                if ($subTopik == 'Norma' || $key == 'Norma') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh norma kesopanan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mengucapkan salam saat bertemu',
                                'b' => 'Membayar pajak',
                                'c' => 'Tidak mencuri',
                                'd' => 'Beribadah',
                                'e' => 'Belajar'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh norma hukum adalah...";
                            $template['jawaban'] = [
                                'a' => 'Membayar pajak',
                                'b' => 'Mengucapkan salam saat bertemu',
                                'c' => 'Beribadah',
                                'd' => 'Belajar',
                                'e' => 'Membantu orang lain'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh norma agama adalah...";
                            $template['jawaban'] = [
                                'a' => 'Beribadah',
                                'b' => 'Mengucapkan salam saat bertemu',
                                'c' => 'Membayar pajak',
                                'd' => 'Belajar',
                                'e' => 'Membantu orang lain'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Kebudayaan' || $key == 'Kebudayaan' ) {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh kebudayaan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Tarian tradisional',
                                'b' => 'Makanan cepat saji',
                                'c' => 'Pakaian modern',
                                'd' => 'Kendaraan bermotor',
                                'e' => 'Gadget'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Berikut ini yang merupakan contoh kebudayaan material adalah...";
                            $template['jawaban'] = [
                                'a' => 'Rumah adat',
                                'b' => 'Tarian tradisional',
                                'c' => 'Lagu daerah',
                                'd' => 'Upacara adat',
                                'e' => 'Cerita rakyat'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Berikut ini yang merupakan contoh kebudayaan non-material adalah...";
                            $template['jawaban'] = [
                                'a' => 'Sistem nilai',
                                'b' => 'Rumah adat',
                                'c' => 'Pakaian tradisional',
                                'd' => 'Senjata tradisional',
                                'e' => 'Alat musik tradisional'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateJawabanSejarahSD()
    {
        $jawaban = [
            'a' => "17 Agustus 1945",
            'b' => "17 Agustus 1946",
            'c' => "17 Agustus 1944",
            'd' => "17 Agustus 1947",
            'e' => "17 Agustus 1943"
        ];

        // Variasi jawaban untuk SD
        $variasiJawaban = [
            'Proklamasi' => [
                'a' => "17 Agustus 1945",
                'b' => "17 Agustus 1946",
                'c' => "17 Agustus 1944",
                'd' => "17 Agustus 1947",
                'e' => "17 Agustus 1943"
            ],
            'Tokoh' => [
                'a' => "Ir. Soekarno dan Drs. Moh. Hatta",
                'b' => "Ir. Soekarno dan Bung Tomo",
                'c' => "Drs. Moh. Hatta dan Bung Tomo",
                'd' => "Ir. Soekarno dan Sutan Sjahrir",
                'e' => "Drs. Moh. Hatta dan Sutan Sjahrir"
            ],
            'Tempat' => [
                'a' => "Jalan Pegangsaan Timur No. 56",
                'b' => "Jalan Pegangsaan Barat No. 56",
                'c' => "Jalan Pegangsaan Timur No. 65",
                'd' => "Jalan Pegangsaan Barat No. 65",
                'e' => "Jalan Pegangsaan Timur No. 46"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanSejarahSMP()
    {
        // Variasi jawaban untuk SMP
        $variasiJawaban = [
            'Peristiwa' => [
                'a' => "Pembacaan Teks Proklamasi",
                'b' => "Pengibaran Bendera Merah Putih",
                'c' => "Pertempuran Surabaya",
                'd' => "Perjanjian Linggarjati",
                'e' => "Konferensi Meja Bundar"
            ],
            'Tokoh' => [
                'a' => "Ir. Soekarno",
                'b' => "Drs. Moh. Hatta",
                'c' => "Sutan Sjahrir",
                'd' => "Bung Tomo",
                'e' => "Jenderal Sudirman"
            ],
            'Dokumen' => [
                'a' => "Teks Proklamasi",
                'b' => "Piagam Jakarta",
                'c' => "Undang-Undang Dasar 1945",
                'd' => "Sumpah Pemuda",
                'e' => "Perjanjian Renville"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanSejarahSMA()
    {
        // Variasi jawaban untuk SMA
        $variasiJawaban = [
            'Peristiwa' => [
                'a' => "Proklamasi Kemerdekaan Indonesia",
                'b' => "Pertempuran Ambarawa",
                'c' => "Pertempuran Surabaya",
                'd' => "Agresi Militer Belanda I",
                'e' => "Agresi Militer Belanda II"
            ],
            'Tokoh' => [
                'a' => "Ir. Soekarno dan Drs. Moh. Hatta",
                'b' => "Sutan Sjahrir dan Amir Sjarifuddin",
                'c' => "Jenderal Sudirman dan Bung Tomo",
                'd' => "Tan Malaka dan Sutan Sjahrir",
                'e' => "Mohammad Natsir dan Syafruddin Prawiranegara"
            ],
            'Dokumen' => [
                'a' => "Teks Proklamasi Kemerdekaan",
                'b' => "Piagam Jakarta",
                'c' => "Undang-Undang Dasar 1945",
                'd' => "Perjanjian Linggarjati",
                'e' => "Perjanjian Renville"
            ],
            'Latar Belakang' => [
                'a' => "Kekalahan Jepang dalam Perang Dunia II",
                'b' => "Kekalahan Belanda dalam Perang Dunia II",
                'c' => "Kemenangan Sekutu dalam Perang Dunia II",
                'd' => "Kemenangan Jepang dalam Perang Dunia II",
                'e' => "Kemenangan Belanda dalam Perang Dunia II"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanGeografiSD()
    {
        $variasiJawaban = [
            'Gunung' => [
                'a' => 'Gunung Bromo (2.329 m) di Jawa Timur',
                'b' => 'Gunung Merapi (2.930 m) di Jawa Tengah',
                'c' => 'Gunung Semeru (3.676 m) di Jawa Timur',
                'd' => 'Gunung Rinjani (3.726 m) di Nusa Tenggara Barat',
                'e' => 'Gunung Kerinci (3.805 m) di Sumatera Barat'
            ],
            'Danau' => [
                'a' => 'Danau Toba (1.130 km²) di Sumatera Utara',
                'b' => 'Danau Singkarak (107,8 km²) di Sumatera Barat',
                'c' => 'Danau Maninjau (99,5 km²) di Sumatera Barat',
                'd' => 'Danau Poso (323,2 km²) di Sulawesi Tengah',
                'e' => 'Danau Tempe (350 km²) di Sulawesi Selatan'
            ],
            'Sungai' => [
                'a' => 'Sungai Kapuas (1.143 km) di Kalimantan Barat',
                'b' => 'Sungai Mahakam (980 km) di Kalimantan Timur',
                'c' => 'Sungai Barito (909 km) di Kalimantan Selatan',
                'd' => 'Sungai Musi (750 km) di Sumatera Selatan',
                'e' => 'Sungai Bengawan Solo (548 km) di Jawa Tengah'
            ],
            'Laut' => [
                'a' => 'Laut Jawa (310.000 km²) di antara Pulau Jawa dan Kalimantan',
                'b' => 'Laut Sulawesi (280.000 km²) di antara Pulau Sulawesi dan Filipina',
                'c' => 'Laut Banda (470.000 km²) di antara Pulau Maluku dan Nusa Tenggara',
                'd' => 'Laut Arafura (650.000 km²) di antara Pulau Papua dan Australia',
                'e' => 'Laut Maluku (200.000 km²) di antara Pulau Sulawesi dan Maluku'
            ],
            'Selat' => [
                'a' => 'Selat Sunda (30 km) antara Pulau Jawa dan Sumatera',
                'b' => 'Selat Malaka (805 km) antara Pulau Sumatera dan Malaysia',
                'c' => 'Selat Makassar (800 km) antara Pulau Kalimantan dan Sulawesi',
                'd' => 'Selat Lombok (60 km) antara Pulau Bali dan Lombok',
                'a' => "Selat Malaka (800 km)",
                'b' => "Selat Sunda (30 km)",
                'c' => "Selat Makassar (800 km)",
                'd' => "Selat Lombok (60 km)",
                'e' => "Selat Bali (2,4 km)"
            ],
            'Pulau' => [
                'a' => "Pulau Papua (785.753 km²)",
                'b' => "Pulau Kalimantan (743.330 km²)",
                'c' => "Pulau Sumatra (473.481 km²)",
                'd' => "Pulau Sulawesi (174.600 km²)",
                'e' => "Pulau Jawa (128.297 km²)"
            ],
            'Curah Hujan' => [
                'a' => "Bogor (3.500 mm/tahun)",
                'b' => "Manado (3.000 mm/tahun)",
                'c' => "Padang (2.800 mm/tahun)",
                'd' => "Jakarta (2.000 mm/tahun)",
                'e' => "Surabaya (1.500 mm/tahun)"
            ],
            'Suhu' => [
                'a' => "Puncak Jaya (-10°C)",
                'b' => "Dieng (15°C)",
                'c' => "Bandung (23°C)",
                'd' => "Jakarta (30°C)",
                'e' => "Surabaya (35°C)"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanGeografiSMP()
    {
        $variasiJawaban = [
            'Litosfer' => [
                'a' => 'Lempeng Eurasia - Lempeng tektonik terbesar di dunia',
                'b' => 'Lempeng Indo-Australia - Lempeng yang bergerak ke utara',
                'c' => 'Lempeng Pasifik - Lempeng yang bergerak ke barat',
                'd' => 'Lempeng Filipina - Lempeng yang bergerak ke barat laut',
                'e' => 'Lempeng Amerika - Lempeng yang bergerak ke barat'
            ],
            'Atmosfer' => [
                'a' => 'Troposfer (0-12 km) - Lapisan terendah atmosfer',
                'b' => 'Stratosfer (12-50 km) - Lapisan dengan ozon',
                'c' => 'Mesosfer (50-85 km) - Lapisan terdingin',
                'd' => 'Termosfer (85-500 km) - Lapisan terpanas',
                'e' => 'Eksosfer (>500 km) - Lapisan terluar atmosfer'
            ],
            'Hidrosfer' => [
                'a' => "Siklus Air Pendek",
                'b' => "Siklus Air Sedang",
                'c' => "Siklus Air Panjang",
                'd' => "Siklus Air Dalam",
                'e' => "Siklus Air Permukaan"
            ],
            'Biosfer' => [
                'a' => "Hutan Hujan Tropis",
                'b' => "Hutan Musim",
                'c' => "Sabana",
                'd' => "Stepa",
                'e' => "Padang Rumput"
            ],
            'Antroposfer' => [
                'a' => "Pertumbuhan Penduduk Alami",
                'b' => "Pertumbuhan Penduduk Total",
                'c' => "Pertumbuhan Penduduk Migrasi",
                'd' => "Pertumbuhan Penduduk Sosial",
                'e' => "Pertumbuhan Penduduk Ekonomi"
            ],
            'Klimatologi' => [
                'a' => "Iklim Tropis",
                'b' => "Iklim Subtropis",
                'c' => "Iklim Sedang",
                'd' => "Iklim Dingin",
                'e' => "Iklim Kutub"
            ],
            'Oseanografi' => [
                'a' => "Arus Lintas Indonesia",
                'b' => "Arus Khatulistiwa Selatan",
                'c' => "Arus Khatulistiwa Utara",
                'd' => "Arus Kuroshio",
                'e' => "Arus Oyashio"
            ],
            'Geomorfologi' => [
                'a' => "Dataran Tinggi",
                'b' => "Dataran Rendah",
                'c' => "Pegunungan",
                'd' => "Perbukitan",
                'e' => "Depresi"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanGeografiSMA()
    {
        // Variasi jawaban untuk SMA dengan konteks yang lebih dinamis
        $variasiJawaban = [
            'Litosfer' => [
                'a' => "Tektonik Lempeng Konvergen",
                'b' => "Tektonik Lempeng Divergen",
                'c' => "Tektonik Lempeng Transform",
                'd' => "Tektonik Lempeng Hotspot",
                'e' => "Tektonik Lempeng Subduksi"
            ],
            'Atmosfer' => [
                'a' => "El Nino",
                'b' => "La Nina",
                'c' => "Dipole Mode",
                'd' => "Monsun",
                'e' => "Siklon Tropis"
            ],
            'Hidrosfer' => [
                'a' => "Siklus Hidrologi Global",
                'b' => "Siklus Hidrologi Regional",
                'c' => "Siklus Hidrologi Lokal",
                'd' => "Siklus Hidrologi Permukaan",
                'e' => "Siklus Hidrologi Bawah Tanah"
            ],
            'Biosfer' => [
                'a' => "Ekosistem Hutan Hujan Tropis",
                'b' => "Ekosistem Hutan Musim",
                'c' => "Ekosistem Sabana",
                'd' => "Ekosistem Stepa",
                'e' => "Ekosistem Padang Rumput"
            ],
            'Antroposfer' => [
                'a' => "Teori Transisi Demografi",
                'b' => "Teori Malthus",
                'c' => "Teori Boserup",
                'd' => "Teori Optimum Population",
                'e' => "Teori Zero Population Growth"
            ],
            'Klimatologi' => [
                'a' => "Klasifikasi Iklim Koppen",
                'b' => "Klasifikasi Iklim Schmidt-Ferguson",
                'c' => "Klasifikasi Iklim Oldeman",
                'd' => "Klasifikasi Iklim Junghuhn",
                'e' => "Klasifikasi Iklim Thornthwaite"
            ],
            'Oseanografi' => [
                'a' => "Arus Termohalin",
                'b' => "Arus Ekman",
                'c' => "Arus Geostropik",
                'd' => "Arus Barotropik",
                'e' => "Arus Baroklinik"
            ],
            'Geomorfologi' => [
                'a' => "Proses Endogen",
                'b' => "Proses Eksogen",
                'c' => "Proses Vulkanik",
                'd' => "Proses Tektonik",
                'e' => "Proses Erosi"
            ],
            'Pembangunan' => [
                'a' => "Pembangunan Berkelanjutan",
                'b' => "Pembangunan Ekonomi",
                'c' => "Pembangunan Sosial",
                'd' => "Pembangunan Lingkungan",
                'e' => "Pembangunan Infrastruktur"
            ],
            'Globalisasi' => [
                'a' => "Globalisasi Ekonomi",
                'b' => "Globalisasi Politik",
                'c' => "Globalisasi Budaya",
                'd' => "Globalisasi Teknologi",
                'e' => "Globalisasi Informasi"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanPeninggalanSD()
    {
        $jawaban = [
            'a' => "Mataram Kuno",
            'b' => "Majapahit",
            'c' => "Sriwijaya",
            'd' => "Singasari",
            'e' => "Kediri"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPeninggalanSMP()
    {
        $jawaban = [
            'a' => "Mataram Kuno",
            'b' => "Majapahit",
            'c' => "Sriwijaya",
            'd' => "Singasari",
            'e' => "Kediri"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPeninggalanSMA()
    {
        $jawaban = [
            'a' => "Mataram Kuno",
            'b' => "Majapahit",
            'c' => "Sriwijaya",
            'd' => "Singasari",
            'e' => "Kediri"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPetaSD()
    {
        $jawaban = [
            'a' => "Fisik",
            'b' => "Politik",
            'c' => "Tematik",
            'd' => "Umum",
            'e' => "Khusus"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPetaSMP()
    {
        $jawaban = [
            'a' => "Fisik",
            'b' => "Politik",
            'c' => "Tematik",
            'd' => "Umum",
            'e' => "Khusus"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanPetaSMA()
    {
        $jawaban = [
            'a' => "Fisik",
            'b' => "Politik",
            'c' => "Tematik",
            'd' => "Umum",
            'e' => "Khusus"
        ];

        return [
            'jawaban' => $jawaban,
            'benar' => $jawaban['a']
        ];
    }

    private function generateJawabanEkonomiSD()
    {
        // Variasi jawaban untuk SD
        $variasiJawaban = [
            'Kegiatan Ekonomi' => [
                'a' => "Produksi",
                'b' => "Distribusi",
                'c' => "Konsumsi",
                'd' => "Jasa",
                'e' => "Perdagangan"
            ],
            'Pekerjaan' => [
                'a' => "Petani",
                'b' => "Pedagang",
                'c' => "Guru",
                'd' => "Dokter",
                'e' => "Polisi"
            ],
            'Kebutuhan' => [
                'a' => "Makanan",
                'b' => "Pakaian",
                'c' => "Tempat tinggal",
                'd' => "Pendidikan",
                'e' => "Kesehatan"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanEkonomiSMP()
    {
        // Variasi jawaban untuk SMP
        $variasiJawaban = [
            'Kegiatan Ekonomi' => [
                'a' => "Produksi",
                'b' => "Distribusi",
                'c' => "Konsumsi",
                'd' => "Jasa",
                'e' => "Perdagangan"
            ],
            'Sistem Ekonomi' => [
                'a' => "Ekonomi Pancasila",
                'b' => "Ekonomi Kapitalis",
                'c' => "Ekonomi Sosialis",
                'd' => "Ekonomi Campuran",
                'e' => "Ekonomi Tradisional"
            ],
            'Pasar' => [
                'a' => "Pasar Tradisional",
                'b' => "Pasar Modern",
                'c' => "Pasar Swalayan",
                'd' => "Pasar Online",
                'e' => "Pasar Khusus"
            ],
            'Koperasi' => [
                'a' => "Koperasi Simpan Pinjam",
                'b' => "Koperasi Konsumsi",
                'c' => "Koperasi Produksi",
                'd' => "Koperasi Jasa",
                'e' => "Koperasi Serba Usaha"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanEkonomiSMA()
    {
        // Variasi jawaban untuk SMA
        $variasiJawaban = [
            'Konsep Ekonomi' => [
                'a' => "Kelangkaan",
                'b' => "Kebutuhan",
                'c' => "Biaya Peluang",
                'd' => "Skala Prioritas",
                'e' => "Sistem Ekonomi"
            ],
            'Pasar' => [
                'a' => "Pasar Persaingan Sempurna",
                'b' => "Pasar Monopoli",
                'c' => "Pasar Oligopoli",
                'd' => "Pasar Monopolistik",
                'e' => "Pasar Duopoli"
            ],
            'Kebijakan' => [
                'a' => "Kebijakan Moneter",
                'b' => "Kebijakan Fiskal",
                'c' => "Kebijakan Perdagangan",
                'd' => "Kebijakan Industri",
                'e' => "Kebijakan Tenaga Kerja"
            ],
            'Pertumbuhan' => [
                'a' => "Pertumbuhan Ekonomi",
                'b' => "Pembangunan Ekonomi",
                'c' => "Pemerataan Ekonomi",
                'd' => "Stabilitas Ekonomi",
                'e' => "Kemandirian Ekonomi"
            ],
            'Globalisasi' => [
                'a' => "Perdagangan Internasional",
                'b' => "Investasi Asing",
                'c' => "Transfer Teknologi",
                'd' => "Tenaga Kerja Asing",
                'e' => "Pasar Global"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanSosiologiSD()
    {
        // Variasi jawaban untuk SD
        $variasiJawaban = [
            'Norma' => [
                'a' => "Norma Kesusilaan",
                'b' => "Norma Kesopanan",
                'c' => "Norma Hukum",
                'd' => "Norma Agama",
                'e' => "Norma Adat"
            ],
            'Kebiasaan' => [
                'a' => "Mengucapkan salam",
                'b' => "Membuang sampah sembarangan",
                'c' => "Berkata kasar",
                'd' => "Mengabaikan aturan",
                'e' => "Tidak menghormati orang tua"
            ],
            'Nilai' => [
                'a' => "Kejujuran",
                'b' => "Kedisiplinan",
                'c' => "Tanggung jawab",
                'd' => "Kebersamaan",
                'e' => "Kesopanan"
            ],
            'Interaksi' => [
                'a' => "Bermain bersama",
                'b' => "Berkelahi",
                'c' => "Mengabaikan teman",
                'd' => "Mengucilkan teman",
                'e' => "Tidak mau berbagi"
            ],
            'Kebudayaan' => [
                'a' => "Tarian daerah",
                'b' => "Lagu daerah",
                'c' => "Pakaian adat",
                'd' => "Makanan tradisional",
                'e' => "Permainan tradisional"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanSosiologiSMP()
    {
        // Variasi jawaban untuk SMP
        $variasiJawaban = [
            'Norma' => [
                'a' => "Norma Kesusilaan",
                'b' => "Norma Kesopanan",
                'c' => "Norma Hukum",
                'd' => "Norma Agama",
                'e' => "Norma Adat"
            ],
            'Lembaga' => [
                'a' => "Lembaga Keluarga",
                'b' => "Lembaga Pendidikan",
                'c' => "Lembaga Agama",
                'd' => "Lembaga Ekonomi",
                'e' => "Lembaga Politik"
            ],
            'Sosialisasi' => [
                'a' => "Sosialisasi Primer",
                'b' => "Sosialisasi Sekunder",
                'c' => "Sosialisasi Formal",
                'd' => "Sosialisasi Informal",
                'e' => "Sosialisasi Nonformal"
            ],
            'Interaksi' => [
                'a' => "Interaksi Sosial Asosiatif",
                'b' => "Interaksi Sosial Disosiatif",
                'c' => "Interaksi Sosial Primer",
                'd' => "Interaksi Sosial Sekunder",
                'e' => "Interaksi Sosial Formal"
            ],
            'Perubahan' => [
                'a' => "Perubahan Sosial Evolusi",
                'b' => "Perubahan Sosial Revolusi",
                'c' => "Perubahan Sosial Direncanakan",
                'd' => "Perubahan Sosial Tidak Direncanakan",
                'e' => "Perubahan Sosial Progresif"
            ],
            'Konflik' => [
                'a' => "Konflik Antarindividu",
                'b' => "Konflik Antarkelompok",
                'c' => "Konflik Antargenerasi",
                'd' => "Konflik Antarbudaya",
                'e' => "Konflik Antaretnis"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateJawabanSosiologiSMA()
    {
        // Variasi jawaban untuk SMA
        $variasiJawaban = [
            'Struktur' => [
                'a' => "Struktur Sosial Horizontal",
                'b' => "Struktur Sosial Vertikal",
                'c' => "Struktur Sosial Campuran",
                'd' => "Struktur Sosial Formal",
                'e' => "Struktur Sosial Informal"
            ],
            'Diferensiasi' => [
                'a' => "Diferensiasi Ras",
                'b' => "Diferensiasi Etnis",
                'c' => "Diferensiasi Agama",
                'd' => "Diferensiasi Profesi",
                'e' => "Diferensiasi Gender"
            ],
            'Stratifikasi' => [
                'a' => "Stratifikasi Sosial Terbuka",
                'b' => "Stratifikasi Sosial Tertutup",
                'c' => "Stratifikasi Sosial Campuran",
                'd' => "Stratifikasi Sosial Formal",
                'e' => "Stratifikasi Sosial Informal"
            ],
            'Perubahan' => [
                'a' => "Perubahan Sosial Evolusi",
                'b' => "Perubahan Sosial Revolusi",
                'c' => "Perubahan Sosial Direncanakan",
                'd' => "Perubahan Sosial Tidak Direncanakan",
                'e' => "Perubahan Sosial Progresif"
            ],
            'Modernisasi' => [
                'a' => "Modernisasi Teknologi",
                'b' => "Modernisasi Ekonomi",
                'c' => "Modernisasi Politik",
                'd' => "Modernisasi Sosial",
                'e' => "Modernisasi Budaya"
            ],
            'Globalisasi' => [
                'a' => "Globalisasi Ekonomi",
                'b' => "Globalisasi Politik",
                'c' => "Globalisasi Budaya",
                'd' => "Globalisasi Teknologi",
                'e' => "Globalisasi Informasi"
            ],
            'Konflik' => [
                'a' => "Konflik Antarindividu",
                'b' => "Konflik Antarkelompok",
                'c' => "Konflik Antargenerasi",
                'd' => "Konflik Antarbudaya",
                'e' => "Konflik Antaretnis"
            ],
            'Integrasi' => [
                'a' => "Integrasi Normatif",
                'b' => "Integrasi Fungsional",
                'c' => "Integrasi Koersif",
                'd' => "Integrasi Akomodatif",
                'e' => "Integrasi Asimilatif"
            ]
        ];

        $topik = array_rand($variasiJawaban);
        return [
            'jawaban' => $variasiJawaban[$topik],
            'benar' => $variasiJawaban[$topik]['a']
        ];
    }

    private function generateSoalBahasaInggris($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Reading':
                if ($subTopik == 'Reading Comprehension' || $key == 'Reading Comprehension') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Read the text below!\n\nTom is a student. He goes to school every day. He likes to play football with his friends. His favorite color is blue.\n\nWhat does Tom like to do?";
                            $template['jawaban'] = [
                                'a' => 'Play football',
                                'b' => 'Play basketball',
                                'c' => 'Play tennis',
                                'd' => 'Play volleyball',
                                'e' => 'Play badminton'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Read the text below!\n\nSarah is a high school student. She studies hard every day because she wants to be a doctor. She likes reading medical books and watching documentaries about medicine. Her dream is to help people who are sick.\n\nWhat is Sarah's dream?";
                            $template['jawaban'] = [
                                'a' => 'To be a doctor',
                                'b' => 'To be a teacher',
                                'c' => 'To be a nurse',
                                'd' => 'To be a lawyer',
                                'e' => 'To be an engineer'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Read the text below!\n\nClimate change is one of the most pressing issues facing humanity today. Scientists have found overwhelming evidence that human activities, particularly the burning of fossil fuels, are causing global temperatures to rise. This has led to more frequent extreme weather events, rising sea levels, and threats to biodiversity.\n\nWhat is the main cause of climate change according to the text?";
                            $template['jawaban'] = [
                                'a' => 'Burning of fossil fuels',
                                'b' => 'Natural disasters',
                                'c' => 'Volcanic eruptions',
                                'd' => 'Solar activity',
                                'e' => 'Ocean currents'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Vocabulary' || $key == 'Vocabulary') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "The opposite of 'big' is...";
                            $template['jawaban'] = [
                                'a' => 'Small',
                                'b' => 'Tall',
                                'c' => 'Long',
                                'd' => 'Wide',
                                'e' => 'High'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "The synonym of 'happy' is...";
                            $template['jawaban'] = [
                                'a' => 'Joyful',
                                'b' => 'Sad',
                                'c' => 'Angry',
                                'd' => 'Tired',
                                'e' => 'Worried'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "The word 'sustainable' means...";
                            $template['jawaban'] = [
                                'a' => 'Able to be maintained',
                                'b' => 'Expensive',
                                'c' => 'Difficult',
                                'd' => 'Temporary',
                                'e' => 'Impossible'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Writing':
                if ($subTopik == 'Grammar' || $key == 'Grammar') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Choose the correct sentence!";
                            $template['jawaban'] = [
                                'a' => 'I am a student',
                                'b' => 'I is a student',
                                'c' => 'I are a student',
                                'd' => 'I be a student',
                                'e' => 'I being a student'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Choose the correct form of the verb!";
                            $template['jawaban'] = [
                                'a' => 'She has been studying',
                                'b' => 'She have been studying',
                                'c' => 'She has been study',
                                'd' => 'She have been study',
                                'e' => 'She has studying'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Choose the correct conditional sentence!";
                            $template['jawaban'] = [
                                'a' => 'If I had studied harder, I would have passed the exam',
                                'b' => 'If I study harder, I would have passed the exam',
                                'c' => 'If I had studied harder, I will pass the exam',
                                'd' => 'If I study harder, I will have passed the exam',
                                'e' => 'If I had studied harder, I pass the exam'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Sentence Structure' || $key == 'Sentence Structure') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Arrange these words into a good sentence!\n\n(1) book (2) is (3) reading (4) She (5) a";
                            $template['jawaban'] = [
                                'a' => '4-2-3-5-1',
                                'b' => '4-3-2-5-1',
                                'c' => '4-2-5-3-1',
                                'd' => '4-5-2-3-1',
                                'e' => '4-3-5-2-1'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Arrange these words into a good sentence!\n\n(1) library (2) to (3) going (4) She (5) is (6) the";
                            $template['jawaban'] = [
                                'a' => '4-5-3-2-6-1',
                                'b' => '4-3-5-2-6-1',
                                'c' => '4-5-2-6-3-1',
                                'd' => '4-3-2-6-5-1',
                                'e' => '4-2-6-5-3-1'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Arrange these words into a good sentence!\n\n(1) research (2) conducting (3) scientists (4) are (5) important (6) an";
                            $template['jawaban'] = [
                                'a' => '3-4-2-6-5-1',
                                'b' => '3-2-4-6-5-1',
                                'c' => '3-4-6-5-2-1',
                                'd' => '3-2-6-5-4-1',
                                'e' => '3-6-5-4-2-1'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Speaking':
                if ($subTopik == 'Greeting' || $key == 'Greeting') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "What do you say when you meet someone in the morning?";
                            $template['jawaban'] = [
                                'a' => 'Good morning',
                                'b' => 'Good afternoon',
                                'c' => 'Good evening',
                                'd' => 'Good night',
                                'e' => 'Good bye'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "What do you say when you meet someone for the first time?";
                            $template['jawaban'] = [
                                'a' => 'Nice to meet you',
                                'b' => 'Goodbye',
                                'c' => 'Thank you',
                                'd' => 'Excuse me',
                                'e' => 'You are welcome'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "What do you say when you want to express disagreement politely?";
                            $template['jawaban'] = [
                                'a' => 'I respectfully disagree',
                                'b' => 'You are wrong',
                                'c' => 'That is stupid',
                                'd' => 'I do not care',
                                'e' => 'Whatever'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Introduction' || $key == 'Introduction') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "What do you say when you want to introduce yourself?";
                            $template['jawaban'] = [
                                'a' => 'My name is...',
                                'b' => 'Your name is...',
                                'c' => 'His name is...',
                                'd' => 'Her name is...',
                                'e' => 'Their name is...'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "What do you say when you want to introduce someone else?";
                            $template['jawaban'] = [
                                'a' => 'This is...',
                                'b' => 'I am...',
                                'c' => 'You are...',
                                'd' => 'He is...',
                                'e' => 'She is...'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "What do you say when you want to give a formal presentation?";
                            $template['jawaban'] = [
                                'a' => 'Good morning, ladies and gentlemen',
                                'b' => 'Hi everyone',
                                'c' => 'Hello there',
                                'd' => 'Hey guys',
                                'e' => 'What\'s up'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Listening':
                if ($subTopik == 'Numbers' || $key == 'Numbers') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Listen to the number and choose the correct answer!\n\n(Number: 15)";
                            $template['jawaban'] = [
                                'a' => 'Fifteen',
                                'b' => 'Five',
                                'c' => 'Fifty',
                                'd' => 'Five hundred',
                                'e' => 'Five thousand'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Listen to the number and choose the correct answer!\n\n(Number: 1,250)";
                            $template['jawaban'] = [
                                'a' => 'One thousand two hundred fifty',
                                'b' => 'One thousand two hundred fifteen',
                                'c' => 'One thousand two hundred five',
                                'd' => 'One thousand two hundred',
                                'e' => 'One thousand two hundred fifty five'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Listen to the number and choose the correct answer!\n\n(Number: 2,500,000)";
                            $template['jawaban'] = [
                                'a' => 'Two million five hundred thousand',
                                'b' => 'Two million fifty thousand',
                                'c' => 'Two million five thousand',
                                'd' => 'Two million five hundred',
                                'e' => 'Two million five hundred thousand five hundred'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Colors' || $key == 'Colors'         ) {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Listen to the color and choose the correct answer!\n\n(Color: Red)";
                            $template['jawaban'] = [
                                'a' => 'Merah',
                                'b' => 'Biru',
                                'c' => 'Kuning',
                                'd' => 'Hijau',
                                'e' => 'Hitam'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Listen to the color and choose the correct answer!\n\n(Color: Turquoise)";
                            $template['jawaban'] = [
                                'a' => 'Biru kehijauan',
                                'b' => 'Merah muda',
                                'c' => 'Ungu',
                                'd' => 'Oranye',
                                'e' => 'Coklat'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Listen to the color and choose the correct answer!\n\n(Color: Maroon)";
                            $template['jawaban'] = [
                                'a' => 'Merah tua',
                                'b' => 'Merah muda',
                                'c' => 'Merah terang',
                                'd' => 'Merah jambu',
                                'e' => 'Merah oranye'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalPKn($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Pancasila':
                if ($subTopik == 'Sila Pancasila' || $key == 'Sila Pancasila') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Sila Pancasila yang berbunyi 'Kemanusiaan yang Adil dan Beradab' adalah sila ke...";
                            $template['jawaban'] = [
                                'a' => 'Dua',
                                'b' => 'Satu',
                                'c' => 'Tiga',
                                'd' => 'Empat',
                                'e' => 'Lima'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Sila Pancasila yang berbunyi 'Persatuan Indonesia' adalah sila ke...";
                            $template['jawaban'] = [
                                'a' => 'Tiga',
                                'b' => 'Satu',
                                'c' => 'Dua',
                                'd' => 'Empat',
                                'e' => 'Lima'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Sila Pancasila yang berbunyi 'Keadilan Sosial bagi Seluruh Rakyat Indonesia' adalah sila ke...";
                            $template['jawaban'] = [
                                'a' => 'Lima',
                                'b' => 'Satu',
                                'c' => 'Dua',
                                'd' => 'Tiga',
                                'e' => 'Empat'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Lambang Pancasila' || $key == 'Lambang Pancasila') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Lambang sila pertama Pancasila adalah...";
                            $template['jawaban'] = [
                                'a' => 'Bintang',
                                'b' => 'Rantai',
                                'c' => 'Pohon Beringin',
                                'd' => 'Kepala Banteng',
                                'e' => 'Padi dan Kapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Lambang sila kedua Pancasila adalah...";
                            $template['jawaban'] = [
                                'a' => 'Rantai',
                                'b' => 'Bintang',
                                'c' => 'Pohon Beringin',
                                'd' => 'Kepala Banteng',
                                'e' => 'Padi dan Kapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Lambang sila ketiga Pancasila adalah...";
                            $template['jawaban'] = [
                                'a' => 'Pohon Beringin',
                                'b' => 'Bintang',
                                'c' => 'Rantai',
                                'd' => 'Kepala Banteng',
                                'e' => 'Padi dan Kapas'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'UUD 1945':
                if ($subTopik == 'Pembukaan' || $key == 'Pembukaan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Pembukaan UUD 1945 terdiri dari... alinea";
                            $template['jawaban'] = [
                                'a' => '4',
                                'b' => '3',
                                'c' => '5',
                                'd' => '6',
                                'e' => '7'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Alinea pertama Pembukaan UUD 1945 berisi tentang...";
                            $template['jawaban'] = [
                                'a' => 'Kemerdekaan adalah hak segala bangsa',
                                'b' => 'Perjuangan pergerakan kemerdekaan Indonesia',
                                'c' => 'Atas berkat rahmat Allah Yang Maha Kuasa',
                                'd' => 'Maka disusunlah Kemerdekaan Kebangsaan Indonesia',
                                'e' => 'Dalam suatu Undang-Undang Dasar Negara Indonesia'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Alinea kedua Pembukaan UUD 1945 berisi tentang...";
                            $template['jawaban'] = [
                                'a' => 'Perjuangan pergerakan kemerdekaan Indonesia',
                                'b' => 'Kemerdekaan adalah hak segala bangsa',
                                'c' => 'Atas berkat rahmat Allah Yang Maha Kuasa',
                                'd' => 'Maka disusunlah Kemerdekaan Kebangsaan Indonesia',
                                'e' => 'Dalam suatu Undang-Undang Dasar Negara Indonesia'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Batang Tubuh' || $key == 'Batang Tubuh') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Batang tubuh UUD 1945 terdiri dari... bab";
                            $template['jawaban'] = [
                                'a' => '16',
                                'b' => '15',
                                'c' => '17',
                                'd' => '18',
                                'e' => '19'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Bab I UUD 1945 berisi tentang...";
                            $template['jawaban'] = [
                                'a' => 'Bentuk dan Kedaulatan',
                                'b' => 'Majelis Permusyawaratan Rakyat',
                                'c' => 'Kekuasaan Pemerintahan Negara',
                                'd' => 'Dewan Perwakilan Rakyat',
                                'e' => 'Pemerintahan Daerah'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Bab II UUD 1945 berisi tentang...";
                            $template['jawaban'] = [
                                'a' => 'Majelis Permusyawaratan Rakyat',
                                'b' => 'Bentuk dan Kedaulatan',
                                'c' => 'Kekuasaan Pemerintahan Negara',
                                'd' => 'Dewan Perwakilan Rakyat',
                                'e' => 'Pemerintahan Daerah'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'NKRI':
                if ($subTopik == 'Lambang Negara' || $key == 'Lambang Negara') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Lambang negara Indonesia adalah...";
                            $template['jawaban'] = [
                                'a' => 'Garuda Pancasila',
                                'b' => 'Bendera Merah Putih',
                                'c' => 'Lagu Indonesia Raya',
                                'd' => 'Bahasa Indonesia',
                                'e' => 'Pancasila'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Jumlah bulu pada sayap Garuda Pancasila adalah...";
                            $template['jawaban'] = [
                                'a' => '17',
                                'b' => '16',
                                'c' => '18',
                                'd' => '19',
                                'e' => '20'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Jumlah bulu pada ekor Garuda Pancasila adalah...";
                            $template['jawaban'] = [
                                'a' => '8',
                                'b' => '7',
                                'c' => '9',
                                'd' => '10',
                                'e' => '11'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Bendera' || $key == 'Bendera'       ) {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Bendera negara Indonesia berwarna...";
                            $template['jawaban'] = [
                                'a' => 'Merah dan Putih',
                                'b' => 'Merah dan Biru',
                                'c' => 'Merah dan Kuning',
                                'd' => 'Merah dan Hitam',
                                'e' => 'Merah dan Hijau'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Perbandingan ukuran bendera Indonesia adalah...";
                            $template['jawaban'] = [
                                'a' => '2:3',
                                'b' => '1:2',
                                'c' => '3:4',
                                'd' => '4:5',
                                'e' => '5:6'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Warna merah pada bendera Indonesia melambangkan...";
                            $template['jawaban'] = [
                                'a' => 'Keberanian',
                                'b' => 'Kesucian',
                                'c' => 'Kemakmuran',
                                'd' => 'Kedamaian',
                                'e' => 'Persatuan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Pemerintahan':
                if ($subTopik == 'Lembaga Negara' || $key == 'Lembaga Negara') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Lembaga negara yang memegang kekuasaan membentuk undang-undang adalah...";
                            $template['jawaban'] = [
                                'a' => 'DPR',
                                'b' => 'MPR',
                                'c' => 'Presiden',
                                'd' => 'MA',
                                'e' => 'MK'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Lembaga negara yang memegang kekuasaan kehakiman adalah...";
                            $template['jawaban'] = [
                                'a' => 'MA dan MK',
                                'b' => 'DPR dan MPR',
                                'c' => 'Presiden dan Wakil Presiden',
                                'd' => 'BPK dan KY',
                                'e' => 'DPD dan DPR'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Lembaga negara yang berwenang menguji undang-undang terhadap UUD 1945 adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mahkamah Konstitusi',
                                'b' => 'Mahkamah Agung',
                                'c' => 'Dewan Perwakilan Rakyat',
                                'd' => 'Majelis Permusyawaratan Rakyat',
                                'e' => 'Badan Pemeriksa Keuangan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Pemilu' || $key == 'Pemilu') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Pemilu dilaksanakan setiap... tahun sekali";
                            $template['jawaban'] = [
                                'a' => '5',
                                'b' => '4',
                                'c' => '6',
                                'd' => '7',
                                'e' => '8'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMP':
                            $template['soal'] = "Pemilu untuk memilih anggota DPR dilaksanakan pada tahun...";
                            $template['jawaban'] = [
                                'a' => '2024',
                                'b' => '2023',
                                'c' => '2025',
                                'd' => '2026',
                                'e' => '2027'
                            ];
                            $template['benar'] = 'a';
                            break;
                        case 'SMA':
                            $template['soal'] = "Pemilu untuk memilih Presiden dan Wakil Presiden dilaksanakan pada tahun...";
                            $template['jawaban'] = [
                                'a' => '2024',
                                'b' => '2023',
                                'c' => '2025',
                                'd' => '2026',
                                'e' => '2027'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalSeniBudaya($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Seni Rupa':
                if ($subTopik == 'Unsur Seni Rupa' || $key == 'Unsur Seni Rupa') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan unsur seni rupa adalah...";
                            $template['jawaban'] = [
                                'a' => 'Garis, warna, dan bentuk',
                                'b' => 'Suara, nada, dan irama',
                                'c' => 'Gerak, tari, dan musik',
                                'd' => 'Kata, kalimat, dan paragraf',
                                'e' => 'Angka, huruf, dan simbol'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Teknik Menggambar' || $key == 'Teknik Menggambar') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Teknik menggambar dengan cara menorehkan pensil secara berulang-ulang disebut...";
                            $template['jawaban'] = [
                                'a' => 'Arsir',
                                'b' => 'Blok',
                                'c' => 'Pointilis',
                                'd' => 'Dusel',
                                'e' => 'Aquarel'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Seni Musik':
                if ($subTopik == 'Alat Musik' || $key == 'Alat Musik') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan alat musik tiup adalah...";
                            $template['jawaban'] = [
                                'a' => 'Seruling',
                                'b' => 'Gitar',
                                'c' => 'Drum',
                                'd' => 'Piano',
                                'e' => 'Biola'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Notasi' || $key == 'Notasi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Notasi yang berbunyi 'do' ditulis dengan huruf...";
                            $template['jawaban'] = [
                                'a' => 'C',
                                'b' => 'D',
                                'c' => 'E',
                                'd' => 'F',
                                'e' => 'G'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Seni Tari':
                if ($subTopik == 'Gerak Tari' || $key == 'Gerak Tari') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Gerakan mengangkat tangan ke atas termasuk gerak tari...";
                            $template['jawaban'] = [
                                'a' => 'Atas',
                                'b' => 'Bawah',
                                'c' => 'Samping',
                                'd' => 'Depan',
                                'e' => 'Belakang'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Tari Daerah' || $key == 'Tari Daerah') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Tari Saman berasal dari provinsi...";
                            $template['jawaban'] = [
                                'a' => 'Aceh',
                                'b' => 'Sumatera Utara',
                                'c' => 'Sumatera Barat',
                                'd' => 'Riau',
                                'e' => 'Jambi'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Seni Teater':
                if ($subTopik == 'Unsur Teater' || $key == 'Unsur Teater') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan unsur teater adalah...";
                            $template['jawaban'] = [
                                'a' => 'Aktor, naskah, dan panggung',
                                'b' => 'Pensil, kertas, dan cat',
                                'c' => 'Gitar, drum, dan piano',
                                'd' => 'Kostum, rias, dan properti',
                                'e' => 'Lampu, suara, dan musik'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Drama' || $key == 'Drama') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Orang yang memerankan tokoh dalam drama disebut...";
                            $template['jawaban'] = [
                                'a' => 'Aktor',
                                'b' => 'Sutradara',
                                'c' => 'Penulis',
                                'd' => 'Penonton',
                                'e' => 'Kru'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalPJOK($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Olahraga':
                if ($subTopik == 'Sepak Bola' || $key == 'Sepak Bola') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Dalam permainan sepak bola, jumlah pemain dalam satu tim adalah...";
                            $template['jawaban'] = [
                                'a' => '11',
                                'b' => '10',
                                'c' => '12',
                                'd' => '9',
                                'e' => '13'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Basket' || $key == 'Basket') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Dalam permainan basket, jumlah pemain dalam satu tim adalah...";
                            $template['jawaban'] = [
                                'a' => '5',
                                'b' => '4',
                                'c' => '6',
                                'd' => '7',
                                'e' => '8'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kesehatan':
                if ($subTopik == 'Makanan Sehat' || $key == 'Makanan Sehat') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh makanan sehat adalah...";
                            $template['jawaban'] = [
                                'a' => 'Sayur dan buah',
                                'b' => 'Mie instan',
                                'c' => 'Minuman bersoda',
                                'd' => 'Makanan cepat saji',
                                'e' => 'Makanan berlemak'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Kebersihan' || $key == 'Kebersihan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan cara menjaga kebersihan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mencuci tangan sebelum makan',
                                'b' => 'Membuang sampah sembarangan',
                                'c' => 'Tidak mandi',
                                'd' => 'Tidak gosok gigi',
                                'e' => 'Tidak cuci tangan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kebugaran':
                if ($subTopik == 'Senam' || $key == 'Senam') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan gerakan senam lantai adalah...";
                            $template['jawaban'] = [
                                'a' => 'Roll depan',
                                'b' => 'Lari',
                                'c' => 'Lompat',
                                'd' => 'Jalan',
                                'e' => 'Berjalan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Pemanasan' || $key == 'Pemanasan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan gerakan pemanasan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menggerakkan leher',
                                'b' => 'Lari cepat',
                                'c' => 'Lompat tinggi',
                                'd' => 'Push up',
                                'e' => 'Sit up'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Renang':
                if ($subTopik == 'Gaya Renang' || $key == 'Gaya Renang') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan gaya renang adalah...";
                            $template['jawaban'] = [
                                'a' => 'Gaya bebas',
                                'b' => 'Gaya lari',
                                'c' => 'Gaya jalan',
                                'd' => 'Gaya duduk',
                                'e' => 'Gaya berdiri'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Perlengkapan' || $key == 'Perlengkapan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan perlengkapan renang adalah...";
                            $template['jawaban'] = [
                                'a' => 'Kacamata renang',
                                'b' => 'Sepatu',
                                'c' => 'Topi',
                                'd' => 'Sarung tangan',
                                'e' => 'Kaos kaki'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalEkonomi($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Konsep':
                if ($subTopik == 'Konsep dasar ilmu ekonomi' || $key == 'Konsep dasar ilmu ekonomi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Ilmu ekonomi yang mempelajari perilaku ekonomi secara keseluruhan disebut...";
                            $template['jawaban'] = [
                                'a' => 'Makroekonomi',
                                'b' => 'Mikroekonomi',
                                'c' => 'Ekonomi internasional',
                                'd' => 'Ekonomi pembangunan',
                                'e' => 'Ekonomi moneter'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Pasar':
                if ($subTopik == 'Pasar dan harga' || $key == 'Pasar dan harga') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Pasar yang memperjualbelikan surat berharga disebut...";
                            $template['jawaban'] = [
                                'a' => 'Pasar modal',
                                'b' => 'Pasar uang',
                                'c' => 'Pasar valuta asing',
                                'd' => 'Pasar komoditas',
                                'e' => 'Pasar tenaga kerja'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kebijakan':
                if ($subTopik == 'Kebijakan moneter dan fiskal' || $key == 'Kebijakan moneter dan fiskal') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Kebijakan moneter yang dilakukan dengan menjual SBI disebut...";
                            $template['jawaban'] = [
                                'a' => 'Operasi pasar terbuka',
                                'b' => 'Kebijakan diskonto',
                                'c' => 'Kebijakan cadangan wajib',
                                'd' => 'Kebijakan kredit selektif',
                                'e' => 'Kebijakan devaluasi'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalSosiologi($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Struktur':
                if ($subTopik == 'Struktur sosial dan diferensiasi' || $key == 'Struktur sosial dan diferensiasi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Pengelompokan masyarakat berdasarkan profesi disebut...";
                            $template['jawaban'] = [
                                'a' => 'Diferensiasi sosial',
                                'b' => 'Stratifikasi sosial',
                                'c' => 'Mobilitas sosial',
                                'd' => 'Struktur sosial',
                                'e' => 'Perubahan sosial'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Konflik':
                if ($subTopik == 'Konflik dan integrasi sosial' || $key == 'Konflik dan integrasi sosial') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Konflik yang terjadi antar kelompok disebut...";
                            $template['jawaban'] = [
                                'a' => 'Konflik horizontal',
                                'b' => 'Konflik vertikal',
                                'c' => 'Konflik diagonal',
                                'd' => 'Konflik internal',
                                'e' => 'Konflik eksternal'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Perubahan':
                if ($subTopik == 'Perubahan sosial dan modernisasi' || $key == 'Perubahan sosial dan modernisasi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Perubahan sosial yang terjadi secara cepat disebut...";
                            $template['jawaban'] = [
                                'a' => 'Revolusi',
                                'b' => 'Evolusi',
                                'c' => 'Reformasi',
                                'd' => 'Regenerasi',
                                'e' => 'Transformasi'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalFisika($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Mekanika':
                if ($subTopik == 'Kinematika' || $key == 'Kinematika') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung kecepatan adalah...",
                                    'jawaban' => [
                                        'a' => 'v = s/t',
                                        'b' => 'v = t/s',
                                        'c' => 'v = s × t',
                                        'd' => 'v = s + t',
                                        'e' => 'v = s - t'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung percepatan adalah...",
                                    'jawaban' => [
                                        'a' => 'a = Δv/Δt',
                                        'b' => 'a = v/t',
                                        'c' => 'a = s/t²',
                                        'd' => 'a = v²/s',
                                        'e' => 'a = s/v'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung kecepatan rata-rata adalah...",
                                    'jawaban' => [
                                        'a' => 'v = (v₁ + v₂)/2',
                                        'b' => 'v = v₁ + v₂',
                                        'c' => 'v = v₁ × v₂',
                                        'd' => 'v = v₁ - v₂',
                                        'e' => 'v = v₁/v₂'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Dinamika' || $key == 'Dinamika') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung gaya adalah...",
                                    'jawaban' => [
                                        'a' => 'F = m × a',
                                        'b' => 'F = m ÷ a',
                                        'c' => 'F = m + a',
                                        'd' => 'F = m - a',
                                        'e' => 'F = m² × a'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Hukum Newton I menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Benda akan tetap diam atau bergerak lurus beraturan jika tidak ada gaya yang bekerja',
                                        'b' => 'Percepatan berbanding lurus dengan gaya dan berbanding terbalik dengan massa',
                                        'c' => 'Setiap aksi akan menimbulkan reaksi yang sama besar dan berlawanan arah',
                                        'd' => 'Gaya sama dengan massa kali percepatan',
                                        'e' => 'Energi tidak dapat diciptakan atau dimusnahkan'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Hukum Newton II menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Percepatan berbanding lurus dengan gaya dan berbanding terbalik dengan massa',
                                        'b' => 'Benda akan tetap diam atau bergerak lurus beraturan jika tidak ada gaya yang bekerja',
                                        'c' => 'Setiap aksi akan menimbulkan reaksi yang sama besar dan berlawanan arah',
                                        'd' => 'Gaya sama dengan massa kali percepatan',
                                        'e' => 'Energi tidak dapat diciptakan atau dimusnahkan'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Energi' || $key == 'Energi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung energi kinetik adalah...",
                                    'jawaban' => [
                                        'a' => 'Ek = ½mv²',
                                        'b' => 'Ek = mv',
                                        'c' => 'Ek = mgh',
                                        'd' => 'Ek = Fs',
                                        'e' => 'Ek = Pt'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung energi potensial gravitasi adalah...",
                                    'jawaban' => [
                                        'a' => 'Ep = mgh',
                                        'b' => 'Ep = ½mv²',
                                        'c' => 'Ep = Fs',
                                        'd' => 'Ep = Pt',
                                        'e' => 'Ep = mv'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Hukum kekekalan energi menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Energi tidak dapat diciptakan atau dimusnahkan, hanya berubah bentuk',
                                        'b' => 'Energi selalu bertambah dalam setiap proses',
                                        'c' => 'Energi selalu berkurang dalam setiap proses',
                                        'd' => 'Energi dapat diciptakan dari ketiadaan',
                                        'e' => 'Energi dapat dimusnahkan menjadi ketiadaan'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Momentum' || $key == 'Momentum') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung momentum adalah...",
                                    'jawaban' => [
                                        'a' => 'p = mv',
                                        'b' => 'p = m/v',
                                        'c' => 'p = m + v',
                                        'd' => 'p = m - v',
                                        'e' => 'p = m²v'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung impuls adalah...",
                                    'jawaban' => [
                                        'a' => 'I = FΔt',
                                        'b' => 'I = F/Δt',
                                        'c' => 'I = F + Δt',
                                        'd' => 'I = F - Δt',
                                        'e' => 'I = F²Δt'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Hukum kekekalan momentum menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Momentum total sistem tertutup tetap konstan',
                                        'b' => 'Momentum selalu bertambah dalam setiap tumbukan',
                                        'c' => 'Momentum selalu berkurang dalam setiap tumbukan',
                                        'd' => 'Momentum dapat diciptakan dalam tumbukan',
                                        'e' => 'Momentum dapat dimusnahkan dalam tumbukan'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Tumbukan' || $key == 'Tumbukan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Tumbukan elastis adalah tumbukan yang...",
                                    'jawaban' => [
                                        'a' => 'Energi kinetiknya kekal',
                                        'b' => 'Energi kinetiknya tidak kekal',
                                        'c' => 'Momentumnya tidak kekal',
                                        'd' => 'Kedua benda menyatu setelah tumbukan',
                                        'e' => 'Salah satu benda berhenti setelah tumbukan'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Tumbukan tidak elastis adalah tumbukan yang...",
                                    'jawaban' => [
                                        'a' => 'Energi kinetiknya tidak kekal',
                                        'b' => 'Energi kinetiknya kekal',
                                        'c' => 'Momentumnya tidak kekal',
                                        'd' => 'Kedua benda terpisah setelah tumbukan',
                                        'e' => 'Kedua benda bergerak dengan kecepatan sama'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Gerak Melingkar' || $key == 'Gerak Melingkar') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung kecepatan sudut adalah...",
                                    'jawaban' => [
                                        'a' => 'ω = θ/t',
                                        'b' => 'ω = t/θ',
                                        'c' => 'ω = θ × t',
                                        'd' => 'ω = θ + t',
                                        'e' => 'ω = θ - t'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung percepatan sentripetal adalah...",
                                    'jawaban' => [
                                        'a' => 'as = v²/r',
                                        'b' => 'as = v/r',
                                        'c' => 'as = v × r',
                                        'd' => 'as = v + r',
                                        'e' => 'as = v - r'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Gravitasi' || $key == 'Gravitasi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Hukum gravitasi Newton menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Gaya gravitasi berbanding lurus dengan massa dan berbanding terbalik dengan kuadrat jarak',
                                        'b' => 'Gaya gravitasi berbanding terbalik dengan massa dan berbanding lurus dengan kuadrat jarak',
                                        'c' => 'Gaya gravitasi berbanding lurus dengan massa dan jarak',
                                        'd' => 'Gaya gravitasi berbanding terbalik dengan massa dan jarak',
                                        'e' => 'Gaya gravitasi tidak bergantung pada massa dan jarak'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung gaya gravitasi adalah...",
                                    'jawaban' => [
                                        'a' => 'F = G(m₁m₂)/r²',
                                        'b' => 'F = G(m₁ + m₂)/r²',
                                        'c' => 'F = G(m₁m₂)/r',
                                        'd' => 'F = G(m₁ + m₂)/r',
                                        'e' => 'F = G(m₁m₂)r²'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Usaha' || $key == 'Usaha') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung usaha adalah...",
                                    'jawaban' => [
                                        'a' => 'W = Fs cos θ',
                                        'b' => 'W = Fs sin θ',
                                        'c' => 'W = Fs tan θ',
                                        'd' => 'W = F + s',
                                        'e' => 'W = F - s'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung daya adalah...",
                                    'jawaban' => [
                                        'a' => 'P = W/t',
                                        'b' => 'P = t/W',
                                        'c' => 'P = W × t',
                                        'd' => 'P = W + t',
                                        'e' => 'P = W - t'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Fluida':
                if ($subTopik == 'Tekanan' || $key == 'Tekanan' ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung tekanan adalah...",
                                    'jawaban' => [
                                        'a' => 'P = F/A',
                                        'b' => 'P = A/F',
                                        'c' => 'P = F × A',
                                        'd' => 'P = F + A',
                                        'e' => 'P = F - A'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung tekanan hidrostatis adalah...",
                                    'jawaban' => [
                                        'a' => 'P = ρgh',
                                        'b' => 'P = ρg/h',
                                        'c' => 'P = ρ + gh',
                                        'd' => 'P = ρ - gh',
                                        'e' => 'P = ρgh²'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Hukum Pascal' || $key == 'Hukum Pascal') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Hukum Pascal menyatakan bahwa...";
                            $template['jawaban'] = [
                                'a' => 'Tekanan yang diberikan pada fluida dalam ruang tertutup diteruskan sama besar ke segala arah',
                                'b' => 'Tekanan berbanding lurus dengan kedalaman',
                                'c' => 'Tekanan berbanding terbalik dengan luas permukaan',
                                'd' => 'Tekanan tidak bergantung pada jenis fluida',
                                'e' => 'Tekanan selalu konstan dalam fluida'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Hukum Archimedes' || $key == 'Hukum Archimedes') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Hukum Archimedes menyatakan bahwa...";
                            $template['jawaban'] = [
                                'a' => 'Gaya apung sama dengan berat fluida yang dipindahkan',
                                'b' => 'Gaya apung sama dengan berat benda',
                                'c' => 'Gaya apung berbanding lurus dengan volume benda',
                                'd' => 'Gaya apung tidak bergantung pada jenis fluida',
                                'e' => 'Gaya apung selalu konstan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Termodinamika':
                if ($subTopik == 'Suhu' || $key == 'Suhu') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung kalor adalah...",
                                    'jawaban' => [
                                        'a' => 'Q = mcΔT',
                                        'b' => 'Q = m/cΔT',
                                        'c' => 'Q = m + cΔT',
                                        'd' => 'Q = m - cΔT',
                                        'e' => 'Q = mc/ΔT'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Satuan SI untuk suhu adalah...",
                                    'jawaban' => [
                                        'a' => 'Kelvin',
                                        'b' => 'Celsius',
                                        'c' => 'Fahrenheit',
                                        'd' => 'Reamur',
                                        'e' => 'Rankine'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                } elseif ($subTopik == 'Hukum Termodinamika' || $key == 'Hukum Termodinamika') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Hukum Termodinamika I menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Energi dalam sistem tertutup adalah kekal',
                                        'b' => 'Entropi sistem tertutup selalu bertambah',
                                        'c' => 'Tidak ada mesin yang efisiensinya 100%',
                                        'd' => 'Kalor mengalir dari benda panas ke benda dingin',
                                        'e' => 'Energi tidak dapat diubah bentuknya'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Hukum Termodinamika II menyatakan bahwa...",
                                    'jawaban' => [
                                        'a' => 'Entropi sistem tertutup selalu bertambah',
                                        'b' => 'Energi dalam sistem tertutup adalah kekal',
                                        'c' => 'Kalor mengalir dari benda dingin ke benda panas',
                                        'd' => 'Tidak ada mesin yang efisiensinya 100%',
                                        'e' => 'Energi dapat diciptakan dari ketiadaan'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Gelombang':
                if ($subTopik == 'Gelombang Mekanik' || $key == 'Gelombang Mekanik') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung kecepatan gelombang adalah...",
                                    'jawaban' => [
                                        'a' => 'v = λf',
                                        'b' => 'v = λ/f',
                                        'c' => 'v = λ + f',
                                        'd' => 'v = λ - f',
                                        'e' => 'v = λ²f'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung frekuensi adalah...",
                                    'jawaban' => [
                                        'a' => 'f = 1/T',
                                        'b' => 'f = T',
                                        'c' => 'f = 1 + T',
                                        'd' => 'f = 1 - T',
                                        'e' => 'f = T²'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Listrik':
                if ($subTopik == 'Arus Listrik' || $key == 'Arus Listrik') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Satuan SI untuk kuat arus listrik adalah...";
                            $template['jawaban'] = [
                                'a' => 'Ampere',
                                'b' => 'Volt',
                                'c' => 'Watt',
                                'd' => 'Ohm',
                                'e' => 'Coulomb'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Tegangan' || $key == 'Tegangan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Satuan SI untuk tegangan listrik adalah...";
                            $template['jawaban'] = [
                                'a' => 'Volt',
                                'b' => 'Ampere',
                                'c' => 'Watt',
                                'd' => 'Ohm',
                                'e' => 'Coulomb'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Hambatan' || $key == 'Hambatan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $questions = [
                                [
                                    'soal' => "Rumus untuk menghitung hambatan adalah...",
                                    'jawaban' => [
                                        'a' => 'R = V/I',
                                        'b' => 'R = I/V',
                                        'c' => 'R = V × I',
                                        'd' => 'R = V + I',
                                        'e' => 'R = V - I'
                                    ],
                                    'benar' => 'a'
                                ],
                                [
                                    'soal' => "Rumus untuk menghitung hambatan seri adalah...",
                                    'jawaban' => [
                                        'a' => 'R = R₁ + R₂ + R₃',
                                        'b' => 'R = 1/R₁ + 1/R₂ + 1/R₃',
                                        'c' => 'R = R₁ × R₂ × R₃',
                                        'd' => 'R = R₁/R₂/R₃',
                                        'e' => 'R = R₁ - R₂ - R₃'
                                    ],
                                    'benar' => 'a'
                                ]
                            ];
                            $selectedQuestion = $questions[array_rand($questions)];
                            $template['soal'] = $selectedQuestion['soal'];
                            $template['jawaban'] = $selectedQuestion['jawaban'];
                            $template['benar'] = $selectedQuestion['benar'];
                            break;
                    }
                }
                break;
            case 'Fisika Modern':
                if ($subTopik == 'Relativitas' || $key == 'Relativitas') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Teori relativitas Einstein menyatakan bahwa...";
                            $template['jawaban'] = [
                                'a' => 'Kecepatan cahaya adalah konstan dan tidak bergantung pada pengamat',
                                'b' => 'Kecepatan cahaya berubah tergantung pada pengamat',
                                'c' => 'Waktu dan ruang adalah absolut',
                                'd' => 'Massa tidak berubah dengan kecepatan',
                                'e' => 'Energi tidak setara dengan massa'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Foton' || $key == 'Foton'   ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Rumus untuk menghitung energi foton adalah...";
                            $template['jawaban'] = [
                                'a' => 'E = hf',
                                'b' => 'E = h/f',
                                'c' => 'E = h + f',
                                'd' => 'E = h - f',
                                'e' => 'E = h²f'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalKimia($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Struktur Atom':
                if ($subTopik == 'Konfigurasi Elektron' || $key == 'Konfigurasi Elektron') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Jumlah elektron maksimum pada kulit K adalah...";
                                    $template['jawaban'] = [
                                        'a' => '2',
                                        'b' => '8',
                                        'c' => '18',
                                        'd' => '32',
                                        'e' => '50'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Jumlah elektron maksimum pada kulit L adalah...";
                                    $template['jawaban'] = [
                                        'a' => '8',
                                        'b' => '2',
                                        'c' => '18',
                                        'd' => '32',
                                        'e' => '50'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Konfigurasi elektron atom natrium (Na) adalah...";
                                    $template['jawaban'] = [
                                        'a' => '2, 8, 1',
                                        'b' => '2, 8, 2',
                                        'c' => '2, 8, 8, 1',
                                        'd' => '2, 8, 8, 2',
                                        'e' => '2, 8, 8, 8, 1'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Elektron valensi adalah elektron yang berada di...";
                                    $template['jawaban'] = [
                                        'a' => 'Kulit terluar',
                                        'b' => 'Kulit terdalam',
                                        'c' => 'Kulit tengah',
                                        'd' => 'Inti atom',
                                        'e' => 'Orbital s'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Jumlah elektron maksimum pada kulit M adalah...";
                                    $template['jawaban'] = [
                                        'a' => '18',
                                        'b' => '8',
                                        'c' => '32',
                                        'd' => '2',
                                        'e' => '50'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Sistem Periodik' || $key == 'Sistem Periodik') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Unsur yang memiliki nomor atom 1 adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Hidrogen',
                                        'b' => 'Helium',
                                        'c' => 'Litium',
                                        'd' => 'Berilium',
                                        'e' => 'Boron'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Unsur yang memiliki nomor atom 2 adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Helium',
                                        'b' => 'Hidrogen',
                                        'c' => 'Litium',
                                        'd' => 'Berilium',
                                        'e' => 'Boron'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Golongan alkali tanah berada di golongan...";
                                    $template['jawaban'] = [
                                        'a' => 'IIA',
                                        'b' => 'IA',
                                        'c' => 'IIIA',
                                        'd' => 'IVA',
                                        'e' => 'VA'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Golongan halogen berada di golongan...";
                                    $template['jawaban'] = [
                                        'a' => 'VIIA',
                                        'b' => 'VIA',
                                        'c' => 'VIIIA',
                                        'd' => 'VA',
                                        'e' => 'IVA'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Golongan gas mulia berada di golongan...";
                                    $template['jawaban'] = [
                                        'a' => 'VIIIA',
                                        'b' => 'VIIA',
                                        'c' => 'VIA',
                                        'd' => 'VA',
                                        'e' => 'IVA'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Ikatan Kimia' || $key == 'Ikatan Kimia') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Ikatan yang terjadi karena serah terima elektron disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Ikatan ion',
                                        'b' => 'Ikatan kovalen',
                                        'c' => 'Ikatan hidrogen',
                                        'd' => 'Ikatan van der Waals',
                                        'e' => 'Ikatan logam'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Ikatan yang terjadi karena penggunaan bersama pasangan elektron disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Ikatan kovalen',
                                        'b' => 'Ikatan ion',
                                        'c' => 'Ikatan hidrogen',
                                        'd' => 'Ikatan van der Waals',
                                        'e' => 'Ikatan logam'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Molekul H₂O memiliki ikatan...";
                                    $template['jawaban'] = [
                                        'a' => 'Kovalen polar',
                                        'b' => 'Kovalen nonpolar',
                                        'c' => 'Ion',
                                        'd' => 'Hidrogen',
                                        'e' => 'Van der Waals'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Molekul O₂ memiliki ikatan...";
                                    $template['jawaban'] = [
                                        'a' => 'Kovalen nonpolar',
                                        'b' => 'Kovalen polar',
                                        'c' => 'Ion',
                                        'd' => 'Hidrogen',
                                        'e' => 'Van der Waals'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Ikatan yang terjadi antara atom H dan O dalam air disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Ikatan hidrogen',
                                        'b' => 'Ikatan kovalen',
                                        'c' => 'Ikatan ion',
                                        'd' => 'Ikatan van der Waals',
                                        'e' => 'Ikatan logam'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
            case 'Reaksi Kimia':
                if ($subTopik == 'Persamaan Reaksi' || $key == 'Persamaan Reaksi'   ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Rumus kimia untuk air adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'H₂O',
                                        'b' => 'CO₂',
                                        'c' => 'O₂',
                                        'd' => 'H₂',
                                        'e' => 'H₂O₂'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Rumus kimia untuk karbon dioksida adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'CO₂',
                                        'b' => 'H₂O',
                                        'c' => 'O₂',
                                        'd' => 'H₂',
                                        'e' => 'CO'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Rumus kimia untuk asam sulfat adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'H₂SO₄',
                                        'b' => 'HCl',
                                        'c' => 'HNO₃',
                                        'd' => 'H₃PO₄',
                                        'e' => 'H₂CO₃'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Rumus kimia untuk natrium hidroksida adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'NaOH',
                                        'b' => 'KOH',
                                        'c' => 'Ca(OH)₂',
                                        'd' => 'Mg(OH)₂',
                                        'e' => 'Al(OH)₃'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Rumus kimia untuk natrium klorida adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'NaCl',
                                        'b' => 'KCl',
                                        'c' => 'CaCl₂',
                                        'd' => 'MgCl₂',
                                        'e' => 'AlCl₃'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Stoikiometri' || $key == 'Stoikiometri') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Satuan untuk jumlah zat dalam SI adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Mol',
                                        'b' => 'Gram',
                                        'c' => 'Liter',
                                        'd' => 'Meter',
                                        'e' => 'Detik'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Bilangan Avogadro adalah...";
                                    $template['jawaban'] = [
                                        'a' => '6,02 × 10²³',
                                        'b' => '6,02 × 10²²',
                                        'c' => '6,02 × 10²⁴',
                                        'd' => '6,02 × 10²¹',
                                        'e' => '6,02 × 10²⁰'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Massa molar adalah massa...";
                                    $template['jawaban'] = [
                                        'a' => '1 mol zat',
                                        'b' => '1 gram zat',
                                        'c' => '1 liter zat',
                                        'd' => '1 atom zat',
                                        'e' => '1 molekul zat'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Volume molar gas pada STP adalah...";
                                    $template['jawaban'] = [
                                        'a' => '22,4 L',
                                        'b' => '24,5 L',
                                        'c' => '20,0 L',
                                        'd' => '25,0 L',
                                        'e' => '21,0 L'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Rumus untuk menghitung jumlah mol adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'n = m/Mr',
                                        'b' => 'n = m/V',
                                        'c' => 'n = V/22,4',
                                        'd' => 'n = P/RT',
                                        'e' => 'n = cV'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Laju Reaksi' || $key == 'Laju Reaksi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Faktor yang mempengaruhi laju reaksi adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Konsentrasi pereaksi',
                                        'b' => 'Warna pereaksi',
                                        'c' => 'Bentuk wadah',
                                        'd' => 'Ukuran wadah',
                                        'e' => 'Jenis wadah'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Katalis adalah zat yang...";
                                    $template['jawaban'] = [
                                        'a' => 'Mempercepat reaksi tanpa ikut bereaksi',
                                        'b' => 'Memperlambat reaksi',
                                        'c' => 'Menghentikan reaksi',
                                        'd' => 'Mengubah hasil reaksi',
                                        'e' => 'Mengurangi hasil reaksi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Semakin tinggi suhu, laju reaksi akan...";
                                    $template['jawaban'] = [
                                        'a' => 'Semakin cepat',
                                        'b' => 'Semakin lambat',
                                        'c' => 'Tetap',
                                        'd' => 'Tidak teratur',
                                        'e' => 'Berhenti'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Semakin besar luas permukaan, laju reaksi akan...";
                                    $template['jawaban'] = [
                                        'a' => 'Semakin cepat',
                                        'b' => 'Semakin lambat',
                                        'c' => 'Tetap',
                                        'd' => 'Tidak teratur',
                                        'e' => 'Berhenti'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Satuan laju reaksi adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'M/s',
                                        'b' => 'M/s²',
                                        'c' => 'M²/s',
                                        'd' => 'M/s³',
                                        'e' => 'M³/s'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
            case 'Larutan':
                if ($subTopik == 'Konsentrasi Larutan' || $key == 'Konsentrasi Larutan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Konsentrasi molar adalah jumlah mol zat terlarut dalam...";
                                    $template['jawaban'] = [
                                        'a' => '1 liter larutan',
                                        'b' => '1 liter pelarut',
                                        'c' => '1 kg larutan',
                                        'd' => '1 kg pelarut',
                                        'e' => '1 mol pelarut'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Satuan konsentrasi molar adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Molar (M)',
                                        'b' => 'Molal (m)',
                                        'c' => 'Normal (N)',
                                        'd' => 'Persen (%)',
                                        'e' => 'Ppm'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Konsentrasi molal adalah jumlah mol zat terlarut dalam...";
                                    $template['jawaban'] = [
                                        'a' => '1 kg pelarut',
                                        'b' => '1 liter larutan',
                                        'c' => '1 liter pelarut',
                                        'd' => '1 kg larutan',
                                        'e' => '1 mol pelarut'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Rumus untuk menghitung molaritas adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'M = n/V',
                                        'b' => 'M = m/V',
                                        'c' => 'M = n/m',
                                        'd' => 'M = V/n',
                                        'e' => 'M = m/n'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Rumus untuk menghitung molalitas adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'm = n/kg pelarut',
                                        'b' => 'm = n/V',
                                        'c' => 'm = m/V',
                                        'd' => 'm = V/n',
                                        'e' => 'm = kg pelarut/n'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Asam Basa' || $key == 'Asam Basa'   ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "pH larutan asam adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Kurang dari 7',
                                        'b' => 'Lebih dari 7',
                                        'c' => 'Sama dengan 7',
                                        'd' => 'Sama dengan 0',
                                        'e' => 'Sama dengan 14'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "pH larutan basa adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Lebih dari 7',
                                        'b' => 'Kurang dari 7',
                                        'c' => 'Sama dengan 7',
                                        'd' => 'Sama dengan 0',
                                        'e' => 'Sama dengan 14'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "pH larutan netral adalah...";
                                    $template['jawaban'] = [
                                        'a' => '7',
                                        'b' => '0',
                                        'c' => '14',
                                        'd' => '1',
                                        'e' => '13'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Rumus pH adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'pH = -log[H⁺]',
                                        'b' => 'pH = log[H⁺]',
                                        'c' => 'pH = [H⁺]',
                                        'd' => 'pH = 1/[H⁺]',
                                        'e' => 'pH = [H⁺]²'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Rumus pOH adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'pOH = -log[OH⁻]',
                                        'b' => 'pOH = log[OH⁻]',
                                        'c' => 'pOH = [OH⁻]',
                                        'd' => 'pOH = 1/[OH⁻]',
                                        'e' => 'pOH = [OH⁻]²'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalBiologi($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Sel':
                if ($subTopik == 'Struktur dan fungsi sel' || $key == 'Struktur dan fungsi sel') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Organel sel yang berfungsi sebagai tempat respirasi sel adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Mitokondria',
                                        'b' => 'Ribosom',
                                        'c' => 'Lisosom',
                                        'd' => 'Vakuola',
                                        'e' => 'Nukleus'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Organel sel yang berfungsi sebagai tempat sintesis protein adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Ribosom',
                                        'b' => 'Mitokondria',
                                        'c' => 'Lisosom',
                                        'd' => 'Vakuola',
                                        'e' => 'Nukleus'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Organel sel yang berfungsi sebagai pusat kendali sel adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Nukleus',
                                        'b' => 'Mitokondria',
                                        'c' => 'Ribosom',
                                        'd' => 'Lisosom',
                                        'e' => 'Vakuola'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Organel sel yang berfungsi sebagai sistem pencernaan sel adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Lisosom',
                                        'b' => 'Mitokondria',
                                        'c' => 'Ribosom',
                                        'd' => 'Vakuola',
                                        'e' => 'Nukleus'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Organel sel yang berfungsi sebagai tempat penyimpanan adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Vakuola',
                                        'b' => 'Mitokondria',
                                        'c' => 'Ribosom',
                                        'd' => 'Lisosom',
                                        'e' => 'Nukleus'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Pembelahan sel' || $key == 'Pembelahan sel') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Pembelahan sel yang menghasilkan dua sel anak yang identik disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Mitosis',
                                        'b' => 'Meiosis',
                                        'c' => 'Amitosis',
                                        'd' => 'Endomitosis',
                                        'e' => 'Politen'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Pembelahan sel yang menghasilkan empat sel anak dengan setengah kromosom disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Meiosis',
                                        'b' => 'Mitosis',
                                        'c' => 'Amitosis',
                                        'd' => 'Endomitosis',
                                        'e' => 'Politen'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Tahap pembelahan sel dimana kromosom menebal dan memendek disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Profase',
                                        'b' => 'Metafase',
                                        'c' => 'Anafase',
                                        'd' => 'Telofase',
                                        'e' => 'Interfase'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Tahap pembelahan sel dimana kromosom berjajar di bidang ekuator disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Metafase',
                                        'b' => 'Profase',
                                        'c' => 'Anafase',
                                        'd' => 'Telofase',
                                        'e' => 'Interfase'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Tahap pembelahan sel dimana kromatid berpisah ke kutub berlawanan disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Anafase',
                                        'b' => 'Profase',
                                        'c' => 'Metafase',
                                        'd' => 'Telofase',
                                        'e' => 'Interfase'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Transportasi sel' || $key == 'Transportasi sel') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Transportasi yang memerlukan energi disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Transportasi aktif',
                                        'b' => 'Transportasi pasif',
                                        'c' => 'Difusi',
                                        'd' => 'Osmosis',
                                        'e' => 'Endositosis'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Perpindahan zat dari konsentrasi tinggi ke rendah disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Difusi',
                                        'b' => 'Osmosis',
                                        'c' => 'Transportasi aktif',
                                        'd' => 'Endositosis',
                                        'e' => 'Eksositosis'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Perpindahan air melalui membran semipermeabel disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Osmosis',
                                        'b' => 'Difusi',
                                        'c' => 'Transportasi aktif',
                                        'd' => 'Endositosis',
                                        'e' => 'Eksositosis'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Proses memasukkan zat ke dalam sel dengan membentuk vesikel disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Endositosis',
                                        'b' => 'Eksositosis',
                                        'c' => 'Difusi',
                                        'd' => 'Osmosis',
                                        'e' => 'Transportasi aktif'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Proses mengeluarkan zat dari sel dengan vesikel disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Eksositosis',
                                        'b' => 'Endositosis',
                                        'c' => 'Difusi',
                                        'd' => 'Osmosis',
                                        'e' => 'Transportasi aktif'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
            case 'Metabolisme':
                if ($subTopik == 'Fotosintesis' || $key == 'Fotosintesis'   ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Pigmen yang berperan dalam fotosintesis adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Klorofil',
                                        'b' => 'Hemoglobin',
                                        'c' => 'Melanin',
                                        'd' => 'Karoten',
                                        'e' => 'Xantofil'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Reaksi terang fotosintesis terjadi di...";
                                    $template['jawaban'] = [
                                        'a' => 'Grana',
                                        'b' => 'Stroma',
                                        'c' => 'Membran tilakoid',
                                        'd' => 'Matriks',
                                        'e' => 'Krista'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Reaksi gelap fotosintesis terjadi di...";
                                    $template['jawaban'] = [
                                        'a' => 'Stroma',
                                        'b' => 'Grana',
                                        'c' => 'Membran tilakoid',
                                        'd' => 'Matriks',
                                        'e' => 'Krista'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Hasil akhir fotosintesis adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Glukosa dan oksigen',
                                        'b' => 'Karbon dioksida dan air',
                                        'c' => 'ATP dan NADPH',
                                        'd' => 'Asam piruvat',
                                        'e' => 'Etanol'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Faktor yang mempengaruhi fotosintesis adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Intensitas cahaya',
                                        'b' => 'Warna daun',
                                        'c' => 'Ukuran daun',
                                        'd' => 'Bentuk daun',
                                        'e' => 'Tekstur daun'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Respirasi' || $key == 'Respirasi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Proses respirasi yang membutuhkan oksigen disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Aerob',
                                        'b' => 'Anaerob',
                                        'c' => 'Fermentasi',
                                        'd' => 'Glikolisis',
                                        'e' => 'Siklus Krebs'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Proses respirasi yang tidak membutuhkan oksigen disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Anaerob',
                                        'b' => 'Aerob',
                                        'c' => 'Oksidasi',
                                        'd' => 'Reduksi',
                                        'e' => 'Fosforilasi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Tahap pertama respirasi sel adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Glikolisis',
                                        'b' => 'Siklus Krebs',
                                        'c' => 'Rantai transpor elektron',
                                        'd' => 'Dekarboksilasi oksidatif',
                                        'e' => 'Fosforilasi oksidatif'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Tahap respirasi yang menghasilkan ATP terbanyak adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Rantai transpor elektron',
                                        'b' => 'Glikolisis',
                                        'c' => 'Siklus Krebs',
                                        'd' => 'Dekarboksilasi oksidatif',
                                        'e' => 'Fermentasi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Hasil akhir respirasi aerob adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'CO₂, H₂O, dan ATP',
                                        'b' => 'CO₂, H₂O, dan NADH',
                                        'c' => 'Asam laktat dan ATP',
                                        'd' => 'Etanol dan CO₂',
                                        'e' => 'Asam piruvat'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Enzim' || $key == 'Enzim') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Enzim adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Biokatalisator',
                                        'b' => 'Hormon',
                                        'c' => 'Vitamin',
                                        'd' => 'Mineral',
                                        'e' => 'Protein struktural'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Bagian enzim yang berikatan dengan substrat disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Sisi aktif',
                                        'b' => 'Kofaktor',
                                        'c' => 'Koenzim',
                                        'd' => 'Apoenzim',
                                        'e' => 'Holoenzim'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Faktor yang mempengaruhi kerja enzim adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Suhu',
                                        'b' => 'Warna substrat',
                                        'c' => 'Bentuk substrat',
                                        'd' => 'Ukuran substrat',
                                        'e' => 'Tekstur substrat'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Suhu optimum enzim manusia adalah...";
                                    $template['jawaban'] = [
                                        'a' => '37°C',
                                        'b' => '25°C',
                                        'c' => '50°C',
                                        'd' => '0°C',
                                        'e' => '100°C'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "pH optimum enzim pepsin adalah...";
                                    $template['jawaban'] = [
                                        'a' => '2',
                                        'b' => '7',
                                        'c' => '8',
                                        'd' => '10',
                                        'e' => '12'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
            case 'Genetika':
                if ($subTopik == 'Hukum Mendel' || $key == 'Hukum Mendel') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Hukum Mendel I menyatakan tentang...";
                                    $template['jawaban'] = [
                                        'a' => 'Pemisahan alel',
                                        'b' => 'Pengelompokan bebas',
                                        'c' => 'Dominansi',
                                        'd' => 'Resesivitas',
                                        'e' => 'Kodominansi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Hukum Mendel II menyatakan tentang...";
                                    $template['jawaban'] = [
                                        'a' => 'Pengelompokan bebas',
                                        'b' => 'Pemisahan alel',
                                        'c' => 'Dominansi',
                                        'd' => 'Resesivitas',
                                        'e' => 'Kodominansi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Genotipe homozigot dominan ditulis...";
                                    $template['jawaban'] = [
                                        'a' => 'AA',
                                        'b' => 'Aa',
                                        'c' => 'aa',
                                        'd' => 'AB',
                                        'e' => 'AO'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Genotipe heterozigot ditulis...";
                                    $template['jawaban'] = [
                                        'a' => 'Aa',
                                        'b' => 'AA',
                                        'c' => 'aa',
                                        'd' => 'AB',
                                        'e' => 'AO'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Genotipe homozigot resesif ditulis...";
                                    $template['jawaban'] = [
                                        'a' => 'aa',
                                        'b' => 'AA',
                                        'c' => 'Aa',
                                        'd' => 'AB',
                                        'e' => 'AO'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'DNA dan RNA' || $key == 'DNA dan RNA'   ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Basa nitrogen yang terdapat dalam DNA adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Adenin, Timin, Guanin, Sitosin',
                                        'b' => 'Adenin, Urasil, Guanin, Sitosin',
                                        'c' => 'Adenin, Timin, Guanin, Urasil',
                                        'd' => 'Timin, Urasil, Guanin, Sitosin',
                                        'e' => 'Adenin, Timin, Urasil, Sitosin'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Basa nitrogen yang terdapat dalam RNA adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Adenin, Urasil, Guanin, Sitosin',
                                        'b' => 'Adenin, Timin, Guanin, Sitosin',
                                        'c' => 'Adenin, Timin, Guanin, Urasil',
                                        'd' => 'Timin, Urasil, Guanin, Sitosin',
                                        'e' => 'Adenin, Timin, Urasil, Sitosin'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Struktur DNA berbentuk...";
                                    $template['jawaban'] = [
                                        'a' => 'Double helix',
                                        'b' => 'Single strand',
                                        'c' => 'Triple helix',
                                        'd' => 'Circular',
                                        'e' => 'Linear'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Proses sintesis protein terjadi di...";
                                    $template['jawaban'] = [
                                        'a' => 'Ribosom',
                                        'b' => 'Nukleus',
                                        'c' => 'Mitokondria',
                                        'd' => 'Lisosom',
                                        'e' => 'Vakuola'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Proses transkripsi terjadi di...";
                                    $template['jawaban'] = [
                                        'a' => 'Nukleus',
                                        'b' => 'Ribosom',
                                        'c' => 'Sitoplasma',
                                        'd' => 'Mitokondria',
                                        'e' => 'Lisosom'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
            case 'Evolusi':
                if ($subTopik == 'Teori Evolusi' || $key == 'Teori Evolusi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Bapak teori evolusi adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Charles Darwin',
                                        'b' => 'Jean Lamarck',
                                        'c' => 'Alfred Wallace',
                                        'd' => 'Gregor Mendel',
                                        'e' => 'Louis Pasteur'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Mekanisme evolusi yang utama adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Seleksi alam',
                                        'b' => 'Mutasi',
                                        'c' => 'Migrasi',
                                        'd' => 'Genetic drift',
                                        'e' => 'Non-random mating'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Perubahan frekuensi gen dalam populasi disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Evolusi',
                                        'b' => 'Adaptasi',
                                        'c' => 'Variasi',
                                        'd' => 'Mutasi',
                                        'e' => 'Seleksi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Bukti evolusi dari struktur tubuh adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Homologi',
                                        'b' => 'Analog',
                                        'c' => 'Vestigial',
                                        'd' => 'Embriologi',
                                        'e' => 'Fosil'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Organ yang tidak berfungsi disebut...";
                                    $template['jawaban'] = [
                                        'a' => 'Organ vestigial',
                                        'b' => 'Organ homolog',
                                        'c' => 'Organ analog',
                                        'd' => 'Organ rudimenter',
                                        'e' => 'Organ atavistik'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                } elseif ($subTopik == 'Adaptasi' || $key == 'Adaptasi') {
                    switch ($jenjang) {
                        case 'SMA':
                            $variasi = rand(1, 5);
                            switch ($variasi) {
                                case 1:
                                    $template['soal'] = "Adaptasi morfologi adalah penyesuaian bentuk...";
                                    $template['jawaban'] = [
                                        'a' => 'Tubuh',
                                        'b' => 'Fungsi',
                                        'c' => 'Perilaku',
                                        'd' => 'Fisiologi',
                                        'e' => 'Biokimia'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 2:
                                    $template['soal'] = "Adaptasi fisiologi adalah penyesuaian...";
                                    $template['jawaban'] = [
                                        'a' => 'Fungsi organ',
                                        'b' => 'Bentuk tubuh',
                                        'c' => 'Perilaku',
                                        'd' => 'Struktur',
                                        'e' => 'Anatomi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 3:
                                    $template['soal'] = "Adaptasi tingkah laku adalah penyesuaian...";
                                    $template['jawaban'] = [
                                        'a' => 'Perilaku',
                                        'b' => 'Bentuk tubuh',
                                        'c' => 'Fungsi organ',
                                        'd' => 'Struktur',
                                        'e' => 'Anatomi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 4:
                                    $template['soal'] = "Contoh adaptasi morfologi adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Paruh burung',
                                        'b' => 'Kemampuan berkamuflase',
                                        'c' => 'Kemampuan berhibernasi',
                                        'd' => 'Kemampuan mimikri',
                                        'e' => 'Kemampuan estivasi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                                case 5:
                                    $template['soal'] = "Contoh adaptasi fisiologi adalah...";
                                    $template['jawaban'] = [
                                        'a' => 'Kemampuan berhibernasi',
                                        'b' => 'Paruh burung',
                                        'c' => 'Kemampuan berkamuflase',
                                        'd' => 'Kemampuan mimikri',
                                        'e' => 'Kemampuan estivasi'
                                    ];
                                    $template['benar'] = 'a';
                                    break;
                            }
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalSejarah($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Peradaban':
                if ($subTopik == 'Peradaban awal dunia' || $key == 'Peradaban awal dunia') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Peradaban Mesopotamia berkembang di antara sungai...";
                            $template['jawaban'] = [
                                'a' => 'Tigris dan Efrat',
                                'b' => 'Nil dan Tigris',
                                'c' => 'Efrat dan Nil',
                                'd' => 'Gangga dan Indus',
                                'e' => 'Kuning dan Yangtze'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Peradaban kuno' || $key == 'Peradaban kuno') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Peradaban kuno yang terkenal dengan piramidanya adalah...";
                            $template['jawaban'] = [
                                'a' => 'Mesir',
                                'b' => 'Yunani',
                                'c' => 'Romawi',
                                'd' => 'Babilonia',
                                'e' => 'Persia'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kolonialisme':
                if ($subTopik == 'Kolonialisme dan imperialisme' || $key == 'Kolonialisme dan imperialisme') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "VOC dibubarkan pada tahun...";
                            $template['jawaban'] = [
                                'a' => '1799',
                                'b' => '1800',
                                'c' => '1798',
                                'd' => '1801',
                                'e' => '1797'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Perlawanan' || $key == 'Perlawanan') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Perang Diponegoro terjadi pada tahun...";
                            $template['jawaban'] = [
                                'a' => '1825-1830',
                                'b' => '1820-1825',
                                'c' => '1830-1835',
                                'd' => '1835-1840',
                                'e' => '1840-1845'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalGeografi($jenjang, $topik, $key, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Litosfer':
                if ($subTopik == 'Litosfer dan pedosfer' || $key == 'Litosfer dan pedosfer') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Batuan yang terbentuk dari proses pendinginan magma disebut...";
                            $template['jawaban'] = [
                                'a' => 'Batuan beku',
                                'b' => 'Batuan sedimen',
                                'c' => 'Batuan metamorf',
                                'd' => 'Batuan vulkanik',
                                'e' => 'Batuan plutonik'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Tenaga endogen' || $key == 'Tenaga endogen') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Tenaga yang berasal dari dalam bumi disebut...";
                            $template['jawaban'] = [
                                'a' => 'Tenaga endogen',
                                'b' => 'Tenaga eksogen',
                                'c' => 'Tenaga tektonik',
                                'd' => 'Tenaga vulkanik',
                                'e' => 'Tenaga seismik'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Atmosfer':
                if ($subTopik == 'Atmosfer dan hidrosfer' || $key == 'Atmosfer dan hidrosfer') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Lapisan atmosfer yang mengandung ozon adalah...";
                            $template['jawaban'] = [
                                'a' => 'Stratosfer',
                                'b' => 'Troposfer',
                                'c' => 'Mesosfer',
                                'd' => 'Termosfer',
                                'e' => 'Eksosfer'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Cuaca dan iklim' || $key == 'Cuaca dan iklim'  ) {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Alat untuk mengukur kelembaban udara adalah...";
                            $template['jawaban'] = [
                                'a' => 'Hygrometer',
                                'b' => 'Barometer',
                                'c' => 'Termometer',
                                'd' => 'Anemometer',
                                'e' => 'Altimeter'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
        }

        return $template;
    }
}
