<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\news;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--force : Force regenerate even if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml from all routes and dynamic content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Memulai generate sitemap...');
        
        $startTime = microtime(true);
        
        // Cek apakah sitemap sudah ada
        if (Storage::disk('public')->exists('sitemap.xml') && !$this->option('force')) {
            if (!$this->confirm('Sitemap sudah ada. Apakah Anda ingin generate ulang?')) {
                $this->info('❌ Generate sitemap dibatalkan.');
                return;
            }
        }
        
        try {
            $urls = $this->getStaticUrls();
            $this->info('✅ Static URLs: ' . count($urls) . ' URLs');
            
            $newsUrls = $this->getDynamicNewsUrls();
            $this->info('✅ News URLs: ' . count($newsUrls) . ' URLs');
            
            $materiUrls = $this->getDynamicMateriUrls();
            $this->info('✅ Materi URLs: ' . count($materiUrls) . ' URLs');
            
            $soalUrls = $this->getDynamicSoalUrls();
            $this->info('✅ Soal URLs: ' . count($soalUrls) . ' URLs');
            
            $blogUrls = $this->getDynamicBlogUrls();
            $this->info('✅ Blog URLs: ' . count($blogUrls) . ' URLs');
            
            $allUrls = array_merge($urls, $newsUrls, $materiUrls, $soalUrls, $blogUrls);
            
            $xml = $this->generateXml($allUrls);
            
            // Simpan ke public/sitemap.xml
            Storage::disk('public')->put('sitemap.xml', $xml);
            
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);
            
            $this->info('🎉 Sitemap berhasil di-generate!');
            $this->info('📊 Total URLs: ' . count($allUrls));
            $this->info('⏱️  Waktu eksekusi: ' . $executionTime . ' detik');
            $this->info('📁 File: public/sitemap.xml');
            $this->info('🌐 URL: ' . config('app.url') . '/sitemap.xml');
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }

    private function getStaticUrls()
    {
        $baseUrl = config('app.url');
        $today = Carbon::now()->toDateString();
        
        return [
            [
                'loc' => $baseUrl,
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'loc' => $baseUrl . '/home',
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'loc' => $baseUrl . '/les-privat',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'loc' => $baseUrl . '/les-privat/sd',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $baseUrl . '/les-privat/smp',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $baseUrl . '/les-privat/sma',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $baseUrl . '/bank-soal',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $baseUrl . '/soal',
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'loc' => $baseUrl . '/test',
                'lastmod' => $today,
                'changefreq' => 'daily',
                'priority' => '0.8'
            ],
            [
                'loc' => $baseUrl . '/materi',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => $baseUrl . '/news',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog',
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/about',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $baseUrl . '/careers',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.5'
            ],
            [
                'loc' => $baseUrl . '/contact',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $baseUrl . '/privacy',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.3'
            ],
            [
                'loc' => $baseUrl . '/terms',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.3'
            ],
            [
                'loc' => $baseUrl . '/tnc-child-care',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.2'
            ],
            [
                'loc' => $baseUrl . '/tnc-kelas-privat',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.2'
            ],
            [
                'loc' => $baseUrl . '/login',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.4'
            ],
            [
                'loc' => $baseUrl . '/register',
                'lastmod' => $today,
                'changefreq' => 'yearly',
                'priority' => '0.4'
            ],
            // Blog static pages
            [
                'loc' => $baseUrl . '/blog/tips-belajar-efektif',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/peran-teknologi-pendidikan',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/mempertahankan-motivasi-belajar',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/persiapan-ujian-nasional',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/cara-mudah-belajar-matematika',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/tips-jago-bahasa-inggris',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/pilihan-jurusan-kuliah',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/belajar-fisika-eksperimen',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $baseUrl . '/blog/kesehatan-mental-belajar',
                'lastmod' => $today,
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ]
        ];
    }

    private function getDynamicNewsUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
        try {
            // Ambil semua news yang tidak dihapus
            $news = news::where('is_deleted', 0)->get();
            
            foreach ($news as $item) {
                $urls[] = [
                    'loc' => $baseUrl . '/news/' . $item->id,
                    'lastmod' => $item->updated_at->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Warning: Tidak bisa mengambil data news - ' . $e->getMessage());
        }
        
        return $urls;
    }

    private function getDynamicMateriUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
        try {
            // Ambil semua materi
            $materi = Materi::all();
            
            foreach ($materi as $item) {
                $urls[] = [
                    'loc' => $baseUrl . '/materi/show/' . $item->slug,
                    'lastmod' => $item->updated_at->toDateString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Warning: Tidak bisa mengambil data materi - ' . $e->getMessage());
        }
        
        return $urls;
    }

    private function getDynamicSoalUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
        try {
            // Ambil semua soal yang aktif
            $soal = Soal::where('is_deleted', 0)->get();
            
            foreach ($soal as $item) {
                $urls[] = [
                    'loc' => $baseUrl . '/soal/' . $item->id,
                    'lastmod' => $item->updated_at->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Warning: Tidak bisa mengambil data soal - ' . $e->getMessage());
        }
        
        return $urls;
    }

    private function getDynamicBlogUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
        try {
            // Ambil semua blog post yang published
            $blogPosts = BlogPost::where('is_published', true)->get();
            
            foreach ($blogPosts as $post) {
                $urls[] = [
                    'loc' => $baseUrl . '/blog/' . $post->slug,
                    'lastmod' => $post->updated_at->toDateString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6'
                ];
            }
            
            // Tambahkan kategori blog
            $categories = BlogCategory::all();
            foreach ($categories as $category) {
                $urls[] = [
                    'loc' => $baseUrl . '/blog/kategori/' . $category->slug,
                    'lastmod' => Carbon::now()->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.5'
                ];
            }
        } catch (\Exception $e) {
            $this->warn('⚠️  Warning: Tidak bisa mengambil data blog - ' . $e->getMessage());
        }
        
        return $urls;
    }

    private function generateXml($urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        foreach ($urls as $url) {
            $xml .= '    <url>' . "\n";
            $xml .= '        <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '        <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '        <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '        <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '    </url>' . "\n";
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
} 