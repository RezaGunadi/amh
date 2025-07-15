@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">📋 Hasil Scraping</h1>
                <p class="lead text-muted">Content berhasil di-scrape dari berbagai sumber</p>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-5">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                                    <i class="fas fa-bolt fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Total Scraped</p>
                                    <h3 class="fw-bold mb-0">{{ $results['total_scraped'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                                    <i class="fas fa-check fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Saved to DB</p>
                                    <h3 class="fw-bold mb-0">{{ $results['saved_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                                    <i class="fas fa-newspaper fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">News Articles</p>
                                    <h3 class="fw-bold mb-0">{{ $results['news_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle me-3">
                                    <i class="fas fa-blog fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-1">Blog Posts</p>
                                    <h3 class="fw-bold mb-0">{{ $results['blog_count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content List -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h3 fw-bold text-dark mb-4">📄 Detail Content</h2>
                    
                    <div class="space-y-4">
                        @foreach($results['content'] as $index => $item)
                            <div class="border rounded-3 p-4 mb-4 hover-shadow">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($item['category'] === 'news')
                                                <span class="badge bg-primary bg-opacity-10 text-primary me-3">
                                                    📰 News
                                                </span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success me-3">
                                                    📝 Blog
                                                </span>
                                            @endif
                                            
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($item['date'])->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                        
                                        <h4 class="h5 fw-bold text-dark mb-2">{{ $item['title'] }}</h4>
                                        
                                        <p class="text-muted mb-3">{{ $item['excerpt'] }}</p>
                                        
                                        <div class="d-flex align-items-center text-muted small">
                                            <i class="fas fa-globe me-2"></i>
                                            {{ parse_url($item['source'], PHP_URL_HOST) ?: $item['source'] }}
                                        </div>
                                    </div>
                                    
                                    @if($item['image'])
                                        <div class="col-md-4 text-center">
                                            <img src="{{ $item['image'] }}" 
                                                 alt="{{ $item['title'] }}" 
                                                 class="img-fluid rounded" style="max-width: 120px;">
                                        </div>
                                    @endif
                                </div>
                                
                                @if($item['content'])
                                    <div class="mt-3 pt-3 border-top">
                                        <details class="group">
                                            <summary class="cursor-pointer text-primary fw-medium">
                                                Lihat konten lengkap
                                            </summary>
                                            <div class="mt-3 text-muted small">
                                                {{ $item['content'] }}
                                            </div>
                                        </details>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-5">
                <a href="{{ route('scraper.index') }}" 
                   class="btn btn-primary btn-lg me-3">
                    Scrape Lagi
                </a>
                
                <a href="{{ route('scraper.history') }}" 
                   class="btn btn-secondary btn-lg me-3">
                    Lihat History
                </a>
                
                <a href="{{ route('news.index') }}" 
                   class="btn btn-success btn-lg me-3">
                    Lihat News
                </a>
                
                <a href="{{ route('blog.index') }}" 
                   class="btn btn-info btn-lg">
                    Lihat Blog
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 