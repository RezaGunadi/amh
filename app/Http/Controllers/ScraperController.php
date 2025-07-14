<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContentScraperService;
use App\Models\BlogPost;
use App\Models\news;
use Illuminate\Support\Facades\DB;

class ScraperController extends Controller
{
    protected $scraperService;

    public function __construct(ContentScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    /**
     * Show scraping interface
     */
    public function index()
    {
        $stats = [
            'news_count' => news::count(),
            'blog_count' => BlogPost::count(),
            'recent_news' => news::latest()->take(5)->get(),
            'recent_blogs' => BlogPost::latest()->take(5)->get()
        ];

        return view('scraper.index', compact('stats'));
    }

    /**
     * Run scraping and show results
     */
    public function scrape(Request $request)
    {
        $request->validate([
            'limit' => 'integer|min:1|max:50',
            'save' => 'boolean'
        ]);

        $limit = $request->input('limit', 20);
        $save = $request->input('save', false);

        try {
            // Run scraping
            $content = $this->scraperService->scrapeContent($limit);
            
            if (empty($content)) {
                return back()->with('error', 'Tidak ada content yang berhasil di-scrape!');
            }

            // Save to database if requested
            $savedCount = 0;
            if ($save) {
                $savedCount = $this->saveScrapedContent($content);
            }

            // Prepare results for view
            $results = [
                'content' => $content,
                'total_scraped' => count($content),
                'saved_count' => $savedCount,
                'news_count' => collect($content)->where('category', 'news')->count(),
                'blog_count' => collect($content)->where('category', 'blog')->count()
            ];

            return view('scraper.results', compact('results'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Save scraped content to database
     */
    protected function saveScrapedContent($content)
    {
        DB::beginTransaction();

        try {
            $savedCount = 0;

            foreach ($content as $item) {
                if ($item['category'] === 'news') {
                    $saved = $this->saveNews($item);
                } else {
                    $saved = $this->saveBlogPost($item);
                }

                if ($saved) {
                    $savedCount++;
                }
            }

            DB::commit();
            return $savedCount;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Save news article
     */
    protected function saveNews($item)
    {
        try {
            // Check if news already exists
            $existingNews = news::where('slug', $item['slug'])->first();
            if ($existingNews) {
                return false;
            }

            // Create news
            $news = news::create([
                'title' => $item['title'],
                'slug' => $item['slug'],
                'description' => $item['content'],
                'image' => $item['image'],
                'published_at' => $item['date'],
                'is_published' => 1,
                'user_id' => 1, // Admin user
                'created_at' => $item['date'],
                'updated_at' => now()
            ]);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Save blog post
     */
    protected function saveBlogPost($item)
    {
        try {
            // Check if blog post already exists
            $existingPost = BlogPost::where('slug', $item['slug'])->first();
            if ($existingPost) {
                return false;
            }

            // Get or create category
            $category = $this->getOrCreateCategory('Scraped Content');

            // Create blog post
            $blogPost = BlogPost::create([
                'title' => $item['title'],
                'slug' => $item['slug'],
                'content' => $item['content'],
                'excerpt' => $item['excerpt'],
                'featured_image' => $item['image'],
                'blog_category_id' => $category->id,
                'user_id' => 1, // Admin user
                'is_published' => 1,
                'published_at' => $item['date'],
                'created_at' => $item['date'],
                'updated_at' => now()
            ]);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get or create blog category
     */
    protected function getOrCreateCategory($name)
    {
        $category = \App\Models\BlogCategory::where('name', $name)->first();
        
        if (!$category) {
            $category = \App\Models\BlogCategory::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'description' => 'Content scraped from external sources'
            ]);
        }

        return $category;
    }

    /**
     * Show scraping history
     */
    public function history()
    {
        $recentNews = news::latest()->take(20)->get();
        $recentBlogs = BlogPost::latest()->take(20)->get();

        return view('scraper.history', compact('recentNews', 'recentBlogs'));
    }

    /**
     * Clear scraped content
     */
    public function clear(Request $request)
    {
        try {
            $type = $request->input('type', 'all');
            
            if ($type === 'news' || $type === 'all') {
                news::truncate();
            }
            
            if ($type === 'blog' || $type === 'all') {
                BlogPost::truncate();
            }

            return back()->with('success', 'Content berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
} 