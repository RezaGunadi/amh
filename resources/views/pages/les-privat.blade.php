@extends('layouts.app')

@section('title', 'Les Privat Online Terbaik di Indonesia | KelasPrivat.id')
@section('meta_description', 'Temukan les privat online terbaik dengan guru berpengalaman. Program les privat SD, SMP, SMA dengan metode pembelajaran interaktif dan bank soal gratis.')
@section('meta_keywords', 'les privat, les privat online, les privat SD, les privat SMP, les privat SMA, guru les privat, bimbel online, bank soal gratis')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="gradient-primary">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 fw-bold text-white mb-4">
                        Les Privat Online Terbaik di Indonesia
                    </h1>
                    <p class="lead text-white-50 mb-5">
                        Tingkatkan prestasi akademik dengan program les privat online yang dipandu oleh guru-guru berpengalaman. Metode pembelajaran interaktif dan bank soal gratis untuk SD, SMP, dan SMA.
                    </p>
                    <div class="mt-4">
                        <a href="/register" class="btn btn-light btn-lg px-5">
                            Mulai Les Privat Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark mb-3">
                    Mengapa Memilih Les Privat Online Kami?
                </h2>
                <p class="lead text-muted">
                    Kami menawarkan solusi pembelajaran terbaik untuk meningkatkan prestasi akademik siswa
                </p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-primary mb-3">
                                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                            </div>
                            <h3 class="h4 fw-bold text-dark mb-3">Guru Berpengalaman</h3>
                            <p class="text-muted">
                                Tim pengajar kami terdiri dari guru-guru profesional dengan pengalaman mengajar minimal 5 tahun dan lulusan universitas terbaik.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-primary mb-3">
                                <i class="fas fa-laptop fa-3x"></i>
                            </div>
                            <h3 class="h4 fw-bold text-dark mb-3">Pembelajaran Interaktif</h3>
                            <p class="text-muted">
                                Metode pembelajaran yang menyenangkan dan interaktif menggunakan teknologi modern untuk memaksimalkan pemahaman siswa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-primary mb-3">
                                <i class="fas fa-book fa-3x"></i>
                            </div>
                            <h3 class="h4 fw-bold text-dark mb-3">Bank Soal Gratis</h3>
                            <p class="text-muted">
                                Akses ribuan soal latihan gratis untuk semua mata pelajaran, membantu siswa berlatih dan meningkatkan kemampuan akademik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Section -->
    <div class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark mb-3">
                    Program Les Privat Online
                </h2>
                <p class="lead text-muted">
                    Program les privat online yang dirancang khusus untuk setiap jenjang pendidikan
                </p>
            </div>

            <div class="row g-4">
                <!-- SD Program -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h3 fw-bold text-dark mb-4">Les Privat SD</h3>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Mata pelajaran: Matematika, IPA, Bahasa Indonesia, Bahasa Inggris</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Metode pembelajaran yang menyenangkan dan mudah dipahami</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Latihan soal sesuai kurikulum terbaru</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SMP Program -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h3 fw-bold text-dark mb-4">Les Privat SMP</h3>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Mata pelajaran: Matematika, IPA, Bahasa Indonesia, Bahasa Inggris, IPS</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Persiapan Ujian Nasional dan Ujian Sekolah</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Bank soal lengkap dengan pembahasan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SMA Program -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h3 fw-bold text-dark mb-4">Les Privat SMA</h3>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Program IPA: Matematika, Fisika, Kimia, Biologi</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Program IPS: Ekonomi, Geografi, Sejarah, Sosiologi</span>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="fas fa-check text-success mt-1 me-3"></i>
                                    <span class="text-muted">Persiapan UTBK dan Ujian Mandiri</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="gradient-dark">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold text-white mb-3">
                        <span class="d-block">Siap untuk meningkatkan prestasi akademik?</span>
                        <span class="d-block text-white-50">Daftar sekarang dan dapatkan konsultasi gratis!</span>
                    </h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="/register" class="btn btn-light btn-lg">
                            Daftar Sekarang
                        </a>
                        <a href="/contact" class="btn btn-outline-light btn-lg">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 