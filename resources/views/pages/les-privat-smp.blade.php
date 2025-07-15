@extends('layouts.app')

@section('title', 'Les Privat SMP - KelasPrivat.id | Les Privat Online untuk Sekolah Menengah Pertama')
@section('meta_description', 'Les privat online untuk siswa SMP dengan pengajar berpengalaman. Program les privat SMP yang efektif untuk persiapan ujian dan peningkatan prestasi akademik.')
@section('meta_keywords', 'les privat SMP, les privat online SMP, bimbel SMP, les privat sekolah menengah pertama, pengajar SMP, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Les Privat SMP</h1>
                <p class="lead mb-4" style="color:white">Program les privat online khusus untuk siswa SMP dengan fokus pada persiapan ujian dan penguatan konsep dasar.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Kelas 7-9</h3>
                        <small>SMP</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Semua Mata Pelajaran</h3>
                        <small>Lengkap</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">1-on-1</h3>
                        <small>Privat</small>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#programs" class="btn btn-light btn-lg me-3">Lihat Program</a>
                    <a href="/contact" class="btn btn-outline-light btn-lg">Konsultasi Gratis</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ URL::To('assets/img/hero-img.png') }}" class="img-fluid floating" alt="Les Privat SMP">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Mengapa Les Privat SMP di KelasPrivat.id?</h2>
            <p class="text-muted">Keunggulan program les privat SMP kami</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-target text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Fokus Ujian</h5>
                        <p class="text-muted">Persiapan khusus untuk UTS, UAS, dan UN dengan latihan soal yang terstruktur.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-user-graduate text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Pengajar Berpengalaman</h5>
                        <p class="text-muted">Pengajar yang memahami kurikulum SMP dan memiliki pengalaman mengajar siswa SMP.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-clock text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Jadwal Fleksibel</h5>
                        <p class="text-muted">Sesuaikan jadwal les dengan kegiatan sekolah dan ekstrakurikuler siswa.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-chart-line text-info fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Progress Tracking</h5>
                        <p class="text-muted">Pantau perkembangan belajar melalui laporan berkala dan evaluasi rutin.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-home text-danger fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Belajar dari Rumah</h5>
                        <p class="text-muted">Belajar dengan nyaman di rumah tanpa perlu keluar, hemat waktu dan biaya transport.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-users text-secondary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Konsultasi Orang Tua</h5>
                        <p class="text-muted">Orang tua dapat berkonsultasi dengan pengajar tentang perkembangan akademik anak.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="py-5 bg-light" id="programs">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Program Les Privat SMP</h2>
            <p class="text-muted">Pilih program yang sesuai dengan kebutuhan siswa</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                            <i class="fas fa-star text-primary fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Program Basic</h4>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>1 mata pelajaran</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>2x pertemuan/minggu</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Durasi 90 menit</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Laporan progress</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Konsultasi orang tua</li>
                        </ul>
                        <div class="mb-4">
                            <h3 class="fw-bold text-primary mb-0">Rp 200.000</h3>
                            <small class="text-muted">per minggu</small>
                        </div>
                        <a href="/contact" class="btn btn-primary w-100">Pilih Program</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 position-relative">
                    <div class="position-absolute top-0 start-50 translate-middle-x">
                        <span class="badge bg-danger px-3 py-2">Terpopuler</span>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                            <i class="fas fa-crown text-success fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Program Premium</h4>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>2 mata pelajaran</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>3x pertemuan/minggu</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Durasi 120 menit</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Laporan detail</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Konsultasi intensif</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Bonus latihan soal</li>
                        </ul>
                        <div class="mb-4">
                            <h3 class="fw-bold text-success mb-0">Rp 350.000</h3>
                            <small class="text-muted">per minggu</small>
                        </div>
                        <a href="/contact" class="btn btn-success w-100">Pilih Program</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                            <i class="fas fa-rocket text-warning fa-3x"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Program Intensive</h4>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Semua mata pelajaran</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>5x pertemuan/minggu</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Durasi 150 menit</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Laporan komprehensif</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Konsultasi unlimited</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mock test berkala</li>
                        </ul>
                        <div class="mb-4">
                            <h3 class="fw-bold text-warning mb-0">Rp 500.000</h3>
                            <small class="text-muted">per minggu</small>
                        </div>
                        <a href="/contact" class="btn btn-warning w-100">Pilih Program</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Subjects Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Mata Pelajaran yang Tersedia</h2>
            <p class="text-muted">Kami menyediakan les privat untuk semua mata pelajaran SMP</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-calculator text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Matematika</h5>
                        <p class="text-muted small">Aljabar, geometri, statistika, dan peluang</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-language text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bahasa Indonesia</h5>
                        <p class="text-muted small">Teks, puisi, drama, dan karya sastra</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-globe text-info fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bahasa Inggris</h5>
                        <p class="text-muted small">Grammar, reading, writing, dan speaking</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-flask text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">IPA</h5>
                        <p class="text-muted small">Fisika, kimia, dan biologi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-map text-danger fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">IPS</h5>
                        <p class="text-muted small">Sejarah, geografi, ekonomi, dan sosiologi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-pray text-secondary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Pendidikan Agama</h5>
                        <p class="text-muted small">Akidah, ibadah, akhlak, dan sejarah Islam</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-palette text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Seni Budaya</h5>
                        <p class="text-muted small">Seni rupa, musik, tari, dan teater</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="800">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-running text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-2">PJOK</h5>
                        <p class="text-muted small">Olahraga, permainan, dan kesehatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Apa Kata Siswa SMP?</h2>
            <p class="text-muted">Testimoni dari siswa SMP yang telah bergabung</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-3">"Les privat online ini sangat membantu. Pengajarnya menjelaskan dengan jelas dan sabar. Nilai matematika saya naik dari 75 jadi 90!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/31.jpg" alt="Student" class="rounded-circle me-3" width="48" height="48">
                            <div>
                                <h6 class="fw-bold mb-0">Rina, 14 tahun</h6>
                                <small class="text-muted">Siswa kelas 8 SMP</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-3">"Belajar dari rumah jadi lebih nyaman. Pengajar selalu memberikan latihan soal yang sesuai dengan materi sekolah."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Student" class="rounded-circle me-3" width="48" height="48">
                            <div>
                                <h6 class="fw-bold mb-0">Ahmad, 15 tahun</h6>
                                <small class="text-muted">Siswa kelas 9 SMP</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="text-muted mb-3">"Jadwal les yang fleksibel sangat membantu. Bisa belajar setelah pulang sekolah tanpa perlu keluar rumah lagi."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Student" class="rounded-circle me-3" width="48" height="48">
                            <div>
                                <h6 class="fw-bold mb-0">Sari, 13 tahun</h6>
                                <small class="text-muted">Siswa kelas 7 SMP</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Mulai Les Privat SMP Sekarang</h2>
        <p class="lead mb-4">Dapatkan konsultasi gratis dan trial class untuk siswa Anda</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="/contact" class="btn btn-light btn-lg">Konsultasi Gratis</a>
            <a href="https://wa.me/6281211006445" class="btn btn-outline-light btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
}

.list-unstyled li {
    padding: 0.25rem 0;
}
</style>
@endsection 