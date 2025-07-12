<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketSoal;
use App\Models\Soal;
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

        // Jumlah paket per mata pelajaran (50 paket untuk setiap mata pelajaran)
        $jumlahPaket = 50;

        // Tahun ajaran
        $tahunAjaran = ['2022', '2023', '2024'];

        // Generate paket soal untuk setiap jenjang
        foreach ($mataPelajaran as $jenjang => $mapelList) {
            foreach ($mapelList as $mapel) {
                for ($i = 1; $i <= $jumlahPaket; $i++) {
                    // Buat paket soal
                    $paketSoal = PaketSoal::create([
                        'user_id' => 1, // Admin ID
                        'name' => "Paket {$i} {$mapel} {$jenjang}",
                        'jenjang' => $jenjang,
                        'mapel' => $mapel,
                        'tahun' => $tahunAjaran[array_rand($tahunAjaran)],
                        'is_public' => 1,
                        'is_deleted' => 0
                    ]);

                    // Generate 50 soal untuk setiap paket
                    for ($j = 1; $j <= 50; $j++) {
                        $this->generateSoal($paketSoal->id, $mapel, $jenjang);
                    }
                }
            }
        }
    }

    private function generateSoal($paketId, $mapel, $jenjang)
    {
        // Dapatkan kurikulum untuk mata pelajaran dan jenjang
        $kurikulum = $this->getKurikulum($mapel, $jenjang);

        // Hitung jumlah topik dan sub-topik
        $totalTopik = count($kurikulum);
        $totalSubTopik = 0;
        foreach ($kurikulum as $topik => $subTopik) {
            $totalSubTopik += count($subTopik);
        }

        // Distribusikan soal berdasarkan topik dan sub-topik
        $soalPerSubTopik = ceil(50 / $totalSubTopik);
        $soalTersisa = 50;

        foreach ($kurikulum as $topik => $subTopikList) {
            foreach ($subTopikList as $key => $subTopik) {
                $jumlahSoal = min($soalPerSubTopik, $soalTersisa);
                for ($i = 0; $i < $jumlahSoal; $i++) {
                    // Generate template soal
                    $template = $this->generateTemplateSoal($mapel, $jenjang, $topik, $subTopik);

                    // Create the soal
                    $this->createSoal($paketId, $template);
                }
                $soalTersisa -= $jumlahSoal;
            }
        }
    }

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
            case 'Geometri':
                $template = $this->generateSoalMatematika($jenjang, $topik, $subTopik);
                break;
        }

        // Ensure template has valid content
        if (empty($template['soal']) || empty($template['jawaban']) || empty($template['benar'])) {
            throw new \Exception("Invalid template generated for mapel: {$mapel}, jenjang: {$jenjang}, topik: {$topik}, subTopik: {$subTopik}");
        }

        return $template;
    }

    // private function generateDefaultTemplate($mapel, $jenjang, $topik, $subTopik)
    // {
    //     return [
    //         'soal' => $this->generateDefaultSoal($mapel, $jenjang, $topik, $subTopik),
    //         'jawaban' => $this->generateDefaultJawaban($mapel, $jenjang, $topik, $subTopik),
    //         'benar' => 'a',
    //         'perlu_gambar' => false
    //     ];
    // }

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

    // private function generateDefaultJawaban($mapel, $jenjang, $topik, $subTopik)
    // {
    //     $jawabanTemplates = [
    //         'a' => "Jawaban yang paling tepat dan sesuai dengan konteks",
    //         'b' => "Jawaban yang kurang tepat namun masih relevan",
    //         'c' => "Jawaban yang tidak sesuai dengan konteks",
    //         'd' => "Jawaban yang bertentangan dengan konteks",
    //         'e' => "Jawaban yang tidak ada hubungannya dengan konteks"
    //     ];

    //     return [
    //         'jawaban' => $jawabanTemplates,
    //         'benar' => 'a'
    //     ];
    // }

    private function generateSoalMatematika($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Bilangan':
                if ($subTopik == 'Operasi hitung bilangan cacah sampai 1000') {
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
                } elseif ($subTopik == 'Operasi hitung bilangan bulat dan sifat-sifatnya') {
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
                } elseif ($subTopik == 'Pecahan sederhana dan operasi hitung pecahan') {
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
                } elseif ($subTopik == 'Kelipatan Persekutuan Terkecil dan Faktor Persekutuan Terbesar') {
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
                $template = $this->generateSoalMatematika($jenjang, $topik, $subTopik);
                break;
            case 'Pengukuran':
                if ($subTopik == 'Satuan Panjang') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "1 meter sama dengan berapa sentimeter?";
                            $template['jawaban'] = [
                                'a' => '100 cm',
                                'b' => '10 cm',
                                'c' => '1000 cm',
                                'd' => '50 cm',
                                'e' => '200 cm'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Satuan Berat') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "1 kilogram sama dengan berapa gram?";
                            $template['jawaban'] = [
                                'a' => '1000 gram',
                                'b' => '100 gram',
                                'c' => '10 gram',
                                'd' => '500 gram',
                                'e' => '2000 gram'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Satuan Waktu') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "1 jam sama dengan berapa menit?";
                            $template['jawaban'] = [
                                'a' => '60 menit',
                                'b' => '30 menit',
                                'c' => '45 menit',
                                'd' => '90 menit',
                                'e' => '120 menit'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Satuan Luas') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "1 hektar sama dengan berapa meter persegi?";
                            $template['jawaban'] = [
                                'a' => '10000 m²',
                                'b' => '1000 m²',
                                'c' => '100 m²',
                                'd' => '100000 m²',
                                'e' => '1000000 m²'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Statistika':
                if ($subTopik == 'Pengumpulan Data') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut adalah data nilai ulangan matematika: 7, 8, 6, 9, 7, 8, 7. Berapakah nilai yang paling sering muncul?";
                            $template['jawaban'] = [
                                'a' => '7',
                                'b' => '8',
                                'c' => '6',
                                'd' => '9',
                                'e' => '5'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Diagram') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Diagram yang menggunakan batang untuk menyajikan data disebut...";
                            $template['jawaban'] = [
                                'a' => 'Diagram batang',
                                'b' => 'Diagram garis',
                                'c' => 'Diagram lingkaran',
                                'd' => 'Diagram gambar',
                                'e' => 'Diagram tabel'
                            ];
                            $template['benar'] = 'a';
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
                if ($subTopik == 'Membaca Nyaring') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan contoh kalimat yang baik untuk dibaca nyaring adalah...";
                            $template['jawaban'] = [
                                'a' => 'Ani pergi ke sekolah dengan riang gembira.',
                                'b' => 'Ani pergi ke sekolah dengan riang gembira!',
                                'c' => 'Ani pergi ke sekolah dengan riang gembira?',
                                'd' => 'Ani pergi ke sekolah dengan riang gembira...',
                                'e' => 'Ani pergi ke sekolah dengan riang gembira;'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Pemahaman') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Budi sedang bermain bola di lapangan. Tiba-tiba hujan turun. Budi segera pulang ke rumah.\n\nApa yang dilakukan Budi ketika hujan turun?";
                            $template['jawaban'] = [
                                'a' => 'Pulang ke rumah',
                                'b' => 'Terus bermain bola',
                                'c' => 'Bermain di bawah pohon',
                                'd' => 'Menunggu hujan reda',
                                'e' => 'Mencari tempat berteduh'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Membaca Cepat') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan teknik membaca cepat adalah...";
                            $template['jawaban'] = [
                                'a' => 'Membaca dengan gerakan mata yang cepat',
                                'b' => 'Membaca dengan suara keras',
                                'c' => 'Membaca dengan jari',
                                'd' => 'Membaca dengan menggerakkan kepala',
                                'e' => 'Membaca dengan menggerakkan bibir'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Menulis':
                if ($subTopik == 'Menulis Karangan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan bagian pembuka dalam karangan adalah...";
                            $template['jawaban'] = [
                                'a' => 'Pendahuluan',
                                'b' => 'Kesimpulan',
                                'c' => 'Penutup',
                                'd' => 'Daftar pustaka',
                                'e' => 'Lampiran'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Surat') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Bagian surat yang berisi tanggal surat adalah...";
                            $template['jawaban'] = [
                                'a' => 'Kepala surat',
                                'b' => 'Pembuka surat',
                                'c' => 'Isi surat',
                                'd' => 'Penutup surat',
                                'e' => 'Tanda tangan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Menulis Puisi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan ciri-ciri puisi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menggunakan bahasa yang indah',
                                'b' => 'Menggunakan bahasa yang panjang',
                                'c' => 'Menggunakan bahasa yang sulit',
                                'd' => 'Menggunakan bahasa yang formal',
                                'e' => 'Menggunakan bahasa yang kaku'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Berbicara':
                if ($subTopik == 'Berbicara di Depan Kelas') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan sikap yang baik saat berbicara di depan kelas adalah...";
                            $template['jawaban'] = [
                                'a' => 'Berdiri tegak dan menatap audiens',
                                'b' => 'Berdiri sambil bersandar',
                                'c' => 'Berdiri sambil menggerakkan kaki',
                                'd' => 'Berdiri sambil menunduk',
                                'e' => 'Berdiri sambil memainkan tangan'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Berdiskusi') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan sikap yang baik dalam berdiskusi adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menghargai pendapat teman',
                                'b' => 'Memotong pembicaraan teman',
                                'c' => 'Mengabaikan pendapat teman',
                                'd' => 'Memaksa teman setuju',
                                'e' => 'Mengolok-olok pendapat teman'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Bercerita') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan ciri-ciri cerita yang baik adalah...";
                            $template['jawaban'] = [
                                'a' => 'Menggunakan bahasa yang mudah dipahami',
                                'b' => 'Menggunakan bahasa yang sulit',
                                'c' => 'Menggunakan bahasa yang panjang',
                                'd' => 'Menggunakan bahasa yang kaku',
                                'e' => 'Menggunakan bahasa yang formal'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Kebahasaan':
                if ($subTopik == 'Kata Baku') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Berikut ini yang merupakan kata baku adalah...";
                            $template['jawaban'] = [
                                'a' => 'karier',
                                'b' => 'karir',
                                'c' => 'kariir',
                                'd' => 'karier',
                                'e' => 'karierr'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Ejaan') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Penulisan huruf kapital yang benar terdapat pada kalimat...";
                            $template['jawaban'] = [
                                'a' => 'Saya pergi ke Jakarta.',
                                'b' => 'saya pergi ke jakarta.',
                                'c' => 'Saya pergi ke jakarta.',
                                'd' => 'saya pergi ke Jakarta.',
                                'e' => 'SAYA PERGI KE JAKARTA.'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Tanda Baca') {
                    switch ($jenjang) {
                        case 'SD':
                            $template['soal'] = "Penggunaan tanda baca yang benar terdapat pada kalimat...";
                            $template['jawaban'] = [
                                'a' => 'Ayah membeli buku, pensil, dan penggaris.',
                                'b' => 'Ayah membeli buku pensil dan penggaris.',
                                'c' => 'Ayah membeli buku, pensil dan penggaris.',
                                'd' => 'Ayah membeli buku pensil, dan penggaris.',
                                'e' => 'Ayah membeli buku, pensil, dan, penggaris.'
                            ];
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

    private function generateSoalIPA($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Makhluk Hidup':
                if ($subTopik == 'Ciri-ciri Makhluk Hidup') {
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
                    }
                } elseif ($subTopik == 'Pertumbuhan') {
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
                    }
                } elseif ($subTopik == 'Adaptasi') {
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
                    }
                }
                break;
            case 'Benda dan Sifatnya':
                if ($subTopik == 'Sifat Benda') {
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
                    }
                } elseif ($subTopik == 'Perubahan Wujud') {
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
                    }
                } elseif ($subTopik == 'Energi') {
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
                    }
                }
                break;
            case 'Bumi dan Alam Semesta':
                if ($subTopik == 'Tata Surya') {
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
                    }
                } elseif ($subTopik == 'Cuaca') {
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
                    }
                } elseif ($subTopik == 'Bencana Alam') {
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
        $soal = Soal::create([
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
                        'KPK dan FPB' => 'Kelipatan Persekutuan Terkecil dan Faktor Persekutuan Terbesar'
                    ],
                    'Geometri' => [
                        'Bangun Datar' => 'Sifat-sifat bangun datar sederhana (persegi, persegi panjang, segitiga)',
                        'Luas dan Keliling' => 'Menghitung luas dan keliling bangun datar sederhana',
                        'Simetri' => 'Simetri lipat dan simetri putar pada bangun datar'
                    ],
                    'Pengukuran' => [
                        'Satuan Panjang' => 'Satuan panjang dan konversinya',
                        'Satuan Berat' => 'Satuan berat dan konversinya',
                        'Satuan Waktu' => 'Satuan waktu dan konversinya',
                        'Satuan Luas' => 'Satuan luas dan konversinya'
                    ],
                    'Statistika' => [
                        'Pengumpulan Data' => 'Mengumpulkan dan menyajikan data dalam bentuk tabel',
                        'Diagram' => 'Menyajikan data dalam bentuk diagram batang dan diagram gambar'
                    ]
                ],
                'SMP' => [
                    'Bilangan' => [
                        'Bilangan Bulat' => 'Operasi hitung bilangan bulat dan sifat-sifatnya',
                        'Bilangan Pecahan' => 'Operasi hitung pecahan dan desimal',
                        'Bilangan Berpangkat' => 'Bilangan berpangkat dan bentuk akar',
                        'Perbandingan' => 'Perbandingan senilai dan berbalik nilai'
                    ],
                    'Aljabar' => [
                        'Persamaan Linear' => 'Persamaan dan pertidaksamaan linear satu variabel',
                        'Sistem Persamaan' => 'Sistem persamaan linear dua variabel',
                        'Fungsi' => 'Relasi dan fungsi'
                    ],
                    'Geometri' => [
                        'Bangun Datar' => 'Sifat-sifat dan keliling serta luas bangun datar',
                        'Bangun Ruang' => 'Sifat-sifat dan luas permukaan serta volume bangun ruang',
                        'Teorema Pythagoras' => 'Teorema Pythagoras dan tripel Pythagoras'
                    ],
                    'Statistika' => [
                        'Penyajian Data' => 'Menyajikan data dalam bentuk tabel, diagram, dan grafik',
                        'Ukuran Pemusatan' => 'Mean, median, dan modus',
                        'Peluang' => 'Peluang kejadian sederhana'
                    ]
                ],
                'SMA' => [
                    'Aljabar' => [
                        'Fungsi' => 'Fungsi komposisi dan fungsi invers',
                        'Persamaan' => 'Persamaan dan pertidaksamaan kuadrat',
                        'Logaritma' => 'Logaritma dan sifat-sifatnya',
                        'Matriks' => 'Operasi matriks dan determinan'
                    ],
                    'Kalkulus' => [
                        'Limit' => 'Limit fungsi aljabar dan trigonometri',
                        'Turunan' => 'Turunan fungsi aljabar dan trigonometri',
                        'Integral' => 'Integral tak tentu dan integral tentu',
                        'Aplikasi' => 'Aplikasi turunan dan integral'
                    ],
                    'Geometri' => [
                        'Trigonometri' => 'Perbandingan trigonometri dan identitas trigonometri',
                        'Vektor' => 'Operasi vektor dan aplikasinya',
                        'Transformasi' => 'Transformasi geometri'
                    ],
                    'Statistika' => [
                        'Peluang' => 'Peluang kejadian majemuk',
                        'Distribusi' => 'Distribusi normal dan binomial',
                        'Inferensia' => 'Statistika inferensial'
                    ]
                ]
            ],
            'Bahasa Indonesia' => [
                'SD' => [
                    'Membaca' => [
                        'Membaca Nyaring' => 'Membaca nyaring dengan lafal dan intonasi yang tepat',
                        'Membaca Pemahaman' => 'Membaca dan memahami teks sederhana',
                        'Membaca Cepat' => 'Membaca cepat dengan pemahaman'
                    ],
                    'Menulis' => [
                        'Menulis Karangan' => 'Menulis karangan sederhana',
                        'Menulis Surat' => 'Menulis surat pribadi',
                        'Menulis Puisi' => 'Menulis puisi anak'
                    ],
                    'Berbicara' => [
                        'Berbicara di Depan Kelas' => 'Berbicara di depan kelas dengan bahasa yang baik',
                        'Berdiskusi' => 'Berdiskusi dalam kelompok kecil',
                        'Bercerita' => 'Bercerita pengalaman pribadi'
                    ],
                    'Kebahasaan' => [
                        'Kata Baku' => 'Penggunaan kata baku dan tidak baku',
                        'Ejaan' => 'Penggunaan ejaan yang benar',
                        'Tanda Baca' => 'Penggunaan tanda baca yang tepat'
                    ]
                ],
                'SMP' => [
                    'Membaca' => [
                        'Membaca Kritis' => 'Membaca dan memahami teks dengan kritis',
                        'Membaca Sastra' => 'Membaca dan memahami karya sastra',
                        'Membaca Berita' => 'Membaca dan memahami berita'
                    ],
                    'Menulis' => [
                        'Menulis Karya Ilmiah' => 'Menulis karya ilmiah sederhana',
                        'Menulis Cerpen' => 'Menulis cerita pendek',
                        'Menulis Berita' => 'Menulis berita'
                    ],
                    'Berbicara' => [
                        'Berpidato' => 'Berpidato dengan bahasa yang baik',
                        'Debat' => 'Berdebat dengan argumentasi yang baik',
                        'Wawancara' => 'Melakukan wawancara'
                    ],
                    'Kebahasaan' => [
                        'Kalimat Efektif' => 'Penggunaan kalimat efektif',
                        'Paragraf' => 'Pengembangan paragraf',
                        'Karya Sastra' => 'Unsur-unsur karya sastra'
                    ]
                ],
                'SMA' => [
                    'Membaca' => [
                        'Membaca Karya Sastra' => 'Membaca dan menganalisis karya sastra',
                        'Membaca Kritis' => 'Membaca dan menganalisis teks secara kritis',
                        'Membaca Berita' => 'Membaca dan menganalisis berita'
                    ],
                    'Menulis' => [
                        'Menulis Karya Ilmiah' => 'Menulis karya ilmiah',
                        'Menulis Karya Sastra' => 'Menulis karya sastra',
                        'Menulis Berita' => 'Menulis berita dengan bahasa jurnalistik'
                    ],
                    'Berbicara' => [
                        'Berpidato' => 'Berpidato dengan bahasa yang baik dan benar',
                        'Debat' => 'Berdebat dengan argumentasi yang kuat',
                        'Diskusi' => 'Berdiskusi dengan bahasa yang baik'
                    ],
                    'Kebahasaan' => [
                        'Kalimat Efektif' => 'Penggunaan kalimat efektif dalam berbagai konteks',
                        'Paragraf' => 'Pengembangan paragraf yang koheren',
                        'Karya Sastra' => 'Analisis karya sastra'
                    ]
                ]
            ],
            'IPA' => [
                'SD' => [
                    'Makhluk Hidup' => [
                        'Ciri-ciri Makhluk Hidup' => 'Ciri-ciri makhluk hidup dan pengelompokannya',
                        'Pertumbuhan' => 'Pertumbuhan dan perkembangan makhluk hidup',
                        'Adaptasi' => 'Adaptasi makhluk hidup terhadap lingkungan'
                    ],
                    'Benda dan Sifatnya' => [
                        'Sifat Benda' => 'Sifat-sifat benda padat, cair, dan gas',
                        'Perubahan Wujud' => 'Perubahan wujud benda',
                        'Energi' => 'Bentuk-bentuk energi dan perubahannya'
                    ],
                    'Bumi dan Alam Semesta' => [
                        'Tata Surya' => 'Sistem tata surya dan benda-benda langit',
                        'Cuaca' => 'Cuaca dan iklim',
                        'Bencana Alam' => 'Bencana alam dan cara penanggulangannya'
                    ]
                ],
                'SMP' => [
                    'Fisika' => [
                        'Gerak' => 'Gerak lurus dan gerak melingkar',
                        'Gaya' => 'Gaya dan hukum Newton',
                        'Energi' => 'Energi dan perubahannya'
                    ],
                    'Kimia' => [
                        'Zat' => 'Sifat fisika dan kimia zat',
                        'Larutan' => 'Larutan dan konsentrasi',
                        'Asam Basa' => 'Asam, basa, dan garam'
                    ],
                    'Biologi' => [
                        'Sistem Organ' => 'Sistem organ pada manusia',
                        'Reproduksi' => 'Reproduksi pada manusia',
                        'Pewarisan' => 'Pewarisan sifat'
                    ]
                ],
                'SMA' => [
                    'Fisika' => [
                        'Mekanika' => 'Hukum Newton dan gerak',
                        'Termodinamika' => 'Hukum termodinamika',
                        'Listrik' => 'Listrik statis dan dinamis'
                    ],
                    'Kimia' => [
                        'Struktur Atom' => 'Struktur atom dan sistem periodik',
                        'Ikatan Kimia' => 'Ikatan kimia dan bentuk molekul',
                        'Reaksi Kimia' => 'Laju reaksi dan kesetimbangan'
                    ],
                    'Biologi' => [
                        'Sel' => 'Struktur dan fungsi sel',
                        'Metabolisme' => 'Metabolisme sel',
                        'Genetika' => 'Pewarisan sifat dan mutasi'
                    ]
                ]
            ],
            'IPS' => [
                'SD' => [
                    'Sejarah' => [
                        'Sejarah Indonesia' => 'Sejarah perjuangan kemerdekaan Indonesia',
                        'Peninggalan' => 'Peninggalan sejarah di Indonesia',
                        'Tokoh' => 'Tokoh-tokoh sejarah Indonesia'
                    ],
                    'Geografi' => [
                        'Kenampakan Alam' => 'Kenampakan alam dan buatan',
                        'Peta' => 'Membaca dan membuat peta',
                        'Sumber Daya' => 'Sumber daya alam dan pemanfaatannya'
                    ],
                    'Ekonomi' => [
                        'Kegiatan Ekonomi' => 'Kegiatan ekonomi di lingkungan sekitar',
                        'Uang' => 'Sejarah dan fungsi uang',
                        'Koperasi' => 'Koperasi dan peranannya'
                    ],
                    'Sosiologi' => [
                        'Norma' => 'Norma dan nilai dalam masyarakat',
                        'Keberagaman' => 'Keberagaman suku bangsa dan budaya',
                        'Globalisasi' => 'Dampak globalisasi'
                    ]
                ],
                'SMP' => [
                    'Sejarah' => [
                        'Perjuangan' => 'Perjuangan kemerdekaan Indonesia',
                        'Proklamasi' => 'Proklamasi kemerdekaan',
                        'Orde Baru' => 'Masa Orde Baru dan Reformasi'
                    ],
                    'Geografi' => [
                        'Kondisi Geografis' => 'Kondisi geografis Indonesia',
                        'Penduduk' => 'Kependudukan dan migrasi',
                        'Lingkungan' => 'Lingkungan hidup dan pembangunan berkelanjutan'
                    ],
                    'Ekonomi' => [
                        'Kebutuhan' => 'Kebutuhan manusia dan kelangkaan',
                        'Pasar' => 'Pasar dan harga',
                        'Perdagangan' => 'Perdagangan internasional'
                    ],
                    'Sosiologi' => [
                        'Interaksi' => 'Interaksi sosial dan sosialisasi',
                        'Lembaga' => 'Lembaga sosial',
                        'Perubahan' => 'Perubahan sosial dan globalisasi'
                    ]
                ],
                'SMA' => [
                    'Sejarah' => [
                        'Peradaban' => 'Peradaban awal dunia',
                        'Kolonialisme' => 'Kolonialisme dan imperialisme',
                        'Kemerdekaan' => 'Perjuangan kemerdekaan Indonesia'
                    ],
                    'Geografi' => [
                        'Litosfer' => 'Litosfer dan pedosfer',
                        'Atmosfer' => 'Atmosfer dan hidrosfer',
                        'Biosfer' => 'Biosfer dan antroposfer'
                    ],
                    'Ekonomi' => [
                        'Konsep' => 'Konsep dasar ilmu ekonomi',
                        'Pasar' => 'Pasar dan harga',
                        'Kebijakan' => 'Kebijakan moneter dan fiskal'
                    ],
                    'Sosiologi' => [
                        'Struktur' => 'Struktur sosial dan diferensiasi',
                        'Konflik' => 'Konflik dan integrasi sosial',
                        'Perubahan' => 'Perubahan sosial dan modernisasi'
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
        Soal::where('id', $soalId)->update([
            'image_soal' => '/assets/soal/' . $filename
        ]);
    }

    private function generateSoalIPS($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Sejarah':
                if ($subTopik == 'Perjuangan Kemerdekaan') {
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
                    }
                } elseif ($subTopik == 'Peninggalan Sejarah') {
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
                    }
                }
                break;
            case 'Geografi':
                if ($subTopik == 'Kenampakan Alam') {
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
                    }
                } elseif ($subTopik == 'Peta') {
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
                    }
                }
                break;
            case 'Ekonomi':
                if ($subTopik == 'Kegiatan Ekonomi') {
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
                    }
                } elseif ($subTopik == 'Uang') {
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
                    }
                }
                break;
            case 'Sosiologi':
                if ($subTopik == 'Norma') {
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
                    }
                } elseif ($subTopik == 'Kebudayaan') {
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

    private function generateSoalBahasaInggris($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Reading':
                if ($subTopik == 'Reading Comprehension') {
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
                    }
                } elseif ($subTopik == 'Vocabulary') {
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
                    }
                }
                break;
            case 'Writing':
                if ($subTopik == 'Grammar') {
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
                    }
                } elseif ($subTopik == 'Sentence Structure') {
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
                    }
                }
                break;
            case 'Speaking':
                if ($subTopik == 'Greeting') {
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
                    }
                } elseif ($subTopik == 'Introduction') {
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
                    }
                }
                break;
            case 'Listening':
                if ($subTopik == 'Numbers') {
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
                    }
                } elseif ($subTopik == 'Colors') {
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
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalPKn($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Pancasila':
                if ($subTopik == 'Sila Pancasila') {
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
                    }
                } elseif ($subTopik == 'Lambang Pancasila') {
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
                    }
                }
                break;
            case 'UUD 1945':
                if ($subTopik == 'Pembukaan') {
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
                    }
                } elseif ($subTopik == 'Batang Tubuh') {
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
                    }
                }
                break;
            case 'NKRI':
                if ($subTopik == 'Lambang Negara') {
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
                    }
                } elseif ($subTopik == 'Bendera') {
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
                    }
                }
                break;
            case 'Pemerintahan':
                if ($subTopik == 'Lembaga Negara') {
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
                    }
                } elseif ($subTopik == 'Pemilu') {
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
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalSeniBudaya($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Seni Rupa':
                if ($subTopik == 'Unsur Seni Rupa') {
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
                } elseif ($subTopik == 'Teknik Menggambar') {
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
                if ($subTopik == 'Alat Musik') {
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
                } elseif ($subTopik == 'Notasi') {
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
                if ($subTopik == 'Gerak Tari') {
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
                } elseif ($subTopik == 'Tari Daerah') {
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
                if ($subTopik == 'Unsur Teater') {
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
                } elseif ($subTopik == 'Drama') {
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

    private function generateSoalPJOK($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Olahraga':
                if ($subTopik == 'Sepak Bola') {
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
                } elseif ($subTopik == 'Basket') {
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
                if ($subTopik == 'Makanan Sehat') {
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
                } elseif ($subTopik == 'Kebersihan') {
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
                if ($subTopik == 'Senam') {
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
                } elseif ($subTopik == 'Pemanasan') {
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
                if ($subTopik == 'Gaya Renang') {
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
                } elseif ($subTopik == 'Perlengkapan') {
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

    private function generateSoalEkonomi($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Konsep':
                if ($subTopik == 'Konsep dasar ilmu ekonomi') {
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
                if ($subTopik == 'Pasar dan harga') {
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
                if ($subTopik == 'Kebijakan moneter dan fiskal') {
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

    private function generateSoalSosiologi($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Struktur':
                if ($subTopik == 'Struktur sosial dan diferensiasi') {
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
                if ($subTopik == 'Konflik dan integrasi sosial') {
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
                if ($subTopik == 'Perubahan sosial dan modernisasi') {
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

    private function generateSoalFisika($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Mekanika':
                if ($subTopik == 'Gerak') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Rumus untuk menghitung kecepatan adalah...";
                            $template['jawaban'] = [
                                'a' => 'v = s/t',
                                'b' => 'v = t/s',
                                'c' => 'v = s × t',
                                'd' => 'v = s + t',
                                'e' => 'v = s - t'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                } elseif ($subTopik == 'Gaya') {
                    switch ($jenjang) {
                        case 'SMA':
                            $template['soal'] = "Rumus untuk menghitung gaya adalah...";
                            $template['jawaban'] = [
                                'a' => 'F = m × a',
                                'b' => 'F = m ÷ a',
                                'c' => 'F = m + a',
                                'd' => 'F = m - a',
                                'e' => 'F = m² × a'
                            ];
                            $template['benar'] = 'a';
                            break;
                    }
                }
                break;
            case 'Listrik':
                if ($subTopik == 'Arus Listrik') {
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
                } elseif ($subTopik == 'Tegangan') {
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
                }
                break;
        }

        return $template;
    }

    private function generateSoalKimia($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Struktur Atom':
                if ($subTopik == 'Konfigurasi Elektron') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                } elseif ($subTopik == 'Sistem Periodik') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                }
                break;
            case 'Reaksi Kimia':
                if ($subTopik == 'Persamaan Reaksi') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                } elseif ($subTopik == 'Stoikiometri') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalBiologi($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Sel':
                if ($subTopik == 'Struktur dan fungsi sel') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                } elseif ($subTopik == 'Pembelahan sel') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                }
                break;
            case 'Metabolisme':
                if ($subTopik == 'Fotosintesis') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                } elseif ($subTopik == 'Respirasi') {
                    switch ($jenjang) {
                        case 'SMA':
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
                    }
                }
                break;
        }

        return $template;
    }

    private function generateSoalSejarah($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Peradaban':
                if ($subTopik == 'Peradaban awal dunia') {
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
                } elseif ($subTopik == 'Peradaban kuno') {
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
                if ($subTopik == 'Kolonialisme dan imperialisme') {
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
                } elseif ($subTopik == 'Perlawanan') {
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

    private function generateSoalGeografi($jenjang, $topik, $subTopik)
    {
        $template = [
            'soal' => '',
            'jawaban' => [],
            'benar' => '',
            'perlu_gambar' => false
        ];

        switch ($topik) {
            case 'Litosfer':
                if ($subTopik == 'Litosfer dan pedosfer') {
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
                } elseif ($subTopik == 'Tenaga endogen') {
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
                if ($subTopik == 'Atmosfer dan hidrosfer') {
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
                } elseif ($subTopik == 'Cuaca dan iklim') {
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
