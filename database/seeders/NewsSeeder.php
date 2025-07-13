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
                'description' => 'Kurikulum Merdeka merupakan inisiatif pemerintah Indonesia untuk mentransformasi sistem pendidikan nasional. Program ini dirancang untuk memberikan fleksibilitas yang lebih besar kepada sekolah dalam mengembangkan pembelajaran yang sesuai dengan kebutuhan dan karakteristik siswa.

Kurikulum Merdeka menekankan pada pengembangan kompetensi siswa melalui pembelajaran yang lebih kontekstual dan relevan dengan kehidupan sehari-hari. Beberapa prinsip utama dari kurikulum ini meliputi pembelajaran berbasis proyek, penilaian yang lebih holistik, dan pengembangan karakter siswa.

Implementasi Kurikulum Merdeka dilakukan secara bertahap, dimulai dengan sekolah-sekolah yang telah siap dan memiliki kapasitas yang memadai. Pemerintah juga menyediakan berbagai dukungan seperti pelatihan guru, pengembangan bahan ajar, dan monitoring implementasi.

Dampak positif dari Kurikulum Merdeka diharapkan dapat meningkatkan kualitas pendidikan di Indonesia, menghasilkan lulusan yang lebih siap menghadapi tantangan global, dan mendorong inovasi dalam proses pembelajaran.

Sekolah yang telah mengimplementasikan Kurikulum Merdeka melaporkan peningkatan motivasi belajar siswa, kreativitas dalam pembelajaran, dan keterlibatan yang lebih aktif dari semua pemangku kepentingan pendidikan.',
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
                'description' => 'Seleksi Nasional Berdasarkan Tes (SNBT) 2025 menghadirkan format baru yang menuntut persiapan yang lebih matang dari calon mahasiswa. Berikut adalah strategi komprehensif untuk menghadapi SNBT 2025.

Pertama, pahami dengan baik struktur tes yang terdiri dari Tes Potensi Skolastik (TPS) dan Tes Literasi dalam Bahasa Indonesia dan Bahasa Inggris. TPS mengukur kemampuan penalaran umum, pengetahuan kuantitatif, pengetahuan dan pemahaman umum, serta kemampuan memahami bacaan dan menulis.

Untuk persiapan TPS, latih kemampuan logika dan matematika dasar secara rutin. Kerjakan soal-soal latihan yang beragam dan analisis pola soal yang sering muncul. Fokus pada pemahaman konsep, bukan hanya menghafal rumus.

Untuk tes literasi, tingkatkan kemampuan membaca cepat dan pemahaman. Latih diri untuk mengidentifikasi ide pokok, kesimpulan, dan hubungan antar paragraf. Perbanyak membaca artikel ilmiah, berita, dan teks akademik.

Manajemen waktu sangat kritis dalam SNBT. Latih diri untuk mengerjakan soal dengan batas waktu yang ketat. Buat strategi prioritas soal berdasarkan tingkat kesulitan dan kemampuan diri.

Jangan lupa untuk menjaga kesehatan fisik dan mental menjelang tes. Istirahat yang cukup, makan makanan bergizi, dan lakukan relaksasi untuk mengurangi stres. Kepercayaan diri dan mental yang positif sangat mempengaruhi performa tes.

Terakhir, ikuti tryout resmi yang diselenggarakan oleh panitia SNBT untuk mengukur kesiapan dan menyesuaikan strategi belajar.',
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
                'description' => 'Dalam rangka mendukung transformasi digital di dunia pendidikan, kami mengundang seluruh tenaga pendidik, mahasiswa, dan pemerhati pendidikan untuk mengikuti serangkaian webinar gratis yang akan diselenggarakan sepanjang tahun 2025.

Webinar ini menghadirkan para pakar nasional dan internasional yang akan membahas berbagai topik terkait inovasi pendidikan digital. Setiap sesi webinar dirancang untuk memberikan wawasan praktis yang dapat langsung diterapkan dalam proses pembelajaran.

Topik yang akan dibahas meliputi integrasi teknologi dalam pembelajaran, pengembangan konten digital yang menarik, strategi pembelajaran hybrid, penilaian berbasis teknologi, dan pengembangan kompetensi digital siswa.

