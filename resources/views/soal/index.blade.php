@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Bank Soal Online">
<meta name="description" content="Bank soal online terlengkap untuk SD, SMP, dan SMA dengan pembahasan dan analisis kemampuan belajar">
<meta name="keywords" content="Kelas Privat, bank soal, soal online, latihan soal, pembahasan soal, analisis kemampuan">
<meta property="og:title" content="Kelas Privat - Bank Soal Online">
<meta property="og:description" content="Bank soal online terlengkap untuk SD, SMP, dan SMA dengan pembahasan dan analisis kemampuan belajar">
<meta property="og:site_name" content="Kelas Privat: Platform Pembelajaran Online">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@endpush

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-3">Bank Soal Online</h1>
        <p class="lead text-muted">Latih kemampuanmu dengan ribuan soal berkualitas untuk SD, SMP, dan SMA</p>
    </div>

    <!-- Search & Filter Section -->
    <div class="card shadow-sm mb-5">
        <div class="card-body p-4">
            <form action="{{ route('soal.index') }}" method="GET" id="searchForm">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   name="search" 
                                   placeholder="Cari soal..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="jenjang" id="jenjang">
                            <option value="">Semua Jenjang</option>
                            <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="mapel" id="mapel">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel }}" {{ request('mapel') == $mapel ? 'selected' : '' }}>
                                    {{ $mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Question Packages Grid -->
    <div class="row g-4" id="questionPackages">
        @forelse($paket as $p)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                                    {{ $p->jenjang }}
                                </span>
                                <h3 class="h5 mb-1">{{ $p->name }}</h3>
                                <p class="text-muted small mb-0">{{ $p->mapel }}</p>
                            </div>
                            @if($p->is_public)
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-globe me-1"></i>Public
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="fas fa-lock me-1"></i>Private
                                </span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book-open text-primary me-2"></i>
                                <span class="small">{{ $totalSoal[$p->id] ?? '0' }} Soal</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="small">{{ $p->durasi ?? '60' }} Menit</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user text-primary me-2"></i>
                                <span class="small">{{ $p->user->name ?? 'Admin' }}</span>
                            </div>
                            <form action="{{ route('goto_soal') }}" method="POST">
                                @csrf
                                <input type="hidden" name="paket" value="{{ $p->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Mulai Latihan
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h3 class="h5 text-muted">Tidak ada soal yang ditemukan</h3>
                    <p class="text-muted">Coba ubah filter pencarian Anda atau buat soal baru</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($paket->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $paket->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: all .2s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto submit form when filter changes
    document.getElementById('jenjang').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    document.getElementById('mapel').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
</script>
@endpush

@endsection