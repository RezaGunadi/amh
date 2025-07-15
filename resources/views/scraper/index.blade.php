@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">🚀 Content Scraper</h1>
                <p class="lead text-muted">Scrape blog posts dan news articles dari berbagai sumber dalam satu kali hit</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-5">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                                    <i class="fas fa-newspaper fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Total News</p>
                                    <h3 class="fw-bold mb-0">{{ $stats['news_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                                    <i class="fas fa-blog fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Total Blog Posts</p>
                                    <h3 class="fw-bold mb-0">{{ $stats['blog_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle me-3">
                                    <i class="fas fa-bolt fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Total Content</p>
                                    <h3 class="fw-bold mb-0">{{ $stats['news_count'] + $stats['blog_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scraping Form -->
            <div class="card shadow-sm mb-5">
                <div class="card-body p-4">
                    <h2 class="h3 fw-bold text-dark mb-4">📡 Mulai Scraping</h2>
                    
                    <form action="{{ route('scraper.scrape') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="limit" class="form-label fw-medium">
                                    Jumlah Artikel
                                </label>
                                <input type="number" 
                                       id="limit" 
                                       name="limit" 
                                       value="20" 
                                       min="1" 
                                       max="50"
                                       class="form-control">
                                <div class="form-text">Maksimal 50 artikel per scraping</div>
                            </div>
                            
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           id="save" 
                                           name="save" 
                                           value="1"
                                           class="form-check-input">
                                    <label for="save" class="form-check-label">
                                        Simpan ke Database
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" 
                                    class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-bolt me-2"></i>
                                Mulai Scraping
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Content -->
            <div class="row">
                <!-- Recent News -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h4 fw-bold text-dark mb-4">
                                <i class="fas fa-newspaper text-primary me-2"></i>
                                Recent News
                            </h3>
                            
                            @if($stats['recent_news']->count() > 0)
                                <div class="space-y-3">
                                    @foreach($stats['recent_news'] as $news)
                                        <div class="border-start border-primary border-3 ps-3 mb-3">
                                            <h5 class="fw-semibold text-dark mb-1">{{ $news->title }}</h5>
                                            <p class="text-muted small mb-0">{{ $news->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center py-4">Belum ada news</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Blog Posts -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="h4 fw-bold text-dark mb-4">
                                <i class="fas fa-blog text-success me-2"></i>
                                Recent Blog Posts
                            </h3>
                            
                            @if($stats['recent_blogs']->count() > 0)
                                <div class="space-y-3">
                                    @foreach($stats['recent_blogs'] as $blog)
                                        <div class="border-start border-success border-3 ps-3 mb-3">
                                            <h5 class="fw-semibold text-dark mb-1">{{ $blog->title }}</h5>
                                            <p class="text-muted small mb-0">{{ $blog->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center py-4">Belum ada blog posts</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <a href="{{ route('scraper.history') }}" 
                   class="btn btn-secondary btn-lg me-3">
                    Lihat History
                </a>
                
                <form action="{{ route('scraper.clear') }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('Yakin ingin menghapus semua content?')">
                    @csrf
                    <input type="hidden" name="type" value="all">
                    <button type="submit" 
                            class="btn btn-danger btn-lg">
                        Clear All
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif
@endsection 