Setiap peserta webinar akan mendapatkan sertifikat kehadiran yang dapat digunakan untuk pengembangan profesional. Materi webinar juga akan tersedia untuk diunduh setelah acara selesai.

Webinar akan diselenggarakan secara online melalui platform Zoom dan YouTube Live, sehingga dapat diakses dari mana saja. Pendaftaran dibuka untuk umum dan tidak dipungut biaya apapun.

Jadwal webinar akan diumumkan secara berkala melalui website resmi dan media sosial kami. Pastikan untuk mendaftar lebih awal karena kuota peserta terbatas untuk setiap sesi.

Selain webinar, kami juga akan menyelenggarakan workshop praktis dan kompetisi inovasi pendidikan digital yang memberikan hadiah total jutaan rupiah.',
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
                'description' => 'Pemerintah Indonesia melalui berbagai kementerian dan lembaga menyediakan berbagai program beasiswa S1 untuk siswa berprestasi yang ingin melanjutkan pendidikan tinggi di dalam negeri. Berikut adalah informasi lengkap mengenai beasiswa yang tersedia.

Beasiswa KIP-Kuliah (Kartu Indonesia Pintar Kuliah) merupakan program utama pemerintah yang memberikan bantuan biaya pendidikan dan biaya hidup bagi mahasiswa dari keluarga kurang mampu. Beasiswa ini mencakup biaya kuliah penuh dan tunjangan hidup bulanan.

Beasiswa Bidikmisi diperluas untuk menjangkau lebih banyak mahasiswa berprestasi. Program ini tidak hanya melihat prestasi akademik, tetapi juga mempertimbangkan prestasi non-akademik seperti olahraga, seni, dan kepemimpinan.

Beasiswa dari berbagai perusahaan swasta juga tersedia dengan persyaratan yang beragam. Beberapa perusahaan menawarkan beasiswa dengan ikatan dinas, sementara yang lain memberikan beasiswa penuh tanpa ikatan.

Untuk mendaftar beasiswa, persiapkan dokumen yang diperlukan seperti surat keterangan tidak mampu, ijazah dan transkrip nilai, surat rekomendasi, dan esai motivasi. Pastikan semua dokumen lengkap dan valid.

Proses seleksi beasiswa biasanya meliputi seleksi administrasi, tes akademik, wawancara, dan home visit. Persiapkan diri dengan baik untuk setiap tahap seleksi.

Informasi lebih detail mengenai setiap program beasiswa dapat diakses melalui website resmi masing-masing penyelenggara. Jangan ragu untuk menghubungi panitia beasiswa jika ada pertanyaan.',
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
                'description' => 'Pemerintah Indonesia resmi menghapus Ujian Nasional (UN) dan menggantinya dengan sistem penilaian yang lebih komprehensif. Perubahan ini menandai transformasi besar dalam sistem evaluasi pendidikan di Indonesia.

Sistem pengganti UN terdiri dari beberapa komponen yang saling melengkapi. Pertama, Asesmen Nasional (AN) yang mengukur kompetensi literasi, numerasi, dan karakter siswa. AN tidak menentukan kelulusan siswa, tetapi digunakan untuk evaluasi sistem pendidikan.

Kedua, penilaian oleh guru menjadi komponen utama dalam menentukan kelulusan siswa. Guru diberikan kepercayaan penuh untuk menilai kemampuan siswa berdasarkan berbagai aspek seperti pengetahuan, keterampilan, dan sikap.

Ketiga, penilaian berbasis portofolio memungkinkan siswa menunjukkan kemampuan mereka melalui berbagai karya dan proyek yang telah dikerjakan selama masa belajar.

Keempat, ujian sekolah yang diselenggarakan oleh masing-masing sekolah dengan standar yang ditetapkan oleh pemerintah daerah.

Perubahan ini memberikan fleksibilitas yang lebih besar kepada sekolah dalam mengembangkan sistem penilaian yang sesuai dengan karakteristik dan kebutuhan siswa. Sekolah dapat mengembangkan instrumen penilaian yang lebih inovatif dan kontekstual.

Dampak positif dari perubahan ini diharapkan dapat mengurangi stres siswa, meningkatkan kualitas pembelajaran, dan menghasilkan lulusan yang lebih siap menghadapi tantangan masa depan.',
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
                'description' => 'Komunitas Guru Inovatif adalah wadah berkumpulnya para pendidik yang memiliki semangat untuk terus belajar dan berinovasi dalam mengembangkan metode pembelajaran yang efektif dan menarik.

