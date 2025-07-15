@extends('layouts.app')

@section('title', $post->title . ' | KelasPrivat.id')
@section('meta_description', $post->excerpt)
@section('meta_keywords', $post->meta_keywords ?? 'blog, artikel, pendidikan, les privat')

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
                <li class="breadcrumb-item active">{{ Str::limit($post->title, 50) }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Article Header -->
                <header class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                <i class="fas fa-tag me-2"></i>
                                {{ $post->category->name ?? $post->category }}
                            </span>
                        </div>
                        
                        <h1 class="h2 fw-bold text-dark mb-4">
                            {{ $post->title }}
                        </h1>
                        
                        <div class="d-flex flex-wrap align-items-center gap-4 text-muted mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($post->author_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="fw-semibold text-dark mb-0">{{ $post->author_name }}</p>
                                    <p class="small mb-0">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="fw-medium">{{ $post->reading_time }} menit baca</span>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye text-success me-2"></i>
                                <span class="fw-medium">{{ $post->views ?? rand(100, 500) }} kali dibaca</span>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        @if($post->featured_image)
                        <div class="mb-4">
                            <img src="{{ asset($post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="img-fluid rounded-3">
                        </div>
                        @else
                        <div class="mb-4">
                            <div class="gradient-primary rounded-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                                <div class="text-center text-white">
                                    <i class="fas fa-image fa-4x mb-3 opacity-50"></i>
                                    <p class="h5 fw-medium">Ilustrasi Artikel</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Excerpt -->
                        <div class="bg-primary bg-opacity-10 rounded-3 p-4 border-start border-primary border-4">
                            <p class="h6 text-dark fw-medium mb-0">
                                {{ $post->excerpt }}
                            </p>
                        </div>
                    </div>
                </header>

                <!-- Article Content -->
                <article class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-dark">
                            {!! $post->content !!}
                        </div>
                    </div>
                </article>

                <!-- Share & Engagement -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h5 class="fw-semibold text-dark mb-3">Bagikan Artikel Ini</h5>
                                <div class="d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/blog/' . $post->slug)) }}" 
                                       target="_blank" 
                                       class="btn btn-primary btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/blog/' . $post->slug)) }}&text={{ urlencode($post->title) }}" 
                                       target="_blank" 
                                       class="btn btn-info btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url('/blog/' . $post->slug)) }}" 
                                       target="_blank" 
                                       class="btn btn-success btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(url('/blog/' . $post->slug)) }}&text={{ urlencode($post->title) }}" 
                                       target="_blank" 
                                       class="btn btn-primary btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 text-center text-md-end">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-4 text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-heart text-danger me-2"></i>
                                        <span class="fw-medium">{{ rand(50, 200) }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-comment text-primary me-2"></i>
                                        <span class="fw-medium">{{ rand(10, 50) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Articles -->
                @if($relatedPosts->count() > 0)
                <section class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="h4 fw-bold text-dark mb-4">
                            <i class="fas fa-list text-primary me-2"></i>
                            Artikel Terkait
                        </h3>
                        <div class="row">
                            @foreach($relatedPosts as $relatedPost)
                            <div class="col-md-4 mb-4">
                                <article class="card h-100 hover-shadow">
                                    @if($relatedPost->featured_image)
                                    <img src="{{ asset($relatedPost->featured_image) }}" 
                                         alt="{{ $relatedPost->title }}" 
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
                                            {{ $relatedPost->category->name ?? $relatedPost->category }}
                                        </span>
                                        <h5 class="card-title fw-semibold text-dark mb-3">
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}" class="text-decoration-none">
                                                {{ Str::limit($relatedPost->title, 60) }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted small mb-3">
                                            {{ Str::limit($relatedPost->excerpt, 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between text-muted small">
                                            <span>{{ $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y') }}</span>
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $relatedPost->reading_time }} menit
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced Blog Content Styling */
.card-body h2 {
    color: var(--dark-color);
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.card-body h3 {
    color: var(--dark-color);
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
}

.card-body p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.card-body ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-bottom: 1.5rem;
}

.card-body li {
    margin-bottom: 0.5rem;
}

.card-body blockquote {
    border-left: 4px solid var(--primary-color);
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: var(--gray-600);
}

.card-body img {
    border-radius: 0.5rem;
    margin: 1.5rem 0;
    max-width: 100%;
    height: auto;
}

.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    h1 {
        font-size: 1.875rem;
    }
    
    .card-body {
        font-size: 0.875rem;
    }
}
</style>
@endsection 