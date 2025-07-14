@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">📋 Hasil Scraping</h1>
            <p class="text-lg text-gray-600">Content berhasil di-scrape dari berbagai sumber</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Scraped</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $results['total_scraped'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Saved to DB</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $results['saved_count'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">News Articles</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $results['news_count'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Blog Posts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $results['blog_count'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📄 Detail Content</h2>
            
            <div class="space-y-6">
                @foreach($results['content'] as $index => $item)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    @if($item['category'] === 'news')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mr-3">
                                            📰 News
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mr-3">
                                            📝 Blog
                                        </span>
                                    @endif
                                    
                                    <span class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($item['date'])->format('d M Y H:i') }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item['title'] }}</h3>
                                
                                <p class="text-gray-600 mb-4">{{ $item['excerpt'] }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                    </svg>
                                    {{ parse_url($item['source'], PHP_URL_HOST) ?: $item['source'] }}
                                </div>
                            </div>
                            
                            @if($item['image'])
                                <div class="ml-4">
                                    <img src="{{ $item['image'] }}" 
                                         alt="{{ $item['title'] }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                        
                        @if($item['content'])
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <details class="group">
                                    <summary class="cursor-pointer text-sm font-medium text-blue-600 hover:text-blue-800">
                                        Lihat konten lengkap
                                    </summary>
                                    <div class="mt-3 text-gray-700 text-sm leading-relaxed">
                                        {{ $item['content'] }}
                                    </div>
                                </details>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mt-8">
            <a href="{{ route('scraper.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Scrape Lagi
            </a>
            
            <a href="{{ route('scraper.history') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Lihat History
            </a>
            
            <a href="{{ route('news.index') }}" 
               class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Lihat News
            </a>
            
            <a href="{{ route('blog.index') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Lihat Blog
            </a>
        </div>
    </div>
</div>
@endsection 