Komunitas ini menyediakan platform untuk berbagi pengalaman, ide, dan praktik terbaik dalam dunia pendidikan. Melalui forum diskusi online, workshop rutin, dan program mentoring, guru dapat mengembangkan kompetensi profesional mereka.

Setiap bulan, komunitas menyelenggarakan webinar dengan tema yang berbeda-beda, menghadirkan pembicara dari kalangan akademisi, praktisi pendidikan, dan inovator teknologi pendidikan. Webinar ini memberikan wawasan terbaru tentang tren pendidikan dan inovasi pembelajaran.

Program mentoring mempertemukan guru senior dengan guru muda untuk berbagi pengalaman dan memberikan bimbingan dalam mengembangkan karir pendidikan. Program ini membantu guru muda untuk tumbuh dan berkembang dengan lebih cepat.

Komunitas juga mengembangkan bank materi pembelajaran yang dapat diakses oleh semua anggota. Materi ini mencakup rencana pelaksanaan pembelajaran, media pembelajaran, dan instrumen penilaian yang inovatif.

Selain itu, komunitas menyelenggarakan berbagai kompetisi dan lomba inovasi pembelajaran yang memberikan apresiasi dan hadiah kepada guru yang berhasil mengembangkan metode pembelajaran kreatif.

Keanggotaan komunitas terbuka untuk semua guru dari berbagai jenjang pendidikan. Pendaftaran dapat dilakukan melalui website resmi komunitas atau menghubungi panitia melalui media sosial.',
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
                'description' => 'Lomba Sains Nasional (LSN) 2025 akan diselenggarakan dengan format yang lebih inovatif dan menarik. Kompetisi ini dirancang untuk mengembangkan minat dan bakat siswa dalam bidang sains dan teknologi.

LSN 2025 terdiri dari beberapa kategori lomba yang mencakup berbagai bidang sains seperti fisika, kimia, biologi, matematika, dan teknologi informasi. Setiap kategori dirancang untuk menguji kemampuan analitis, kreativitas, dan pemecahan masalah siswa.

Proses seleksi dilakukan secara bertahap, dimulai dari tingkat sekolah, kabupaten/kota, provinsi, hingga tingkat nasional. Setiap tahap memiliki kriteria penilaian yang berbeda dan semakin menantang.

Para pemenang LSN akan mendapatkan beasiswa pendidikan, kesempatan mengikuti pelatihan khusus, dan representasi Indonesia dalam kompetisi sains internasional.

Selain kompetisi individual, LSN 2025 juga menyelenggarakan kompetisi tim yang memungkinkan siswa bekerja sama dalam mengembangkan proyek sains inovatif. Kompetisi ini mendorong kolaborasi dan kerja tim antar siswa.

Pendaftaran LSN 2025 dibuka untuk siswa SD, SMP, dan SMA dari seluruh Indonesia. Informasi lengkap mengenai persyaratan, jadwal, dan mekanisme pendaftaran dapat diakses melalui website resmi LSN.

Kompetisi ini tidak hanya bertujuan untuk mencari bakat-bakat unggul dalam bidang sains, tetapi juga untuk menumbuhkan budaya ilmiah dan semangat inovasi di kalangan siswa Indonesia.',
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
                'description' => 'Kecerdasan Buatan (AI) mulai diterapkan di berbagai sekolah di Indonesia untuk meningkatkan kualitas pembelajaran dan efisiensi administrasi pendidikan. Implementasi AI dalam pendidikan membuka peluang baru untuk personalisasi pembelajaran.

Sistem AI dapat menganalisis pola belajar setiap siswa dan memberikan rekomendasi materi pembelajaran yang sesuai dengan kemampuan dan gaya belajar mereka. Hal ini memungkinkan pembelajaran yang lebih personal dan efektif.

AI juga digunakan untuk mengembangkan sistem penilaian otomatis yang dapat memberikan feedback instan kepada siswa. Sistem ini tidak hanya menilai jawaban benar atau salah, tetapi juga memberikan penjelasan dan saran perbaikan.

Dalam administrasi sekolah, AI membantu mengoptimalkan jadwal pelajaran, mengelola inventaris, dan menganalisis data kehadiran siswa. Hal ini mengurangi beban administrasi guru dan staf sekolah.

