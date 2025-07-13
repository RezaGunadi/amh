<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for better performance
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing data
        BlogPost::truncate();
        BlogCategory::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Create categories first
        $this->createCategories();

        // Create blog posts with chunking
        $this->createBlogPosts();
    }

    private function createCategories()
    {
        $categories = [
            [
                'name' => 'Tips Belajar',
                'slug' => 'tips-belajar',
                'description' => 'Artikel tentang tips dan trik belajar efektif',
                'svg_icon' => 'assets/svg/blog/tips-belajar.svg',
                'color' => '#3B82F6',
                'post_count' => 0
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Artikel seputar dunia pendidikan',
                'svg_icon' => 'assets/svg/blog/pendidikan.svg',
                'color' => '#10B981',
                'post_count' => 0
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Artikel tentang teknologi dalam pendidikan',
                'svg_icon' => 'assets/svg/blog/teknologi.svg',
                'color' => '#06B6D4',
                'post_count' => 0
            ],
            [
                'name' => 'Motivasi',
                'slug' => 'motivasi',
                'description' => 'Artikel motivasi untuk siswa dan guru',
                'svg_icon' => 'assets/svg/blog/motivasi.svg',
                'color' => '#F59E0B',
                'post_count' => 0
            ],
            [
                'name' => 'Karir',
                'slug' => 'karir',
                'description' => 'Artikel tentang karir dan masa depan',
                'svg_icon' => 'assets/svg/blog/karir.svg',
                'color' => '#EF4444',
                'post_count' => 0
            ],
            [
                'name' => 'Komunitas',
                'slug' => 'komunitas',
                'description' => 'Artikel tentang komunitas pendidikan',
                'svg_icon' => 'assets/svg/blog/komunitas.svg',
                'color' => '#6B7280',
                'post_count' => 0
            ]
        ];

        // Insert categories in chunks
        foreach (array_chunk($categories, 3) as $chunk) {
            BlogCategory::insert($chunk);
        }
    }

    private function createBlogPosts()
    {
        // Get category IDs for reference
        $categories = BlogCategory::pluck('id', 'slug')->toArray();
        
        // Define posts data in smaller chunks
        $postsChunks = $this->getPostsData($categories);
        
        // Process each chunk
        foreach ($postsChunks as $chunk) {
            // Insert chunk
            BlogPost::insert($chunk);
            
            // Clear memory after each chunk
            unset($chunk);
            gc_collect_cycles();
        }
        
        // Update post counts for categories
        $this->updateCategoryPostCounts();
    }

    private function getPostsData($categories)
    {
        // Split posts into smaller chunks to prevent memory issues
        $allPosts = [
            // Chunk 1: Tips Belajar
            [
                'title' => '10 Tips Belajar Efektif untuk Siswa SD, SMP, dan SMA',
                'slug' => '10-tips-belajar-efektif-untuk-siswa',
                'excerpt' => 'Temukan strategi belajar yang efektif untuk meningkatkan prestasi akademik Anda. Artikel ini membahas teknik-teknik yang telah terbukti berhasil.',
                'content' => $this->getTipsBelajarContent(),
                'blog_category_id' => $categories['tips-belajar'],
                'author_name' => 'Sarah Putri',
                'author_avatar' => 'assets/img/avatar-default.jpg',
                'reading_time' => 5,
                'svg_icon' => 'assets/svg/blog/tips-belajar.svg',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Cara Mudah Belajar Matematika',
                'slug' => 'cara-mudah-belajar-matematika',
                'excerpt' => 'Teknik dan trik untuk menguasai matematika dengan cara yang menyenangkan dan mudah dipahami.',
                'content' => $this->getMatematikaContent(),
                'blog_category_id' => $categories['tips-belajar'],
                'author_name' => 'Rina Wati',
                'author_avatar' => 'assets/img/avatar-default.jpg',
                'reading_time' => 7,
                'svg_icon' => 'assets/svg/blog/matematika.svg',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subWeek(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Belajar Fisika dengan Eksperimen Sederhana',
                'slug' => 'belajar-fisika-dengan-eksperimen-sederhana',
                'excerpt' => 'Cara memahami konsep fisika melalui eksperimen yang bisa dilakukan di rumah.',
                'content' => $this->getFisikaContent(),
                'blog_category_id' => $categories['tips-belajar'],
                'author_name' => 'Prof. Dr. Surya',
                'author_avatar' => 'assets/img/avatar-default.jpg',
                'reading_time' => 6,
                'svg_icon' => 'assets/svg/blog/tips-belajar.svg',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subWeeks(3),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Chunk 2: Teknologi dan Pendidikan
        $allPosts[] = [
            'title' => 'Peran Teknologi dalam Pendidikan Modern',
            'slug' => 'peran-teknologi-dalam-pendidikan-modern',
            'excerpt' => 'Bagaimana teknologi mengubah cara kita belajar dan mengajar di era digital.',
            'content' => $this->getTeknologiContent(),
            'blog_category_id' => $categories['teknologi'],
            'author_name' => 'Ahmad Rizki',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 3,
            'svg_icon' => 'assets/svg/blog/teknologi.svg',
            'is_featured' => true,
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'created_at' => now(),
            'updated_at' => now()
        ];

        $allPosts[] = [
            'title' => 'Persiapan Ujian Nasional yang Efektif',
            'slug' => 'persiapan-ujian-nasional-yang-efektif',
            'excerpt' => 'Panduan lengkap untuk mempersiapkan ujian nasional dengan strategi yang tepat dan efektif.',
            'content' => $this->getUjianContent(),
            'blog_category_id' => $categories['pendidikan'],
            'author_name' => 'Diana Sari',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 6,
            'svg_icon' => 'assets/svg/blog/pendidikan.svg',
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now()->subWeek(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        $allPosts[] = [
            'title' => 'Tips Jago Bahasa Inggris',
            'slug' => 'tips-jago-bahasa-inggris',
            'excerpt' => 'Metode praktis untuk meningkatkan kemampuan berbahasa Inggris dengan cepat dan efektif.',
            'content' => $this->getBahasaInggrisContent(),
            'blog_category_id' => $categories['pendidikan'],
            'author_name' => 'John Doe',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 5,
            'svg_icon' => 'assets/svg/blog/bahasa-inggris.svg',
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now()->subWeeks(2),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Chunk 3: Motivasi dan Karir
        $allPosts[] = [
            'title' => 'Cara Mempertahankan Motivasi Belajar',
            'slug' => 'cara-mempertahankan-motivasi-belajar',
            'excerpt' => 'Strategi untuk tetap termotivasi dalam perjalanan belajar Anda.',
            'content' => $this->getMotivasiContent(),
            'blog_category_id' => $categories['motivasi'],
            'author_name' => 'Budi Santoso',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 4,
            'svg_icon' => 'assets/svg/blog/motivasi.svg',
            'is_featured' => true,
            'is_published' => true,
            'published_at' => now()->subDays(4),
            'created_at' => now(),
            'updated_at' => now()
        ];

        $allPosts[] = [
            'title' => 'Menjaga Kesehatan Mental Saat Belajar',
            'slug' => 'menjaga-kesehatan-mental-saat-belajar',
            'excerpt' => 'Pentingnya menjaga kesehatan mental dalam proses pembelajaran dan cara mengelolanya.',
            'content' => $this->getKesehatanMentalContent(),
            'blog_category_id' => $categories['motivasi'],
            'author_name' => 'Dr. Maya',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 4,
            'svg_icon' => 'assets/svg/blog/motivasi.svg',
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now()->subWeeks(3),
            'created_at' => now(),
            'updated_at' => now()
        ];

        $allPosts[] = [
            'title' => 'Pilihan Jurusan Kuliah yang Menjanjikan',
            'slug' => 'pilihan-jurusan-kuliah-yang-menjanjikan',
            'excerpt' => 'Analisis mendalam tentang jurusan kuliah yang memiliki prospek karir cerah di masa depan.',
            'content' => $this->getKarirContent(),
            'blog_category_id' => $categories['karir'],
            'author_name' => 'Lisa Chen',
            'author_avatar' => 'assets/img/avatar-default.jpg',
            'reading_time' => 8,
            'svg_icon' => 'assets/svg/blog/karir.svg',
            'is_featured' => false,
            'is_published' => true,
            'published_at' => now()->subWeeks(2),
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Return posts in chunks of 2 to prevent memory issues
        return array_chunk($allPosts, 2);
    }

    private function updateCategoryPostCounts()
    {
        // Update post counts for each category
        $categories = BlogCategory::all();
        
        foreach ($categories as $category) {
            $postCount = BlogPost::where('blog_category_id', $category->id)->count();
            $category->update(['post_count' => $postCount]);
        }
    }

    // Content methods remain the same but with memory optimization
    private function getTipsBelajarContent()
    {
        return '<h2>10 Tips Belajar Efektif untuk Siswa</h2>
        
        <p>Belajar adalah proses yang membutuhkan strategi dan teknik yang tepat. Berikut adalah 10 tips belajar efektif yang dapat membantu siswa SD, SMP, dan SMA meningkatkan prestasi akademik mereka:</p>

        <h3>1. Buat Jadwal Belajar yang Teratur</h3>
        <p>Membuat jadwal belajar yang konsisten membantu otak membentuk kebiasaan. Siswa sebaiknya belajar pada waktu yang sama setiap hari untuk hasil yang optimal.</p>

        <h3>2. Gunakan Teknik Pomodoro</h3>
        <p>Teknik ini melibatkan belajar selama 25 menit, kemudian istirahat 5 menit. Setelah 4 sesi, ambil istirahat lebih lama (15-30 menit).</p>

        <h3>3. Buat Catatan yang Efektif</h3>
        <p>Gunakan metode Cornell atau mind mapping untuk membuat catatan yang lebih terorganisir dan mudah dipahami.</p>

        <h3>4. Praktikkan Active Recall</h3>
        <p>Daripada hanya membaca ulang, coba ingat informasi tanpa melihat catatan. Ini lebih efektif untuk retensi jangka panjang.</p>

        <h3>5. Ajarkan kepada Orang Lain</h3>
        <p>Mengajarkan konsep kepada teman atau keluarga membantu memperkuat pemahaman dan mengidentifikasi area yang perlu diperbaiki.</p>

        <h3>6. Gunakan Multiple Learning Styles</h3>
        <p>Kombinasikan visual (gambar, diagram), auditori (mendengarkan), dan kinestetik (praktik langsung) untuk hasil terbaik.</p>

        <h3>7. Istirahat yang Cukup</h3>
        <p>Tidur 7-9 jam per malam sangat penting untuk konsolidasi memori dan fungsi kognitif yang optimal.</p>

        <h3>8. Makan Makanan Bergizi</h3>
        <p>Nutrisi yang tepat, terutama omega-3, vitamin B, dan antioksidan, mendukung fungsi otak yang optimal.</p>

        <h3>9. Latihan Fisik Rutin</h3>
        <p>Olahraga meningkatkan aliran darah ke otak dan melepaskan endorfin yang meningkatkan mood dan konsentrasi.</p>

        <h3>10. Evaluasi dan Refleksi</h3>
        <p>Secara berkala evaluasi metode belajar Anda dan sesuaikan strategi berdasarkan hasil yang diperoleh.</p>

        <h3>Kesimpulan</h3>
        <p>Implementasi tips-tips ini secara konsisten akan membantu siswa mengembangkan kebiasaan belajar yang efektif dan mencapai prestasi akademik yang lebih baik.</p>';
    }

    private function getTeknologiContent()
    {
        return '<h2>Peran Teknologi dalam Pendidikan Modern</h2>
        
        <p>Teknologi telah mengubah cara kita belajar dan mengajar secara fundamental. Mari kita eksplorasi bagaimana teknologi mempengaruhi pendidikan di era digital.</p>

        <h3>1. Pembelajaran Jarak Jauh</h3>
        <p>Platform seperti Zoom, Google Meet, dan Microsoft Teams memungkinkan pembelajaran berlangsung dari mana saja, menghilangkan batasan geografis.</p>

        <h3>2. Sumber Belajar Digital</h3>
        <p>E-book, video pembelajaran, dan aplikasi edukasi memberikan akses ke informasi yang lebih luas dan interaktif.</p>

        <h3>3. Personalisasi Pembelajaran</h3>
        <p>AI dan machine learning memungkinkan sistem pembelajaran yang disesuaikan dengan kebutuhan individual setiap siswa.</p>

        <h3>4. Kolaborasi Global</h3>
        <p>Siswa dapat berkolaborasi dengan teman dari berbagai negara, memperluas perspektif dan pemahaman budaya.</p>

        <h3>5. Gamifikasi</h3>
        <p>Penggunaan elemen game dalam pembelajaran membuat proses belajar lebih menyenangkan dan engaging.</p>

        <h3>6. Real-time Feedback</h3>
        <p>Teknologi memungkinkan feedback instan, membantu siswa segera mengetahui area yang perlu diperbaiki.</p>

        <h3>7. Virtual Reality dan Augmented Reality</h3>
        <p>VR/AR memberikan pengalaman belajar yang imersif, terutama untuk mata pelajaran yang membutuhkan visualisasi.</p>

        <h3>8. Data Analytics</h3>
        <p>Analisis data membantu guru memahami pola belajar siswa dan mengoptimalkan metode pengajaran.</p>

        <h3>9. Aksesibilitas</h3>
        <p>Teknologi membuat pendidikan lebih mudah diakses oleh siswa dengan kebutuhan khusus.</p>

        <h3>10. Persiapan untuk Masa Depan</h3>
        <p>Penggunaan teknologi dalam pendidikan mempersiapkan siswa untuk dunia kerja yang semakin digital.</p>

        <h3>Kesimpulan</h3>
        <p>Teknologi bukan hanya alat, tetapi katalisator untuk transformasi pendidikan yang lebih inklusif, efektif, dan relevan dengan kebutuhan masa depan.</p>';
    }

    private function getMotivasiContent()
    {
        return '<h2>Cara Mempertahankan Motivasi Belajar</h2>
        
        <p>Motivasi adalah kunci keberhasilan dalam pembelajaran. Namun, mempertahankan motivasi tidak selalu mudah. Berikut adalah strategi untuk tetap termotivasi dalam perjalanan belajar Anda.</p>

        <h3>1. Tetapkan Tujuan yang Jelas</h3>
        <p>Tujuan yang spesifik, terukur, dan realistis membantu Anda tetap fokus dan termotivasi. Bagilah tujuan besar menjadi target-target kecil yang dapat dicapai.</p>

        <h3>2. Visualisasikan Kesuksesan</h3>
        <p>Bayangkan diri Anda mencapai tujuan. Visualisasi positif membantu otak tetap fokus pada hasil yang diinginkan.</p>

        <h3>3. Rayakan Pencapaian Kecil</h3>
        <p>Jangan menunggu sampai mencapai tujuan besar untuk merayakan. Akui dan rayakan setiap kemajuan, sekecil apapun.</p>

        <h3>4. Kelilingi Diri dengan Orang Positif</h3>
        <p>Bergaul dengan orang-orang yang mendukung dan memotivasi Anda. Hindari energi negatif yang dapat menurunkan semangat.</p>

        <h3>5. Buat Rutinitas yang Menyenangkan</h3>
        <p>Gabungkan aktivitas yang Anda sukai dengan sesi belajar. Misalnya, mendengarkan musik sambil belajar atau belajar di tempat yang nyaman.</p>

        <h3>6. Ingat "Why" Anda</h3>
        <p>Ketika motivasi menurun, ingat kembali mengapa Anda memulai perjalanan ini. Hubungkan pembelajaran dengan impian dan tujuan hidup Anda.</p>

        <h3>7. Ambil Istirahat yang Cukup</h3>
        <p>Burnout adalah musuh motivasi. Pastikan Anda mengambil istirahat yang cukup dan melakukan aktivitas yang menyegarkan.</p>

        <h3>8. Belajar dari Kegagalan</h3>
        <p>Lihat kegagalan sebagai peluang untuk belajar, bukan sebagai akhir dari perjalanan. Setiap kesalahan adalah langkah menuju kesuksesan.</p>

        <h3>9. Gunakan Sistem Reward</h3>
        <p>Buat sistem reward untuk diri sendiri. Setelah menyelesaikan tugas tertentu, berikan hadiah kecil yang Anda nikmati.</p>

        <h3>10. Fokus pada Proses, Bukan Hanya Hasil</h3>
        <p>Nikmati proses belajar itu sendiri. Ketika Anda menikmati apa yang Anda lakukan, motivasi akan datang secara alami.</p>

        <h3>Kesimpulan</h3>
        <p>Motivasi adalah keterampilan yang dapat dikembangkan. Dengan strategi yang tepat dan konsistensi, Anda dapat mempertahankan motivasi belajar dalam jangka panjang.</p>';
    }

    private function getUjianContent()
    {
        return '<h2>Persiapan Ujian Nasional yang Efektif</h2>
        
        <p>Ujian Nasional adalah momen penting dalam perjalanan akademik siswa. Persiapan yang tepat sangat menentukan keberhasilan. Berikut adalah panduan lengkap untuk mempersiapkan UN dengan efektif.</p>

        <h3>1. Analisis Kisi-kisi</h3>
        <p>Pelajari kisi-kisi UN dengan teliti. Identifikasi topik yang sering muncul dan tingkat kesulitan masing-masing materi.</p>

        <h3>2. Buat Rencana Studi</h3>
        <p>Susun jadwal belajar yang terstruktur, alokasikan waktu lebih untuk materi yang sulit dan prioritaskan topik yang sering keluar.</p>

        <h3>3. Latihan Soal Berkualitas</h3>
        <p>Kerjakan soal-soal UN tahun sebelumnya dan prediksi. Fokus pada pemahaman konsep, bukan hanya menghafal jawaban.</p>

        <h3>4. Teknik Time Management</h3>
        <p>Latih kemampuan mengatur waktu saat mengerjakan soal. Alokasikan waktu sesuai dengan bobot dan kesulitan soal.</p>

        <h3>5. Strategi Mengerjakan Soal</h3>
        <p>Mulai dengan soal yang mudah, kemudian lanjut ke yang sulit. Jangan terlalu lama di satu soal yang sulit.</p>

        <h3>6. Persiapan Fisik dan Mental</h3>
        <p>Jaga kesehatan fisik dengan istirahat cukup, makan bergizi, dan olahraga ringan. Kelola stres dengan teknik relaksasi.</p>

        <h3>7. Simulasi Ujian</h3>
        <p>Lakukan simulasi ujian dalam kondisi yang mirip dengan UN sebenarnya untuk membiasakan diri dengan tekanan waktu.</p>

        <h3>8. Review dan Evaluasi</h3>
        <p>Secara berkala review materi yang sudah dipelajari dan evaluasi kemajuan. Identifikasi area yang masih perlu diperbaiki.</p>

        <h3>9. Konsultasi dengan Guru</h3>
        <p>Jangan ragu untuk bertanya kepada guru jika ada materi yang belum dipahami dengan baik.</p>

        <h3>10. Persiapan Hari H</h3>
        <p>Siapkan semua keperluan ujian sehari sebelumnya. Pastikan istirahat yang cukup dan sarapan yang bergizi.</p>

        <h3>Kesimpulan</h3>
        <p>Persiapan UN yang efektif membutuhkan perencanaan matang, konsistensi, dan keseimbangan antara belajar dan istirahat. Dengan strategi yang tepat, kesuksesan UN dapat dicapai.</p>';
    }

    private function getMatematikaContent()
    {
        return '<h2>Cara Mudah Belajar Matematika</h2>
        
        <p>Matematika sering dianggap sebagai mata pelajaran yang sulit. Namun, dengan pendekatan yang tepat, matematika bisa menjadi pelajaran yang menyenangkan dan mudah dipahami.</p>

        <h3>1. Pahami Konsep Dasar</h3>
        <p>Jangan hanya menghafal rumus. Pahami konsep dasar di balik setiap rumus dan bagaimana rumus tersebut bekerja.</p>

        <h3>2. Gunakan Visualisasi</h3>
        <p>Gambar, diagram, dan grafik membantu memahami konsep matematika yang abstrak. Gunakan alat visual untuk mempermudah pemahaman.</p>

        <h3>3. Praktik dengan Soal Bertahap</h3>
        <p>Mulai dengan soal yang mudah, kemudian tingkatkan kesulitan secara bertahap. Ini membangun kepercayaan diri dan pemahaman.</p>

        <h3>4. Hubungkan dengan Kehidupan Sehari-hari</h3>
        <p>Lihat aplikasi matematika dalam kehidupan nyata. Ini membuat matematika lebih relevan dan menarik.</p>

        <h3>5. Gunakan Mnemonik</h3>
        <p>Buat jembatan keledai atau singkatan untuk mengingat rumus atau konsep yang sulit.</p>

        <h3>6. Belajar dalam Kelompok</h3>
        <p>Belajar bersama teman memungkinkan diskusi dan penjelasan dari berbagai perspektif.</p>

        <h3>7. Gunakan Teknologi</h3>
        <p>Aplikasi dan software matematika dapat membantu visualisasi dan pemecahan masalah yang kompleks.</p>

        <h3>8. Fokus pada Pemecahan Masalah</h3>
        <p>Latih kemampuan berpikir logis dan sistematis dalam memecahkan masalah matematika.</p>

        <h3>9. Jangan Takut Salah</h3>
        <p>Kesalahan adalah bagian dari proses belajar. Analisis kesalahan untuk memahami di mana letak masalahnya.</p>

        <h3>10. Konsistensi dalam Latihan</h3>
        <p>Latihan rutin adalah kunci untuk menguasai matematika. Dedikasikan waktu setiap hari untuk berlatih.</p>

        <h3>Kesimpulan</h3>
        <p>Matematika tidak harus sulit. Dengan pendekatan yang tepat, kesabaran, dan latihan yang konsisten, siapa pun dapat menguasai matematika dengan baik.</p>';
    }

    private function getBahasaInggrisContent()
    {
        return '<h2>Tips Jago Bahasa Inggris</h2>
        
        <p>Bahasa Inggris adalah bahasa internasional yang penting untuk dikuasai. Berikut adalah metode praktis untuk meningkatkan kemampuan berbahasa Inggris dengan cepat dan efektif.</p>

        <h3>1. Immerse Yourself</h3>
        <p>Lingkungi diri Anda dengan bahasa Inggris. Tonton film, dengarkan musik, dan baca buku dalam bahasa Inggris.</p>

        <h3>2. Praktik Speaking Setiap Hari</h3>
        <p>Berbicara adalah cara terbaik untuk meningkatkan fluency. Praktik dengan teman, keluarga, atau bahkan dengan diri sendiri.</p>

        <h3>3. Pelajari Vocabulary dalam Konteks</h3>
        <p>Jangan menghafal kata-kata secara terpisah. Pelajari kata-kata dalam kalimat dan situasi yang relevan.</p>

        <h3>4. Fokus pada Pronunciation</h3>
        <p>Pelajari cara pengucapan yang benar. Gunakan aplikasi atau video tutorial untuk melatih pronunciation.</p>

        <h3>5. Tulis dalam Bahasa Inggris</h3>
        <p>Menulis membantu memperkuat pemahaman grammar dan vocabulary. Mulai dengan diary atau blog sederhana.</p>

        <h3>6. Gunakan Language Learning Apps</h3>
        <p>Aplikasi seperti Duolingo, Babbel, atau Memrise dapat membantu belajar secara terstruktur dan menyenangkan.</p>

        <h3>7. Bergabung dengan English Club</h3>
        <p>Bergabung dengan komunitas yang menggunakan bahasa Inggris memberikan kesempatan untuk praktik secara rutin.</p>

        <h3>8. Pelajari Grammar Secara Bertahap</h3>
        <p>Fokus pada grammar yang paling sering digunakan terlebih dahulu, kemudian tingkatkan ke level yang lebih kompleks.</p>

        <h3>9. Dengarkan Podcast Bahasa Inggris</h3>
        <p>Podcast membantu melatih listening skill dan memberikan exposure pada berbagai aksen dan gaya berbicara.</p>

        <h3>10. Jangan Takut Salah</h3>
        <p>Kesalahan adalah bagian dari proses belajar. Fokus pada komunikasi, bukan kesempurnaan grammar.</p>

        <h3>Kesimpulan</h3>
        <p>Menguasai bahasa Inggris membutuhkan waktu dan konsistensi. Dengan metode yang tepat dan latihan rutin, Anda dapat meningkatkan kemampuan bahasa Inggris secara signifikan.</p>';
    }

    private function getKarirContent()
    {
        return '<h2>Pilihan Jurusan Kuliah yang Menjanjikan</h2>
        
        <p>Memilih jurusan kuliah adalah keputusan penting yang mempengaruhi masa depan karir. Berikut adalah analisis mendalam tentang jurusan yang memiliki prospek cerah di masa depan.</p>

        <h3>1. Teknologi Informasi</h3>
        <p>Jurusan IT tetap menjadi pilihan terdepan dengan perkembangan teknologi yang pesat. Prospek karir meliputi software developer, data scientist, dan cybersecurity expert.</p>

        <h3>2. Data Science dan Analytics</h3>
        <p>Era big data membutuhkan profesional yang dapat menganalisis dan menginterpretasikan data. Karir di bidang ini sangat menjanjikan.</p>

        <h3>3. Kesehatan dan Kedokteran</h3>
        <p>Bidang kesehatan selalu dibutuhkan. Selain dokter, profesi seperti farmasi, keperawatan, dan kesehatan masyarakat memiliki prospek yang baik.</p>

        <h3>4. Ekonomi dan Bisnis</h3>
        <p>Jurusan ekonomi, manajemen, dan bisnis memberikan fondasi yang kuat untuk berbagai karir di dunia bisnis dan keuangan.</p>

        <h3>5. Pendidikan</h3>
        <p>Pendidikan adalah investasi jangka panjang. Profesi guru dan tenaga kependidikan tetap dibutuhkan seiring pertumbuhan populasi.</p>

        <h3>6. Lingkungan dan Sustainability</h3>
        <p>Kesadaran lingkungan yang meningkat membuka peluang karir di bidang environmental science dan sustainable development.</p>

        <h3>7. Psikologi</h3>
        <p>Kesadaran akan kesehatan mental yang meningkat membuat profesi psikolog semakin dibutuhkan di berbagai sektor.</p>

        <h3>8. Marketing Digital</h3>
        <p>Perkembangan e-commerce dan digital marketing menciptakan peluang karir yang luas di bidang pemasaran digital.</p>

        <h3>9. Hukum</h3>
        <p>Profesi hukum tetap relevan dengan kompleksitas hukum yang semakin meningkat di era digital.</p>

        <h3>10. Seni dan Desain</h3>
        <p>Industri kreatif yang berkembang pesat membuka peluang karir di bidang desain grafis, animasi, dan multimedia.</p>

        <h3>Faktor yang Perlu Dipertimbangkan</h3>
        <p>Selain prospek karir, pertimbangkan juga minat, bakat, dan nilai-nilai pribadi dalam memilih jurusan kuliah.</p>

        <h3>Kesimpulan</h3>
        <p>Pilihan jurusan kuliah harus berdasarkan kombinasi antara prospek karir, minat pribadi, dan kemampuan. Lakukan riset mendalam sebelum membuat keputusan.</p>';
    }

    private function getFisikaContent()
    {
        return '<h2>Belajar Fisika dengan Eksperimen Sederhana</h2>
        
        <p>Fisika sering dianggap sebagai mata pelajaran yang sulit karena konsepnya yang abstrak. Namun, melalui eksperimen sederhana, fisika bisa menjadi pelajaran yang menyenangkan dan mudah dipahami.</p>

        <h3>1. Eksperimen Gravitasi</h3>
        <p>Jatuhkan dua benda dengan berat berbeda dari ketinggian yang sama. Ini membuktikan bahwa semua benda jatuh dengan kecepatan yang sama (jika hambatan udara diabaikan).</p>

        <h3>2. Eksperimen Gelombang</h3>
        <p>Gunakan tali atau slinky untuk mendemonstrasikan gelombang transversal dan longitudinal. Ini membantu memahami konsep gelombang.</p>

        <h3>3. Eksperimen Listrik Statis</h3>
        <p>Gosok balon pada rambut dan dekatkan ke kertas kecil. Ini mendemonstrasikan konsep muatan listrik dan gaya elektrostatik.</p>

        <h3>4. Eksperimen Optik</h3>
        <p>Gunakan cermin dan lensa untuk mendemonstrasikan pemantulan dan pembiasan cahaya. Ini membantu memahami konsep optik geometri.</p>

        <h3>5. Eksperimen Termodinamika</h3>
        <p>Panaskan air dalam panci tertutup dan amati perubahan tekanan. Ini mendemonstrasikan hubungan antara suhu dan tekanan.</p>

        <h3>6. Eksperimen Magnet</h3>
        <p>Gunakan magnet dan benda-benda logam untuk mendemonstrasikan sifat magnetik dan medan magnet.</p>

        <h3>7. Eksperimen Suara</h3>
        <p>Gunakan gelas berisi air dengan ketinggian berbeda untuk mendemonstrasikan konsep frekuensi dan resonansi.</p>

        <h3>8. Eksperimen Energi</h3>
        <p>Buat pendulum sederhana untuk mendemonstrasikan transformasi energi kinetik dan potensial.</p>

        <h3>9. Eksperimen Fluida</h3>
        <p>Gunakan air dan minyak untuk mendemonstrasikan konsep massa jenis dan tekanan hidrostatik.</p>

        <h3>10. Eksperimen Gerak</h3>
        <p>Gunakan mainan mobil atau bola untuk mendemonstrasikan konsep kecepatan, percepatan, dan momentum.</p>

        <h3>Tips Melakukan Eksperimen</h3>
        <p>Selalu lakukan eksperimen dengan pengawasan orang dewasa, gunakan alat yang aman, dan catat hasil pengamatan dengan teliti.</p>

        <h3>Kesimpulan</h3>
        <p>Eksperimen sederhana membuat fisika lebih konkret dan mudah dipahami. Kombinasikan teori dengan praktik untuk hasil belajar yang optimal.</p>';
    }

    private function getKesehatanMentalContent()
    {
        return '<h2>Menjaga Kesehatan Mental Saat Belajar</h2>
        
        <p>Kesehatan mental sama pentingnya dengan kesehatan fisik dalam proses pembelajaran. Stres akademik yang berlebihan dapat mempengaruhi performa belajar dan kesejahteraan secara keseluruhan.</p>

        <h3>1. Kenali Tanda Stres</h3>
        <p>Waspadai gejala stres seperti sulit tidur, mudah marah, kehilangan nafsu makan, atau kesulitan berkonsentrasi.</p>

        <h3>2. Tetapkan Batasan yang Sehat</h3>
        <p>Jangan terlalu memaksakan diri. Tetapkan target yang realistis dan berikan waktu istirahat yang cukup.</p>

        <h3>3. Praktikkan Teknik Relaksasi</h3>
        <p>Teknik pernapasan dalam, meditasi, atau yoga dapat membantu mengurangi stres dan kecemasan.</p>

        <h3>4. Jaga Rutinitas yang Sehat</h3>
        <p>Tidur yang cukup, makan bergizi, dan olahraga rutin sangat penting untuk kesehatan mental yang optimal.</p>

        <h3>5. Jangan Bandingkan Diri dengan Orang Lain</h3>
        <p>Setiap orang memiliki kecepatan dan gaya belajar yang berbeda. Fokus pada kemajuan diri sendiri.</p>

        <h3>6. Cari Dukungan Sosial</h3>
        <p>Berbicara dengan teman, keluarga, atau konselor dapat membantu meringankan beban mental.</p>

        <h3>7. Kelola Ekspektasi</h3>
        <p>Terima bahwa tidak semua hal akan berjalan sempurna. Belajar dari kesalahan dan kegagalan adalah bagian dari proses.</p>

        <h3>8. Lakukan Aktivitas yang Menyenangkan</h3>
        <p>Sisihkan waktu untuk hobi dan aktivitas yang Anda nikmati. Ini membantu menyeimbangkan tekanan akademik.</p>

        <h3>9. Praktikkan Self-Care</h3>
        <p>Lakukan hal-hal yang membuat Anda merasa baik, seperti mandi air hangat, membaca buku favorit, atau mendengarkan musik.</p>

        <h3>10. Jangan Ragu Mencari Bantuan Profesional</h3>
        <p>Jika stres atau kecemasan mengganggu kehidupan sehari-hari, jangan ragu untuk berkonsultasi dengan psikolog atau konselor.</p>

        <h3>Kesimpulan</h3>
        <p>Kesehatan mental adalah fondasi untuk pembelajaran yang efektif. Dengan perawatan yang tepat, Anda dapat mencapai potensi akademik maksimal sambil menjaga kesejahteraan mental.</p>';
    }
}
