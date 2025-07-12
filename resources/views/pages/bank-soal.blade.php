@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Bank Soal Online">
<meta name="description" content="Akses ribuan soal latihan untuk SD, SMP, dan SMA dengan berbagai mata pelajaran">
<meta name="keywords" content="Kelas Privat, bank soal, latihan soal, soal SD, soal SMP, soal SMA">
<meta property="og:title" content="Kelas Privat - Bank Soal Online">
<meta property="og:description" content="Akses ribuan soal latihan untuk SD, SMP, dan SMA dengan berbagai mata pelajaran">
<meta property="og:site_name" content="Kelas Privat: Latihan Soal Online">
<meta property="og:image" content="https://kelas-privat.com/assets/img/logo.png">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@push('styles')
<style>
    .hero-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .gradient-overlay {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(67, 56, 202, 0.95) 100%);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: 0.5s;
    }

    .stat-card:hover::before {
        transform: translateX(100%);
    }

    .search-input {
        transition: all 0.3s ease;
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .select-input {
        transition: all 0.3s ease;
    }

    .select-input:focus {
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .subject-list li {
        transition: all 0.2s ease;
    }

    .subject-list li:hover {
        transform: translateX(5px);
        color: #4F46E5;
    }

    .cta-section {
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.1;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
<div class="min-vh-100 bg-light">
    <!-- Hero Section -->
    <div class="position-relative bg-primary overflow-hidden">
        <div class="position-absolute w-100 h-100 hero-pattern"></div>
        <div class="position-absolute w-100 h-100 gradient-overlay"></div>
        <div class="container position-relative py-5 py-md-6">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-white mb-4">
                    Bank Soal Online
                </h1>
                <p class="lead text-white-50 mb-5">
                    Akses ribuan soal latihan untuk SD, SMP, dan SMA dengan berbagai mata pelajaran
                </p>
                <div class="mt-4">
                    <a href="#search" class="btn btn-light btn-lg px-5 py-3 rounded-3 shadow-sm">
                        Mulai Latihan
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Quick Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card stat-card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 float-animation me-3">
                                <i class="fas fa-book text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="h5 mb-1">Total Soal</h3>
                                <p class="h3 fw-bold text-primary mb-0">10,000+</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3 float-animation me-3">
                                <i class="fas fa-users text-success fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="h5 mb-1">Siswa Aktif</h3>
                                <p class="h3 fw-bold text-success mb-0">5,000+</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3 float-animation me-3">
                                <i class="fas fa-chart-line text-info fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="h5 mb-1">Tingkat Kelulusan</h3>
                                <p class="h3 fw-bold text-info mb-0">98%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div id="search" class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('soal.index') }}">
                    <div class="row g-3">
                        <!-- Search Box -->
                        <div class="col-md-4">
                            <div class="position-relative">
                                <input type="text" name="search" placeholder="Cari soal..." value="{{ request('search') }}" 
                                    class="form-control form-control-lg search-input ps-5">
                                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </div>
                        </div>

                        <!-- Jenjang Selection -->
                        <div class="col-md-4">
                            <select name="jenjang" id="jenjang" class="form-select form-select-lg select-input">
                                <option value="">Pilih Jenjang</option>
                                <option value="sd" {{ request('jenjang') == 'sd' ? 'selected' : '' }}>SD</option>
                                <option value="smp" {{ request('jenjang') == 'smp' ? 'selected' : '' }}>SMP</option>
                                <option value="sma" {{ request('jenjang') == 'sma' ? 'selected' : '' }}>SMA</option>
                            </select>
                        </div>

                        <!-- Mata Pelajaran Selection -->
                        <div class="col-md-4">
                            <select name="mapel" id="mapel" class="form-select form-select-lg select-input">
                                <option value="">Pilih Mata Pelajaran</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            Cari Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Education Level Cards -->
        <div class="row g-4 mb-5">
            <!-- SD Card -->
            <div class="col-md-4">
                <div class="card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">SD</span>
                            <span class="text-muted small">Kelas 1-6</span>
                        </div>
                        <h3 class="h4 mb-4">Sekolah Dasar</h3>
                        <ul class="list-unstyled subject-list mb-4">
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Matematika
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                IPA
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Bahasa Indonesia
                            </li>
                        </ul>
                        <a href="{{ route('soal.index', ['jenjang' => 'sd']) }}" 
                            class="btn btn-primary w-100">
                            Lihat Soal SD
                        </a>
                    </div>
                </div>
            </div>

            <!-- SMP Card -->
            <div class="col-md-4">
                <div class="card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">SMP</span>
                            <span class="text-muted small">Kelas 7-9</span>
                        </div>
                        <h3 class="h4 mb-4">Sekolah Menengah Pertama</h3>
                        <ul class="list-unstyled subject-list mb-4">
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Matematika
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                IPA
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Bahasa Inggris
                            </li>
                        </ul>
                        <a href="{{ route('soal.index', ['jenjang' => 'smp']) }}" 
                            class="btn btn-success w-100">
                            Lihat Soal SMP
                        </a>
                    </div>
                </div>
            </div>

            <!-- SMA Card -->
            <div class="col-md-4">
                <div class="card card-hover h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">SMA</span>
                            <span class="text-muted small">Kelas 10-12</span>
                        </div>
                        <h3 class="h4 mb-4">Sekolah Menengah Atas</h3>
                        <ul class="list-unstyled subject-list mb-4">
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Matematika
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Fisika
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Kimia
                            </li>
                        </ul>
                        <a href="{{ route('soal.index', ['jenjang' => 'sma']) }}" 
                            class="btn btn-info w-100">
                            Lihat Soal SMA
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section bg-primary rounded-4 overflow-hidden">
            <div class="container py-5">
                <div class="text-center">
                    <h2 class="display-5 text-white mb-4">
                        Siap untuk mulai berlatih?
                    </h2>
                    <p class="lead text-white-50 mb-5">
                        Daftar sekarang dan dapatkan akses ke ribuan soal latihan
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" 
                            class="btn btn-light btn-lg px-4">
                            Daftar Gratis
                        </a>
                        <a href="{{ route('contact') }}" 
                            class="btn btn-outline-light btn-lg px-4">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Pastikan script berjalan setelah DOM dimuat
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded');
    
    const jenjangSelect = document.getElementById('jenjang');
    const mapelSelect = document.getElementById('mapel');
    
    console.log('Jenjang select:', jenjangSelect);
    console.log('Mapel select:', mapelSelect);
    
    // Map mata pelajaran berdasarkan jenjang
    const mapelByJenjang = {
        'sd': [
            { value: 'matematika', label: 'Matematika' },
            { value: 'ipa', label: 'IPA' },
            { value: 'ips', label: 'IPS' },
            { value: 'bahasa-indonesia', label: 'Bahasa Indonesia' },
            { value: 'bahasa-inggris', label: 'Bahasa Inggris' },
            { value: 'pkn', label: 'PKN' }
        ],
        'smp': [
            { value: 'matematika', label: 'Matematika' },
            { value: 'ipa', label: 'IPA' },
            { value: 'ips', label: 'IPS' },
            { value: 'bahasa-indonesia', label: 'Bahasa Indonesia' },
            { value: 'bahasa-inggris', label: 'Bahasa Inggris' },
            { value: 'pkn', label: 'PKN' }
        ],
        'sma': [
            { value: 'matematika', label: 'Matematika' },
            { value: 'fisika', label: 'Fisika' },
            { value: 'kimia', label: 'Kimia' },
            { value: 'biologi', label: 'Biologi' },
            { value: 'bahasa-indonesia', label: 'Bahasa Indonesia' },
            { value: 'bahasa-inggris', label: 'Bahasa Inggris' },
            { value: 'ekonomi', label: 'Ekonomi' },
            { value: 'sosiologi', label: 'Sosiologi' },
            { value: 'sejarah', label: 'Sejarah' },
            { value: 'geografi', label: 'Geografi' }
        ]
    };

    // Fungsi untuk mengupdate opsi mata pelajaran
    function updateMapelOptions() {
        console.log('Updating mapel options');
        const selectedJenjang = jenjangSelect.value;
        console.log('Selected jenjang:', selectedJenjang);
        
        // Reset mapel select
        mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';

        if (selectedJenjang && mapelByJenjang[selectedJenjang]) {
            console.log('Adding mapel options for:', selectedJenjang);
            mapelByJenjang[selectedJenjang].forEach(mapel => {
                const option = document.createElement('option');
                option.value = mapel.value;
                option.textContent = mapel.label;
                if (mapel.value === '{{ request('mapel') }}') {
                    option.selected = true;
                }
                mapelSelect.appendChild(option);
            });
        }
    }

    // Event listener untuk perubahan jenjang
    if (jenjangSelect) {
        jenjangSelect.addEventListener('change', function() {
            console.log('Jenjang changed to:', this.value);
            updateMapelOptions();
        });
    }

    // Inisialisasi opsi mata pelajaran saat halaman dimuat
    if (jenjangSelect && mapelSelect) {
        console.log('Initializing mapel options');
        updateMapelOptions();
    }

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>
@endpush
@endsection 