Chatbot AI dikembangkan untuk menjawab pertanyaan siswa dan orang tua secara real-time. Chatbot ini dapat memberikan informasi tentang jadwal pelajaran, tugas, dan kegiatan sekolah.

Meskipun AI menawarkan banyak manfaat, implementasinya harus dilakukan dengan hati-hati. Penting untuk memastikan bahwa AI tidak menggantikan peran guru, tetapi membantu guru dalam memberikan pembelajaran yang lebih baik.

Pelatihan guru dalam penggunaan teknologi AI menjadi kunci keberhasilan implementasi. Guru perlu memahami cara menggunakan AI sebagai alat bantu pembelajaran yang efektif.',
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
                'description' => 'Belajar mandiri menjadi semakin penting di era digital, terutama setelah pandemi yang mengubah cara kita belajar. Berikut adalah panduan komprehensif untuk mengembangkan kemampuan belajar mandiri yang efektif.

Pertama, tetapkan tujuan belajar yang jelas dan spesifik. Tujuan yang jelas membantu Anda fokus dan mengukur kemajuan belajar. Buat tujuan yang realistis dan dapat dicapai dalam waktu tertentu.

Kedua, buat jadwal belajar yang konsisten. Alokasikan waktu tertentu setiap hari untuk belajar, meskipun hanya 30 menit. Konsistensi lebih penting daripada durasi belajar yang panjang tapi tidak teratur.

Ketiga, pilih metode belajar yang sesuai dengan gaya belajar Anda. Beberapa orang lebih suka belajar visual melalui video dan diagram, sementara yang lain lebih suka belajar auditori melalui podcast atau diskusi.

Keempat, gunakan teknologi untuk mendukung pembelajaran. Aplikasi pembelajaran, platform online course, dan sumber daya digital dapat memperkaya pengalaman belajar Anda.

Kelima, praktikkan teknik pembelajaran aktif seperti membuat catatan, mengajarkan materi kepada orang lain, dan mengerjakan latihan soal. Pembelajaran aktif lebih efektif daripada hanya membaca atau mendengarkan.

Keenam, evaluasi kemajuan belajar secara berkala. Refleksi membantu Anda mengidentifikasi area yang perlu diperbaiki dan menyesuaikan strategi belajar.

Terakhir, jaga motivasi belajar dengan memberikan reward kepada diri sendiri ketika mencapai target tertentu. Motivasi internal adalah kunci keberhasilan belajar mandiri.',
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
                'description' => 'Pendidikan karakter menjadi semakin penting dalam menghadapi tantangan global yang kompleks. Karakter yang kuat tidak hanya penting untuk kesuksesan akademik, tetapi juga untuk kehidupan sosial dan profesional.

Pendidikan karakter mengembangkan nilai-nilai fundamental seperti integritas, tanggung jawab, empati, dan kerja keras. Nilai-nilai ini menjadi fondasi yang kuat untuk menghadapi berbagai situasi dalam kehidupan.

Di sekolah, pendidikan karakter dapat diintegrasikan dalam semua mata pelajaran. Guru dapat menggunakan contoh-contoh dari kehidupan nyata untuk mengajarkan nilai-nilai karakter kepada siswa.

Kegiatan ekstrakurikuler juga memainkan peran penting dalam pengembangan karakter. Melalui kegiatan seperti olahraga, seni, dan kepemimpinan, siswa belajar tentang kerja tim, disiplin, dan kreativitas.

Peran keluarga dalam pendidikan karakter tidak kalah penting. Orang tua harus menjadi teladan yang baik dan memberikan bimbingan yang konsisten kepada anak-anak mereka.

Masyarakat juga berkontribusi dalam pengembangan karakter melalui berbagai program dan kegiatan yang mendukung nilai-nilai positif.

Pendidikan karakter yang efektif membutuhkan kolaborasi antara sekolah, keluarga, dan masyarakat. Ketiga elemen ini harus bekerja sama untuk menciptakan lingkungan yang mendukung pengembangan karakter yang positif.

Dampak pendidikan karakter yang baik akan terlihat dalam jangka panjang, menghasilkan individu yang tidak hanya cerdas secara akademik, tetapi juga memiliki moral dan etika yang kuat.',
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