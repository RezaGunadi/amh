@extends('layouts.app')

@section('title', 'Tentang Kami - KelasPrivat.id | Platform Les Privat Online Terbaik')
@section('meta_description', 'Kenali KelasPrivat.id, platform les privat online terbaik di Indonesia dengan pengajar berpengalaman dan metode pembelajaran interaktif untuk SD, SMP, dan SMA.')
@section('meta_keywords', 'tentang kami, kelaspivat, les privat online, bimbel online, pengajar berpengalaman, metode pembelajaran')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Tentang KelasPrivat.id</h1>
                <p class="lead mb-4" style="color:white">Platform les privat online terbaik di Indonesia yang menghubungkan siswa dengan pengajar berpengalaman untuk mencapai prestasi akademik yang optimal.</p>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">10K+</h3>
                        <small>Siswa Aktif</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">500+</h3>
                        <small>Pengajar</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">95%</h3>
                        <small>Kepuasan</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Tentang KelasPrivat.id" class="img-fluid floating">
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-eye text-primary fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-0">Visi Kami</h3>
                        </div>
                        <p class="text-muted">Menjadi platform pendidikan online terdepan yang memudahkan akses pendidikan berkualitas bagi setiap siswa di Indonesia, mendorong pertumbuhan akademik dan pengembangan karakter yang unggul.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-bullseye text-success fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-0">Misi Kami</h3>
                        </div>
                        <p class="text-muted">Menyediakan layanan les privat online yang berkualitas tinggi dengan pengajar berpengalaman, metode pembelajaran yang inovatif, dan teknologi yang memudahkan proses belajar mengajar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nilai-Nilai Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Nilai-Nilai Kami</h2>
            <p class="text-muted">Prinsip yang menjadi fondasi dalam memberikan layanan pendidikan terbaik</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-star text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Kualitas</h5>
                        <p class="text-muted">Kami berkomitmen memberikan layanan pendidikan berkualitas tinggi dengan standar yang konsisten.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-users text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Kolaborasi</h5>
                        <p class="text-muted">Membangun kerjasama yang erat antara siswa, pengajar, dan orang tua untuk hasil optimal.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-lightbulb text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Inovasi</h5>
                        <p class="text-muted">Terus berinovasi dalam metode pembelajaran dan teknologi untuk pengalaman belajar terbaik.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-heart text-info fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Integritas</h5>
                        <p class="text-muted">Menjalankan bisnis dengan kejujuran, transparansi, dan tanggung jawab sosial.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Perjalanan Kami</h2>
            <p class="text-muted">Tahapan perkembangan KelasPrivat.id dari awal hingga sekarang</p>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="timeline">
                    <div class="timeline-item" data-aos="fade-right">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2020 - Awal Mula</h5>
                            <p class="text-muted">KelasPrivat.id didirikan dengan visi untuk memudahkan akses pendidikan berkualitas melalui teknologi digital.</p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-left">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2021 - Pertumbuhan</h5>
                            <p class="text-muted">Platform berkembang pesat dengan ribuan siswa aktif dan ratusan pengajar bergabung.</p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-right">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2022 - Inovasi</h5>
                            <p class="text-muted">Meluncurkan fitur-fitur baru seperti bank soal interaktif dan sistem pembelajaran adaptif.</p>
                        </div>
                    </div>
                    <div class="timeline-item" data-aos="fade-left">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h5 class="fw-bold">2024 - Ekspansi</h5>
                            <p class="text-muted">Menjadi platform les privat online terdepan dengan cakupan nasional dan teknologi AI.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Tim Kami</h2>
            <p class="text-muted">Dibalik kesuksesan KelasPrivat.id ada tim yang berdedikasi dan berpengalaman</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <img src="{{ asset('murid/Ahmad_Rizki-ui_hubungan_internasional.jpg') }}" alt="CEO" class="rounded-circle mb-3" width="120" height="120">
                        <h5 class="fw-bold mb-1">Tasya Uktifillah</h5>
                        <p class="text-primary mb-3">CEO & Founder</p>
                        <p class="text-muted">Pendiri KelasPrivat.id dengan pengalaman 10+ tahun di bidang pendidikan dan teknologi.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <img src="https://randomuser.me/api/portraits/women/66.jpg" alt="CTO" class="rounded-circle mb-3" width="120" height="120">
                        <h5 class="fw-bold mb-1">Reza Gunadi</h5>
                        <p class="text-primary mb-3">CTO</p>
                        <p class="text-muted">Ahli teknologi dengan fokus pada pengembangan platform pendidikan yang user-friendly.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body p-4">
                        <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Head of Education" class="rounded-circle mb-3" width="120" height="120">
                        <h5 class="fw-bold mb-1">Muhammad Ghazi Al Fatih</h5>
                        <p class="text-primary mb-3">Head of Education</p>
                        <p class="text-muted">Mantan guru dengan pengalaman 15 tahun dalam mengembangkan kurikulum dan metode pembelajaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Bergabunglah Bersama Kami</h2>
        <p class="lead mb-4">Mari wujudkan impian pendidikan berkualitas untuk setiap anak Indonesia</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="/register" class="btn btn-light btn-lg">Daftar Sekarang</a>
            <a href="/contact" class="btn btn-outline-light btn-lg">Hubungi Kami</a>
        </div>
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gray-300);
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
}

.timeline-item:nth-child(odd) {
    flex-direction: row;
}

.timeline-item:nth-child(even) {
    flex-direction: row-reverse;
}

.timeline-marker {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
}

.timeline-content {
    width: 45%;
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-right: 55%;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-left: 55%;
}

@media (max-width: 768px) {
    .timeline::before {
        left: 20px;
    }
    
    .timeline-item {
        flex-direction: row !important;
    }
    
    .timeline-marker {
        left: 20px !important;
    }
    
    .timeline-content {
        width: calc(100% - 60px);
        margin-left: 60px !important;
        margin-right: 0 !important;
    }
}
</style>
@endsection 