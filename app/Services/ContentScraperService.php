<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class ContentScraperService
{
    protected $userAgents = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
    ];

    protected $newsSources = [
        'detik' => [
            'url' => 'https://www.detik.com/',
            'title_selector' => 'h1, h2, h3',
            'content_selector' => '.detail__body-text, .itp_bodycontent',
            'image_selector' => '.detail__media img, .itp_bodycontent img',
            'date_selector' => '.detail__date, .itp_bodycontent .date',
            'category' => 'news'
        ],
        'kompas' => [
            'url' => 'https://www.kompas.com/',
            'title_selector' => 'h1, h2, h3',
            'content_selector' => '.read__content, .article__content',
            'image_selector' => '.read__img img, .article__img img',
            'date_selector' => '.read__time, .article__time',
            'category' => 'news'
        ],
        'tribun' => [
            'url' => 'https://www.tribunnews.com/',
            'title_selector' => 'h1, h2, h3',
            'content_selector' => '.txt-article, .article-content',
            'image_selector' => '.imgfullwidth img, .article-img img',
            'date_selector' => '.time, .article-time',
            'category' => 'news'
        ]
    ];

    protected $blogSources = [
        'medium' => [
            'url' => 'https://medium.com/tag/indonesia',
            'title_selector' => 'h1, h2, h3',
            'content_selector' => '.postArticle-content, .section-content',
            'image_selector' => '.postArticle-content img, .section-content img',
            'date_selector' => '.postArticle-header time, .section-header time',
            'category' => 'blog'
        ],
        'devto' => [
            'url' => 'https://dev.to/t/indonesia',
            'title_selector' => 'h1, h2, h3',
            'content_selector' => '.crayons-article__content, .article-content',
            'image_selector' => '.crayons-article__content img, .article-content img',
            'date_selector' => '.crayons-article__date, .article-date',
            'category' => 'blog'
        ]
    ];

    /**
     * Scrape content from multiple sources
     */
    public function scrapeContent($limit = 10)
    {
        $allContent = [];
        
        try {
            // Scrape news
            $newsContent = $this->scrapeNews($limit);
            $allContent = array_merge($allContent, $newsContent);
            
            // Scrape blog posts
            $blogContent = $this->scrapeBlogs($limit);
            $allContent = array_merge($allContent, $blogContent);
            
            // Shuffle and limit results
            shuffle($allContent);
            return array_slice($allContent, 0, $limit);
            
        } catch (\Exception $e) {
            Log::error('Scraping error: ' . $e->getMessage());
            return $this->generateFallbackContent($limit);
        }
    }

    /**
     * Scrape news articles
     */
    public function scrapeNews($limit = 5)
    {
        $newsContent = [];
        
        foreach ($this->newsSources as $source => $config) {
            try {
                $content = $this->scrapeSource($config, $limit / count($this->newsSources));
                $newsContent = array_merge($newsContent, $content);
                
                // Add delay to be respectful
                sleep(1);
                
            } catch (\Exception $e) {
                Log::error("Error scraping {$source}: " . $e->getMessage());
                continue;
            }
        }
        
        return $newsContent;
    }

    /**
     * Scrape blog posts
     */
    public function scrapeBlogs($limit = 5)
    {
        $blogContent = [];
        
        foreach ($this->blogSources as $source => $config) {
            try {
                $content = $this->scrapeSource($config, $limit / count($this->blogSources));
                $blogContent = array_merge($blogContent, $content);
                
                // Add delay to be respectful
                sleep(1);
                
            } catch (\Exception $e) {
                Log::error("Error scraping {$source}: " . $e->getMessage());
                continue;
            }
        }
        
        return $blogContent;
    }

    /**
     * Scrape individual source
     */
    protected function scrapeSource($config, $limit)
    {
        $content = [];
        
        try {
            $response = Http::withHeaders([
                'User-Agent' => $this->userAgents[array_rand($this->userAgents)],
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Accept-Encoding' => 'gzip, deflate',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
            ])->timeout(30)->get($config['url']);
            
            if ($response->successful()) {
                $html = $response->body();
                $crawler = new Crawler($html);
                
                // Extract articles
                $articles = $crawler->filter('article, .article, .post, .news-item')->slice(0, $limit);
                
                foreach ($articles as $article) {
                    $articleCrawler = new Crawler($article);
                    
                    $title = $this->extractText($articleCrawler, $config['title_selector']);
                    $content_text = $this->extractText($articleCrawler, $config['content_selector']);
                    $image = $this->extractImage($articleCrawler, $config['image_selector']);
                    $date = $this->extractDate($articleCrawler, $config['date_selector']);
                    
                    if ($title && $content_text) {
                        $content[] = [
                            'title' => $title,
                            'content' => $this->cleanContent($content_text),
                            'image' => $image,
                            'date' => $date,
                            'category' => $config['category'],
                            'source' => $config['url'],
                            'slug' => Str::slug($title),
                            'excerpt' => Str::limit($content_text, 200)
                        ];
                    }
                }
            }
            
        } catch (\Exception $e) {
            Log::error("Error scraping source {$config['url']}: " . $e->getMessage());
        }
        
        return $content;
    }

    /**
     * Extract text from selector
     */
    protected function extractText(Crawler $crawler, $selector)
    {
        try {
            $element = $crawler->filter($selector)->first();
            return $element->count() > 0 ? trim($element->text()) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extract image from selector
     */
    protected function extractImage(Crawler $crawler, $selector)
    {
        try {
            $element = $crawler->filter($selector)->first();
            if ($element->count() > 0) {
                $src = $element->attr('src');
                $dataSrc = $element->attr('data-src');
                return $src ?: $dataSrc;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extract date from selector
     */
    protected function extractDate(Crawler $crawler, $selector)
    {
        try {
            $element = $crawler->filter($selector)->first();
            if ($element->count() > 0) {
                $dateText = trim($element->text());
                $dateTime = $element->attr('datetime');
                
                if ($dateTime) {
                    return date('Y-m-d H:i:s', strtotime($dateTime));
                }
                
                // Try to parse common date formats
                $patterns = [
                    '/\d{1,2}\/\d{1,2}\/\d{4}/',
                    '/\d{1,2}-\d{1,2}-\d{4}/',
                    '/\d{4}-\d{1,2}-\d{1,2}/'
                ];
                
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $dateText, $matches)) {
                        return date('Y-m-d H:i:s', strtotime($matches[0]));
                    }
                }
            }
            return now()->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return now()->format('Y-m-d H:i:s');
        }
    }

    /**
     * Clean content text
     */
    protected function cleanContent($content)
    {
        // Remove extra whitespace
        $content = preg_replace('/\s+/', ' ', $content);
        
        // Remove HTML tags
        $content = strip_tags($content);
        
        // Trim
        $content = trim($content);
        
        // Limit length
        return Str::limit($content, 2000);
    }

    /**
     * Generate fallback content if scraping fails
     */
    protected function generateFallbackContent($limit)
    {
        $fallbackContent = [];
        
        $newsTitles = [
            'Teknologi AI Terbaru Mengubah Cara Belajar',
            'Pendidikan Digital di Era Modern',
            'Inovasi Pembelajaran Jarak Jauh',
            'Peran Teknologi dalam Pendidikan',
            'Strategi Belajar Efektif di Era Digital'
        ];
        
        $blogTitles = [
            'Tips Belajar Matematika yang Menyenangkan',
            'Cara Menguasai Bahasa Inggris dengan Cepat',
            'Strategi Menghadapi Ujian Nasional',
            'Belajar Fisika dengan Pendekatan Praktis',
            'Mengembangkan Kreativitas dalam Belajar'
        ];
        
        $content = [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.'
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