<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()->with('category');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = BlogCategory::active()->get();
        $featuredPosts = BlogPost::published()->featured()->latest('published_at')->take(3)->get();

        return view('pages.blog', compact('posts', 'categories', 'featuredPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category($category)
    {
        $posts = BlogPost::published()
            ->byCategory($category)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categoryInfo = BlogCategory::where('slug', $category)->first();

        return view('blog.category', compact('posts', 'categoryInfo'));
    }
}
