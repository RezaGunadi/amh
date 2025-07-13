@extends('layouts.app')

@section('title', 'Blog Kategori: ' . ($categoryInfo->name ?? $category) . ' - Kelas Privat')

@section('meta')
<meta name="description" content="Artikel blog kategori {{ $categoryInfo->name ?? $category }} - Tips belajar, pendidikan, dan informasi terkini untuk siswa dan guru.">
<meta name="keywords" content="blog, {{ $categoryInfo->name ?? $category }}, pendidikan, tips belajar">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 mb-6">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/>
                </svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('blog') }}" class="hover:text-blue-600">Blog</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/>
                </svg>
            </li>
            <li class="flex items-center">
                <span class="text-gray-900">{{ $categoryInfo->name ?? $category }}</span>
            </li>
        </ol>
    </nav>

    <div class="max-w-6xl mx-auto">
        <!-- Category Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Kategori: {{ $categoryInfo->name ?? $category }}
            </h1>
            @if($categoryInfo && $categoryInfo->description)
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $categoryInfo->description }}
            </p>
            @endif
            <div class="mt-4">
                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $posts->total() }} artikel
                </span>
            </div>
        </header>

        <!-- Articles Grid -->
        @if($posts->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($posts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($post->featured_image)
                <img src="{{ asset($post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $post->category->name ?? $post->category }}
                        </span>
                        @if($post->is_featured)
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                            Featured
                        </span>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h2>
                    
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                        {{ Str::limit($post->excerpt, 120) }}
                    </p>
                    
                    <div class="flex items-center justify-between text-gray-500 text-xs">
                        <div class="flex items-center">
                            <img src="{{ asset($post->author_avatar ?? 'assets/img/avatar-default.jpg') }}" 
                                 alt="{{ $post->author_name }}" 
                                 class="w-6 h-6 rounded-full mr-2">
                            <span>{{ $post->author_name }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span>{{ $post->reading_time }} menit</span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada artikel</h3>
            <p class="text-gray-600 mb-6">
                Belum ada artikel dalam kategori ini. Silakan cek kategori lain atau kembali ke halaman blog.
            </p>
            <a href="{{ route('blog') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Kembali ke Blog
            </a>
        </div>
        @endif
    </div>
</div>
@endsection 