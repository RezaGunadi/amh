<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\ContentScraperService;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\news;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScrapedContentSeeder extends Seeder
{
    protected $scraperService;

    public function __construct(ContentScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🚀 Memulai ScrapedContentSeeder...');
        
        try {
            // Scrape content
            $this->command->info('📡 Scraping content dari berbagai sumber...');
            $content = $this->scraperService->scrapeContent(30); // 30 articles total
            
            if (empty($content)) {
                $this->command->warn('⚠️ Tidak ada content yang berhasil di-scrape, menggunakan fallback content...');
                $content = $this->generateFallbackContent(30);
            }
            
            $this->command->info('✅ Berhasil mendapatkan ' . count($content) . ' artikel');
            
            // Save to database
            $this->saveContentToDatabase($content);
            
            $this->command->info('🎉 ScrapedContentSeeder selesai!');
            
        } catch (\Exception $e) {
            $this->command->error('❌ Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Save scraped content to database
     */
    protected function saveContentToDatabase($content)
    {
        $this->command->info('💾 Menyimpan content ke database...');
        
        DB::beginTransaction();
        
        try {
            $savedCount = 0;
            $newsCount = 0;
            $blogCount = 0;
            
            foreach ($content as $item) {
                if ($item['category'] === 'news') {
                    $saved = $this->saveNews($item);
                    if ($saved) $newsCount++;
                } else {
                    $saved = $this->saveBlogPost($item);
                    if ($saved) $blogCount++;
                }
                
                if ($saved) {
                    $savedCount++;
                    $this->command->info("✅ Saved: {$item['title']}");
                }
            }
            
            DB::commit();
            
            $this->command->info("📊 Summary: {$savedCount} artikel tersimpan");
            $this->command->info("📰 News: {$newsCount} artikel");
            $this->command->info("📝 Blog: {$blogCount} artikel");
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('❌ Error saving to database: ' . $e->getMessage());
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
            $this->command->error("Error saving news: " . $e->getMessage());
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
            $this->command->error("Error saving blog post: " . $e->getMessage());
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

    /**
     * Generate fallback content if scraping fails
     */
    protected function generateFallbackContent($limit)
    {
        $fallbackContent = [];
        
        $newsTitles = [
            'Teknologi AI Terbaru Mengubah Cara Belajar di Indonesia',
            'Pendidikan Digital: Transformasi Pembelajaran di Era Modern',
            'Inovasi Pembelajaran Jarak Jauh Pasca Pandemi',
            'Peran Teknologi dalam Meningkatkan Kualitas Pendidikan',
            'Strategi Belajar Efektif di Era Digital',
            'Kurikulum Merdeka: Solusi Pendidikan Masa Kini',
            'Pentingnya Literasi Digital untuk Pelajar',
            'Metode Pembelajaran Interaktif dengan Teknologi',
            'Dampak Teknologi pada Prestasi Akademik Siswa',
            'Pendidikan Karakter di Era Digital',
            'Belajar Coding untuk Anak-Anak',
            'Pemanfaatan Media Sosial dalam Pendidikan',
            'Teknologi VR/AR dalam Pembelajaran',
            'Pentingnya Soft Skills di Era Digital',
            'Strategi Menghadapi Ujian dengan Teknologi'
        ];
        
        $blogTitles = [
            'Tips Belajar Matematika yang Menyenangkan untuk Anak SD',
            'Cara Menguasai Bahasa Inggris dengan Metode Modern',
            'Strategi Menghadapi Ujian Nasional dengan Percaya Diri',
            'Belajar Fisika dengan Pendekatan Praktis dan Menarik',
            'Mengembangkan Kreativitas dalam Belajar Seni',
            'Teknik Membaca Cepat untuk Pelajar',
            'Cara Menulis Esai yang Baik dan Benar',
            'Belajar Kimia dengan Eksperimen Sederhana',
            'Tips Mengatur Waktu Belajar yang Efektif',
            'Mengatasi Kesulitan Belajar dengan Metode yang Tepat',
            'Pentingnya Olahraga untuk Prestasi Akademik',
            'Belajar Sejarah dengan Pendekatan Storytelling',
            'Teknik Menghafal yang Efektif untuk Pelajar',
            'Cara Mengatasi Rasa Malas Belajar',
            'Strategi Belajar Kelompok yang Produktif'
        ];
        
        $content = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
            'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
            'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.',
            'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi.',
            'Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.'
        ];
        
        // Generate news content
        for ($i = 0; $i < min($limit / 2, count($newsTitles)); $i++) {
            $fallbackContent[] = [
                'title' => $newsTitles[$i],
                'content' => $content[array_rand($content)],
                'image' => null,
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'category' => 'news',
                'source' => 'fallback',
                'slug' => Str::slug($newsTitles[$i]),
                'excerpt' => Str::limit($content[array_rand($content)], 200)
            ];
        }
        
        // Generate blog content
        for ($i = 0; $i < min($limit / 2, count($blogTitles)); $i++) {
            $fallbackContent[] = [
                'title' => $blogTitles[$i],
                'content' => $content[array_rand($content)],
                'image' => null,
                'date' => now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'category' => 'blog',
                'source' => 'fallback',
                'slug' => Str::slug($blogTitles[$i]),
                'excerpt' => Str::limit($content[array_rand($content)], 200)
            ];
        }
        
        shuffle($fallbackContent);
        return array_slice($fallbackContent, 0, $limit);
    }
} 