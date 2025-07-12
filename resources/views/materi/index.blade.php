@extends('layouts.app')

@section('title', 'Materi Pembelajaran - KelasPrivat.id')
@section('meta_description', 'Kumpulan materi pembelajaran untuk SD, SMP, dan SMA dari KelasPrivat.id - Lembaga les privat profesional terbaik di Indonesia')
@section('meta_keywords', 'materi pembelajaran, materi SD, materi SMP, materi SMA, les privat, kelas privat')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Materi Pembelajaran</h1>
        <p class="lead text-muted">Kumpulan materi pembelajaran lengkap untuk SD, SMP, dan SMA</p>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('materi') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <select name="level" class="form-select" id="level">
                                <option value="">Pilih Tingkat</option>
                                @foreach($levels as $lvl)
                                    <option value="{{ $lvl }}" {{ $selectedLevel == $lvl ? 'selected' : '' }}>
                                        {{ $lvl }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="subject" class="form-select" id="subject">
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj }}" {{ $selectedSubject == $subj ? 'selected' : '' }}>
                                        {{ $subj }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ $search ?? '' }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Materials Grid -->
    <div class="row g-4">
        @forelse($materi as $item)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="feature-icon bg-primary bg-gradient text-white rounded-circle me-3">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <span class="badge bg-primary mb-2">{{ $item->grade }}</span>
                            <h3 class="card-title h5 fw-bold mb-0">{{ $item->title }}</h3>
                        </div>
                    </div>
                    <p class="card-text text-muted mb-3">{{ Str::limit($item->resume, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ $item->mapel }}</small>
                        <a href="{{ route('show_materi', $item->slug) }}" class="btn btn-outline-primary btn-sm">Lihat Materi</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Tidak ada materi yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    <!-- Download Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="h4 fw-bold mb-3">Download Materi Lengkap</h2>
                            <p class="text-muted mb-0">Dapatkan akses ke semua materi pembelajaran dalam format PDF yang dapat diunduh.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Download Semua Materi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 48px;
    height: 48px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.form-select, .form-control {
    border-color: #e5e7eb;
}

.form-select:focus, .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(26, 86, 219, 0.25);
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
}
</style>
@endsection