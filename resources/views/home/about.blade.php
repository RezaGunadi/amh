@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Les Privat Terbaik di Indonesia | Tutor Berpengalaman">
<meta name="description" content="Les Privat terbaik dengan tutor berpengalaman dari PTN/PTS ternama. Program belajar personal, konsultasi rutin, dan metode pembelajaran yang efektif untuk SD, SMP, dan SMA.">
<meta name="keywords" content="Kelas Privat, les privat terbaik, tutor berpengalaman, bimbingan belajar, les privat SD, les privat SMP, les privat SMA, bimbel online, guru privat, konsultasi belajar">
<meta property="og:title" content="Kelas Privat: Les Privat Terbaik dengan Tutor Berpengalaman">
<meta property="og:description" content="Les Privat terbaik dengan tutor berpengalaman dari PTN/PTS ternama. Program belajar personal, konsultasi rutin, dan metode pembelajaran yang efektif.">
<meta property="og:site_name" content="Kelas Privat: Les Privat Terbaik di Indonesia">
<meta property="og:image" content="https://kelas-privat.com/assets/img/logo.png">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
<meta property="og:type" content="website">
<meta property="og:url" content="https://kelas-privat.com">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">
<meta name="author" content="Kelas Privat">
@endpush

@section('content')
<!-- Hero Section -->
<section class="py-5 gradient-primary text-white position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Les Privat Terbaik di Indonesia</h1>
                <p class="lead mb-4">Lembaga pendidikan les privat yang berfokus pada perkembangan belajar siswa dengan metode pembelajaran yang efektif dan tutor berpengalaman dari PTN/PTS ternama.</p>
                <div class="d-flex gap-3">
                    <a href="https://api.whatsapp.com/send?phone=6281211006445&text=Halo%20nama%20saya%20......%20saya,%20mau%20tanya%20terkait" class="btn btn-light btn-lg px-4">
                        <i class="fab fa-whatsapp me-2"></i>Konsultasi Gratis
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-info-circle me-2"></i>Informasi Program
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="{{ asset('assets/img/management.png') }}" alt="Kelas Privat - Les Privat Terbaik" class="img-fluid floating">
            </div>
        </div>
    </div>
    <div class="position-absolute top-0 end-0 w-50 h-100 d-none d-lg-block">
        <div class="shape-1"></div>
        <div class="shape-2"></div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Mengapa Memilih Kelas Privat?</h2>
            <p class="lead text-muted">Keunggulan yang membuat kami menjadi pilihan utama les privat di Indonesia</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Tutor Berpengalaman</h3>
                        <p class="text-muted mb-0">Tutor kami berasal dari PTN/PTS ternama dengan pengalaman mengajar yang mumpuni dan kemampuan pedagogis yang teruji.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Metode Pembelajaran Personal</h3>
                        <p class="text-muted mb-0">Program belajar yang disesuaikan dengan kebutuhan dan kemampuan siswa, memastikan pemahaman yang optimal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Konsultasi Rutin</h3>
                        <p class="text-muted mb-0">Diskusi berkala dengan orang tua untuk membahas perkembangan belajar dan memberikan saran pembelajaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-4">Visi Kami</h2>
                <p class="lead text-muted mb-5">
                    Hadir sebagai solusi terbaik bagi orangtua serta siswa yang membutuhkan les privat dengan konsultasi rutin dan diskusi mengenai permasalahan belajar anak serta kiat-kiat belajar agar hasil yang didapatkan maksimal.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Program Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold">Program Unggulan Kami</h2>
            <p class="lead text-muted">Program belajar yang dirancang untuk memaksimalkan potensi siswa</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold mb-3">Les Privat SD</h3>
                        <p class="text-muted">Program belajar untuk siswa SD dengan fokus pada pengembangan dasar-dasar pembelajaran yang kuat, termasuk:</p>
                        <ul class="text-muted">
                            <li>Pembelajaran Matematika Dasar</li>
                            <li>Bahasa Indonesia</li>
                            <li>IPA Terpadu</li>
                            <li>IPS Terpadu</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold mb-3">Les Privat SMP</h3>
                        <p class="text-muted">Program belajar untuk siswa SMP dengan pendekatan yang lebih terstruktur, mencakup:</p>
                        <ul class="text-muted">
                            <li>Matematika</li>
                            <li>IPA (Fisika, Kimia, Biologi)</li>
                            <li>Bahasa Inggris</li>
                            <li>Persiapan UNBK</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold mb-3">Les Privat SMA</h3>
                        <p class="text-muted">Program belajar untuk siswa SMA dengan fokus pada persiapan UTBK dan UNBK, meliputi:</p>
                        <ul class="text-muted">
                            <li>Matematika</li>
                            <li>Fisika</li>
                            <li>Kimia</li>
                            <li>Biologi</li>
                            <li>Persiapan UTBK</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold mb-3">Program Khusus</h3>
                        <p class="text-muted">Program tambahan untuk pengembangan kemampuan siswa:</p>
                        <ul class="text-muted">
                            <li>Olimpiade Sains</li>
                            <li>Bahasa Inggris</li>
                            <li>Komputer</li>
                            <li>Bimbingan Konseling</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partner Universities -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Partner Universitas</h2>
            <p class="lead text-muted">Berkolaborasi dengan universitas terbaik di Indonesia untuk memberikan kualitas pendidikan terbaik</p>
        </div>
        <div class="row justify-content-center g-4" data-aos="fade-up" data-aos-delay="100">
            <div class="col-auto">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <img src="{{ asset('assets/img/ui.png') }}" alt="Universitas Indonesia" class="img-fluid" style="height: 80px; width: 80px;">
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <img src="{{ asset('assets/img/gundar.png') }}" alt="Universitas Gunadarma" class="img-fluid" style="height: 80px; width: 80px;">
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <img src="{{ asset('assets/img/ipb.png') }}" alt="Institut Pertanian Bogor" class="img-fluid" style="height: 80px; width: 80px;">
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <img src="{{ asset('assets/img/itb.png') }}" alt="Institut Teknologi Bandung" class="img-fluid" style="height: 80px; width: 80px;">
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <img src="{{ asset('assets/img/uin.png') }}" alt="UIN Jakarta" class="img-fluid" style="height: 80px; width: 80px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Teaching Method -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="fw-bold mb-4">Metode Pembelajaran</h2>
                <p class="lead text-muted">
                    Kelas privat memiliki tutor pengajar yang berkompeten serta menggunakan metode pembelajaran khusus yang sesuai dengan kriteria masing-masing siswa. Metode kami mencakup:
                </p>
                <div class="row g-4 mt-4">
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body p-4">
                                <h3 class="h5 fw-bold mb-3">Pembelajaran Personal</h3>
                                <p class="text-muted mb-0">Setiap siswa mendapatkan perhatian penuh dari tutor dan program belajar yang disesuaikan dengan kebutuhan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="card h-100 border-0 shadow-sm hover-card">
                            <div class="card-body p-4">
                                <h3 class="h5 fw-bold mb-3">Evaluasi Berkala</h3>
                                <p class="text-muted mb-0">Melakukan penilaian rutin untuk memantau perkembangan dan menyesuaikan metode pembelajaran.</p>
                            </div>
                        </div>
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
            <h2 class="fw-bold">Apa Kata Mereka?</h2>
            <p class="lead text-muted">Testimoni dari siswa dan orang tua yang telah bergabung dengan Kelas Privat</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('murid/Kayla-IUP_UNDIP.jpg') }}" alt="Testimoni Siswa" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="mb-0">Kayla</h5>
                                <small class="text-muted">Mahasiswa IUP Undip</small>
                            </div>
                        </div>
                        <p class="text-muted mb-0">"Bimbingan tutor yang sangat profesional. Metode pembelajarannya sangat efektif dan mudah dipahami."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('murid/adila_putri-teknik_sipi_undip.jpg') }}" alt="Testimoni Orang Tua" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="mb-0">Adila Putri</h5>
                                <small class="text-muted">Mahasiswa Teknik Sipil Undip</small>
                            </div>
                        </div>
                        <p class="text-muted mb-0">"Berkat bimbingan intensif dari tutor Kelas Privat, saya berhasil meraih nilai tertinggi di kelas dan diterima di jurusan impian. Program belajar yang disesuaikan dengan kebutuhan membuat saya lebih mudah memahami materi."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('murid/Ghaniya_Elmira-ipb.jpg') }}" alt="Testimoni Siswa" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="mb-0">Ghina Elmira</h5>
                                <small class="text-muted">Mahasiswa IPB</small>
                            </div>
                        </div>
                        <p class="text-muted mb-0">"Saya sangat terbantu dengan program les privat ini. Tutornya sabar dalam menjelaskan dan selalu memberikan tips-tips yang berguna untuk memahami materi dengan lebih baik."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h2 class="fw-bold mb-4">Bergabung Bersama Kami</h2>
                <p class="lead mb-4">Dapatkan pengalaman belajar terbaik dengan tutor berpengalaman dari PTN/PTS ternama</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="https://api.whatsapp.com/send?phone=6281211006445&text=Halo%20nama%20saya%20......%20saya,%20mau%20tanya%20terkait" class="btn btn-light btn-lg px-5">
                        <i class="fab fa-whatsapp me-2"></i>Konsultasi Gratis
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5">
                        <i class="fas fa-phone-alt me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.shape-1 {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    transform: skewY(-12deg);
    transform-origin: top right;
}

.shape-2 {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(-45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    transform: skewY(12deg);
    transform-origin: top left;
}

.floating {
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}

.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.feature-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });
});
</script>
@endpush
@endsection