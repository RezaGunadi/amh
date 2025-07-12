@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - KelasPrivat.id')
@section('meta_description', 'Syarat dan ketentuan penggunaan layanan KelasPrivat.id - Lembaga les privat profesional terbaik di Indonesia')
@section('meta_keywords', 'syarat dan ketentuan, terms and conditions, les privat, kelas privat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-4">Syarat dan Ketentuan</h1>
            <p class="lead text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">1. Penerimaan Syarat dan Ketentuan</h2>
                    <p>Dengan mengakses dan menggunakan layanan KelasPrivat.id, Anda menyetujui untuk terikat dengan syarat dan ketentuan ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">2. Layanan Les Privat</h2>
                    <p>KelasPrivat.id menyediakan layanan les privat online dengan ketentuan:</p>
                    <ul>
                        <li>Les privat dilakukan secara online melalui platform video conference</li>
                        <li>Durasi setiap sesi les adalah 90 menit</li>
                        <li>Jadwal les dapat diatur sesuai kesepakatan dengan tutor</li>
                        <li>Materi pembelajaran disesuaikan dengan kurikulum dan kebutuhan siswa</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">3. Pendaftaran dan Akun</h2>
                    <p>Untuk menggunakan layanan kami, Anda harus:</p>
                    <ul>
                        <li>Berusia minimal 13 tahun</li>
                        <li>Memberikan informasi yang akurat dan lengkap</li>
                        <li>Menjaga kerahasiaan akun dan password</li>
                        <li>Bertanggung jawab atas semua aktivitas dalam akun Anda</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">4. Pembayaran dan Biaya</h2>
                    <p>Ketentuan pembayaran:</p>
                    <ul>
                        <li>Pembayaran dilakukan di muka sesuai paket yang dipilih</li>
                        <li>Metode pembayaran yang tersedia: transfer bank, e-wallet</li>
                        <li>Biaya les dapat berubah sewaktu-waktu dengan pemberitahuan terlebih dahulu</li>
                        <li>Pembatalan les harus dilakukan minimal 24 jam sebelum jadwal</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">5. Kebijakan Pembatalan</h2>
                    <p>Kebijakan pembatalan les:</p>
                    <ul>
                        <li>Pembatalan 24 jam sebelum jadwal: pengembalian dana 100%</li>
                        <li>Pembatalan 12-24 jam sebelum jadwal: pengembalian dana 50%</li>
                        <li>Pembatalan kurang dari 12 jam: tidak ada pengembalian dana</li>
                        <li>Pembatalan dari pihak tutor: pengembalian dana 100%</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">6. Hak Kekayaan Intelektual</h2>
                    <p>Semua materi pembelajaran, konten, dan hak cipta terkait layanan KelasPrivat.id adalah milik kami. Pengguna tidak diperkenankan untuk:</p>
                    <ul>
                        <li>Menggunakan materi untuk tujuan komersial</li>
                        <li>Mendistribusikan materi tanpa izin</li>
                        <li>Mengubah atau memodifikasi materi</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">7. Pembatasan Tanggung Jawab</h2>
                    <p>KelasPrivat.id tidak bertanggung jawab atas:</p>
                    <ul>
                        <li>Gangguan teknis di luar kendali kami</li>
                        <li>Kegagalan siswa dalam ujian atau tes</li>
                        <li>Kerugian yang timbul dari penggunaan layanan</li>
                        <li>Konten yang diunggah oleh pengguna</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">8. Perubahan Syarat dan Ketentuan</h2>
                    <p>Kami berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui:</p>
                    <ul>
                        <li>Email ke alamat terdaftar</li>
                        <li>Pengumuman di website</li>
                        <li>Notifikasi dalam aplikasi</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">9. Kontak</h2>
                    <p>Untuk pertanyaan tentang syarat dan ketentuan, silakan hubungi:</p>
                    <ul>
                        <li>Email: terms@kelasprivat.id</li>
                        <li>WhatsApp: 0812-1100-6445</li>
                        <li>Alamat: Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 