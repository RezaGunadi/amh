@extends('layouts.app')

@section('title', 'Kebijakan Privasi - KelasPrivat.id | Perlindungan Data Pribadi')
@section('meta_description', 'Kebijakan privasi KelasPrivat.id menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi pengguna platform les privat online kami.')
@section('meta_keywords', 'kebijakan privasi, privacy policy, perlindungan data, data pribadi, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Kebijakan Privasi</h1>
                <p class="lead mb-4">Kami berkomitmen melindungi privasi dan data pribadi Anda. Pelajari bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">100%</h3>
                        <small>Aman</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">SSL</h3>
                        <small>Encrypted</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">24/7</h3>
                        <small>Monitoring</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Kebijakan Privasi" class="img-fluid floating">
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
                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">1. Informasi Umum</h2>
                            <p class="text-muted">Kebijakan Privasi ini menjelaskan bagaimana KelasPrivat.id ("kami", "kita", atau "platform") mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda ketika Anda menggunakan layanan kami.</p>
                            <p class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">2. Informasi yang Kami Kumpulkan</h2>
                            <h5 class="fw-bold mb-2">2.1 Informasi Pribadi</h5>
                            <p class="text-muted mb-3">Kami dapat mengumpulkan informasi pribadi berikut:</p>
                            <ul class="text-muted mb-3">
                                <li>Nama lengkap</li>
                                <li>Alamat email</li>
                                <li>Nomor telepon</li>
                                <li>Alamat</li>
                                <li>Tanggal lahir</li>
                                <li>Informasi pendidikan (jenjang, sekolah, kelas)</li>
                                <li>Foto profil (opsional)</li>
                            </ul>

                            <h5 class="fw-bold mb-2">2.2 Informasi Penggunaan</h5>
                            <p class="text-muted mb-3">Kami juga mengumpulkan informasi tentang bagaimana Anda menggunakan platform kami:</p>
                            <ul class="text-muted mb-3">
                                <li>Riwayat pembelajaran</li>
                                <li>Hasil tes dan latihan</li>
                                <li>Preferensi mata pelajaran</li>
                                <li>Waktu dan durasi penggunaan</li>
                                <li>Interaksi dengan pengajar</li>
                            </ul>

                            <h5 class="fw-bold mb-2">2.3 Informasi Teknis</h5>
                            <p class="text-muted mb-3">Informasi teknis yang kami kumpulkan:</p>
                            <ul class="text-muted mb-3">
                                <li>Alamat IP</li>
                                <li>Jenis browser</li>
                                <li>Sistem operasi</li>
                                <li>Perangkat yang digunakan</li>
                                <li>Lokasi geografis (jika diizinkan)</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">3. Bagaimana Kami Menggunakan Informasi</h2>
                            <p class="text-muted mb-3">Kami menggunakan informasi yang kami kumpulkan untuk:</p>
                            <ul class="text-muted mb-3">
                                <li>Menyediakan dan memelihara layanan les privat online</li>
                                <li>Menghubungkan siswa dengan pengajar yang sesuai</li>
                                <li>Memantau dan meningkatkan kualitas pembelajaran</li>
                                <li>Mengirim notifikasi dan pembaruan layanan</li>
                                <li>Memberikan dukungan pelanggan</li>
                                <li>Menganalisis penggunaan platform untuk perbaikan</li>
                                <li>Memenuhi kewajiban hukum</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">4. Berbagi Informasi</h2>
                            <p class="text-muted mb-3">Kami tidak menjual, memperdagangkan, atau mentransfer informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali dalam situasi berikut:</p>
                            <ul class="text-muted mb-3">
                                <li>Dengan pengajar yang ditugaskan untuk memberikan les privat</li>
                                <li>Dengan penyedia layanan yang membantu kami mengoperasikan platform</li>
                                <li>Ketika diperlukan untuk mematuhi hukum atau peraturan</li>
                                <li>Untuk melindungi hak, properti, atau keselamatan kami atau pengguna lain</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">5. Keamanan Data</h2>
                            <p class="text-muted mb-3">Kami menerapkan langkah-langkah keamanan yang tepat untuk melindungi informasi pribadi Anda:</p>
                            <ul class="text-muted mb-3">
                                <li>Enkripsi SSL untuk transmisi data</li>
                                <li>Penyimpanan data yang aman</li>
                                <li>Kontrol akses yang ketat</li>
                                <li>Pemantauan keamanan 24/7</li>
                                <li>Pembaruan keamanan berkala</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">6. Penyimpanan Data</h2>
                            <p class="text-muted mb-3">Kami menyimpan informasi pribadi Anda selama diperlukan untuk menyediakan layanan atau sesuai dengan kewajiban hukum. Data akan dihapus secara otomatis ketika tidak lagi diperlukan.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">7. Hak Pengguna</h2>
                            <p class="text-muted mb-3">Anda memiliki hak berikut terkait data pribadi Anda:</p>
                            <ul class="text-muted mb-3">
                                <li>Hak untuk mengakses data pribadi Anda</li>
                                <li>Hak untuk memperbaiki data yang tidak akurat</li>
                                <li>Hak untuk menghapus data pribadi</li>
                                <li>Hak untuk membatasi pemrosesan data</li>
                                <li>Hak untuk portabilitas data</li>
                                <li>Hak untuk menarik persetujuan</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">8. Cookie dan Teknologi Pelacakan</h2>
                            <p class="text-muted mb-3">Kami menggunakan cookie dan teknologi serupa untuk:</p>
                            <ul class="text-muted mb-3">
                                <li>Mengingat preferensi Anda</li>
                                <li>Menganalisis penggunaan platform</li>
                                <li>Meningkatkan pengalaman pengguna</li>
                                <li>Menyediakan konten yang dipersonalisasi</li>
                            </ul>
                            <p class="text-muted">Anda dapat mengontrol penggunaan cookie melalui pengaturan browser Anda.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">9. Perubahan Kebijakan</h2>
                            <p class="text-muted mb-3">Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diberitahukan melalui email atau notifikasi di platform. Penggunaan berkelanjutan setelah perubahan berarti Anda menerima kebijakan yang diperbarui.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">10. Kontak</h2>
                            <p class="text-muted mb-3">Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami:</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <span>privacy@kelasprivat.id</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <span>+62 812 1100 6445</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <span>Jl. Pendidikan No. 123, Jakarta Selatan</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">Dengan menggunakan platform KelasPrivat.id, Anda menyetujui Kebijakan Privasi ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold mb-4">Punya Pertanyaan?</h2>
        <p class="lead mb-4">Tim kami siap membantu menjawab pertanyaan Anda tentang kebijakan privasi</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="/contact" class="btn btn-primary btn-lg">Hubungi Kami</a>
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

h2 {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

h5 {
    color: var(--dark-color);
}

ul {
    padding-left: 1.5rem;
}

ul li {
    margin-bottom: 0.5rem;
}
</style>
@endsection 