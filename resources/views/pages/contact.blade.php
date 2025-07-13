@extends('layouts.app')

@section('title', 'Kontak Kami - KelasPrivat.id | Hubungi Tim Support Kami')
@section('meta_description', 'Hubungi tim support KelasPrivat.id untuk pertanyaan, bantuan teknis, atau informasi lebih lanjut tentang layanan les privat online kami.')
@section('meta_keywords', 'kontak, hubungi kami, customer service, bantuan, support, kelaspivat, les privat online')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Hubungi Kami</h1>
                <p class="lead mb-4" >Tim support kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami untuk pertanyaan atau bantuan apapun.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">24/7</h3>
                        <small>Support</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">< 5 menit</h3>
                        <small>Response Time</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">98%</h3>
                        <small>Satisfaction</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Hubungi Kami" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-phone text-primary fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Telepon & WhatsApp</h5>
                        <p class="text-muted mb-3">Hubungi kami melalui telepon atau WhatsApp untuk bantuan cepat</p>
                        <a href="https://wa.me/6281211006445" class="btn btn-outline-primary">
                            <i class="fab fa-whatsapp me-2"></i>+62 812 1100 6445
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-envelope text-success fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Email</h5>
                        <p class="text-muted mb-3">Kirim email untuk pertanyaan detail atau keluhan</p>
                        <a href="mailto:info@kelasprivat.id" class="btn btn-outline-success">
                            <i class="fas fa-envelope me-2"></i>info@kelasprivat.id
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="fas fa-map-marker-alt text-warning fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Alamat Kantor</h5>
                        <p class="text-muted mb-3">Kunjungi kantor kami untuk pertemuan langsung</p>
                        <p class="text-muted">Griya Family 4<br>Kab. Bekasi, 17520</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold mb-3">Kirim Pesan</h2>
                    <p class="text-muted">Isi form di bawah ini dan tim kami akan segera menghubungi Anda</p>
                </div>
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    <div class="card-body p-4">
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subjek *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Pilih subjek</option>
                                        <option value="general">Pertanyaan Umum</option>
                                        <option value="technical">Bantuan Teknis</option>
                                        <option value="billing">Pembayaran</option>
                                        <option value="complaint">Keluhan</option>
                                        <option value="partnership">Kerjasama</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Pesan *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" required>
                                        <label class="form-check-label" for="privacy">
                                            Saya setuju dengan <a href="/privacy" class="text-decoration-none">Kebijakan Privasi</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-muted">Temukan jawaban untuk pertanyaan umum seputar layanan kami</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                Bagaimana cara mendaftar les privat online?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Anda dapat mendaftar melalui website kami dengan mengklik tombol "Daftar" di halaman utama. Setelah mendaftar, tim kami akan menghubungi Anda untuk konsultasi dan penjadwalan sesi les.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                Berapa biaya les privat online?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Biaya les privat bervariasi tergantung jenjang pendidikan, mata pelajaran, dan paket yang dipilih. Mulai dari Rp 50.000 per sesi. Hubungi kami untuk informasi detail dan penawaran khusus.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                Apakah pengajar sudah berpengalaman?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, semua pengajar kami telah melalui proses seleksi ketat dan memiliki pengalaman minimal 3 tahun dalam mengajar. Mereka juga telah dilatih dalam metode pembelajaran online yang efektif.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                Bagaimana jika saya tidak puas dengan layanan?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Kami memberikan garansi kepuasan 100%. Jika Anda tidak puas dengan sesi pertama, kami akan mengganti pengajar atau mengembalikan biaya sesi tersebut tanpa syarat.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                Apakah ada jadwal yang fleksibel?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ya, kami menawarkan jadwal yang sangat fleksibel. Anda dapat memilih waktu les sesuai dengan ketersediaan Anda, termasuk pagi, siang, sore, atau malam hari.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Office Hours Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="fw-bold mb-4">Jam Operasional</h2>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded shadow-sm">
                            <span class="fw-bold">Senin - Jumat</span>
                            <span class="text-muted">08:00 - 22:00 WIB</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded shadow-sm">
                            <span class="fw-bold">Sabtu</span>
                            <span class="text-muted">08:00 - 18:00 WIB</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded shadow-sm">
                            <span class="fw-bold">Minggu</span>
                            <span class="text-muted">09:00 - 17:00 WIB</span>
                        </div>
                    </div>
                </div>
                <p class="text-muted mt-3">* Support 24/7 tersedia melalui WhatsApp untuk keadaan darurat</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Lokasi Kantor</h5>
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>Jl. Pendidikan No. 123, Jakarta Selatan</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <span>Senin - Jumat: 08:00 - 22:00 WIB</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <span>+62 812 1100 6445</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <span>info@kelasprivat.id</span>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-map me-2"></i>Lihat di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="py-5">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Ikuti Kami di Social Media</h2>
        <p class="lead mb-4">Dapatkan informasi terbaru, tips belajar, dan konten edukasi menarik</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="#" class="social-link">
                <div class="bg-primary p-3 rounded-circle">
                    <i class="fab fa-facebook-f text-white fa-2x"></i>
                </div>
                <span class="d-block mt-2">Facebook</span>
            </a>
            <a href="#" class="social-link">
                <div class="bg-info p-3 rounded-circle">
                    <i class="fab fa-twitter text-white fa-2x"></i>
                </div>
                <span class="d-block mt-2">Twitter</span>
            </a>
            <a href="#" class="social-link">
                <div class="bg-danger p-3 rounded-circle">
                    <i class="fab fa-instagram text-white fa-2x"></i>
                </div>
                <span class="d-block mt-2">Instagram</span>
            </a>
            <a href="#" class="social-link">
                <div class="bg-danger p-3 rounded-circle">
                    <i class="fab fa-youtube text-white fa-2x"></i>
                </div>
                <span class="d-block mt-2">YouTube</span>
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

.form-control:focus,
.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
}

.accordion-button:not(.collapsed) {
    background-color: var(--primary-color);
    color: white;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
}

.social-link {
    text-decoration: none;
    color: var(--dark-color);
    transition: transform 0.3s ease;
}

.social-link:hover {
    transform: translateY(-5px);
    color: var(--primary-color);
}

.social-link .rounded-circle {
    transition: transform 0.3s ease;
}

.social-link:hover .rounded-circle {
    transform: scale(1.1);
}
</style>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simulasi pengiriman form
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
    submitBtn.disabled = true;
    
    setTimeout(() => {
        alert('Terima kasih! Pesan Anda telah terkirim. Tim kami akan segera menghubungi Anda.');
        this.reset();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
});
</script>
@endsection 