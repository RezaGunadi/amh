@extends('layouts.app')

@section('title', 'Berita & Artikel - KelasPrivat.id')
@section('meta_description', 'Berita terbaru, tips belajar, dan artikel pendidikan dari KelasPrivat.id - Lembaga les privat profesional terbaik di Indonesia')
@section('meta_keywords', 'berita pendidikan, tips belajar, artikel pendidikan, les privat, kelas privat')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Berita & Artikel</h1>
        <p class="lead text-muted">Informasi terbaru seputar pendidikan, tips belajar, dan perkembangan akademik</p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('page_news') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- News Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex gap-2 overflow-auto pb-2">
                @foreach ($categories as $category)
                    <a href="{{ route('page_news', ['category' => $category]) }}" 
                       class="btn {{ $selectedCategory == $category ? 'btn-primary active' : 'btn-outline-primary' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured News -->
    @if($featuredArticle)
    <div class="row mb-5">
        <div class="col-12">
            <a href="{{ route('news.show', $featuredArticle['id']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('assets/svg/news/' . $featuredArticle['image']) }}" 
                                 class="img-fluid rounded-start h-100 object-fit-cover" 
                                 alt="{{ $featuredArticle['title'] }}"
                                 style="background-color: #F3F4F6;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <span class="badge bg-primary mb-2">{{ $featuredArticle['category'] }}</span>
                                <h2 class="card-title h3 fw-bold mb-3 text-dark">{{ $featuredArticle['title'] }}</h2>
                                <p class="card-text text-muted mb-3">{{ $featuredArticle['description'] }}</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/svg/avatar.svg') }}" 
                                         class="rounded-circle me-2" 
                                         width="40" 
                                         height="40" 
                                         alt="{{ $featuredArticle['author'] }}"
                                         style="background-color: #F3F4F6;">
                                    <div>
                                        <p class="mb-0 fw-bold text-dark">{{ $featuredArticle['author'] }}</p>
                                        <small class="text-muted">{{ $featuredArticle['time'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endif

    <!-- News Grid -->
    <div class="row g-4">
        @forelse ($articles as $article)
        <div class="col-md-4">
            <a href="{{ route('news.show', $article['id']) }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ asset('assets/svg/news/' . $article['image']) }}" 
                         class="card-img-top" 
                         alt="{{ $article['title'] }}"
                         style="height: 200px; object-fit: cover; background-color: #F3F4F6;">
                    <div class="card-body p-4">
                        <span class="badge bg-primary mb-2">{{ $article['category'] }}</span>
                        <h3 class="card-title h5 fw-bold mb-3 text-dark">{{ $article['title'] }}</h3>
                        <p class="card-text text-muted mb-3">{{ $article['description'] }}</p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/svg/avatar.svg') }}" 
                                 class="rounded-circle me-2" 
                                 width="32" 
                                 height="32" 
                                 alt="{{ $article['author'] }}"
                                 style="background-color: #F3F4F6;">
                            <div>
                                <p class="mb-0 small fw-bold text-dark">{{ $article['author'] }}</p>
                                <small class="text-muted">{{ $article['time'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-muted">Tidak ada artikel yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if($currentPage > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('page_news', array_merge(request()->query(), ['page' => $currentPage - 1])) }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                @for($i = 1; $i <= $lastPage; $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('page_news', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if($currentPage < $lastPage)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('page_news', array_merge(request()->query(), ['page' => $currentPage + 1])) }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.btn-outline-primary {
    white-space: nowrap;
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

.pagination .page-item.disabled .page-link {
    color: #9ca3af;
    pointer-events: none;
    background-color: #f3f4f6;
    border-color: #e5e7eb;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(26, 86, 219, 0.25);
}
</style>
@endsection 