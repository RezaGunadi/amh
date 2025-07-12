@extends('layouts.app')

@section('title', 'Kebijakan Privasi - KelasPrivat.id')
@section('meta_description', 'Kebijakan privasi KelasPrivat.id - Lembaga les privat profesional terbaik di Indonesia')
@section('meta_keywords', 'kebijakan privasi, privacy policy, les privat, kelas privat')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-4">Kebijakan Privasi</h1>
            <p class="lead text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">1. Informasi yang Kami Kumpulkan</h2>
                    <p>KelasPrivat.id mengumpulkan informasi berikut:</p>
                    <ul>
                        <li>Informasi pribadi (nama, email, nomor telepon)</li>
                        <li>Informasi akademik (sekolah, kelas, mata pelajaran)</li>
                        <li>Informasi pembayaran (metode pembayaran, riwayat transaksi)</li>
                        <li>Data penggunaan platform (waktu login, durasi belajar)</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">2. Penggunaan Informasi</h2>
                    <p>Kami menggunakan informasi yang dikumpulkan untuk:</p>
                    <ul>
                        <li>Menyediakan layanan les privat</li>
                        <li>Mengelola akun pengguna</li>
                        <li>Memproses pembayaran</li>
                        <li>Meningkatkan kualitas layanan</li>
                        <li>Mengirim informasi penting terkait layanan</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">3. Keamanan Data</h2>
                    <p>Kami menerapkan langkah-langkah keamanan untuk melindungi data pengguna:</p>
                    <ul>
                        <li>Enkripsi data sensitif</li>
                        <li>Pembatasan akses ke data pribadi</li>
                        <li>Pemantauan keamanan secara berkala</li>
                        <li>Pelatihan staf tentang keamanan data</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">4. Berbagi Informasi</h2>
                    <p>Kami tidak menjual atau menyewakan data pribadi Anda. Informasi dapat dibagikan dengan:</p>
                    <ul>
                        <li>Tutor yang ditugaskan</li>
                        <li>Penyedia layanan pembayaran</li>
                        <li>Pihak berwenang sesuai hukum</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">5. Hak Pengguna</h2>
                    <p>Anda memiliki hak untuk:</p>
                    <ul>
                        <li>Mengakses data pribadi Anda</li>
                        <li>Memperbarui informasi pribadi</li>
                        <li>Menghapus akun dan data</li>
                        <li>Menolak penggunaan data untuk tujuan tertentu</li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h4 fw-bold mb-3">6. Kontak</h2>
                    <p>Untuk pertanyaan tentang kebijakan privasi, silakan hubungi:</p>
                    <ul>
                        <li>Email: privacy@kelasprivat.id</li>
                        <li>WhatsApp: 0812-1100-6445</li>
                        <li>Alamat: Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 