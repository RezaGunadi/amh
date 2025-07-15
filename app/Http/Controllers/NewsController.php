<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\news;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->input('search');
        $selectedCategory = $request->input('category');

        // Define categories
        $categories = [
            'Semua',
            'Tips Belajar',
            'Olimpiade',
            'Pendidikan',
            'Kurikulum',
            'Ujian Nasional'
        ];

        // Get news from database
        $query = news::where('is_deleted', 0);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Apply category filter
        if ($selectedCategory && $selectedCategory !== 'Semua') {
            $query->where('category', $selectedCategory);
        }

        // Get paginated results
        $articles = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Convert articles to array format with slug
        $articlesArray = $articles->getCollection()->map(function($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'category' => $article->category,
                'description' => $article->description,
                'author' => $article->created_by,
                'time' => $article->created_at->diffForHumans(),
                'image' => 'tips-ptn.svg' // Default image
            ];
        });
        
        // Create new paginator with array data
        $articles = new \Illuminate\Pagination\LengthAwarePaginator(
            $articlesArray,
            $articles->total(),
            $articles->perPage(),
            $articles->currentPage(),
            ['path' => request()->url()]
        );

        // Get featured article (first article with is_home = 1)
        $featuredArticle = news::where('is_deleted', 0)
                              ->where('is_home', 1)
                              ->orderBy('priority', 'asc')
                              ->first();

        // Convert featured article to array format expected by view
        $featuredArticleArray = null;
        if ($featuredArticle) {
            $featuredArticleArray = [
                'id' => $featuredArticle->id,
                'title' => $featuredArticle->title,
                'slug' => $featuredArticle->slug,
                'category' => $featuredArticle->category,
                'description' => $featuredArticle->description,
                'author' => $featuredArticle->created_by,
                'time' => $featuredArticle->created_at->diffForHumans(),
                'image' => 'tips-ptn.svg' // Default image
            ];
        }

        return view('news.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
            'featuredArticle' => $featuredArticleArray,
            'currentPage' => $articles->currentPage(),
            'lastPage' => $articles->lastPage()
        ]);
    }

    public function show($slug)
    {
        // Find the article by slug
        $article = news::where('slug', $slug)
                      ->where('is_deleted', 0)
                      ->first();

        if (!$article) {
            abort(404);
        }

        // Get related articles (same category, excluding current article)
        $relatedArticles = news::where('category', $article->category)
                              ->where('id', '!=', $article->id)
                              ->where('is_deleted', 0)
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();

        return view('news.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }
} 