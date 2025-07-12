@extends('layouts.app')

@push('meta')
<meta name="title" content="Kelas Privat - Forum Diskusi Online">
<meta name="description" content="Forum diskusi online untuk siswa SD, SMP, dan SMA. Diskusikan materi pelajaran, tanya jawab, dan berbagi pengalaman belajar dengan tutor berpengalaman.">
<meta name="keywords" content="Kelas Privat, Forum diskusi online, Tanya jawab online, Diskusi pelajaran, Bimbel online, Les privat online">
<meta property="og:title" content="Kelas Privat - Forum Diskusi Online">
<meta property="og:description" content="Forum diskusi online untuk siswa SD, SMP, dan SMA. Diskusikan materi pelajaran, tanya jawab, dan berbagi pengalaman belajar dengan tutor berpengalaman.">
<meta property="og:site_name" content="Kelas Privat: Forum Diskusi Online">
<meta property="og:image" content="https://kelas-privat.com/assets/img/logo.png">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="robots" content="index, follow">
<meta name="language" content="Indonesian">
<meta name="revisit-after" content="7 days">
<meta name="author" content="Kelas Privat">
@endpush

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Forum Diskusi</li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-up">
        <div>
            <h1 class="display-4 fw-bold mb-2">Forum Diskusi</h1>
            <p class="lead text-muted">Diskusikan materi pelajaran dan berbagi pengalaman belajar</p>
        </div>
        @if (!empty(Auth::user()->role) && !empty(Auth::user()->phone))
            <a href="{{ route('create_post') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Buat Post
            </a>
        @endif
    </div>

    <!-- Search and Filter Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <form method="GET" action="{{ route('chat') }}" class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari diskusi..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="SD" {{ request('category') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('category') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ request('category') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sort" class="form-select">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="comments" {{ request('sort') == 'comments' ? 'selected' : '' }}>Banyak Komentar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-comments text-primary fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Diskusi</h6>
                            <h3 class="mb-0">{{ $posts->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users text-success fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Peserta Aktif</h6>
                            <h3 class="mb-0">{{ $activeUsers ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-comment-dots text-info fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Komentar</h6>
                            <h3 class="mb-0">{{ $totalComments ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="row g-4">
        @foreach ($posts as $post)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $post->user->image ? URL::To($post->user->image.'g') : asset('assets/img/default-avatar.png') }}" 
                             class="rounded-circle me-3" 
                             alt="{{ $post->user->name }}"
                             style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <h6 class="mb-0">{{ $post->user->name }}</h6>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <h5 class="card-title mb-3">
                        <a href="{{ route('show_post', $post->slug) }}" class="text-decoration-none text-dark">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="card-text text-muted mb-3">{{ Str::limit($post->content, 150) }}</p>
                    <div class="d-flex align-items-center text-muted">
                        <span class="me-3">
                            <i class="fas fa-comments me-1"></i>{{ $post->comments_count ?? 0 }}
                        </span>
                        <span class="me-3">
                            <i class="fas fa-eye me-1"></i>{{ $post->views ?? 0 }}
                        </span>
                        <span class="badge bg-primary">{{ $post->category }}</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 p-4 pt-0">
                    <a href="{{ route('show_post', $post->slug) }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Diskusi
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
    </div>
    @endif

    <!-- Empty State -->
    @if($posts->isEmpty())
    <div class="text-center py-5" data-aos="fade-up">
        <img src="{{ asset('assets/svg/empty-state.svg') }}" alt="No Posts Found" class="mb-4" style="max-width: 200px;">
        <h3 class="fw-bold mb-3">Belum Ada Diskusi</h3>
        <p class="text-muted mb-4">Jadilah yang pertama memulai diskusi!</p>
        @if (!empty(Auth::user()->role) && !empty(Auth::user()->phone))
            <a href="{{ route('create_post') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Post Baru
            </a>
        @endif
    </div>
    @endif
</div>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

.form-select:focus,
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.card-title a:hover {
    color: #0d6efd !important;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('select[name="category"], select[name="sort"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
@endsection
