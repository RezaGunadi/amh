@extends('layouts.app')

@section('title', $category->name . ' - Blog | KelasPrivat.id')
@section('meta_description', 'Artikel dan berita tentang ' . $category->name . ' dari KelasPrivat.id')
@section('meta_keywords', 'blog, artikel, ' . $category->name . ', pendidikan, les privat')

@section('content')
<div class="bg-light min-vh-100">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav class="mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb text-muted small">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>
                        Beranda
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blog') }}" class="text-decoration-none">Blog</a>
                </li>
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <!-- Category Header -->
                <header class="card shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <h1 class="h2 fw-bold text-dark mb-3">{{ $category->name }}</h1>
                        <p class="text-muted mb-0">{{ $category->description ?? 'Artikel dan berita terkini tentang ' . $category->name }}</p>
                    </div>
                </header>

                <!-- Articles Grid -->
                @if($posts->count() > 0)
                <div class="row g-4 mb-5">
                    @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <article class="card h-100 hover-shadow">
                            @if($post->featured_image)
                            <img src="{{ asset($post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                            <div class="card-img-top d-flex align-items-center justify-content-center gradient-primary" style="height: 200px;">
                                <div class="text-center text-white opacity-75">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                            </div>
                            @endif
                            <div class="card-body">
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                                    {{ $post->category->name ?? $post->category }}
                                </span>
                                <h5 class="card-title fw-semibold text-dark mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($post->excerpt, 100) }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between text-muted small">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white small me-2" style="width: 24px; height: 24px;">
                                            {{ strtoupper(substr($post->author_name, 0, 1)) }}
                                        </div>
                                        <span>{{ $post->author_name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $post->reading_time }} menit
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="card shadow-sm">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                        <h3 class="h4 fw-bold text-dark mb-3">Belum Ada Artikel</h3>
                        <p class="text-muted mb-4">Belum ada artikel dalam kategori ini. Silakan cek kembali nanti.</p>
                        <a href="{{ route('blog') }}" class="btn btn-primary">
                            Kembali ke Blog
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Category Info -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Tentang Kategori</h5>
                        <p class="text-muted mb-3">{{ $category->description ?? 'Artikel dan berita terkini tentang ' . $category->name }}</p>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="fas fa-file-alt me-2"></i>
                            <span>{{ $posts->total() }} artikel</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Artikel Terbaru</h5>
                        @foreach($recentPosts ?? [] as $recentPost)
                        <div class="d-flex align-items-start mb-3">
                            @if($recentPost->featured_image)
                            <img src="{{ asset($recentPost->featured_image) }}" 
                                 alt="{{ $recentPost->title }}" 
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-primary"></i>
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold text-dark mb-1">
                                    <a href="{{ route('blog.show', $recentPost->slug) }}" class="text-decoration-none">
                                        {{ Str::limit($recentPost->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ $recentPost->published_at ? $recentPost->published_at->format('d M Y') : $recentPost->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Kategori Lainnya</h5>
                        @foreach($categories ?? [] as $cat)
                        <a href="{{ route('blog.category', $cat->slug) }}" 
                           class="d-flex justify-content-between align-items-center p-2 rounded text-decoration-none {{ $cat->id === $category->id ? 'bg-primary bg-opacity-10 text-primary' : 'text-muted' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $cat->posts_count ?? 0 }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection 