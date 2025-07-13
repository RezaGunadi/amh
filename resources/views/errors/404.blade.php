@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - KelasPrivat.id | 404 Error')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan. Kembali ke beranda KelasPrivat.id untuk melanjutkan pembelajaran online.')
@section('meta_keywords', '404, halaman tidak ditemukan, error, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">404</h1>
                <h2 class="h3 mb-4">Halaman Tidak Ditemukan</h2>
                <p class="lead mb-4">Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman tersebut telah dipindahkan atau dihapus.</p>
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
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="404 Error" class="img-fluid floating">
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
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3 class="fw-bold mb-3">Apa yang bisa Anda lakukan?</h3>
                            <p class="text-muted">Berikut beberapa saran untuk membantu Anda menemukan apa yang Anda cari:</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-home fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Kembali ke Beranda</h5>
                                        <p class="text-muted mb-3">Mulai dari halaman utama dan jelajahi layanan kami</p>
                                        <a href="/" class="btn btn-primary">Beranda</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-graduation-cap fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Les Privat</h5>
                                        <p class="text-muted mb-3">Temukan program les privat yang sesuai dengan kebutuhan Anda</p>
                                        <a href="/les-privat" class="btn btn-primary">Lihat Program</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-book fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Bank Soal</h5>
                                        <p class="text-muted mb-3">Latih kemampuan Anda dengan ribuan soal berkualitas</p>
                                        <a href="/bank-soal" class="btn btn-primary">Mulai Latihan</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                        <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                                        <p class="text-muted mb-3">Tim kami siap membantu menjawab pertanyaan Anda</p>
                                        <a href="/contact" class="btn btn-primary">Kontak</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="fw-bold mb-3">Halaman Populer</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="/les-privat/sd" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Les Privat SD
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="/les-privat/smp" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Les Privat SMP
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="/les-privat/sma" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Les Privat SMA
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <a href="/about" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Tentang Kami
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="/blog" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Blog & Artikel
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <a href="/careers" class="text-decoration-none">
                                                <i class="fas fa-chevron-right text-primary me-2"></i>Karir
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center" data-aos="fade-up">
                    <h3 class="fw-bold mb-4">Cari Sesuatu?</h3>
                    <p class="text-muted mb-4">Gunakan fitur pencarian untuk menemukan konten yang Anda butuhkan</p>
                    <form action="/search" method="GET" class="d-flex gap-2">
                        <input type="text" name="q" class="form-control form-control-lg" placeholder="Cari materi, soal, atau artikel...">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Masih Bingung?</h2>
        <p class="lead mb-4">Tim kami siap membantu Anda menemukan apa yang Anda cari</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="/contact" class="btn btn-primary btn-lg">Hubungi Kami</a>
            <a href="https://wa.me/6281211006445" class="btn btn-success btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection 