<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\TravelPackage;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    /**
     * Generate sitemap index
     */
    public function index(): Response
    {
        $sitemapContent = $this->generateSitemapIndex();
        
        return response($sitemapContent)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate main sitemap
     */
    public function main(): Response
    {
        $sitemapContent = $this->generateMainSitemap();
        
        return response($sitemapContent)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate travel packages sitemap
     */
    public function travelPackages(): Response
    {
        $sitemapContent = $this->generateTravelPackagesSitemap();
        
        return response($sitemapContent)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate blog sitemap
     */
    public function blog(): Response
    {
        $sitemapContent = $this->generateBlogSitemap();
        
        return response($sitemapContent)
            ->header('Content-Type', 'application/xml; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Generate sitemap index content
     */
    protected function generateSitemapIndex(): string
    {
        $baseUrl = url('/');
        $lastmod = now()->format('Y-m-d\TH:i:s\Z');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        $sitemaps = [
            ['loc' => $baseUrl . '/sitemap/main.xml', 'lastmod' => $lastmod],
            ['loc' => $baseUrl . '/sitemap/travel-packages.xml', 'lastmod' => $lastmod],
            ['loc' => $baseUrl . '/sitemap/blog.xml', 'lastmod' => $lastmod],
        ];

        foreach ($sitemaps as $sitemap) {
            $xml .= '<sitemap>';
            $xml .= '<loc>' . htmlspecialchars($sitemap['loc']) . '</loc>';
            $xml .= '<lastmod>' . $sitemap['lastmod'] . '</lastmod>';
            $xml .= '</sitemap>';
        }

        $xml .= '</sitemapindex>';

        return $xml;
    }

    /**
     * Generate main sitemap content
     */
    protected function generateMainSitemap(): string
    {
        $baseUrl = url('/');
        $lastmod = now()->format('Y-m-d\TH:i:s\Z');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Static pages
        $staticPages = [
            ['loc' => $baseUrl . '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $baseUrl . '/about', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/visa-services', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/student-admission', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/tours-holidays', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/consultation', 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/blog', 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => $baseUrl . '/contact', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => $baseUrl . '/faq', 'changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['loc']) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Generate travel packages sitemap content
     */
    protected function generateTravelPackagesSitemap(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        
        $packages = TravelPackage::where('is_active', true)
            ->select('slug', 'updated_at', 'title', 'description', 'image')
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($packages as $package) {
            $url = url('/tours-holidays/' . $package->slug);
            $lastmod = $package->updated_at->format('Y-m-d\TH:i:s\Z');
            
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            
            // Add image if exists
            if ($package->image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(url($package->image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($package->title) . '</image:title>';
                if ($package->description) {
                    $xml .= '<image:caption>' . htmlspecialchars(Str::limit($package->description, 200)) . '</image:caption>';
                }
                $xml .= '</image:image>';
            }
            
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Generate blog sitemap content
     */
    protected function generateBlogSitemap(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        
        $posts = Blog::where('published', true)
            ->select('slug', 'updated_at', 'title', 'excerpt', 'featured_image', 'published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            $url = url('/blog/' . $post->slug);
            $lastmod = $post->updated_at->format('Y-m-d\TH:i:s\Z');
            
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            
            // Add image if exists
            if ($post->featured_image) {
                $xml .= '<image:image>';
                $xml .= '<image:loc>' . htmlspecialchars(url($post->featured_image)) . '</image:loc>';
                $xml .= '<image:title>' . htmlspecialchars($post->title) . '</image:title>';
                if ($post->excerpt) {
                    $xml .= '<image:caption>' . htmlspecialchars(Str::limit($post->excerpt, 200)) . '</image:caption>';
                }
                $xml .= '</image:image>';
            }
            
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Generate robots.txt content
     */
    public function robots(): Response
    {
        $baseUrl = url('/');
        
        $content = "# Robots.txt for " . config('app.name') . "\n";
        $content .= "User-agent: *\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /dashboard/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /_ignition/\n";
        $content .= "Disallow: /storage/\n";
        $content .= "Disallow: /vendor/\n";
        $content .= "Disallow: /node_modules/\n";
        $content .= "Disallow: /*.json$\n";
        $content .= "Disallow: /*?\n";
        $content .= "\n";
        
        // Allow important paths
        $content .= "Allow: /sitemap\n";
        $content .= "Allow: /blog\n";
        $content .= "Allow: /tours-holidays\n";
        $content .= "Allow: /visa-services\n";
        $content .= "Allow: /student-admission\n";
        $content .= "\n";
        
        // Sitemap location
        $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";
        
        // Crawl delay
        $content .= "\n";
        $content .= "# Crawl delay (optional)\n";
        $content .= "Crawl-delay: 1\n";

        return response($content)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Cache-Control', 'public, max-age=86400'); // Cache for 24 hours
    }

    /**
     * Generate JSON sitemap
     */
    public function json(): JsonResponse
    {
        $baseUrl = url('/');
        
        $sitemap = [
            'version' => 'https://www.sitemaps.org/schemas/sitemap/0.9',
            'urlset' => [],
        ];

        // Add static pages
        $staticPages = [
            ['url' => $baseUrl . '/', 'priority' => '1.0'],
            ['url' => $baseUrl . '/about', 'priority' => '0.8'],
            ['url' => $baseUrl . '/visa-services', 'priority' => '0.9'],
            ['url' => $baseUrl . '/student-admission', 'priority' => '0.9'],
            ['url' => $baseUrl . '/tours-holidays', 'priority' => '0.9'],
            ['url' => $baseUrl . '/consultation', 'priority' => '0.8'],
            ['url' => $baseUrl . '/blog', 'priority' => '0.8'],
            ['url' => $baseUrl . '/contact', 'priority' => '0.7'],
        ];

        foreach ($staticPages as $page) {
            $sitemap['urlset'][] = [
                'url' => $page['url'],
                'lastmod' => now()->format('c'),
                'priority' => $page['priority'],
            ];
        }

        // Add travel packages
        $packages = TravelPackage::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($packages as $package) {
            $sitemap['urlset'][] = [
                'url' => $baseUrl . '/tours-holidays/' . $package->slug,
                'lastmod' => $package->updated_at->format('c'),
                'priority' => '0.8',
            ];
        }

        // Add blog posts
        $posts = Blog::where('published', true)
            ->select('slug', 'updated_at')
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($posts as $post) {
            $sitemap['urlset'][] = [
                'url' => $baseUrl . '/blog/' . $post->slug,
                'lastmod' => $post->updated_at->format('c'),
                'priority' => '0.7',
            ];
        }

        return response()->json($sitemap)
            ->header('Cache-Control', 'public, max-age=3600');
    }
}