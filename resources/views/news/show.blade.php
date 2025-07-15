@extends('layouts.app')

@section('title', $article->title . ' - KelasPrivat.id')
@section('meta_description', $article->description)
@section('meta_keywords', $article->category . ', ' . 'berita pendidikan, tips belajar, artikel pendidikan')

@section('content')
<div class="bg-light min-vh-100">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>
                        Beranda
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('page_news') }}" class="text-decoration-none">Berita</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
            <!-- Article Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <span class="badge bg-primary">
                                <i class="fas fa-tag me-1"></i>
                        {{ $article->category }}
                    </span>
                </div>
                
                        <h1 class="h2 fw-bold mb-4">
                    {{ $article->title }}
                </h1>
                
                        <div class="d-flex flex-wrap align-items-center gap-3 text-muted mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width: 48px; height: 48px;">
                            {{ strtoupper(substr($article->created_by, 0, 1)) }}
                        </div>
                        <div>
                                    <p class="fw-bold mb-0 text-dark">{{ $article->created_by }}</p>
                                    <p class="small mb-0">{{ $article->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="fw-medium">5 menit baca</span>
                    </div>
                    
                            <div class="d-flex align-items-center">
                                <i class="fas fa-eye text-success me-2"></i>
                                <span class="fw-medium">{{ rand(100, 500) }} kali dibaca</span>
                    </div>
                </div>

                <!-- Featured Image -->
                        <div class="mb-4">
                            <div class="bg-primary bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                        <div class="text-center text-white">
                                    <i class="fas fa-image fa-3x mb-3 opacity-50"></i>
                                    <p class="h5 mb-0">Ilustrasi Artikel</p>
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                        <div class="bg-primary bg-opacity-10 rounded-3 p-4 border-start border-primary border-4">
                            <p class="h5 text-dark mb-0">
                        {{ $article->description }}
                    </p>
                        </div>
                    </div>
                </div>

            <!-- Article Content -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-dark lh-base">
                            <p class="mb-4">
                            {{ $article->description }}
                        </p>
                        
                            <div class="alert alert-warning border-start border-warning border-4">
                                <div class="d-flex">
                                <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                </div>
                                    <div class="ms-3">
                                        <p class="mb-0">
                                        <strong>Poin Penting:</strong> Artikel ini memberikan informasi berharga seputar pendidikan dan tips belajar yang dapat membantu meningkatkan prestasi akademik Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                            <p class="mb-4">
                            Dalam dunia pendidikan yang terus berkembang, penting bagi kita untuk selalu mengikuti perkembangan terbaru dan menerapkan metode belajar yang efektif. Artikel ini akan membahas berbagai aspek penting dalam dunia pendidikan modern.
                        </p>
                        
                            <h2 class="h4 fw-bold mb-3">Mengapa Ini Penting?</h2>
                            <p class="mb-4">
                            Pendidikan adalah investasi terbaik untuk masa depan. Dengan memahami berbagai aspek pendidikan, kita dapat mempersiapkan diri dengan lebih baik untuk menghadapi tantangan di masa depan.
                        </p>
                        
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="bg-primary bg-opacity-10 p-4 rounded-3">
                                        <h3 class="h6 fw-bold text-primary mb-3">Keuntungan</h3>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-primary me-2"></i>
                                        Meningkatkan pemahaman
                                    </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-primary me-2"></i>
                                        Mengembangkan keterampilan
                                    </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-primary me-2"></i>
                                        Mempersiapkan masa depan
                                    </li>
                                </ul>
                                    </div>
                            </div>
                            
                                <div class="col-md-6 mb-3">
                                    <div class="bg-success bg-opacity-10 p-4 rounded-3">
                                        <h3 class="h6 fw-bold text-success mb-3">Manfaat</h3>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                        Prestasi akademik meningkat
                                    </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                        Kepercayaan diri bertambah
                                    </li>
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success me-2"></i>
                                        Peluang karir terbuka lebar
                                    </li>
                                </ul>
                                    </div>
                            </div>
                        </div>
                        
                            <p class="mb-0">
                            Dengan menerapkan tips dan strategi yang dibahas dalam artikel ini, diharapkan pembaca dapat mengoptimalkan proses belajar mereka dan mencapai hasil yang lebih baik dalam pendidikan.
                        </p>
                        </div>
                    </div>
                </div>

            <!-- Share & Engagement -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h3 class="h6 fw-bold mb-3">Bagikan Artikel Ini</h3>
                                <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" 
                                       class="btn btn-primary btn-sm rounded-circle">
                                        <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" 
                               target="_blank" 
                                       class="btn btn-info btn-sm rounded-circle">
                                        <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . request()->url()) }}" 
                               target="_blank" 
                                       class="btn btn-success btn-sm rounded-circle">
                                        <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" 
                               target="_blank" 
                                       class="btn btn-primary btn-sm rounded-circle">
                                        <i class="fab fa-telegram"></i>
                            </a>
                        </div>
                    </div>
                    
                            <div class="col-md-6 text-md-end">
                                <div class="d-flex justify-content-center justify-content-md-end gap-4 text-muted">
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
            @if($relatedArticles->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-4">
                            <i class="fas fa-newspaper me-2"></i>
                    Artikel Terkait
                </h2>
                        <div class="row">
                    @foreach($relatedArticles as $relatedArticle)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('news.show', $relatedArticle->slug) }}" class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="bg-primary bg-opacity-10 rounded-top" style="height: 150px;">
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-image fa-2x text-primary opacity-50"></i>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <span class="badge bg-primary mb-2">{{ $relatedArticle->category }}</span>
                                            <h3 class="h6 fw-bold text-dark mb-2">{{ $relatedArticle->title }}</h3>
                                            <p class="small text-muted mb-2">{{ Str::limit($relatedArticle->description, 80) }}</p>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-center text-white small me-2" style="width: 24px; height: 24px;">
                                                    {{ strtoupper(substr($relatedArticle->created_by, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="small fw-bold text-dark mb-0">{{ $relatedArticle->created_by }}</p>
                                                    <small class="text-muted">{{ $relatedArticle->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                            </div>
                        </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

.btn-sm.rounded-circle {
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection 