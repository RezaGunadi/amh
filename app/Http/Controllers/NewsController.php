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

        return view('news.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'search' => $search
        ]);
    }

    public function show($id)
    {
        // Find the article by ID
        $article = news::where('id', $id)
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