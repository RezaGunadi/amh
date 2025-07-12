<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->input('search');
        $selectedCategory = $request->input('category');

        // Define categories
        $categories = [
            'Semua',
            'Tips Belajar',
            'Olimpiade',
            'Pendidikan',
            'Kurikulum',
            'Ujian Nasional'
        ];

        // SEO-optimized articles data
        $allArticles = $this->getArticles();

        // Filter articles based on search and category
        $filteredArticles = collect($allArticles);
        if ($search) {
            $filteredArticles = $filteredArticles->filter(function ($article) use ($search) {
                return str_contains($article['title'], $search) || str_contains($article['description'], $search) || str_contains($article['content'], $search);
            });
        }
        if ($selectedCategory && $selectedCategory !== 'Semua') {
            $filteredArticles = $filteredArticles->filter(function ($article) use ($selectedCategory) {
                return $article['category'] === $selectedCategory;
            });
        }

        // Paginate the filtered articles
        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $total = $filteredArticles->count();
        $articles = $filteredArticles->forPage($currentPage, $perPage);

        return view('news.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $currentPage
        ]);
    }

    public function show($id)
    {
        // Get the same articles data as in index method
        $allArticles = $this->getArticles();

        // Find the article by ID
        $article = collect($allArticles)->firstWhere('id', $id);

        if (!$article) {
            abort(404);
        }

        // Get related articles (same category, excluding current article)
        $relatedArticles = collect($allArticles)
            ->filter(function ($item) use ($article) {
                return $item['id'] !== $article['id'] && $item['category'] === $article['category'];
            })
            ->take(3);

        return view('news.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }

    private function getArticles()
    {
        return [
            [
                'id' => 1,
                'title' => 'Tips Sukses Masuk PTN Favorit: Strategi Jitu Lolos SNBP dan SNBT 2024',
                'category' => 'Tips Belajar',
                'description' => 'Panduan lengkap strategi dan tips jitu untuk lolos seleksi masuk PTN favorit seperti UI, ITB, UGM, dan IPB melalui jalur SNBP dan SNBT 2024.',
                'content' => 'Memasuki Perguruan Tinggi Negeri (PTN) favorit merupakan impian banyak siswa SMA di Indonesia. Dengan persiapan yang matang dan strategi yang tepat, impian tersebut bisa menjadi kenyataan. Berikut adalah panduan lengkap untuk meraih kesuksesan dalam seleksi masuk PTN:

1. Kenali Jalur Masuk PTN 2024
- SNBP (Seleksi Nasional Berdasarkan Prestasi)
  * Berdasarkan nilai rapor dan prestasi akademik
  * Kuota minimal 20% dari daya tampung
  * Tidak ada tes tertulis
- SNBT (Seleksi Nasional Berdasarkan Tes)
  * Tes Potensi Skolastik (TPS)
  * Tes Literasi dalam Bahasa Indonesia dan Inggris
  * Tes Penalaran Matematika
- Jalur Mandiri
  * Dilaksanakan oleh masing-masing PTN
  * Biaya lebih tinggi
  * Persaingan lebih ketat

2. Persiapkan Diri Sejak Dini
- Buat jadwal belajar yang teratur
  * Alokasikan waktu untuk setiap mata pelajaran
  * Prioritaskan materi yang sering keluar
  * Sesuaikan dengan kemampuan dan kebutuhan
- Ikuti try out berkala
  * Evaluasi kemampuan secara rutin
  * Kenali pola soal
  * Latih manajemen waktu
- Pelajari soal-soal tahun sebelumnya
  * Analisis tipe soal
  * Pahami konsep dasar
  * Latih kemampuan analisis
- Bergabung dengan bimbingan belajar atau les privat
  * Dapatkan bimbingan intensif
  * Konsultasi dengan tutor berpengalaman
  * Akses materi dan soal-soal berkualitas

3. Kuasai Materi Ujian
- Fokus pada materi yang sering keluar
  * Matematika dasar
  * Bahasa Indonesia
  * Bahasa Inggris
  * Penalaran logika
- Latih kemampuan penalaran dan logika
  * Soal-soal TPS
  * Analisis kasus
  * Pemecahan masalah
- Perbanyak latihan soal-soal TPS
  * Pemahaman bacaan
  * Penalaran matematika
  * Pengetahuan umum
- Pelajari materi dasar dengan baik
  * Konsep fundamental
  * Rumus-rumus penting
  * Teknik penyelesaian soal

4. Jaga Kesehatan dan Kondisi Fisik
- Tidur yang cukup
  * Minimal 7-8 jam per hari
  * Hindari begadang
  * Atur jadwal tidur teratur
- Olahraga teratur
  * Minimal 30 menit per hari
  * Pilih olahraga yang disukai
  * Jaga kebugaran tubuh
- Konsumsi makanan bergizi
  * Sarapan pagi
  * Makan teratur
  * Hindari junk food
- Hindari begadang
  * Atur jadwal belajar
  * Prioritaskan istirahat
  * Jaga kesehatan mental

5. Manajemen Waktu yang Baik
- Buat jadwal belajar yang efektif
  * Tentukan target harian
  * Alokasikan waktu istirahat
  * Evaluasi progress secara rutin
- Atur prioritas dengan baik
  * Fokus pada materi penting
  * Sesuaikan dengan kemampuan
  * Jangan menunda-nunda
- Hindari prokrastinasi
  * Mulai dari yang mudah
  * Pecah tugas besar menjadi kecil
  * Tetap konsisten
- Luangkan waktu untuk refreshing
  * Hobi dan aktivitas menyenangkan
  * Istirahat yang cukup
  * Jaga keseimbangan hidup

6. Bergabung dengan Komunitas Belajar
- Diskusi dengan teman-teman
  * Berbagi pengalaman
  * Bertukar informasi
  * Motivasi bersama
- Ikut grup belajar online
  * Akses materi tambahan
  * Diskusi dengan peserta lain
  * Update informasi terbaru
- Konsultasi dengan guru atau tutor
  * Tanya jawab materi
  * Evaluasi kemampuan
  * Dapatkan tips dan trik
- Berbagi pengalaman dengan senior
  * Belajar dari pengalaman
  * Dapatkan insight
  * Motivasi dan inspirasi

7. Persiapan Mental
- Tetap percaya diri
  * Kenali kemampuan diri
  * Fokus pada progress
  * Jangan bandingkan dengan orang lain
- Jangan mudah menyerah
  * Hadapi tantangan
  * Belajar dari kegagalan
  * Tetap semangat
- Hadapi kegagalan sebagai pembelajaran
  * Evaluasi kesalahan
  * Perbaiki kelemahan
  * Tingkatkan kemampuan
- Fokus pada tujuan akhir
  * Visualisasikan kesuksesan
  * Tetap termotivasi
  * Jaga semangat belajar

8. Tips Saat Ujian
- Baca soal dengan teliti
  * Pahami instruksi
  * Analisis pertanyaan
  * Perhatikan kata kunci
- Kerjakan soal yang mudah terlebih dahulu
  * Tingkatkan kepercayaan diri
  * Hemat waktu
  * Hindari kecemasan
- Perhatikan waktu pengerjaan
  * Alokasikan waktu per soal
  * Jangan terlalu lama di satu soal
  * Sediakan waktu untuk review
- Periksa kembali jawaban
  * Pastikan tidak ada yang terlewat
  * Periksa perhitungan
  * Pastikan jawaban sesuai

Ingat, kesuksesan masuk PTN favorit membutuhkan persiapan yang matang dan konsisten. Mulailah persiapan sejak dini dan jangan ragu untuk mencari bantuan dari guru, tutor, atau lembaga bimbingan belajar terpercaya seperti KelasPrivat.id. Dengan tekad yang kuat dan strategi yang tepat, impian masuk PTN favorit bisa menjadi kenyataan.',
                'author' => 'Dr. Budi Santoso, M.Pd.',
                'time' => '2 jam yang lalu',
                'image' => 'tips-ptn.svg',
                'featured' => true
            ],
            [
                'id' => 2,
                'title' => 'Cara Efektif Belajar Matematika: Tips dan Trik untuk Siswa SD hingga SMA',
                'category' => 'Tips Belajar',
                'description' => 'Metode belajar matematika yang menyenangkan dan mudah dipahami untuk siswa SD hingga SMA, dilengkapi dengan tips praktis dan strategi pembelajaran.',
                'content' => 'Matematika sering dianggap sebagai pelajaran yang sulit dan menakutkan. Namun, dengan metode belajar yang tepat, matematika bisa menjadi pelajaran yang menyenangkan dan mudah dipahami. Berikut adalah panduan lengkap cara efektif belajar matematika:

1. Pahami Konsep Dasar
- Mulai dari konsep paling dasar
  * Operasi hitung dasar
  * Bilangan dan sifatnya
  * Aljabar dasar
  * Geometri dasar
- Jangan menghafal rumus tanpa pemahaman
  * Pahami asal-usul rumus
  * Pelajari konsep di balik rumus
  * Latih penerapan rumus
- Buat catatan konsep dengan bahasa sendiri
  * Gunakan bahasa yang mudah dipahami
  * Buat contoh konkret
  * Tambahkan ilustrasi
- Gunakan analogi untuk memudahkan pemahaman
  * Hubungkan dengan kehidupan sehari-hari
  * Buat perumpamaan
  * Gunakan benda konkret

2. Latihan Rutin
- Kerjakan soal setiap hari
  * Minimal 5-10 soal per hari
  * Variasikan tingkat kesulitan
  * Fokus pada pemahaman
- Mulai dari soal mudah ke sulit
  * Bangun kepercayaan diri
  * Tingkatkan kemampuan bertahap
  * Hindari frustrasi
- Buat jadwal latihan yang konsisten
  * Tentukan waktu belajar
  * Sesuaikan dengan kemampuan
  * Evaluasi progress
- Review kesalahan dan pelajari solusinya
  * Analisis kesalahan
  * Pahami konsep yang salah
  * Latih kembali

3. Gunakan Metode Visual
- Gambar diagram
  * Visualisasi konsep
  * Peta konsep
  * Flow chart
- Buat mind mapping
  * Hubungkan konsep
  * Buat hierarki
  * Tambahkan contoh
- Gunakan warna untuk membedakan konsep
  * Kode warna untuk rumus
  * Highlight poin penting
  * Buat catatan berwarna
- Manfaatkan video pembelajaran
  * Tutorial online
  * Penjelasan visual
  * Contoh soal

4. Belajar Kelompok
- Diskusikan soal-soal sulit
  * Berbagi pemahaman
  * Bertukar ide
  * Saling membantu
- Ajarkan konsep ke teman
  * Perdalam pemahaman
  * Latih kemampuan menjelaskan
  * Dapatkan feedback
- Berbagi tips dan trik
  * Teknik penyelesaian
  * Rumus cepat
  * Strategi mengerjakan
- Latihan bersama secara rutin
  * Buat jadwal kelompok
  * Tentukan target
  * Evaluasi bersama

5. Manfaatkan Teknologi
- Gunakan aplikasi pembelajaran
  * Kalkulator grafik
  * Aplikasi latihan soal
  * Platform belajar online
- Tonton video tutorial
  * Penjelasan konsep
  * Contoh soal
  * Tips dan trik
- Ikut kelas online
  * Belajar fleksibel
  * Akses materi berkualitas
  * Interaksi dengan tutor
- Manfaatkan kalkulator grafik
  * Visualisasi fungsi
  * Analisis grafik
  * Pemahaman konsep

6. Tips Praktis
- Buat rumus cepat sendiri
  * Sesuaikan dengan kebutuhan
  * Mudah diingat
  * Efisien dalam penggunaan
- Catat trik-trik khusus
  * Teknik penyelesaian
  * Rumus praktis
  * Tips mengerjakan
- Buat bank soal pribadi
  * Kumpulkan soal sulit
  * Kategorikan berdasarkan topik
  * Review secara berkala
- Review materi secara berkala
  * Evaluasi pemahaman
  * Perbaiki kelemahan
  * Tingkatkan kemampuan

7. Atasi Kesulitan
- Identifikasi topik yang sulit
  * Analisis kesulitan
  * Cari solusi
  * Latih lebih intensif
- Cari bantuan dari guru atau tutor
  * Konsultasi masalah
  * Dapatkan penjelasan
  * Minta bimbingan
- Gunakan sumber belajar tambahan
  * Buku referensi
  * Video tutorial
  * Platform online
- Jangan menyerah pada soal sulit
  * Pecah masalah
  * Cari alternatif
  * Tetap berusaha

8. Persiapan Ujian
- Latihan soal ujian
  * Soal tahun sebelumnya
  * Try out
  * Simulasi ujian
- Manajemen waktu
  * Alokasi waktu per soal
  * Strategi pengerjaan
  * Review jawaban
- Review materi penting
  * Fokus pada konsep utama
  * Latih soal kunci
  * Perbaiki kelemahan
- Istirahat yang cukup
  * Jaga kesehatan
  * Hindari begadang
  * Siapkan mental

9. Motivasi Diri
- Tetapkan target belajar
  * Target harian
  * Target mingguan
  * Target jangka panjang
- Rayakan pencapaian kecil
  * Apresiasi diri
  * Tetap termotivasi
  * Tingkatkan kepercayaan
- Jangan takut salah
  * Belajar dari kesalahan
  * Perbaiki pemahaman
  * Tingkatkan kemampuan
- Percaya pada kemampuan diri
  * Kenali potensi
  * Tingkatkan kepercayaan
  * Tetap semangat

10. Tips untuk Orang Tua
- Dukung proses belajar anak
  * Berikan motivasi
  * Ciptakan suasana nyaman
  * Bantu saat dibutuhkan
- Berikan ruang untuk bertanya
  * Jadilah pendengar yang baik
  * Bantu mencari solusi
  * Berikan dukungan
- Ajak diskusi tentang matematika
  * Hubungkan dengan kehidupan
  * Berikan contoh konkret
  * Buat belajar menyenangkan
- Ciptakan suasana belajar yang nyaman
  * Sediakan tempat belajar
  * Atur jadwal
  * Hindari gangguan

Ingat, setiap orang memiliki cara belajar yang berbeda. Temukan metode yang paling cocok untuk Anda dan konsisten dalam menerapkannya. Dengan tekad dan usaha yang tepat, matematika bisa menjadi pelajaran yang menyenangkan dan bermanfaat. KelasPrivat.id siap membantu Anda mencapai kesuksesan dalam belajar matematika dengan program les privat yang disesuaikan dengan kebutuhan dan kemampuan Anda.',
                'author' => 'Prof. Rudi Hartono, M.Sc.',
                'time' => '1 hari yang lalu',
                'image' => 'matematika.svg',
                'featured' => false
            ],
            [
                'id' => 3,
                'title' => 'Persiapan Olimpiade Sains Nasional 2024: Panduan Lengkap untuk Siswa Berprestasi',
                'category' => 'Olimpiade',
                'description' => 'Panduan komprehensif persiapan Olimpiade Sains Nasional 2024, termasuk strategi belajar, tips sukses, dan persiapan mental untuk siswa berprestasi.',
                'content' => 'Olimpiade Sains Nasional (OSN) adalah ajang kompetisi sains bergengsi di Indonesia yang menjadi wadah pengembangan talenta-talenta muda di bidang sains. Berikut adalah panduan lengkap untuk mempersiapkan diri menghadapi OSN 2024:

1. Pemahaman Dasar OSN
- Pelajari silabus OSN
  * Bidang yang dilombakan
  * Materi yang diujikan
  * Format kompetisi
- Kenali format soal
  * Tipe soal
  * Tingkat kesulitan
  * Sistem penilaian
- Pahami sistem penilaian
  * Bobot nilai
  * Kriteria penilaian
  * Passing grade
- Ketahui jadwal kompetisi
  * Tahap seleksi
  * Waktu pelaksanaan
  * Deadline pendaftaran

2. Persiapan Materi
- Kuasai materi dasar
  * Konsep fundamental
  * Teori dasar
  * Rumus-rumus penting
- Pelajari materi lanjutan
  * Topik spesifik
  * Aplikasi konsep
  * Problem solving
- Latih kemampuan analisis
  * Analisis kasus
  * Pemecahan masalah
  * Penalaran logis
- Perdalam pemahaman konsep
  * Eksperimen
  * Diskusi
  * Praktikum

3. Strategi Belajar
- Buat jadwal belajar teratur
  * Alokasi waktu
  * Prioritas materi
  * Evaluasi progress
- Fokus pada bidang yang dikuasai
  * Kenali kelebihan
  * Tingkatkan kemampuan
  * Perbaiki kelemahan
- Latihan soal secara rutin
  * Soal tahun sebelumnya
  * Simulasi ujian
  * Try out
- Review materi secara berkala
  * Evaluasi pemahaman
  * Perbaiki kesalahan
  * Tingkatkan kemampuan

4. Sumber Belajar
- Buku teks dan referensi
  * Buku wajib
  * Buku pendamping
  * Jurnal ilmiah
- Soal-soal tahun sebelumnya
  * Analisis pola
  * Latihan rutin
  * Evaluasi kemampuan
- Video pembelajaran
  * Tutorial online
  * Penjelasan konsep
  * Contoh soal
- Materi online
  * Platform belajar
  * Artikel ilmiah
  * Forum diskusi

5. Persiapan Mental
- Bangun kepercayaan diri
  * Kenali kemampuan
  * Latih mental
  * Tetap positif
- Atasi kecemasan
  * Teknik relaksasi
  * Manajemen stress
  * Dukungan keluarga
- Latih ketahanan mental
  * Hadapi tekanan
  * Tetap fokus
  * Jaga semangat
- Tetap fokus pada tujuan
  * Visualisasikan kesuksesan
  * Tetap termotivasi
  * Jaga konsistensi

6. Tips Saat Kompetisi
- Baca soal dengan teliti
  * Pahami instruksi
  * Analisis pertanyaan
  * Perhatikan detail
- Atur waktu dengan baik
  * Alokasi waktu
  * Prioritas soal
  * Review jawaban
- Periksa jawaban
  * Pastikan benar
  * Periksa perhitungan
  * Pastikan lengkap
- Tetap tenang dan fokus
  * Kendalikan emosi
  * Jaga konsentrasi
  * Percaya diri

7. Dukungan
- Konsultasi dengan guru
  * Bimbingan akademis
  * Evaluasi kemampuan
  * Tips dan trik
- Bergabung dengan komunitas
  * Berbagi pengalaman
  * Diskusi materi
  * Motivasi bersama
- Ikut pelatihan khusus
  * Program intensif
  * Bimbingan expert
  * Simulasi kompetisi
- Dukungan dari keluarga
  * Motivasi
  * Fasilitas belajar
  * Dukungan moral

8. Evaluasi Diri
- Analisis kekuatan dan kelemahan
  * Kenali kemampuan
  * Identifikasi masalah
  * Cari solusi
- Perbaiki kesalahan
  * Review kesalahan
  * Perbaiki pemahaman
  * Latih kembali
- Tingkatkan kemampuan
  * Latihan rutin
  * Perdalam materi
  * Perbaiki strategi
- Tetapkan target baru
  * Target harian
  * Target mingguan
  * Target jangka panjang

9. Persiapan Fisik
- Istirahat yang cukup
  * Tidur teratur
  * Hindari begadang
  * Jaga kesehatan
- Olahraga teratur
  * Jaga kebugaran
  * Redakan stress
  * Tingkatkan konsentrasi
- Makan makanan bergizi
  * Diet seimbang
  * Vitamin dan mineral
  * Hindari junk food
- Jaga kesehatan
  * Check up rutin
  * Vaksinasi
  * Istirahat cukup

10. Tips Sukses
- Mulai persiapan sejak dini
  * Buat timeline
  * Tetapkan target
  * Konsisten belajar
- Konsisten dalam belajar
  * Jadwal teratur
  * Evaluasi rutin
  * Perbaiki kelemahan
- Jangan menyerah
  * Hadapi tantangan
  * Belajar dari kegagalan
  * Tetap semangat
- Nikmati proses belajar
  * Cari kesenangan
  * Tetap termotivasi
  * Jaga semangat

Ingat, OSN bukan hanya tentang kompetisi, tapi juga tentang pengembangan diri dan kemampuan. Fokus pada proses belajar dan pengembangan kemampuan, bukan hanya pada hasil akhir. KelasPrivat.id menyediakan program bimbingan khusus OSN dengan tutor berpengalaman yang siap membantu Anda meraih prestasi terbaik.',
                'author' => 'Dr. Siti Aminah, M.Sc.',
                'time' => '2 hari yang lalu',
                'image' => 'olimpiade.svg',
                'featured' => false
            ],
            [
                'id' => 4,
                'title' => 'Webinar: Strategi Sukses UTBK 2024 - Tips dan Trik Lolos PTN Favorit',
                'category' => 'Pendidikan',
                'description' => 'Rangkuman lengkap webinar strategi sukses UTBK 2024, termasuk perubahan sistem, tips mengerjakan soal, dan persiapan mental untuk lolos PTN favorit.',
                'content' => 'UTBK 2024 akan segera tiba. Berikut adalah rangkuman lengkap materi dari webinar "Strategi Sukses UTBK 2024" yang diselenggarakan oleh KelasPrivat.id:

1. Perubahan Sistem UTBK 2024
- Format soal baru
  * Tes Potensi Skolastik (TPS)
  * Tes Literasi dalam Bahasa Indonesia dan Inggris
  * Tes Penalaran Matematika
- Sistem penilaian
  * Bobot nilai
  * Passing grade
  * Kriteria kelulusan
- Jadwal pelaksanaan
  * Tahap pendaftaran
  * Pelaksanaan ujian
  * Pengumuman hasil
- Kuota penerimaan
  * SNBP (20%)
  * SNBT (40%)
  * Jalur Mandiri (40%)

2. Strategi Persiapan
- Buat timeline belajar
  * Target harian
  * Target mingguan
  * Target bulanan
- Kenali materi yang diujikan
  * Analisis kisi-kisi
  * Prioritaskan materi
  * Fokus pada konsep
- Latihan soal secara rutin
  * Soal tahun sebelumnya
  * Try out berkala
  * Simulasi ujian
- Ikut try out berkala
  * Evaluasi kemampuan
  * Kenali pola soal
  * Latih manajemen waktu

3. Tips Mengerjakan Soal
- Manajemen waktu
  * Alokasi waktu per soal
  * Prioritas pengerjaan
  * Review jawaban
- Teknik menjawab
  * Baca soal teliti
  * Analisis pertanyaan
  * Pilih jawaban tepat
- Strategi eliminasi
  * Hapus jawaban salah
  * Fokus pada opsi benar
  * Perhatikan detail
- Penanganan soal sulit
  * Lewati sementara
  * Kembali nanti
  * Jangan panik

4. Persiapan Mental
- Atasi kecemasan
  * Teknik relaksasi
  * Manajemen stress
  * Dukungan keluarga
- Bangun kepercayaan diri
  * Kenali kemampuan
  * Latih mental
  * Tetap positif
- Tetap fokus
  * Jaga konsentrasi
  * Hindari gangguan
  * Prioritaskan tujuan
- Jaga kesehatan
  * Istirahat cukup
  * Makan bergizi
  * Olahraga teratur

5. Sumber Belajar
- Materi online
  * Platform belajar
  * Video tutorial
  * Artikel edukasi
- Buku referensi
  * Buku wajib
  * Buku pendamping
  * Modul latihan
- Video pembelajaran
  * Tutorial konsep
  * Contoh soal
  * Tips dan trik
- Latihan soal
  * Bank soal
  * Try out
  * Simulasi

6. Dukungan
- Bimbingan belajar
  * Program intensif
  * Bimbingan expert
  * Evaluasi rutin
- Les privat
  * Belajar personal
  * Fokus kebutuhan
  * Fleksibel waktu
- Grup belajar
  * Diskusi materi
  * Berbagi pengalaman
  * Motivasi bersama
- Konsultasi dengan guru
  * Bimbingan akademis
  * Evaluasi kemampuan
  * Tips dan trik

7. Tips Sukses
- Mulai persiapan sejak dini
  * Buat timeline
  * Tetapkan target
  * Konsisten belajar
- Konsisten dalam belajar
  * Jadwal teratur
  * Evaluasi rutin
  * Perbaiki kelemahan
- Evaluasi kemampuan
  * Analisis kekuatan
  * Identifikasi kelemahan
  * Perbaiki strategi
- Tetapkan target
  * Target harian
  * Target mingguan
  * Target jangka panjang

8. Persiapan Teknis
- Cek perangkat
  * Komputer/laptop
  * Internet
  * Aplikasi ujian
- Siapkan dokumen
  * KTP
  * Kartu peserta
  * Dokumen pendukung
- Kenali lokasi ujian
  * Akses transportasi
  * Fasilitas
  * Prosedur
- Persiapan logistik
  * Makanan
  * Minuman
  * Obat-obatan

9. Manajemen Waktu
- Jadwal belajar
  * Alokasi waktu
  * Prioritas materi
  * Evaluasi progress
- Prioritas materi
  * Fokus pada konsep
  * Latihan rutin
  * Review berkala
- Waktu istirahat
  * Istirahat cukup
  * Olahraga
  * Refreshing
- Persiapan ujian
  * Simulasi
  * Try out
  * Review materi

10. Evaluasi Diri
- Analisis kemampuan
  * Kekuatan
  * Kelemahan
  * Peluang
- Perbaiki kelemahan
  * Identifikasi masalah
  * Cari solusi
  * Latih kembali
- Tingkatkan kemampuan
  * Latihan rutin
  * Perdalam materi
  * Perbaiki strategi
- Tetapkan target baru
  * Target harian
  * Target mingguan
  * Target jangka panjang

Ingat, kesuksesan dalam UTBK membutuhkan persiapan yang matang dan konsisten. Mulailah persiapan sejak dini dan jangan ragu untuk mencari bantuan dari guru, tutor, atau lembaga bimbingan belajar terpercaya seperti KelasPrivat.id. Dengan program bimbingan yang tepat dan dukungan yang maksimal, impian masuk PTN favorit bisa menjadi kenyataan.',
                'author' => 'Tim Akademik KelasPrivat.id',
                'time' => '3 hari yang lalu',
                'image' => 'webinar.svg',
                'featured' => false
            ],
            [
                'id' => 5,
                'title' => 'Kurikulum Merdeka 2024: Transformasi Pendidikan Indonesia',
                'category' => 'Kurikulum',
                'description' => 'Penjelasan komprehensif tentang Kurikulum Merdeka 2024, implementasi, dampak, dan peran stakeholders dalam transformasi pendidikan Indonesia.',
                'content' => 'Kurikulum Merdeka adalah kurikulum baru yang diterapkan oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi (Kemendikbudristek) sebagai upaya transformasi pendidikan Indonesia. Berikut adalah penjelasan lengkap tentang Kurikulum Merdeka:

1. Pengertian Kurikulum Merdeka
- Filosofi kurikulum
  * Merdeka belajar
  * Profil Pelajar Pancasila
  * Pendidikan holistik
- Tujuan penerapan
  * Peningkatan kualitas
  * Pengembangan karakter
  * Kesiapan masa depan
- Perbedaan dengan kurikulum sebelumnya
  * Fleksibilitas
  * Fokus kompetensi
  * Pembelajaran kontekstual
- Implementasi bertahap
  * Persiapan
  * Pelatihan
  * Evaluasi

2. Karakteristik Utama
- Fleksibilitas
  * Adaptasi kebutuhan
  * Pengembangan lokal
  * Inovasi pembelajaran
- Fokus pada kompetensi
  * Literasi
  * Numerasi
  * Karakter
- Pembelajaran berbasis proyek
  * Projek penguatan profil
  * Pembelajaran kontekstual
  * Kolaborasi
- Pengembangan karakter
  * Profil Pelajar Pancasila
  * Nilai-nilai luhur
  * Budaya sekolah

3. Struktur Kurikulum
- Mata pelajaran wajib
  * Pendidikan Agama
  * PPKn
  * Bahasa Indonesia
  * Matematika
- Mata pelajaran pilihan
  * Minat dan bakat
  * Karir masa depan
  * Pengembangan diri
- Projek penguatan profil
  * Tema lintas disiplin
  * Kontekstual
  * Kolaboratif
- Ekstrakurikuler
  * Pengembangan bakat
  * Karakter
  * Soft skills

4. Metode Pembelajaran
- Pembelajaran aktif
  * Student-centered
  * Kontekstual
  * Kolaboratif
- Kolaborasi
  * Diskusi kelompok
  * Projek bersama
  * Pembelajaran tematik
- Problem-based learning
  * Analisis kasus
  * Pemecahan masalah
  * Aplikasi konsep
- Project-based learning
  * Projek nyata
  * Kolaborasi
  * Presentasi

5. Penilaian
- Asesmen formatif
  * Evaluasi proses
  * Feedback
  * Perbaikan
- Asesmen sumatif
  * Evaluasi hasil
  * Pencapaian kompetensi
  * Laporan
- Portofolio
  * Dokumentasi karya
  * Refleksi
  * Pengembangan
- Projek
  * Hasil karya
  * Presentasi
  * Evaluasi

6. Peran Guru
- Fasilitator
  * Memfasilitasi belajar
  * Mengarahkan
  * Membimbing
- Mentor
  * Membimbing
  * Menginspirasi
  * Mengembangkan
- Evaluator
  * Menilai
  * Memberikan feedback
  * Mengevaluasi
- Pengembang kurikulum
  * Mengembangkan materi
  * Berinovasi
  * Beradaptasi

7. Peran Siswa
- Pembelajar aktif
  * Bertanggung jawab
  * Mandiri
  * Kreatif
- Pengembang potensi
  * Mengembangkan bakat
  * Mengeksplorasi
  * Berinovasi
- Pengambil keputusan
  * Memilih minat
  * Merencanakan
  * Mengevaluasi
- Pelaku perubahan
  * Berkontribusi
  * Berinovasi
  * Berkembang

8. Peran Orang Tua
- Pendamping belajar
  * Membimbing
  * Memotivasi
  * Mendukung
- Pengawas perkembangan
  * Memantau
  * Mengevaluasi
  * Membantu
- Mitra sekolah
  * Berkolaborasi
  * Berkomunikasi
  * Berkontribusi
- Pengembang karakter
  * Menanamkan nilai
  * Membimbing
  * Mencontohkan

9. Implementasi
- Persiapan sekolah
  * Infrastruktur
  * SDM
  * Sistem
- Pelatihan guru
  * Pengembangan kompetensi
  * Adaptasi kurikulum
  * Inovasi pembelajaran
- Sosialisasi
  * Pemahaman
  * Komunikasi
  * Dukungan
- Evaluasi
  * Monitoring
  * Penilaian
  * Perbaikan

10. Dampak
- Kualitas pembelajaran
  * Peningkatan hasil
  * Pengembangan kompetensi
  * Karakter
- Pengembangan karakter
  * Profil Pelajar Pancasila
  * Nilai-nilai luhur
  * Budaya
- Kesiapan masa depan
  * Kompetensi
  * Karakter
  * Adaptasi
- Transformasi pendidikan
  * Inovasi
  * Pengembangan
  * Perbaikan

Kurikulum Merdeka dirancang untuk memberikan kebebasan dan fleksibilitas dalam pembelajaran, dengan fokus pada pengembangan kompetensi dan karakter siswa. Implementasi kurikulum ini membutuhkan kerjasama semua pihak untuk mencapai tujuan pendidikan yang lebih baik. KelasPrivat.id siap mendukung implementasi Kurikulum Merdeka dengan program bimbingan yang sesuai dengan kebutuhan dan karakteristik siswa.',
                'author' => 'Tim Kurikulum KelasPrivat.id',
                'time' => '4 hari yang lalu',
                'image' => 'kurikulum.svg',
                'featured' => false
            ],
            [
                'id' => 6,
                'title' => 'Persiapan Menghadapi Ujian Nasional 2024: Strategi Sukses',
                'category' => 'Ujian Nasional',
                'description' => 'Panduan lengkap persiapan Ujian Nasional 2024, termasuk strategi belajar, tips mengerjakan soal, dan persiapan mental untuk meraih nilai maksimal.',
                'content' => 'Ujian Nasional adalah momen penting dalam perjalanan akademik siswa. Berikut adalah panduan lengkap untuk menghadapi Ujian Nasional 2024:

1. Persiapan Awal
- Kenali kisi-kisi ujian
  * Analisis materi
  * Prioritaskan topik
  * Fokus pada konsep
- Pelajari format soal
  * Tipe soal
  * Tingkat kesulitan
  * Sistem penilaian
- Buat jadwal belajar
  * Alokasi waktu
  * Prioritas materi
  * Evaluasi progress
- Siapkan materi
  * Buku teks
  * Catatan
  * Latihan soal

2. Strategi Belajar
- Buat ringkasan materi
  * Poin-poin penting
  * Rumus-rumus
  * Konsep dasar
- Latihan soal rutin
  * Soal tahun sebelumnya
  * Try out
  * Simulasi
- Review materi
  * Evaluasi pemahaman
  * Perbaiki kelemahan
  * Tingkatkan kemampuan
- Diskusi kelompok
  * Berbagi pemahaman
  * Bertukar ide
  * Saling membantu

3. Manajemen Waktu
- Buat jadwal belajar
  * Alokasi waktu
  * Prioritas materi
  * Evaluasi progress
- Atur prioritas
  * Fokus pada konsep
  * Latihan rutin
  * Review berkala
- Waktu istirahat
  * Istirahat cukup
  * Olahraga
  * Refreshing
- Persiapan ujian
  * Simulasi
  * Try out
  * Review materi

4. Tips Mengerjakan Soal
- Baca soal dengan teliti
  * Pahami instruksi
  * Analisis pertanyaan
  * Perhatikan detail
- Kerjakan yang mudah dulu
  * Tingkatkan kepercayaan
  * Hemat waktu
  * Hindari kecemasan
- Perhatikan waktu
  * Alokasi waktu
  * Prioritas soal
  * Review jawaban
- Periksa jawaban
  * Pastikan benar
  * Periksa perhitungan
  * Pastikan lengkap

5. Persiapan Mental
- Bangun kepercayaan diri
  * Kenali kemampuan
  * Latih mental
  * Tetap positif
- Atasi kecemasan
  * Teknik relaksasi
  * Manajemen stress
  * Dukungan keluarga
- Tetap fokus
  * Jaga konsentrasi
  * Hindari gangguan
  * Prioritaskan tujuan
- Jaga kesehatan
  * Istirahat cukup
  * Makan bergizi
  * Olahraga teratur

6. Dukungan
- Bimbingan belajar
  * Program intensif
  * Bimbingan expert
  * Evaluasi rutin
- Les privat
  * Belajar personal
  * Fokus kebutuhan
  * Fleksibel waktu
- Grup belajar
  * Diskusi materi
  * Berbagi pengalaman
  * Motivasi bersama
- Konsultasi guru
  * Bimbingan akademis
  * Evaluasi kemampuan
  * Tips dan trik

7. Evaluasi Diri
- Analisis kemampuan
  * Kekuatan
  * Kelemahan
  * Peluang
- Perbaiki kelemahan
  * Identifikasi masalah
  * Cari solusi
  * Latih kembali
- Tingkatkan kemampuan
  * Latihan rutin
  * Perdalam materi
  * Perbaiki strategi
- Tetapkan target
  * Target harian
  * Target mingguan
  * Target jangka panjang

8. Tips Sukses
- Mulai persiapan sejak dini
  * Buat timeline
  * Tetapkan target
  * Konsisten belajar
- Konsisten dalam belajar
  * Jadwal teratur
  * Evaluasi rutin
  * Perbaiki kelemahan
- Jangan menyerah
  * Hadapi tantangan
  * Belajar dari kegagalan
  * Tetap semangat
- Tetap semangat
  * Motivasi diri
  * Dukungan keluarga
  * Fokus tujuan

9. Persiapan Teknis
- Cek perangkat
  * Komputer/laptop
  * Internet
  * Aplikasi ujian
- Siapkan dokumen
  * KTP
  * Kartu peserta
  * Dokumen pendukung
- Kenali lokasi
  * Akses transportasi
  * Fasilitas
  * Prosedur
- Persiapan logistik
  * Makanan
  * Minuman
  * Obat-obatan

10. Manajemen Stress
- Olahraga teratur
  * Jaga kebugaran
  * Redakan stress
  * Tingkatkan konsentrasi
- Istirahat cukup
  * Tidur teratur
  * Hindari begadang
  * Jaga kesehatan
- Makan bergizi
  * Diet seimbang
  * Vitamin dan mineral
  * Hindari junk food
- Relaksasi
  * Teknik pernapasan
  * Meditasi
  * Hobi

Ingat, kesuksesan dalam Ujian Nasional membutuhkan persiapan yang matang dan konsisten. Mulailah persiapan sejak dini dan jangan ragu untuk mencari bantuan dari guru, tutor, atau lembaga bimbingan belajar terpercaya seperti KelasPrivat.id. Dengan program bimbingan yang tepat dan dukungan yang maksimal, Anda bisa meraih hasil terbaik dalam Ujian Nasional.',
                'author' => 'Tim Akademik KelasPrivat.id',
                'time' => '5 hari yang lalu',
                'image' => 'un.svg',
                'featured' => false
            ]
        ];
    }
} 