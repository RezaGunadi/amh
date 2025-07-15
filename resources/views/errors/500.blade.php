@extends('layouts.app')

@section('title', 'Error Server - KelasPrivat.id | 500 Error')
@section('meta_description', 'Terjadi kesalahan pada server. Tim kami sedang bekerja untuk memperbaiki masalah ini. Silakan coba lagi nanti.')
@section('meta_keywords', '500, error server, kesalahan server, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">500</h1>
                <h2 class="h3 mb-4">Error Server</h2>
                <p class="lead mb-4">Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang bekerja untuk memperbaiki masalah ini.</p>
                <div class="d-flex gap-3">
                    <a href="/" class="btn btn-light btn-lg">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="500 Error" class="img-fluid floating">
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                            <h3 class="fw-bold mb-3">Apa yang terjadi?</h3>
                            <p class="text-muted">Kami mengalami masalah teknis sementara. Berikut yang bisa Anda lakukan:</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-redo fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Coba Lagi</h5>
                                        <p class="text-muted mb-3">Refresh halaman atau coba akses kembali dalam beberapa menit</p>
                                        <button onclick="location.reload()" class="btn btn-primary">Refresh Halaman</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-home fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Kembali ke Beranda</h5>
                                        <p class="text-muted mb-3">Mulai dari halaman utama yang mungkin tidak terpengaruh</p>
                                        <a href="/" class="btn btn-primary">Beranda</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Tunggu Sebentar</h5>
                                        <p class="text-muted mb-3">Tim kami sedang bekerja untuk memperbaiki masalah ini</p>
                                        <span class="badge bg-warning text-dark">Sedang Diperbaiki</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Laporkan Masalah</h5>
                                        <p class="text-muted mb-3">Hubungi tim support kami jika masalah berlanjut</p>
                                        <a href="/contact" class="btn btn-primary">Kontak Support</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="fw-bold mb-3">Status Layanan</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Website Utama</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Bank Soal</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Materi Pembelajaran</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Les Privat Online</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Customer Support</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                                        <span>Pembayaran</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 p-4 bg-light rounded">
                            <h5 class="fw-bold mb-3">Informasi Teknis</h5>
                            <p class="text-muted mb-2">Error ID: {{ uniqid() }}</p>
                            <p class="text-muted mb-2">Waktu: {{ date('d F Y H:i:s') }}</p>
                            <p class="text-muted mb-0">Tim teknis kami telah diberitahu tentang masalah ini dan sedang bekerja untuk memperbaikinya secepat mungkin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alternative Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center" data-aos="fade-up">
                    <h3 class="fw-bold mb-4">Layanan Alternatif</h3>
                    <p class="text-muted mb-4">Sementara tim kami memperbaiki masalah, Anda masih bisa mengakses layanan lain kami</p>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-book fa-2x text-primary mb-3"></i>
                                    <h5 class="fw-bold mb-3">Bank Soal</h5>
                                    <p class="text-muted mb-3">Latih kemampuan dengan ribuan soal berkualitas</p>
                                    <a href="/bank-soal" class="btn btn-outline-primary">Akses</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-newspaper fa-2x text-primary mb-3"></i>
                                    <h5 class="fw-bold mb-3">Berita & Artikel</h5>
                                    <p class="text-muted mb-3">Baca artikel pendidikan terbaru</p>
                                    <a href="/news" class="btn btn-outline-primary">Baca</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                                    <h5 class="fw-bold mb-3">Tentang Kami</h5>
                                    <p class="text-muted mb-3">Pelajari lebih lanjut tentang KelasPrivat.id</p>
                                    <a href="/about" class="btn btn-outline-primary">Pelajari</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Butuh Bantuan?</h2>
        <p class="lead mb-4">Tim support kami siap membantu Anda 24/7</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="/contact" class="btn btn-primary btn-lg">Hubungi Support</a>
            <a href="https://wa.me/6281211006445" class="btn btn-success btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection 