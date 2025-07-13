@extends('layouts.app')

@section('title', 'Blog - KelasPrivat.id | Artikel Pendidikan dan Tips Belajar')
@section('meta_description', 'Baca artikel pendidikan terbaru, tips belajar efektif, dan informasi seputar dunia pendidikan di blog KelasPrivat.id.')
@section('meta_keywords', 'blog, artikel pendidikan, tips belajar, pendidikan, kelaspivat, les privat online')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Blog Pendidikan</h1>
                <p class="lead mb-4">Temukan artikel pendidikan terbaru, tips belajar efektif, dan informasi menarik seputar dunia pendidikan.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">100+</h3>
                        <small>Artikel</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">50K+</h3>
                        <small>Pembaca</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Mingguan</h3>
                        <small>Update</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/svg/hero-image.svg') }}" alt="Blog Pendidikan" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari artikel..." id="searchInput">
                </div>
            </div>
            <div class="col-lg-4">
                <select class="form-select" id="categoryFilter">
                    <option value="">Semua Kategori</option>
                    <option value="tips-belajar">Tips Belajar</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="teknologi">Teknologi</option>
                    <option value="motivasi">Motivasi</option>
                    <option value="karir">Karir</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Featured Articles Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Artikel Unggulan</h2>
            <p class="text-muted">Artikel terpopuler dan terbaru dari tim kami</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 shadow-sm h-100">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="img-fluid h-100 object-fit-cover" alt="Tips Belajar Efektif">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-4">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge bg-primary">Tips Belajar</span>
                                    <span class="text-muted small">5 menit baca</span>
                                </div>
                                <h3 class="fw-bold mb-3">10 Tips Belajar Efektif untuk Siswa SD, SMP, dan SMA</h3>
                                <p class="text-muted mb-3">Temukan strategi belajar yang efektif untuk meningkatkan prestasi akademik Anda. Artikel ini membahas teknik-teknik yang telah terbukti berhasil.</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="32" height="32">
                                    <div>
                                        <small class="fw-bold d-block">Sarah Putri</small>
                                        <small class="text-muted">2 hari yang lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm mb-4">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Teknologi Pendidikan">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-success">Teknologi</span>
                            <span class="text-muted small">3 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Peran Teknologi dalam Pendidikan Modern</h5>
                        <p class="text-muted small mb-3">Bagaimana teknologi mengubah cara kita belajar dan mengajar di era digital.</p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                            <small class="text-muted">Ahmad Rizki</small>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Motivasi Belajar">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-warning">Motivasi</span>
                            <span class="text-muted small">4 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Cara Mempertahankan Motivasi Belajar</h5>
                        <p class="text-muted small mb-3">Strategi untuk tetap termotivasi dalam perjalanan belajar Anda.</p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                            <small class="text-muted">Budi Santoso</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Articles Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Artikel Terbaru</h2>
            <p class="text-muted">Artikel terbaru dari tim penulis kami</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Persiapan Ujian">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-info">Pendidikan</span>
                            <span class="text-muted small">6 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Persiapan Ujian Nasional yang Efektif</h5>
                        <p class="text-muted mb-3">Panduan lengkap untuk mempersiapkan ujian nasional dengan strategi yang tepat dan efektif.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">Diana Sari</small>
                            </div>
                            <small class="text-muted">1 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Matematika">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-danger">Tips Belajar</span>
                            <span class="text-muted small">7 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Cara Mudah Belajar Matematika</h5>
                        <p class="text-muted mb-3">Teknik dan trik untuk menguasai matematika dengan cara yang menyenangkan dan mudah dipahami.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">Rina Wati</small>
                            </div>
                            <small class="text-muted">1 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Bahasa Inggris">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-secondary">Pendidikan</span>
                            <span class="text-muted small">5 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Tips Jago Bahasa Inggris</h5>
                        <p class="text-muted mb-3">Metode praktis untuk meningkatkan kemampuan berbahasa Inggris dengan cepat dan efektif.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">John Doe</small>
                            </div>
                            <small class="text-muted">2 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Kuliah">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-primary">Karir</span>
                            <span class="text-muted small">8 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Pilihan Jurusan Kuliah yang Menjanjikan</h5>
                        <p class="text-muted mb-3">Analisis mendalam tentang jurusan kuliah yang memiliki prospek karir cerah di masa depan.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">Lisa Chen</small>
                            </div>
                            <small class="text-muted">2 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Fisika">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-success">Tips Belajar</span>
                            <span class="text-muted small">6 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Belajar Fisika dengan Eksperimen Sederhana</h5>
                        <p class="text-muted mb-3">Cara memahami konsep fisika melalui eksperimen yang bisa dilakukan di rumah.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">Prof. Dr. Surya</small>
                            </div>
                            <small class="text-muted">3 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('assets/img/bg-blue.jpg') }}" class="card-img-top" alt="Kesehatan Mental">
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge bg-warning">Motivasi</span>
                            <span class="text-muted small">4 menit baca</span>
                        </div>
                        <h5 class="fw-bold mb-2">Menjaga Kesehatan Mental Saat Belajar</h5>
                        <p class="text-muted mb-3">Pentingnya menjaga kesehatan mental dalam proses pembelajaran dan cara mengelolanya.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/img/avatar-default.jpg') }}" alt="Author" class="rounded-circle me-2" width="24" height="24">
                                <small class="text-muted">Dr. Maya</small>
                            </div>
                            <small class="text-muted">3 minggu yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <h2 class="fw-bold mb-3">Berlangganan Newsletter</h2>
                <p class="lead mb-4">Dapatkan artikel terbaru dan tips belajar langsung di email Anda</p>
                <div class="row g-3 justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Masukkan email Anda" id="newsletterEmail">
                            <button class="btn btn-primary" type="button" id="subscribeBtn">
                                <i class="fas fa-paper-plane me-2"></i>Berlangganan
                            </button>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Kami tidak akan mengirim spam. Anda bisa berhenti berlangganan kapan saja.</small>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Kategori Artikel</h2>
            <p class="text-muted">Temukan artikel berdasarkan kategori yang Anda minati</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-lightbulb text-primary fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Tips Belajar</h6>
                        <small class="text-muted">25 Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-graduation-cap text-success fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Pendidikan</h6>
                        <small class="text-muted">18 Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-laptop text-info fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Teknologi</h6>
                        <small class="text-muted">12 Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-heart text-warning fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Motivasi</h6>
                        <small class="text-muted">15 Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-briefcase text-danger fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Karir</h6>
                        <small class="text-muted">10 Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-users text-secondary fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Komunitas</h6>
                        <small class="text-muted">8 Artikel</small>
                    </div>
                </div>
            </div>
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

.object-fit-cover {
    object-fit: cover;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
}

.btn:focus {
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
}
</style>

<script>
// Newsletter subscription
document.getElementById('subscribeBtn').addEventListener('click', function() {
    const email = document.getElementById('newsletterEmail').value;
    if (email) {
        alert('Terima kasih! Anda telah berlangganan newsletter kami.');
        document.getElementById('newsletterEmail').value = '';
    } else {
        alert('Silakan masukkan email Anda.');
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    // Implementasi pencarian artikel
    console.log('Searching for:', this.value);
});

// Category filter
document.getElementById('categoryFilter').addEventListener('change', function() {
    // Implementasi filter kategori
    console.log('Filtering by category:', this.value);
});
</script>
@endsection 