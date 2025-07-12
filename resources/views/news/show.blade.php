@extends('layouts.app')

@section('title', $article['title'] . ' - KelasPrivat.id')
@section('meta_description', $article['description'])
@section('meta_keywords', $article['category'] . ', ' . 'berita pendidikan, tips belajar, artikel pendidikan')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('page_news') }}" class="text-decoration-none">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $article['title'] }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card border-0 shadow-sm">
                <img src="{{ asset('assets/svg/news/' . $article['image']) }}" 
                     class="card-img-top" 
                     alt="{{ $article['title'] }}"
                     style="height: 400px; object-fit: cover; background-color: #F3F4F6;">
                <div class="card-body p-4">
                    <span class="badge bg-primary mb-3">{{ $article['category'] }}</span>
                    <h1 class="card-title h2 fw-bold mb-3">{{ $article['title'] }}</h1>
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('assets/svg/avatar.svg') }}" 
                             class="rounded-circle me-2" 
                             width="40" 
                             height="40" 
                             alt="{{ $article['author'] }}"
                             style="background-color: #F3F4F6;">
                        <div>
                            <p class="mb-0 fw-bold">{{ $article['author'] }}</p>
                            <small class="text-muted">{{ $article['time'] }}</small>
                        </div>
                    </div>
                    <div class="article-content">
                        {!! nl2br(e($article['content'])) !!}
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Articles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-4">Artikel Terkait</h3>
                    @foreach($relatedArticles as $relatedArticle)
                    <div class="d-flex gap-3 mb-4">
                        <img src="{{ asset('assets/svg/news/' . $relatedArticle['image']) }}" 
                             class="rounded" 
                             width="100" 
                             height="70" 
                             alt="{{ $relatedArticle['title'] }}"
                             style="object-fit: cover; background-color: #F3F4F6;">
                        <div>
                            <h4 class="h6 fw-bold mb-1">
                                <a href="{{ route('news.show', $relatedArticle['id']) }}" class="text-decoration-none text-dark">
                                    {{ $relatedArticle['title'] }}
                                </a>
                            </h4>
                            <small class="text-muted">{{ $relatedArticle['time'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Share Buttons -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-4">Bagikan Artikel</h3>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           class="btn btn-outline-primary" 
                           target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article['title']) }}" 
                           class="btn btn-outline-primary" 
                           target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article['title'] . ' ' . request()->url()) }}" 
                           class="btn btn-outline-primary" 
                           target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($article['title']) }}" 
                           class="btn btn-outline-primary" 
                           target="_blank">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.article-content {
    line-height: 1.8;
    color: #4B5563;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
}

.btn-outline-primary {
    width: 40px;
    height: 40px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
@endsection 