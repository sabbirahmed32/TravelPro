<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Translation\Translator;

class LocalizationService
{
    protected $supportedLocales;
    protected $defaultLocale;
    protected $currencyRates = [];

    public function __construct()
    {
        $this->supportedLocales = config('localization.supported_locales', [
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ar' => 'العربية',
            'zh' => '中文',
            'ja' => '日本語',
            'ko' => '한국어',
            'hi' => 'हिन्दी',
            'bn' => 'বাংলা',
        ]);

        $this->defaultLocale = config('app.locale', 'en');
        $this->loadCurrencyRates();
    }

    /**
     * Get supported locales
     */
    public function getSupportedLocales(): array
    {
        return $this->supportedLocales;
    }

    /**
     * Get current locale
     */
    public function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Set locale
     */
    public function setLocale(string $locale): bool
    {
        if (!array_key_exists($locale, $this->supportedLocales)) {
            return false;
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return true;
    }

    /**
     * Get locale name
     */
    public function getLocaleName(string $locale): ?string
    {
        return $this->supportedLocales[$locale] ?? null;
    }

    /**
     * Check if RTL language
     */
    public function isRTL(string $locale = null): bool
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        $rtlLocales = ['ar', 'he', 'fa', 'ur'];
        
        return in_array($locale, $rtlLocales);
    }

    /**
     * Get text direction
     */
    public function getTextDirection(string $locale = null): string
    {
        return $this->isRTL($locale) ? 'rtl' : 'ltr';
    }

    /**
     * Get localized URL
     */
    public function getLocalizedUrl(string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        if ($locale === $this->defaultLocale) {
            return url('/');
        }

        return url("/{$locale}");
    }

    /**
     * Get localized route
     */
    public function getLocalizedRoute(string $routeName, array $parameters = [], string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        if ($locale === $this->defaultLocale) {
            return route($routeName, $parameters);
        }

        return route("{$locale}.{$routeName}", $parameters);
    }

    /**
     * Translate with fallback
     */
    public function translate(string $key, array $parameters = [], string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        $translation = trans($key, $parameters, $locale);
        
        // Fallback to default locale if translation is missing
        if ($translation === $key && $locale !== $this->defaultLocale) {
            $translation = trans($key, $parameters, $this->defaultLocale);
        }
        
        return $translation;
    }

    /**
     * Get date format for locale
     */
    public function getDateFormat(string $format = 'default'): string
    {
        $locale = $this->getCurrentLocale();
        
        $formats = [
            'en' => ['default' => 'M d, Y', 'short' => 'M d', 'long' => 'F d, Y'],
            'es' => ['default' => 'd M, Y', 'short' => 'd M', 'long' => 'd \d\e F \d\e Y'],
            'fr' => ['default' => 'd M Y', 'short' => 'd M', 'long' => 'd F Y'],
            'de' => ['default' => 'd. M Y', 'short' => 'd. M', 'long' => 'd. F Y'],
            'it' => ['default' => 'd M Y', 'short' => 'd M', 'long' => 'd F Y'],
            'pt' => ['default' => 'd M, Y', 'short' => 'd M', 'long' => 'd \d\e F \d\e Y'],
            'ar' => ['default' => 'Y/M/d', 'short' => 'M/d', 'long' => 'Y/M/d'],
            'zh' => ['default' => 'Y年M月d日', 'short' => 'M月d日', 'long' => 'Y年M月d日'],
            'ja' => ['default' => 'Y年M月d日', 'short' => 'M月d日', 'long' => 'Y年M月d日'],
            'ko' => ['default' => 'Y. M. d.', 'short' => 'M. d.', 'long' => 'Y. M. d.'],
            'hi' => ['default' => 'd M, Y', 'short' => 'd M', 'long' => 'd F Y'],
            'bn' => ['default' => 'd F, Y', 'short' => 'd M', 'long' => 'd F, Y'],
        ];

        return $formats[$locale][$format] ?? $formats['en'][$format];
    }

    /**
     * Get currency symbol
     */
    public function getCurrencySymbol(string $currency): string
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'CNY' => '¥',
            'KRW' => '₩',
            'INR' => '₹',
            'BDT' => '৳',
            'CAD' => 'C$',
            'AUD' => 'A$',
        ];

        return $symbols[$currency] ?? $currency;
    }

    /**
     * Format currency
     */
    public function formatCurrency(float $amount, string $currency = 'USD', string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        $symbol = $this->getCurrencySymbol($currency);
        
        // Format based on locale conventions
        switch ($locale) {
            case 'en':
                return $symbol . number_format($amount, 2);
            case 'es':
            case 'fr':
            case 'de':
            case 'it':
            case 'pt':
                return number_format($amount, 2, ',', '.') . ' ' . $symbol;
            case 'ar':
            case 'hi':
            case 'bn':
                return number_format($amount, 2) . ' ' . $symbol;
            case 'ja':
            case 'ko':
            case 'zh':
                return $symbol . number_format($amount, 2);
            default:
                return $symbol . number_format($amount, 2);
        }
    }

    /**
     * Convert currency
     */
    public function convertCurrency(float $amount, string $from, string $to): float
    {
        if ($from === $to) {
            return $amount;
        }

        $rate = $this->getExchangeRate($from, $to);
        
        return $amount * $rate;
    }

    /**
     * Get exchange rate
     */
    public function getExchangeRate(string $from, string $to): float
    {
        if ($from === $to) {
            return 1.0;
        }

        $cacheKey = "exchange_rate_{$from}_{$to}";
        
        return Cache::remember($cacheKey, 3600, function () use ($from, $to) {
            // In production, this would call a real currency API
            // For now, return static rates
            $staticRates = [
                'USD_EUR' => 0.85,
                'USD_GBP' => 0.73,
                'USD_JPY' => 110.0,
                'USD_BDT' => 84.5,
                'EUR_USD' => 1.18,
                'GBP_USD' => 1.37,
                'JPY_USD' => 0.0091,
                'BDT_USD' => 0.0118,
            ];

            $rateKey = "{$from}_{$to}";
            
            return $staticRates[$rateKey] ?? 1.0;
        });
    }

    /**
     * Get supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        return [
            'USD' => [
                'name' => 'US Dollar',
                'symbol' => '$',
                'code' => 'USD',
                'rate' => 1.0,
                'locale' => 'en_US',
            ],
            'EUR' => [
                'name' => 'Euro',
                'symbol' => '€',
                'code' => 'EUR',
                'rate' => $this->getExchangeRate('USD', 'EUR'),
                'locale' => 'de_DE',
            ],
            'GBP' => [
                'name' => 'British Pound',
                'symbol' => '£',
                'code' => 'GBP',
                'rate' => $this->getExchangeRate('USD', 'GBP'),
                'locale' => 'en_GB',
            ],
            'BDT' => [
                'name' => 'Bangladeshi Taka',
                'symbol' => '৳',
                'code' => 'BDT',
                'rate' => $this->getExchangeRate('USD', 'BDT'),
                'locale' => 'bn_BD',
            ],
        ];
    }

    /**
     * Get locale-specific settings
     */
    public function getLocaleSettings(string $locale = null): array
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        return [
            'direction' => $this->getTextDirection($locale),
            'date_format' => $this->getDateFormat('default'),
            'currency' => $this->getPreferredCurrency($locale),
            'number_format' => $this->getNumberFormat($locale),
            'time_format' => $this->getTimeFormat($locale),
        ];
    }

    /**
     * Get preferred currency for locale
     */
    protected function getPreferredCurrency(string $locale): string
    {
        $localeCurrencyMap = [
            'en' => 'USD',
            'es' => 'EUR',
            'fr' => 'EUR',
            'de' => 'EUR',
            'it' => 'EUR',
            'pt' => 'EUR',
            'bn' => 'BDT',
            'hi' => 'INR',
            'ja' => 'JPY',
            'ko' => 'KRW',
            'zh' => 'CNY',
        ];

        return $localeCurrencyMap[$locale] ?? 'USD';
    }

    /**
     * Get number format for locale
     */
    protected function getNumberFormat(string $locale): array
    {
        $formats = [
            'en' => ['thousands_separator' => ',', 'decimal_separator' => '.'],
            'es' => ['thousands_separator' => '.', 'decimal_separator' => ','],
            'fr' => ['thousands_separator' => ' ', 'decimal_separator' => ','],
            'de' => ['thousands_separator' => '.', 'decimal_separator' => ','],
            'ar' => ['thousands_separator' => ',', 'decimal_separator' => '.'],
            'bn' => ['thousands_separator' => ',', 'decimal_separator' => '.'],
        ];

        return $formats[$locale] ?? $formats['en'];
    }

    /**
     * Get time format for locale
     */
    protected function getTimeFormat(string $locale): string
    {
        $formats = [
            'en' => 'g:i A',
            'es' => 'H:i',
            'fr' => 'H:i',
            'de' => 'H:i',
            'ar' => 'H:i',
            'bn' => 'g:i A',
            'ja' => 'H:i',
            'ko' => 'A h:i',
            'zh' => 'A h:i',
        ];

        return $formats[$locale] ?? 'g:i A';
    }

    /**
     * Load currency rates
     */
    protected function loadCurrencyRates(): void
    {
        $this->currencyRates = Cache::remember('currency_rates', 3600, function () {
            // In production, fetch from external API
            return [
                'USD_EUR' => 0.85,
                'USD_GBP' => 0.73,
                'USD_BDT' => 84.5,
                'EUR_USD' => 1.18,
                'GBP_USD' => 1.37,
                'BDT_USD' => 0.0118,
            ];
        });
    }

    /**
     * Update currency rates
     */
    public function updateCurrencyRates(): bool
    {
        try {
            // Fetch from external API (example with ExchangeRate-API)
            $response = file_get_contents('https://v6.exchangerate-api.com/v6/latest/USD');
            $data = json_decode($response, true);
            
            if ($data && isset($data['conversion_rates'])) {
                $rates = $data['conversion_rates'];
                
                $newRates = [
                    'USD_EUR' => $rates['EUR'],
                    'USD_GBP' => $rates['GBP'],
                    'USD_BDT' => $rates['BDT'],
                    'EUR_USD' => 1 / $rates['EUR'],
                    'GBP_USD' => 1 / $rates['GBP'],
                    'BDT_USD' => 1 / $rates['BDT'],
                ];
                
                Cache::put('currency_rates', $newRates, 3600);
                $this->currencyRates = $newRates;
                
                return true;
            }
        } catch (\Exception $e) {
            // Log error but don't fail
        }
        
        return false;
    }

    /**
     * Get localized validation messages
     */
    public function getValidationMessages(string $locale = null): array
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        return [
            'required' => $this->translate('validation.required', [], $locale),
            'email' => $this->translate('validation.email', [], $locale),
            'unique' => $this->translate('validation.unique', [], $locale),
            'min' => $this->translate('validation.min.string', [], $locale),
            'max' => $this->translate('validation.max.string', [], $locale),
            'mimes' => $this->translate('validation.mimes', [], $locale),
            'between' => $this->translate('validation.between.string', [], $locale),
            'after' => $this->translate('validation.after', [], $locale),
            'before' => $this->translate('validation.before', [], $locale),
        ];
    }

    /**
     * Generate localized URL slug
     */
    public function generateSlug(string $text, string $locale = null): string
    {
        $locale = $locale ?? $this->getCurrentLocale();
        
        // Handle locale-specific slug generation
        switch ($locale) {
            case 'ar':
                return $this->generateArabicSlug($text);
            case 'zh':
            case 'ja':
            case 'ko':
                return $this->generateAsianSlug($text);
            default:
                return $this->generateLatinSlug($text);
        }
    }

    /**
     * Generate Arabic slug
     */
    protected function generateArabicSlug(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/[\p{P}\p{Z}]/u', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        
        return strtolower($text);
    }

    /**
     * Generate Asian language slug
     */
    protected function generateAsianSlug(string $text): string
    {
        // For CJK languages, use transliteration or simple replacement
        $text = trim($text);
        $text = preg_replace('/[^a-zA-Z0-9\u4e00-\u9fff\u3040-\u309f\u30a0-\u30ff]/u', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        
        return strtolower($text);
    }

    /**
     * Generate Latin slug
     */
    protected function generateLatinSlug(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }
}