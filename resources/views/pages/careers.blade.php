@extends('layouts.app')

@section('title', 'Karir - KelasPrivat.id | Bergabunglah dengan Tim Kami')
@section('meta_description', 'Bergabunglah dengan tim KelasPrivat.id dan berkontribusi dalam revolusi pendidikan Indonesia. Temukan peluang karir yang menarik di bidang edtech.')
@section('meta_keywords', 'karir, lowongan kerja, edtech, pendidikan, developer, marketing, customer service, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Bergabunglah dengan Tim Kami</h1>
                <p class="lead mb-4" style="color:white">Mari berkontribusi dalam revolusi pendidikan Indonesia. Kami mencari talenta-talenta terbaik yang passionate dalam dunia pendidikan dan teknologi.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">50+</h3>
                        <small>Tim Member</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">10+</h3>
                        <small>Posisi Terbuka</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">100%</h3>
                        <small>Remote Friendly</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Karir di KelasPrivat.id" class="img-fluid floating">
            </div>
        </div>
    </div>
</section>

<!-- Why Join Us Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Mengapa Bergabung dengan Kami?</h2>
            <p class="text-muted">Kami menawarkan lingkungan kerja yang mendukung pertumbuhan dan pengembangan karir Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-rocket text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Pertumbuhan Cepat</h5>
                        <p class="text-muted">Bergabung dengan startup yang sedang berkembang pesat dengan peluang pertumbuhan karir yang tidak terbatas.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-graduation-cap text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Belajar Terus</h5>
                        <p class="text-muted">Akses ke program pelatihan, workshop, dan konferensi untuk meningkatkan skill dan pengetahuan Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-home text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Fleksibilitas</h5>
                        <p class="text-muted">Work from anywhere dengan jam kerja yang fleksibel dan work-life balance yang seimbang.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-users text-info fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Tim Hebat</h5>
                        <p class="text-muted">Bekerja dengan tim yang berdedikasi, kolaboratif, dan supportive dalam mencapai tujuan bersama.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-heart text-danger fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Impact Besar</h5>
                        <p class="text-muted">Berkontribusi langsung dalam meningkatkan kualitas pendidikan di Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-gift text-secondary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Benefit Menarik</h5>
                        <p class="text-muted">Asuransi kesehatan, tunjangan transportasi, dan benefit lainnya untuk kesejahteraan tim.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Open Positions Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Posisi yang Sedang Dibuka</h2>
            <p class="text-muted">Temukan posisi yang sesuai dengan passion dan skill Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Senior Frontend Developer</h5>
                                <span class="badge bg-primary">Full-time</span>
                            </div>
                            <span class="text-muted">Jakarta</span>
                        </div>
                        <p class="text-muted mb-3">Kami mencari Frontend Developer berpengalaman untuk mengembangkan user interface yang menarik dan responsif.</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark">React</span>
                            <span class="badge bg-light text-dark">Vue.js</span>
                            <span class="badge bg-light text-dark">TypeScript</span>
                            <span class="badge bg-light text-dark">3+ years</span>
                        </div>
                        <a href="#apply" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Backend Developer</h5>
                                <span class="badge bg-success">Full-time</span>
                            </div>
                            <span class="text-muted">Remote</span>
                        </div>
                        <p class="text-muted mb-3">Bergabung dengan tim backend untuk mengembangkan API dan sistem yang scalable dan reliable.</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark">Laravel</span>
                            <span class="badge bg-light text-dark">PHP</span>
                            <span class="badge bg-light text-dark">MySQL</span>
                            <span class="badge bg-light text-dark">2+ years</span>
                        </div>
                        <a href="#apply" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Content Creator</h5>
                                <span class="badge bg-warning">Part-time</span>
                            </div>
                            <span class="text-muted">Jakarta</span>
                        </div>
                        <p class="text-muted mb-3">Buat konten edukasi yang menarik untuk platform kami, termasuk video, artikel, dan materi pembelajaran.</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark">Video Editing</span>
                            <span class="badge bg-light text-dark">Copywriting</span>
                            <span class="badge bg-light text-dark">Education</span>
                            <span class="badge bg-light text-dark">1+ year</span>
                        </div>
                        <a href="#apply" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Customer Success</h5>
                                <span class="badge bg-info">Full-time</span>
                            </div>
                            <span class="text-muted">Jakarta</span>
                        </div>
                        <p class="text-muted mb-3">Bantu siswa dan pengajar mendapatkan pengalaman terbaik dengan layanan customer support yang excellent.</p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-light text-dark">Communication</span>
                            <span class="badge bg-light text-dark">Problem Solving</span>
                            <span class="badge bg-light text-dark">Education</span>
                            <span class="badge bg-light text-dark">1+ year</span>
                        </div>
                        <a href="#apply" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Culture Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Budaya Kerja Kami</h2>
                <div class="mb-4">
                    <h5 class="fw-bold mb-2"><i class="fas fa-check-circle text-success me-2"></i>Transparansi</h5>
                    <p class="text-muted">Kami percaya pada komunikasi yang terbuka dan transparan dalam setiap aspek kerja.</p>
                </div>
                <div class="mb-4">
                    <h5 class="fw-bold mb-2"><i class="fas fa-check-circle text-success me-2"></i>Kolaborasi</h5>
                    <p class="text-muted">Bekerja sebagai tim untuk mencapai tujuan bersama dengan semangat gotong royong.</p>
                </div>
                <div class="mb-4">
                    <h5 class="fw-bold mb-2"><i class="fas fa-check-circle text-success me-2"></i>Inovasi</h5>
                    <p class="text-muted">Mendorong ide-ide kreatif dan solusi inovatif untuk menghadapi tantangan.</p>
                </div>
                <div class="mb-4">
                    <h5 class="fw-bold mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pertumbuhan</h5>
                    <p class="text-muted">Mendukung pengembangan skill dan karir setiap anggota tim.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Budaya Kerja" class="img-fluid floating">
            </div>
        </div>
    </div>
</section>

<!-- Application Form Section -->
<section class="py-5 bg-light" id="apply">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold mb-3">Kirim Lamaran Anda</h2>
                    <p class="text-muted">Isi form di bawah ini untuk bergabung dengan tim kami</p>
                </div>
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body p-4">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">Nama Depan *</label>
                                    <input type="text" class="form-control" id="firstName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Nama Belakang *</label>
                                    <input type="text" class="form-control" id="lastName" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                </div>
                                <div class="col-12">
                                    <label for="position" class="form-label">Posisi yang Diminati *</label>
                                    <select class="form-select" id="position" required>
                                        <option value="">Pilih posisi</option>
                                        <option value="frontend">Senior Frontend Developer</option>
                                        <option value="backend">Backend Developer</option>
                                        <option value="content">Content Creator</option>
                                        <option value="customer">Customer Success</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="experience" class="form-label">Pengalaman Kerja *</label>
                                    <textarea class="form-control" id="experience" rows="3" placeholder="Ceritakan pengalaman kerja Anda..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="motivation" class="form-label">Mengapa Ingin Bergabung? *</label>
                                    <textarea class="form-control" id="motivation" rows="3" placeholder="Apa yang membuat Anda tertarik bergabung dengan KelasPrivat.id?" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label for="resume" class="form-label">Upload CV/Resume *</label>
                                    <input type="file" class="form-control" id="resume" accept=".pdf,.doc,.docx" required>
                                    <small class="text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agree" required>
                                        <label class="form-check-label" for="agree">
                                            Saya setuju dengan <a href="/privacy" class="text-decoration-none">Kebijakan Privasi</a> dan <a href="/terms" class="text-decoration-none">Syarat & Ketentuan</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Kirim Lamaran</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Punya Pertanyaan?</h2>
        <p class="lead mb-4">Tim HR kami siap membantu menjawab pertanyaan Anda tentang karir di KelasPrivat.id</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="mailto:hr@kelasprivat.id" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-envelope me-2"></i>Email HR
            </a>
            <a href="https://wa.me/6281211006445" class="btn btn-success btn-lg">
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
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
}
</style>
@endsection 