@extends('layouts.app')

@section('title', 'Blog - KelasPrivat.id | Artikel Pendidikan dan Tips Belajar')
@section('meta_description', 'Baca artikel pendidikan terbaru, tips belajar efektif, dan informasi seputar dunia pendidikan di blog KelasPrivat.id.')
@section('meta_keywords', 'blog, artikel pendidikan, tips belajar, pendidikan, kelaspivat, les privat online')

@section('content')
<!-- Hero Section -->
<section class="hero-section gradient-primary text-white py-5" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Blog Pendidikan</h1>
                <p class="lead mb-4" style="color:white">Temukan artikel pendidikan terbaru, tips belajar efektif, dan informasi menarik seputar dunia pendidikan.</p>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">{{ $posts->total() ?? 0 }}+</h3>
                        <small>Artikel</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">50K+</h3>
                        <small>Pembaca</small>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold mb-0">Mingguan</h3>
                        <small>Update</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/hero-img.png') }}" alt="Blog Pendidikan" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-8">
                <form action="{{ route('blog') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari artikel..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('blog') }}" method="GET">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Featured Articles Section -->
@if($featuredPosts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Artikel Unggulan</h2>
            <p class="text-muted">Artikel terpopuler dan terbaru dari tim kami</p>
        </div>
        <div class="row g-4">
            @foreach($featuredPosts as $index => $post)
                @if($index == 0)
                <div class="col-lg-8" data-aos="fade-right">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 blog-card">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <div class="blog-image-container">
                                        <img src="{{ asset($post->svg_icon ?? 'assets/svg/blog/tips-belajar.svg') }}" class="img-fluid h-100 object-fit-cover" alt="{{ $post->title }}">
                                        <div class="blog-overlay">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body p-4">
                                        <div class="d-flex gap-2 mb-2">
                                            <span class="badge bg-primary">{{ $post->category->name ?? 'Artikel' }}</span>
                                            <span class="text-muted small">{{ $post->reading_time }} menit baca</span>
                                        </div>
                                        <h3 class="fw-bold mb-3 text-dark">{{ $post->title }}</h3>
                                        <p class="text-muted mb-3">{{ $post->excerpt }}</p>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($post->author_avatar ?? 'assets/img/avatar-default.jpg') }}" alt="{{ $post->author_name }}" class="rounded-circle me-2" width="32" height="32">
                                            <div>
                                                <small class="fw-bold d-block text-dark">{{ $post->author_name }}</small>
                                                <small class="text-muted">{{ $post->published_at ? $post->published_at->diffForHumans() : $post->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @else
                <div class="col-lg-4" data-aos="fade-left">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm {{ $index > 1 ? 'mt-4' : '' }} blog-card">
                            <div class="blog-image-container">
                                <img src="{{ asset($post->svg_icon ?? 'assets/svg/blog/teknologi.svg') }}" class="card-img-top" alt="{{ $post->title }}">
                                <div class="blog-overlay">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge bg-success">{{ $post->category->name ?? 'Artikel' }}</span>
                                    <span class="text-muted small">{{ $post->reading_time }} menit baca</span>
                                </div>
                                <h5 class="fw-bold mb-2 text-dark">{{ $post->title }}</h5>
                                <p class="text-muted small mb-3">{{ Str::limit($post->excerpt, 80) }}</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($post->author_avatar ?? 'assets/img/avatar-default.jpg') }}" alt="{{ $post->author_name }}" class="rounded-circle me-2" width="24" height="24">
                                    <small class="text-muted">{{ $post->author_name }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Articles Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Artikel Terbaru</h2>
            <p class="text-muted">Artikel terbaru dari tim penulis kami</p>
        </div>
        <div class="row g-4">
            @forelse($latestPosts as $index => $post)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 blog-card">
                        <div class="blog-image-container">
                            <img src="{{ asset($post->svg_icon ?? 'assets/svg/blog/pendidikan.svg') }}" class="card-img-top" alt="{{ $post->title }}">
                            <div class="blog-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-info">{{ $post->category->name ?? 'Artikel' }}</span>
                                <span class="text-muted small">{{ $post->reading_time }} menit baca</span>
                            </div>
                            <h5 class="fw-bold mb-2 text-dark">{{ $post->title }}</h5>
                            <p class="text-muted mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($post->author_avatar ?? 'assets/img/avatar-default.jpg') }}" alt="{{ $post->author_name }}" class="rounded-circle me-2" width="24" height="24">
                                    <small class="text-muted">{{ $post->author_name }}</small>
                                </div>
                                <small class="text-muted">{{ $post->published_at ? $post->published_at->diffForHumans() : $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada artikel yang tersedia.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Kategori Artikel</h2>
            <p class="text-muted">Jelajahi artikel berdasarkan kategori</p>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">
                    <div class="card border-0 shadow-sm h-100 blog-card text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="{{ asset($category->svg_icon ?? 'assets/svg/blog/tips-belajar.svg') }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-fluid" 
                                     style="width: 80px; height: 80px;">
                            </div>
                            <h5 class="fw-bold mb-2 text-dark">{{ $category->name }}</h5>
                            <p class="text-muted small mb-3">{{ $category->description }}</p>
                            <span class="badge bg-primary">{{ $category->post_count }} artikel</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@section('styles')
<style>
.blog-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.blog-image-container {
    position: relative;
    overflow: hidden;
}

.blog-image-container img {
    transition: transform 0.3s ease;
}

.blog-card:hover .blog-image-container img {
    transform: scale(1.05);
}

.blog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.blog-overlay i {
    color: white;
    font-size: 2rem;
}

.blog-card:hover .blog-overlay {
    opacity: 1;
}

.badge {
    font-size: 0.75rem;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    color: var(--primary-color);
    border-color: #e5e7eb;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.pagination .page-link:hover {
    background-color: #f3f4f6;
    border-color: var(--primary-color);
}
</style>
@endsection 