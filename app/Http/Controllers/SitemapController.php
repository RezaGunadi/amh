<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\news;
use App\Models\Materi;
use App\Models\soal;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function generate()
    {
        $urls = $this->getStaticUrls();
        $urls = array_merge($urls, $this->getDynamicNewsUrls());
        $urls = array_merge($urls, $this->getDynamicMateriUrls());
        $urls = array_merge($urls, $this->getDynamicSoalUrls());
        $urls = array_merge($urls, $this->getDynamicBlogUrls());

        $xml = $this->generateXml($urls);
        
        // Simpan ke public/sitemap.xml
        Storage::disk('public')->put('sitemap.xml', $xml);
        
        return response()->json([
            'success' => true,
            'message' => 'Sitemap berhasil di-generate!',
            'total_urls' => count($urls),
            'file_path' => 'public/sitemap.xml'
        ]);
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
        
        return $urls;
    }

    private function getDynamicMateriUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
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
        
        return $urls;
    }

    private function getDynamicSoalUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
        // Ambil semua soal yang aktif
        $soal = soal::where('is_deleted', 0)->get();
        
        foreach ($soal as $item) {
            $urls[] = [
                'loc' => $baseUrl . '/soal/' . $item->id,
                'lastmod' => $item->updated_at->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ];
        }
        
        return $urls;
    }

    private function getDynamicBlogUrls()
    {
        $urls = [];
        $baseUrl = config('app.url');
        
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

    public function show()
    {
        $sitemapPath = storage_path('app/public/sitemap.xml');
        
        if (!file_exists($sitemapPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Sitemap belum di-generate. Silakan generate terlebih dahulu.'
            ]);
        }
        
        $content = file_get_contents($sitemapPath);
        $urlCount = substr_count($content, '<url>');
        
        return response()->json([
            'success' => true,
            'message' => 'Sitemap berhasil di-load',
            'total_urls' => $urlCount,
            'last_modified' => date('Y-m-d H:i:s', filemtime($sitemapPath)),
            'file_size' => number_format(filesize($sitemapPath) / 1024, 2) . ' KB'
        ]);
    }
} 