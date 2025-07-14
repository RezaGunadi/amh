<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ContentScraperService;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\news;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScrapeContentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:content {--limit=20 : Number of articles to scrape} {--save : Save to database} {--test : Test mode without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape blog posts and news articles from multiple sources';

    protected $scraperService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContentScraperService $scraperService)
    {
        parent::__construct();
        $this->scraperService = $scraperService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $save = $this->option('save');
        $test = $this->option('test');

        $this->info("🚀 Memulai scraping content...");
        $this->info("📊 Target: {$limit} artikel");
        $this->info("💾 Save to DB: " . ($save ? 'Yes' : 'No'));
        $this->info("🧪 Test mode: " . ($test ? 'Yes' : 'No'));

        try {
            // Start scraping
            $this->info("\n📡 Scraping content dari berbagai sumber...");
            $content = $this->scraperService->scrapeContent($limit);

            if (empty($content)) {
                $this->error("❌ Tidak ada content yang berhasil di-scrape!");
                return 1;
            }

            $this->info("✅ Berhasil scrape " . count($content) . " artikel");

            // Display results
            $this->displayResults($content);

            // Save to database if requested
            if ($save && !$test) {
                $this->saveToDatabase($content);
            }

            $this->info("\n🎉 Scraping selesai!");
            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Display scraping results
     */
    protected function displayResults($content)
    {
        $this->info("\n📋 Hasil Scraping:");
        $this->info(str_repeat('-', 80));

        $newsCount = 0;
        $blogCount = 0;

        foreach ($content as $index => $item) {
            $number = $index + 1;
            $category = $item['category'] === 'news' ? '📰' : '📝';
            $source = parse_url($item['source'], PHP_URL_HOST) ?: $item['source'];
            
            $this->info("{$number}. {$category} {$item['title']}");
            $this->info("   📅 {$item['date']} | 🌐 {$source}");
            $this->info("   📄 " . Str::limit($item['excerpt'], 100));
            $this->info("");

            if ($item['category'] === 'news') {
                $newsCount++;
            } else {
                $blogCount++;
            }
        }

        $this->info(str_repeat('-', 80));
        $this->info("📊 Summary: {$newsCount} news, {$blogCount} blog posts");
    }

    /**
     * Save scraped content to database
     */
    protected function saveToDatabase($content)
    {
        $this->info("\n💾 Menyimpan ke database...");

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
                    $this->info("✅ Saved: {$item['title']}");
                }
            }

            DB::commit();
            $this->info("\n🎉 Berhasil menyimpan {$savedCount} artikel ke database!");

        } catch (\Exception $e) {
            DB::rollback();
            $this->error("❌ Error saving to database: " . $e->getMessage());
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
                $this->warn("⚠️ News already exists: {$item['title']}");
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
            $this->error("Error saving news: " . $e->getMessage());
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
                $this->warn("⚠️ Blog post already exists: {$item['title']}");
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
            $this->error("Error saving blog post: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get or create blog category
     */
    protected function getOrCreateCategory($name)
    {
        $category = BlogCategory::where('name', $name)->first();
        
        if (!$category) {
            $category = BlogCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Content scraped from external sources'
            ]);
        }

        return $category;
    }
}
