@extends('layouts.app')

@section('title', $post->title . ' - Kelas Privat')

@section('meta')
<meta name="description" content="{{ $post->excerpt }}">
<meta name="keywords" content="blog, pendidikan, {{ $post->category->name ?? 'artikel' }}">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/blog/' . $post->slug) }}">
@if($post->featured_image)
<meta property="og:image" content="{{ asset($post->featured_image) }}">
@endif
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
                <span class="text-gray-900">{{ $post->title }}</span>
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- Article Header -->
        <header class="mb-8">
            <div class="mb-4">
                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $post->category->name ?? $post->category }}
                </span>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">
                {{ $post->title }}
            </h1>
            
            <div class="flex items-center text-gray-600 text-sm mb-6">
                <div class="flex items-center mr-6">
                    <img src="{{ asset($post->author_avatar ?? 'assets/img/avatar-default.jpg') }}" 
                         alt="{{ $post->author_name }}" 
                         class="w-8 h-8 rounded-full mr-2">
                    <span>{{ $post->author_name }}</span>
                </div>
                <div class="flex items-center mr-6">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $post->reading_time }} menit baca</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                </div>
            </div>

            @if($post->featured_image)
            <div class="mb-6">
                <img src="{{ asset($post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-64 object-cover rounded-lg">
            </div>
            @endif

            <p class="text-xl text-gray-700 leading-relaxed">
                {{ $post->excerpt }}
            </p>
        </header>

        <!-- Article Content -->
        <article class="prose prose-lg max-w-none mb-12">
            {!! $post->content !!}
        </article>

        <!-- Article Footer -->
        <footer class="border-t border-gray-200 pt-8 mb-12">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Bagikan:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/blog/' . $post->slug)) }}" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/blog/' . $post->slug)) }}&text={{ urlencode($post->title) }}" 
                       target="_blank" 
                       class="text-blue-400 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url('/blog/' . $post->slug)) }}" 
                       target="_blank" 
                       class="text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </a>
                </div>
                
                <div class="flex items-center text-gray-600 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $post->views ?? 0 }} kali dibaca</span>
                </div>
            </div>
        </footer>

        <!-- Related Articles -->
        @if($relatedPosts->count() > 0)
        <section class="border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $relatedPost)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($relatedPost->featured_image)
                    <img src="{{ asset($relatedPost->featured_image) }}" 
                         alt="{{ $relatedPost->title }}" 
                         class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full mb-3">
                            {{ $relatedPost->category->name ?? $relatedPost->category }}
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-blue-600">
                                {{ $relatedPost->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-3">
                            {{ Str::limit($relatedPost->excerpt, 100) }}
                        </p>
                        <div class="flex items-center text-gray-500 text-xs">
                            <span>{{ $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $relatedPost->reading_time }} menit</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection 