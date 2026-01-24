<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your payment gateway settings here. Each gateway can be
    | enabled or disabled individually.
    |
    */

    'stripe' => [
        'enabled' => env('STRIPE_ENABLED', false),
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'fee_percent' => env('STRIPE_FEE_PERCENT', 2.9),
        'fee_fixed' => env('STRIPE_FEE_FIXED', 0.30),
    ],

    'paypal' => [
        'enabled' => env('PAYPAL_ENABLED', false),
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'sandbox' => env('PAYPAL_SANDBOX', true),
        'fee_percent' => env('PAYPAL_FEE_PERCENT', 3.4),
        'fee_fixed' => env('PAYPAL_FEE_FIXED', 0.30),
    ],

    'sslcommerz' => [
        'enabled' => env('SSLCOMMERZ_ENABLED', false),
        'store_id' => env('SSLCOMMERZ_STORE_ID'),
        'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
        'test_mode' => env('SSLCOMMERZ_TEST_MODE', true),
        'fee_percent' => env('SSLCOMMERZ_FEE_PERCENT', 3.0),
        'fee_fixed' => env('SSLCOMMERZ_FEE_FIXED', 0.0),
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    |
    | Configure WhatsApp notification settings. Supports multiple providers.
    |
    */

    'whatsapp' => [
        'enabled' => env('WHATSAPP_ENABLED', false),
        'provider' => env('WHATSAPP_PROVIDER', 'twilio'), // twilio, whatsapp_api, messagebird
        
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from_number' => env('TWILIO_WHATSAPP_FROM'),
        ],
        
        'whatsapp_api' => [
            'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
            'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
            'api_version' => env('WHATSAPP_API_VERSION', 'v16.0'),
        ],
        
        'messagebird' => [
            'access_key' => env('MESSAGEBIRD_ACCESS_KEY'),
            'channel_id' => env('MESSAGEBIRD_CHANNEL_ID'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Security settings for the application.
    |
    */

    'security' => [
        'hsts' => [
            'max_age' => env('HSTS_MAX_AGE', 31536000), // 1 year
            'include_subdomains' => env('HSTS_INCLUDE_SUBDOMAINS', false),
            'preload' => env('HSTS_PRELOAD', false),
        ],
        
        'documents' => [
            'backup_enabled' => env('DOCUMENTS_BACKUP_ENABLED', true),
            'backup_retention_days' => env('DOCUMENTS_BACKUP_RETENTION_DAYS', 30),
            'max_file_size' => env('DOCUMENTS_MAX_FILE_SIZE', 10240), // 10MB in KB
        ],
        
        'rate_limiting' => [
            'enabled' => env('RATE_LIMITING_ENABLED', true),
            'attempts' => env('RATE_LIMIT_ATTEMPTS', 5),
            'decay_minutes' => env('RATE_LIMIT_DECAY_MINUTES', 15),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for performance optimization.
    |
    */

    'cache' => [
        'default_ttl' => env('CACHE_DEFAULT_TTL', 3600), // 1 hour
        'stats_ttl' => env('CACHE_STATS_TTL', 300), // 5 minutes
        'currency_rates_ttl' => env('CACHE_CURRENCY_RATES_TTL', 3600), // 1 hour
        'sitemap_ttl' => env('CACHE_SITEMAP_TTL', 86400), // 24 hours
        'cleanup_enabled' => env('CACHE_CLEANUP_ENABLED', true),
        'cleanup_frequency_hours' => env('CACHE_CLEANUP_FREQUENCY_HOURS', 24),
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization Configuration
    |--------------------------------------------------------------------------
    |
    | Multi-language and internationalization settings.
    |
    */

    'localization' => [
        'supported_locales' => explode(',', env('SUPPORTED_LOCALES', 'en,es,fr,de,it,pt,ar,zh,ja,ko,hi,bn')),
        'default_locale' => env('APP_LOCALE', 'en'),
        'currency_conversion_api' => env('CURRENCY_CONVERSION_API', 'https://v6.exchangerate-api.com/v6/latest/USD'),
        'currency_api_key' => env('CURRENCY_API_KEY'),
        'auto_translate' => env('AUTO_TRANSLATE_ENABLED', false),
        'fallback_locale' => 'en',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Configuration
    |--------------------------------------------------------------------------
    |
    | Search engine optimization settings.
    |
    */

    'seo' => [
        'default_title_suffix' => env('SEO_TITLE_SUFFIX', ' - Travel Business'),
        'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'Complete travel solutions including visa services, student admissions, tour packages, and consultations.'),
        'default_keywords' => env('SEO_DEFAULT_KEYWORDS', 'travel business,visa services,student admission,tour packages'),
        'meta_robots' => env('SEO_META_ROBOTS', 'index,follow'),
        'canonical_url' => env('APP_URL'),
        'og_image' => env('SEO_OG_IMAGE', '/images/og-default.jpg'),
        'twitter_site' => env('SEO_TWITTER_SITE', '@travelbusiness'),
        'sitemap_enabled' => env('SITEMAP_ENABLED', true),
        'sitemap_index_enabled' => env('SITEMAP_INDEX_ENABLED', true),
        'json_ld_enabled' => env('JSON_LD_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Secure file storage settings.
    |
    */

    'storage' => [
        'secure_documents_disk' => env('SECURE_DOCUMENTS_DISK', 'local'),
        'public_documents_disk' => env('PUBLIC_DOCUMENTS_DISK', 'public'),
        'encryption_enabled' => env('FILE_ENCRYPTION_ENABLED', true),
        'disk_quota_gb' => env('DISK_QUOTA_GB', 100),
        'allowed_extensions' => explode(',', env('ALLOWED_FILE_EXTENSIONS', 'pdf,jpg,jpeg,png')),
        'max_file_size_mb' => env('MAX_FILE_SIZE_MB', 10),
        'virus_scanning_enabled' => env('VIRUS_SCANNING_ENABLED', false),
        'virus_scanner_path' => env('VIRUS_SCANNER_PATH', '/usr/bin/clamdscan'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    |
    | Email and notification settings.
    |
    */

    'notifications' => [
        'email' => [
            'enabled' => env('EMAIL_NOTIFICATIONS_ENABLED', true),
            'queue_name' => env('EMAIL_QUEUE_NAME', 'emails'),
            'rate_limit' => env('EMAIL_RATE_LIMIT', 60), // per minute
        ],
        
        'sms' => [
            'enabled' => env('SMS_NOTIFICATIONS_ENABLED', false),
            'provider' => env('SMS_PROVIDER', 'twilio'),
            'from_number' => env('SMS_FROM_NUMBER'),
        ],
        
        'push' => [
            'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', false),
            'vapid_public_key' => env('VAPID_PUBLIC_KEY'),
            'vapid_private_key' => env('VAPID_PRIVATE_KEY'),
            'vapid_subject' => env('VAPID_SUBJECT'),
        ],
    ],
];