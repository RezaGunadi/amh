@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - KelasPrivat.id | Ketentuan Penggunaan Platform')
@section('meta_description', 'Syarat dan ketentuan penggunaan platform KelasPrivat.id. Pelajari hak dan kewajiban pengguna dalam menggunakan layanan les privat online kami.')
@section('meta_keywords', 'syarat ketentuan, terms conditions, ketentuan penggunaan, hak kewajiban, kelaspivat')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Syarat & Ketentuan</h1>
                <p class="lead mb-4">Ketentuan penggunaan platform KelasPrivat.id yang mengatur hak dan kewajiban pengguna dalam menggunakan layanan kami.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Transparan</h3>
                        <small>Kebijakan</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Adil</h3>
                        <small>Perlakuan</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Terpercaya</h3>
                        <small>Layanan</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/svg/hero-image.svg') }}" alt="Syarat & Ketentuan" class="img-fluid">
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
                            <h2 class="fw-bold mb-3">1. Penerimaan Syarat dan Ketentuan</h2>
                            <p class="text-muted">Dengan mengakses dan menggunakan platform KelasPrivat.id, Anda menyetujui untuk terikat dengan Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan ketentuan ini, harap jangan menggunakan layanan kami.</p>
                            <p class="text-muted">Terakhir diperbarui: {{ date('d F Y') }}</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">2. Definisi</h2>
                            <ul class="text-muted mb-3">
                                <li><strong>"Platform"</strong> merujuk pada website dan aplikasi KelasPrivat.id</li>
                                <li><strong>"Pengguna"</strong> merujuk pada siswa, orang tua, atau pengajar yang menggunakan platform</li>
                                <li><strong>"Layanan"</strong> merujuk pada layanan les privat online yang disediakan</li>
                                <li><strong>"Konten"</strong> merujuk pada materi pembelajaran, soal, dan informasi lainnya</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">3. Penggunaan Platform</h2>
                            <h5 class="fw-bold mb-2">3.1 Pendaftaran</h5>
                            <p class="text-muted mb-3">Untuk menggunakan layanan kami, Anda harus:</p>
                            <ul class="text-muted mb-3">
                                <li>Berusia minimal 13 tahun atau memiliki persetujuan orang tua</li>
                                <li>Memberikan informasi yang akurat dan lengkap</li>
                                <li>Menjaga kerahasiaan akun dan password</li>
                                <li>Bertanggung jawab atas semua aktivitas yang dilakukan melalui akun Anda</li>
                            </ul>

                            <h5 class="fw-bold mb-2">3.2 Perilaku Pengguna</h5>
                            <p class="text-muted mb-3">Anda setuju untuk tidak:</p>
                            <ul class="text-muted mb-3">
                                <li>Menggunakan platform untuk tujuan ilegal atau melanggar hukum</li>
                                <li>Mengganggu atau merusak sistem platform</li>
                                <li>Menyebarkan konten yang menyinggung, menghina, atau tidak pantas</li>
                                <li>Mencoba mendapatkan akses tidak sah ke sistem atau data pengguna lain</li>
                                <li>Menggunakan layanan untuk tujuan komersial tanpa izin</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">4. Layanan Les Privat</h2>
                            <h5 class="fw-bold mb-2">4.1 Penjadwalan</h5>
                            <ul class="text-muted mb-3">
                                <li>Jadwal les akan diatur berdasarkan kesepakatan antara siswa dan pengajar</li>
                                <li>Perubahan jadwal harus diberitahukan minimal 24 jam sebelumnya</li>
                                <li>Kami berhak membatalkan sesi jika pengajar tidak tersedia</li>
                            </ul>

                            <h5 class="fw-bold mb-2">4.2 Kualitas Layanan</h5>
                            <ul class="text-muted mb-3">
                                <li>Kami berkomitmen memberikan layanan berkualitas tinggi</li>
                                <li>Pengajar telah melalui proses seleksi dan pelatihan</li>
                                <li>Kami akan mengganti pengajar jika diperlukan</li>
                                <li>Kualitas layanan dapat bervariasi tergantung kondisi teknis</li>
                            </ul>

                            <h5 class="fw-bold mb-2">4.3 Pembatalan dan Pengembalian</h5>
                            <ul class="text-muted mb-3">
                                <li>Pembatalan dapat dilakukan sesuai dengan kebijakan yang berlaku</li>
                                <li>Pengembalian dana akan diproses sesuai ketentuan</li>
                                <li>Biaya administrasi dapat dikenakan untuk pembatalan</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">5. Pembayaran dan Biaya</h2>
                            <h5 class="fw-bold mb-2">5.1 Biaya Layanan</h5>
                            <ul class="text-muted mb-3">
                                <li>Biaya les privat ditentukan berdasarkan program yang dipilih</li>
                                <li>Harga dapat berubah dengan pemberitahuan terlebih dahulu</li>
                                <li>Biaya tambahan dapat dikenakan untuk layanan khusus</li>
                            </ul>

                            <h5 class="fw-bold mb-2">5.2 Metode Pembayaran</h5>
                            <ul class="text-muted mb-3">
                                <li>Pembayaran dapat dilakukan melalui berbagai metode yang tersedia</li>
                                <li>Semua transaksi diproses dengan aman</li>
                                <li>Bukti pembayaran akan dikirimkan melalui email</li>
                            </ul>

                            <h5 class="fw-bold mb-2">5.3 Pajak</h5>
                            <p class="text-muted mb-3">Biaya pajak yang berlaku akan ditambahkan ke total pembayaran sesuai dengan peraturan yang berlaku.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">6. Hak Kekayaan Intelektual</h2>
                            <h5 class="fw-bold mb-2">6.1 Konten Platform</h5>
                            <p class="text-muted mb-3">Semua konten di platform, termasuk materi pembelajaran, soal, dan desain, dilindungi oleh hak cipta dan hak kekayaan intelektual lainnya.</p>

                            <h5 class="fw-bold mb-2">6.2 Penggunaan Konten</h5>
                            <ul class="text-muted mb-3">
                                <li>Konten hanya dapat digunakan untuk tujuan pembelajaran pribadi</li>
                                <li>Dilarang menyalin, mendistribusikan, atau menggunakan konten untuk tujuan komersial</li>
                                <li>Pengguna bertanggung jawab atas konten yang mereka unggah</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">7. Privasi dan Keamanan</h2>
                            <ul class="text-muted mb-3">
                                <li>Kami berkomitmen melindungi privasi pengguna sesuai dengan Kebijakan Privasi</li>
                                <li>Data pribadi akan dikumpulkan dan digunakan sesuai ketentuan</li>
                                <li>Kami menerapkan langkah-langkah keamanan untuk melindungi data</li>
                                <li>Pengguna bertanggung jawab menjaga kerahasiaan informasi mereka</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">8. Pembatasan Tanggung Jawab</h2>
                            <h5 class="fw-bold mb-2">8.1 Tanggung Jawab Platform</h5>
                            <ul class="text-muted mb-3">
                                <li>Kami berusaha menyediakan layanan yang berkualitas</li>
                                <li>Kami tidak bertanggung jawab atas hasil akademik siswa</li>
                                <li>Layanan disediakan "sebagaimana adanya" tanpa jaminan</li>
                                <li>Kami tidak bertanggung jawab atas gangguan teknis yang tidak dapat dihindari</li>
                            </ul>

                            <h5 class="fw-bold mb-2">8.2 Tanggung Jawab Pengguna</h5>
                            <ul class="text-muted mb-3">
                                <li>Pengguna bertanggung jawab atas penggunaan platform</li>
                                <li>Pengguna bertanggung jawab atas konten yang mereka unggah</li>
                                <li>Pengguna bertanggung jawab atas kerusakan yang disebabkan oleh penggunaan yang tidak tepat</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">9. Pengakhiran Layanan</h2>
                            <h5 class="fw-bold mb-2">9.1 Pengakhiran oleh Pengguna</h5>
                            <p class="text-muted mb-3">Pengguna dapat mengakhiri penggunaan layanan kapan saja dengan menghapus akun atau berhenti menggunakan platform.</p>

                            <h5 class="fw-bold mb-2">9.2 Pengakhiran oleh Platform</h5>
                            <p class="text-muted mb-3">Kami dapat mengakhiri atau menangguhkan akses pengguna jika:</p>
                            <ul class="text-muted mb-3">
                                <li>Melanggar Syarat dan Ketentuan ini</li>
                                <li>Melakukan aktivitas yang merugikan platform atau pengguna lain</li>
                                <li>Memberikan informasi palsu atau menyesatkan</li>
                                <li>Menggunakan layanan untuk tujuan ilegal</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">10. Perubahan Syarat dan Ketentuan</h2>
                            <p class="text-muted mb-3">Kami dapat memperbarui Syarat dan Ketentuan ini dari waktu ke waktu. Perubahan akan diberitahukan melalui email atau notifikasi di platform. Penggunaan berkelanjutan setelah perubahan berarti Anda menerima ketentuan yang diperbarui.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">11. Hukum yang Berlaku</h2>
                            <p class="text-muted mb-3">Syarat dan Ketentuan ini tunduk pada hukum Republik Indonesia. Setiap sengketa akan diselesaikan melalui musyawarah atau melalui pengadilan yang berwenang di Indonesia.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">12. Kontak</h2>
                            <p class="text-muted mb-3">Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami:</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <span>legal@kelasprivat.id</span>
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
                            <p class="text-muted mb-0">Dengan menggunakan platform KelasPrivat.id, Anda menyetujui Syarat dan Ketentuan ini.</p>
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
        <p class="lead mb-4">Tim kami siap membantu menjawab pertanyaan Anda tentang syarat dan ketentuan</p>
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

strong {
    color: var(--dark-color);
}
</style>
@endsection 