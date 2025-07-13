<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\news;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optimasi: matikan foreign key check dan truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        news::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Simulasi hasil scraping data berita pendidikan (bisa diganti hasil scraping asli)
        $scrapedNews = $this->getScrapedNews();

        // Tambahkan slug ke setiap data
        foreach ($scrapedNews as &$item) {
            $item['slug'] = Str::slug($item['title']);
        }
        unset($item);

        // Chunking: proses per 5 data
        $chunks = array_chunk($scrapedNews, 5);
        foreach ($chunks as $chunk) {
            news::insert($chunk);
            unset($chunk);
            gc_collect_cycles();
        }
    }

    private function getScrapedNews()
    {
        // Data dummy, ganti dengan hasil scraping asli jika sudah ada
        $now = now();
        return [
            [
                'user_id' => 1,
                'title' => 'Kurikulum Merdeka: Transformasi Pendidikan Indonesia',
                'category' => 'Kebijakan',
                'description' => 'Kurikulum Merdeka membawa perubahan besar dalam sistem pendidikan nasional. Simak penjelasan dan dampaknya di sini.',
                'created_by' => 'Admin',
                'is_home' => 1,
                'is_deleted' => 0,
                'priority' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'title' => 'Tips Lolos SNBT 2025',
                'category' => 'Tips',
                'description' => 'Strategi dan tips terbaru agar sukses menghadapi Seleksi Nasional Berdasarkan Tes (SNBT) tahun 2025.',
                'created_by' => 'Redaksi',
                'is_home' => 1,
                'is_deleted' => 0,
                'priority' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'title' => 'Webinar Pendidikan Digital Gratis',
                'category' => 'Event',
                'description' => 'Ikuti webinar gratis tentang inovasi pendidikan digital bersama para pakar nasional.',
                'created_by' => 'Event Team',
                'is_home' => 0,
                'is_deleted' => 0,
                'priority' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'title' => 'Beasiswa S1 Dalam Negeri 2025',
                'category' => 'Beasiswa',
                'description' => 'Daftar beasiswa S1 terbaik dalam negeri tahun 2025 beserta syarat dan cara pendaftarannya.',
                'created_by' => 'Admin',
                'is_home' => 0,
                'is_deleted' => 0,
                'priority' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'title' => 'UN Dihapus, Apa Penggantinya?',
                'category' => 'Kebijakan',
                'description' => 'Ujian Nasional resmi dihapus. Simak penjelasan dan sistem pengganti UN di artikel ini.',
                'created_by' => 'Redaksi',
                'is_home' => 1,
                'is_deleted' => 0,
                'priority' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'title' => 'Komunitas Guru Inovatif',
                'category' => 'Komunitas',
                'description' => 'Gabung komunitas guru inovatif untuk berbagi inspirasi dan materi pembelajaran.',
                'created_by' => 'Event Team',
                'is_home' => 0,
                'is_deleted' => 0,
                'priority' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'title' => 'Lomba Sains Nasional 2025',
                'category' => 'Event',
                'description' => 'Informasi lengkap lomba sains nasional untuk siswa SD, SMP, dan SMA tahun 2025.',
                'created_by' => 'Admin',
                'is_home' => 0,
                'is_deleted' => 0,
                'priority' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'title' => 'Teknologi AI di Sekolah',
                'category' => 'Teknologi',
                'description' => 'Bagaimana kecerdasan buatan (AI) mulai diterapkan di sekolah-sekolah Indonesia.',
                'created_by' => 'Redaksi',
                'is_home' => 1,
                'is_deleted' => 0,
                'priority' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3,
                'title' => 'Panduan Belajar Mandiri',
                'category' => 'Tips',
                'description' => 'Cara efektif belajar mandiri untuk siswa dan mahasiswa di era digital.',
                'created_by' => 'Event Team',
                'is_home' => 0,
                'is_deleted' => 0,
                'priority' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'title' => 'Pentingnya Pendidikan Karakter',
                'category' => 'Opini',
                'description' => 'Mengapa pendidikan karakter sangat penting di sekolah dan keluarga.',
                'created_by' => 'Admin',
                'is_home' => 1,
                'is_deleted' => 0,
                'priority' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
    }
} 