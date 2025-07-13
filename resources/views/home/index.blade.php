@extends('layouts.app')

@section('title', 'KelasPrivat.id - Lembaga Les Privat Profesional Terbaik di Indonesia')
@section('meta_description', 'Lembaga les privat profesional dengan tutor berpengalaman dari PTN/PTS ternama. Ribuan siswa berprestasi telah lulus dari sini. Program les privat SD, SMP, SMA dengan metode pembelajaran interaktif.')
@section('meta_keywords', 'lembaga les privat, les privat profesional, tutor berpengalaman, les privat SD, les privat SMP, les privat SMA, bimbel online')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-gradient-primary text-white position-relative overflow-hidden">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mb-4">
                        <span class="badge bg-light text-primary px-3 py-2 mb-3">
                            <i class="fas fa-award me-2"></i>Lembaga Les Privat Terbaik di Indonesia
                    </span>
                        <h1 class="display-4 fw-bold mb-4">Tingkatkan Prestasi Akademik dengan Les Privat Online Terbaik</h1>
                        <p class="lead mb-4" style="color: #fff;">
                            Bergabunglah dengan ribuan siswa yang telah sukses bersama KelasPrivat.id. 
                            Didukung oleh tutor profesional dari PTN/PTS ternama, metode pembelajaran interaktif, 
                            dan sistem evaluasi berkala untuk hasil yang terjamin.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="https://wa.me/6281211006445" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-rocket me-2"></i>Mulai Belajar Sekarang
                            </a>
                            <a href="https://wa.me/6281211006445" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-info-circle me-2"></i>Konsultasi Gratis
                            </a>
                        </div>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="text-center">
                            <h3 class="fw-bold mb-0">10+</h3>
                            <p class="mb-0" style="color:white">Tahun Pengalaman</p>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-0">5000+</h3>
                            <p class="mb-0" style="color:white">Siswa Berprestasi</p>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold mb-0">98%</h3>
                            <p class="mb-0" style="color:white">Tingkat Kelulusan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <a href="https://wa.me/6281211006445">
                        <img src="{{ asset('assets/img/hero-img.png') }}" alt="Les Privat Profesional" class="img-fluid floating">
                    </a>
                    {{-- <img src="{{ asset('assets/img/hero-img.png') }}" alt="Les Privat Profesional" class="img-fluid floating"> --}}
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 end-0 w-50 h-100 d-none d-lg-block">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
        </div>
        <div class="floating-orb"></div>
        <div class="floating-orb"></div>
        <div class="floating-orb"></div>
        <div class="glass-overlay"></div>
    </section>

    <!-- Prestasi Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Prestasi Membanggakan</h2>
                <p class="lead text-muted">Ribuan siswa telah berhasil meraih prestasi akademik terbaik</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                                <i class="fas fa-medal"></i>
                            </div>
                            <h5 class="card-title">Lulus PTN Favorit</h5>
                            <p class="card-text text-muted">
                                95% siswa berhasil masuk PTN favorit seperti UI, ITB, UGM, dan IPB 
                                dengan nilai yang memuaskan
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h5 class="card-title">Juara Olimpiade</h5>
                            <p class="card-text text-muted">200+ siswa berhasil meraih medali di berbagai olimpiade sains</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                                <i class="fas fa-star"></i>
                            </div>
                            <h5 class="card-title">Nilai UN Tinggi</h5>
                            <p class="card-text text-muted">Rata-rata nilai UN siswa kami di atas 85 untuk semua mata pelajaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-gradient text-white rounded-circle mb-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h5 class="card-title">Beasiswa</h5>
                            <p class="card-text text-muted">300+ siswa berhasil mendapatkan beasiswa di dalam dan luar negeri</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutor Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Tutor Profesional & Berpengalaman</h2>
                <p class="lead text-muted">
                    Dosen dan pengajar berpengalaman dari PTN/PTS ternama dengan metode mengajar yang terbukti efektif
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/tutor-profile.svg') }}" alt="Tutor" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Dr. Budi Santoso, M.Sc.</h5>
                                    <p class="text-muted mb-0">Dosen Matematika UI</p>
                                </div>
                            </div>
                            <p class="card-text">Pengajar dengan pengalaman 15 tahun mengajar matematika. Alumni S3 Matematika UI dengan predikat cum laude.</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Matematika</span>
                                <span class="badge bg-primary">Fisika</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/tutor-profile.svg') }}" alt="Tutor" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Dr. Siti Aminah, Ph.D.</h5>
                                    <p class="text-muted mb-0">Dosen Kimia ITB</p>
                                </div>
                            </div>
                            <p class="card-text">Pengajar dengan pengalaman 12 tahun mengajar kimia. Alumni S3 Kimia dari University of Tokyo.</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Kimia</span>
                                <span class="badge bg-primary">Biologi</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/tutor-profile.svg') }}" alt="Tutor" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Prof. Rudi Hartono, M.Ed.</h5>
                                    <p class="text-muted mb-0">Dosen Bahasa Inggris UGM</p>
                                </div>
                            </div>
                            <p class="card-text">Pengajar dengan pengalaman 10 tahun mengajar bahasa Inggris. Alumni S2 Education dari Harvard University.</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Bahasa Inggris</span>
                                <span class="badge bg-primary">Bahasa Indonesia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Metode Pembelajaran Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Metode Pembelajaran Premium</h2>
                <p class="lead text-muted">
                    Metode pembelajaran yang telah terbukti efektif meningkatkan prestasi akademik siswa
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <img src="{{ asset('assets/svg/learning-method.svg') }}" alt="One-on-One Tutoring" class="img-fluid mb-3" style="height: 120px;">
                            <h5 class="card-title">One-on-One Tutoring</h5>
                            <p class="card-text text-muted">Pembelajaran personal dengan tutor profesional melalui video conference HD</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <img src="{{ asset('assets/svg/achievement-badge.svg') }}" alt="Customized Learning" class="img-fluid mb-3" style="height: 120px;">
                            <h5 class="card-title">Customized Learning</h5>
                            <p class="card-text text-muted">Program belajar yang disesuaikan dengan kebutuhan dan gaya belajar siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <img src="{{ asset('assets/svg/success-story.svg') }}" alt="Progress Tracking" class="img-fluid mb-3" style="height: 120px;">
                            <h5 class="card-title">Progress Tracking</h5>
                            <p class="card-text text-muted">Pemantauan perkembangan belajar siswa secara berkala dan detail</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Program Les Privat Premium</h2>
                <p class="lead text-muted">
                    Program les privat dengan standar internasional untuk SD, SMP, dan SMA
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="feature-icon bg-primary bg-gradient text-white rounded-circle me-3">
                                    <i class="fas fa-child"></i>
                                </div>
                                <h5 class="card-title mb-0">Program SD</h5>
                            </div>
                            <p class="card-text text-muted">Program les privat untuk siswa SD dengan fokus pada:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Matematika</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Bahasa Indonesia</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>IPA</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>IPS</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Bahasa Inggris</li>
                            </ul>
                            <a href="/les-privat/sd" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="feature-icon bg-primary bg-gradient text-white rounded-circle me-3">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h5 class="card-title mb-0">Program SMP</h5>
                            </div>
                            <p class="card-text text-muted">Program les privat untuk siswa SMP dengan fokus pada:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Matematika</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>IPA (Fisika, Kimia, Biologi)</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Bahasa Inggris</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>IPS</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Bahasa Indonesia</li>
                            </ul>
                            <a href="/les-privat/smp" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="feature-icon bg-primary bg-gradient text-white rounded-circle me-3">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <h5 class="card-title mb-0">Program SMA</h5>
                            </div>
                            <p class="card-text text-muted">Program les privat untuk siswa SMA dengan fokus pada:</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Matematika</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Fisika</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Kimia</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Biologi</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Bahasa Inggris</li>
                            </ul>
                            <a href="/les-privat/sma" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Paket Harga Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Paket Premium</h2>
                <p class="lead text-muted">Investasi terbaik untuk masa depan akademik</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title text-center mb-4">Paket Basic</h5>
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Rp 2.500.000</h2>
                                <p class="text-muted">/bulan</p>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>4x pertemuan per bulan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>1 mata pelajaran</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Tutor profesional</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Materi premium</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Laporan perkembangan</li>
                            </ul>
                            <a href="/register" class="btn btn-primary w-100 mt-3">Pilih Paket</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="position-absolute top-0 end-0 p-3">
                                <span class="badge bg-primary">Populer</span>
                            </div>
                            <h5 class="card-title text-center mb-4">Paket Premium</h5>
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Rp 4.000.000</h2>
                                <p class="text-muted">/bulan</p>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>8x pertemuan per bulan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>2 mata pelajaran</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Tutor profesional</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Materi premium</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Laporan perkembangan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Konsultasi tambahan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Try out berkala</li>
                            </ul>
                            <a href="/register" class="btn btn-primary w-100 mt-3">Pilih Paket</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title text-center mb-4">Paket Ultimate</h5>
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Rp 6.000.000</h2>
                                <p class="text-muted">/bulan</p>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>12x pertemuan per bulan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>3 mata pelajaran</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Tutor profesional</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Materi premium</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Laporan perkembangan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Konsultasi tambahan</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Try out berkala</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Garansi uang kembali</li>
                                <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Program beasiswa</li>
                            </ul>
                            <a href="/register" class="btn btn-primary w-100 mt-3">Pilih Paket</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold">Kisah Sukses Siswa Kami</h2>
                <p class="lead text-muted">
                    Testimoni dari siswa yang telah berhasil meraih prestasi akademik terbaik
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/success-story.svg') }}" alt="Testimoni" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Ahmad Rizki</h5>
                                    <p class="text-muted mb-0">Mahasiswa UI</p>
                                </div>
                            </div>
                            <p class="card-text">"Berhasil masuk UI jurusan Kedokteran berkat bimbingan tutor yang sangat profesional. Metode pembelajarannya sangat efektif dan mudah dipahami."</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">UI</span>
                                <span class="badge bg-primary">Kedokteran</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/success-story.svg') }}" alt="Testimoni" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Sarah Putri</h5>
                                    <p class="text-muted mb-0">Mahasiswa ITB</p>
                                </div>
                            </div>
                            <p class="card-text">"Tutor di sini sangat membantu saya memahami konsep matematika dan fisika yang sulit. Sekarang saya bisa kuliah di ITB jurusan Teknik Informatika."</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">ITB</span>
                                <span class="badge bg-primary">Teknik Informatika</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/svg/success-story.svg') }}" alt="Testimoni" class="rounded-circle me-3" width="80">
                                <div>
                                    <h5 class="card-title mb-0">Budi Santoso</h5>
                                    <p class="text-muted mb-0">Mahasiswa UGM</p>
                                </div>
                            </div>
                            <p class="card-text">"Program les privat di sini sangat terstruktur dan sesuai dengan kebutuhan saya. Berhasil masuk UGM jurusan Teknik Mesin dengan nilai yang memuaskan."</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">UGM</span>
                                <span class="badge bg-primary">Teknik Mesin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%); margin-top: 4rem;">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold text-white mb-4">
                        Siap Meraih Prestasi Akademik Terbaik?
                    </h2>
                    <p class="lead text-white-50 mb-5">
                        Daftar sekarang dan dapatkan konsultasi gratis dengan tutor profesional kami!
                        Program les privat online dengan metode pembelajaran yang telah terbukti efektif.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/register" class="btn btn-light btn-lg px-5 py-3 shadow-sm">
                            Daftar Sekarang
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Modern Color Scheme with Elegant Gradients */
        :root {
            --primary-color: #1a56db;
            --secondary-color: #2563eb;
            --accent-color: #3b82f6;
            --text-color: #1f2937;
            --light-bg: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #1a56db 0%, #2563eb 50%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            --gradient-accent: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);
        }

        /* Enhanced Typography with Modern Font Stack */
        body {
            font-family: 'Inter', 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-color);
            line-height: 1.8;
            letter-spacing: -0.01em;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        /* Glassmorphism Card Design */
        .card {
            border: none;
            border-radius: 1.5rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Elegant Button Styles */
        .btn {
            padding: 1rem 2rem;
            font-weight: 600;
            border-radius: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.025em;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.6s;
        }

        .btn:hover::before {
            transform: translateX(100%);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }

        /* Enhanced Feature Icons */
        .feature-icon {
            width: 90px;
            height: 90px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-primary);
            border-radius: 2rem;
            color: white;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.25);
            position: relative;
            overflow: hidden;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            transition: 0.6s;
        }

        .feature-icon:hover::after {
            transform: translateX(100%);
        }

        .feature-icon:hover {
            transform: rotate(10deg) scale(1.1);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.35);
        }

        /* Enhanced Hero Section */
        .bg-gradient-primary {
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }

        /* Modern Background Pattern */
        .bg-gradient-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 100% 0%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 0% 100%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: gradientMove 20s ease infinite;
        }

        /* Animated Background Shapes */
        .bg-gradient-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.5;
            animation: patternMove 30s linear infinite;
        }

        /* Floating Orbs */
        .bg-gradient-primary .floating-orb {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            animation: floatOrb 15s ease-in-out infinite;
        }

        .bg-gradient-primary .floating-orb:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .bg-gradient-primary .floating-orb:nth-child(2) {
            width: 200px;
            height: 200px;
            bottom: -100px;
            right: 50px;
            animation-delay: -5s;
        }

        .bg-gradient-primary .floating-orb:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            left: -75px;
            animation-delay: -10s;
        }

        /* Background Animations */
        @keyframes gradientMove {
            0% {
                background-position: 0% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            100% {
                background-position: 0% 0%;
            }
        }

        @keyframes patternMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 100px 100px;
            }
        }

        @keyframes floatOrb {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -50px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        /* Glassmorphism Overlay */
        .glass-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0.05) 100%
            );
            backdrop-filter: blur(10px);
            z-index: 1;
        }

        /* Content Positioning */
        .bg-gradient-primary .container {
            position: relative;
            z-index: 2;
        }

        /* Enhanced Animations */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* Elegant List Styles */
        .list-unstyled li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .list-unstyled li:hover {
            transform: translateX(5px);
        }

        .list-unstyled li i {
            margin-right: 1rem;
            color: var(--primary-color);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .list-unstyled li:hover i {
            transform: scale(1.2);
        }

        /* Enhanced Image Styles */
        .img-fluid {
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }

        .img-fluid:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        /* Elegant Section Spacing */
        section {
            padding: 6rem 0;
            position: relative;
        }

        section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        }

        /* Responsive Refinements */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 2rem;
            }
            
            .feature-icon {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }
            
            section {
                padding: 4rem 0;
            }

            .btn {
                padding: 0.875rem 1.75rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-secondary);
        }
    </style>
@endsection 