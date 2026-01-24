<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SEOService
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $author;
    protected $image;
    protected $url;
    protected $type = 'website';
    protected $locale;
    protected $siteName;
    protected $canonicalUrl;
    protected $metaTags = [];
    protected $jsonLd = [];

    public function __construct()
    {
        $this->locale = app()->getLocale();
        $this->siteName = config('app.name');
    }

    /**
     * Set page title
     */
    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set page description
     */
    public function description(string $description): self
    {
        $this->description = Str::limit(strip_tags($description), 160);
        return $this;
    }

    /**
     * Set keywords
     */
    public function keywords(array $keywords): self
    {
        $this->keywords = implode(', ', $keywords);
        return $this;
    }

    /**
     * Set author
     */
    public function author(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Set page image
     */
    public function image(string $image): self
    {
        $this->image = URL::asset($image);
        return $this;
    }

    /**
     * Set page URL
     */
    public function url(string $url): self
    {
        $this->url = $url;
        $this->canonicalUrl = $url;
        return $this;
    }

    /**
     * Set page type
     */
    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Set canonical URL
     */
    public function canonical(string $url): self
    {
        $this->canonicalUrl = $url;
        return $this;
    }

    /**
     * Add custom meta tag
     */
    public function addMeta(string $name, string $content, string $property = 'name'): self
    {
        $this->metaTags[] = [
            'property' => $property,
            'name' => $name,
            'content' => $content,
        ];
        return $this;
    }

    /**
     * Add JSON-LD structured data
     */
    public function addJsonLd(string $type, array $data): self
    {
        $this->jsonLd[] = [
            '@type' => $type,
            '@context' => 'https://schema.org',
            ...$data,
        ];
        return $this;
    }

    /**
     * Generate for travel package
     */
    public function forTravelPackage($package): self
    {
        return $this
            ->title($package->title . ' - Travel Package')
            ->description($package->description)
            ->keywords([$package->title, 'travel', 'vacation', $package->destination_country, 'holiday'])
            ->image($package->image ?? 'images/default-package.jpg')
            ->url(route('travel-packages.show', $package->slug))
            ->type('product')
            ->addJsonLd('TouristTrip', [
                'name' => $package->title,
                'description' => $package->description,
                'image' => URL::asset($package->image ?? 'images/default-package.jpg'),
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $package->current_price,
                    'priceCurrency' => $package->currency ?? 'USD',
                    'availability' => $package->is_available ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                ],
                'provider' => [
                    '@type' => 'Organization',
                    'name' => $this->siteName,
                    'url' => URL::to('/'),
                ],
            ]);
    }

    /**
     * Generate for visa service page
     */
    public function forVisaService(): self
    {
        return $this
            ->title('Visa Services - Professional Visa Application Assistance')
            ->description('Get professional help with your visa applications. Fast processing, expert guidance, and high success rates for tourist, student, business, and work visas.')
            ->keywords(['visa services', 'visa application', 'tourist visa', 'student visa', 'work visa', 'immigration', 'travel documents'])
            ->image('images/visa-service-banner.jpg')
            ->url(route('visa-services'))
            ->addJsonLd('Service', [
                'name' => 'Visa Application Services',
                'description' => 'Professional visa application assistance and consultation',
                'provider' => [
                    '@type' => 'Organization',
                    'name' => $this->siteName,
                    'url' => URL::to('/'),
                ],
                'serviceType' => 'Professional Service',
                'areaServed' => 'Worldwide',
            ]);
    }

    /**
     * Generate for student admission page
     */
    public function forStudentAdmission(): self
    {
        return $this
            ->title('Student Admission Services - Study Abroad Assistance')
            ->description('Get expert help with student admissions and study visas. Assistance for universities, courses, applications, and documentation.')
            ->keywords(['student admission', 'study abroad', 'university application', 'student visa', 'education consultancy', 'international students'])
            ->image('images/student-admission-banner.jpg')
            ->url(route('student-admission'))
            ->addJsonLd('EducationalOrganization', [
                'name' => $this->siteName,
                'description' => 'Student admission and study abroad consultancy',
                'url' => URL::to('/'),
                'hasOfferCatalog' => [
                    '@type' => 'OfferCatalog',
                    'name' => 'Student Admission Services',
                    'itemListElement' => [
                        [
                            '@type' => 'Offer',
                            'name' => 'University Application Assistance',
                            'description' => 'Help with university applications and documentation',
                        ],
                        [
                            '@type' => 'Offer',
                            'name' => 'Student Visa Processing',
                            'description' => 'Student visa application and processing services',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * Generate for blog post
     */
    public function forBlogPost($post): self
    {
        return $this
            ->title($post->title . ' - Travel Blog')
            ->description($post->excerpt ?? Str::limit(strip_tags($post->content), 160))
            ->keywords(array_merge([$post->title], explode(',', $post->meta_keywords ?? '')))
            ->image($post->featured_image ?? 'images/default-blog.jpg')
            ->url(route('blog.show', $post->slug))
            ->author($post->author->name)
            ->type('article')
            ->addJsonLd('BlogPosting', [
                'headline' => $post->title,
                'description' => $post->excerpt ?? Str::limit(strip_tags($post->content), 160),
                'image' => URL::asset($post->featured_image ?? 'images/default-blog.jpg'),
                'author' => [
                    '@type' => 'Person',
                    'name' => $post->author->name,
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $this->siteName,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => URL::asset('images/logo.png'),
                    ],
                ],
                'datePublished' => $post->published_at->toIso8601String(),
                'dateModified' => $post->updated_at->toIso8601String(),
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => route('blog.show', $post->slug),
                ],
            ]);
    }

    /**
     * Generate for home page
     */
    public function forHomePage(): self
    {
        return $this
            ->title('Travel Business - Your Trusted Travel Partner')
            ->description('Complete travel solutions including visa services, student admissions, tour packages, and consultations. Expert assistance for all your travel needs.')
            ->keywords(['travel business', 'visa services', 'tour packages', 'student admission', 'travel consultancy'])
            ->image('images/home-banner.jpg')
            ->url(URL::to('/'))
            ->addJsonLd('Organization', [
                'name' => $this->siteName,
                'description' => 'Complete travel solutions and consultancy services',
                'url' => URL::to('/'),
                'logo' => URL::asset('images/logo.png'),
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => config('app.contact.phone'),
                    'contactType' => 'customer service',
                    'availableLanguage' => ['English'],
                ],
                'sameAs' => [
                    config('app.social.facebook'),
                    config('app.social.twitter'),
                    config('app.social.instagram'),
                ],
            ]);
    }

    /**
     * Render meta tags
     */
    public function render(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->description,
            'keywords' => $this->keywords,
            'author' => $this->author,
            'image' => $this->image,
            'url' => $this->url ?? URL::current(),
            'canonical' => $this->canonicalUrl,
            'type' => $this->type,
            'locale' => $this->locale,
            'site_name' => $this->siteName,
            'meta_tags' => $this->generateMetaTags(),
            'json_ld' => $this->generateJsonLd(),
        ];
    }

    /**
     * Get formatted title
     */
    protected function getTitle(): string
    {
        $title = $this->title ?? $this->siteName;
        
        if ($this->title && $this->title !== $this->siteName) {
            $title .= ' - ' . $this->siteName;
        }
        
        return $title;
    }

    /**
     * Generate meta tags HTML
     */
    protected function generateMetaTags(): array
    {
        $tags = [];

        // Basic meta tags
        $tags[] = ['tag' => '<meta charset="utf-8">'];
        $tags[] = ['tag' => '<meta name="viewport" content="width=device-width, initial-scale=1">'];
        $tags[] = ['tag' => '<meta http-equiv="X-UA-Compatible" content="IE=edge">'];

        // Title and description
        $tags[] = ['tag' => '<title>' . $this->getTitle() . '</title>'];
        $tags[] = ['tag' => '<meta name="description" content="' . htmlspecialchars($this->description) . '">'];

        if ($this->keywords) {
            $tags[] = ['tag' => '<meta name="keywords" content="' . htmlspecialchars($this->keywords) . '">'];
        }

        if ($this->author) {
            $tags[] = ['tag' => '<meta name="author" content="' . htmlspecialchars($this->author) . '">'];
        }

        // Open Graph tags
        $tags[] = ['tag' => '<meta property="og:title" content="' . htmlspecialchars($this->getTitle()) . '">'];
        $tags[] = ['tag' => '<meta property="og:description" content="' . htmlspecialchars($this->description) . '">'];
        $tags[] = ['tag' => '<meta property="og:type" content="' . $this->type . '">'];
        $tags[] = ['tag' => '<meta property="og:url" content="' . htmlspecialchars($this->url ?? URL::current()) . '">'];
        $tags[] = ['tag' => '<meta property="og:site_name" content="' . htmlspecialchars($this->siteName) . '">'];
        $tags[] = ['tag' => '<meta property="og:locale" content="' . $this->locale . '">'];

        if ($this->image) {
            $tags[] = ['tag' => '<meta property="og:image" content="' . htmlspecialchars($this->image) . '">'];
            $tags[] = ['tag' => '<meta property="og:image:alt" content="' . htmlspecialchars($this->getTitle()) . '">'];
            $tags[] = ['tag' => '<meta name="twitter:card" content="summary_large_image">'];
            $tags[] = ['tag' => '<meta name="twitter:image" content="' . htmlspecialchars($this->image) . '">'];
        }

        // Twitter Card tags
        $tags[] = ['tag' => '<meta name="twitter:card" content="summary">'];
        $tags[] = ['tag' => '<meta name="twitter:title" content="' . htmlspecialchars($this->getTitle()) . '">'];
        $tags[] = ['tag' => '<meta name="twitter:description" content="' . htmlspecialchars($this->description) . '">'];

        if (config('app.social.twitter')) {
            $tags[] = ['tag' => '<meta name="twitter:site" content="' . config('app.social.twitter') . '">'];
        }

        // Canonical URL
        if ($this->canonicalUrl) {
            $tags[] = ['tag' => '<link rel="canonical" href="' . htmlspecialchars($this->canonicalUrl) . '">'];
        }

        // Custom meta tags
        foreach ($this->metaTags as $metaTag) {
            if ($metaTag['property'] === 'name') {
                $tags[] = ['tag' => '<meta name="' . $metaTag['name'] . '" content="' . htmlspecialchars($metaTag['content']) . '">'];
            } else {
                $tags[] = ['tag' => '<meta property="' . $metaTag['name'] . '" content="' . htmlspecialchars($metaTag['content']) . '">'];
            }
        }

        return $tags;
    }

    /**
     * Generate JSON-LD structured data
     */
    protected function generateJsonLd(): string
    {
        if (empty($this->jsonLd)) {
            return '';
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => $this->jsonLd,
        ];

        return '<script type="application/ld+json">' . json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    /**
     * Generate breadcrumb JSON-LD
     */
    public function breadcrumbs(array $breadcrumbs): self
    {
        $breadcrumbList = [];
        
        foreach ($breadcrumbs as $index => $crumb) {
            $breadcrumbList[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'] ?? URL::to($crumb['path'] ?? '/'),
            ];
        }

        $this->addJsonLd('BreadcrumbList', [
            'itemListElement' => $breadcrumbList,
        ]);

        return $this;
    }

    /**
     * Generate structured data for FAQ
     */
    public function faq(array $faqs): self
    {
        $faqList = [];
        
        foreach ($faqs as $faq) {
            $faqList[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }

        $this->addJsonLd('FAQPage', [
            'mainEntity' => $faqList,
        ]);

        return $this;
    }

    /**
     * Generate hreflang tags for multilingual support
     */
    public function hreflang(array $locales): array
    {
        $tags = [];
        $currentUrl = URL::current();
        
        foreach ($locales as $locale => $url) {
            $hreflang = $locale === 'en' ? 'x-default' : $locale;
            $tags[] = '<link rel="alternate" hreflang="' . $hreflang . '" href="' . $url . '">';
        }

        return $tags;
    }

    /**
     * Generate alternate language URLs
     */
    public function alternateLanguages(array $languages): self
    {
        foreach ($languages as $locale => $path) {
            $this->addMeta('alternate', route('localized.home', $locale), 'hreflang');
        }

        return $this;
    }
}