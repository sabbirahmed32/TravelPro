<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Security Headers
        $securityHeaders = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => $this->getCSPHeader(),
            'Strict-Transport-Security' => $this->getHSTSHeader($request),
            'Permissions-Policy' => $this->getPermissionsPolicy(),
        ];

        foreach ($securityHeaders as $key => $value) {
            $response->headers->set($key, $value);
        }

        // Remove server signature
        $response->headers->remove('Server');
        
        // Log security events
        $this->logSecurityEvents($request);

        return $response;
    }

    /**
     * Generate Content Security Policy header
     */
    protected function getCSPHeader(): string
    {
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://js.stripe.com https://checkout.paypal.com https://www.paypal.com https://www.google.com https://www.gstatic.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "img-src 'self' data: https: blob:",
            "font-src 'self' https://fonts.gstatic.com",
            "connect-src 'self' https://api.stripe.com https://api.paypal.com https://www.sandbox.paypal.com https://securepay.sslcommerz.com",
            "frame-src 'self' https://js.stripe.com https://checkout.paypal.com https://www.paypal.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "upgrade-insecure-requests",
        ];

        return implode('; ', $csp);
    }

    /**
     * Generate HSTS header
     */
    protected function getHSTSHeader(Request $request): ?string
    {
        if (!$request->secure() && !app()->environment('production')) {
            return null;
        }

        $maxAge = config('security.hsts.max_age', 31536000); // 1 year
        $includeSubdomains = config('security.hsts.include_subdomains', false);
        $preload = config('security.hsts.preload', false);

        $hsts = "max-age={$maxAge}";
        
        if ($includeSubdomains) {
            $hsts .= '; includeSubDomains';
        }
        
        if ($preload) {
            $hsts .= '; preload';
        }

        return $hsts;
    }

    /**
     * Generate Permissions Policy header
     */
    protected function getPermissionsPolicy(): string
    {
        $policies = [
            'camera=()',
            'microphone=()',
            'geolocation=(self)',
            'payment=(self)',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            'ambient-light-sensor=()',
        ];
        
        return implode(', ', $policies);
    }

    /**
     * Log security events
     */
    protected function logSecurityEvents(Request $request): void
    {
        // Log suspicious requests
        if ($this->isSuspiciousRequest($request)) {
            Log::warning('Suspicious request detected', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'headers' => $request->headers->all(),
            ]);
        }

        // Log XSS attempts
        if ($this->containsXSS($request)) {
            Log::alert('XSS attempt detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'input' => $request->all(),
            ]);
        }

        // Log SQL injection attempts
        if ($this->containsSQLInjection($request)) {
            Log::alert('SQL injection attempt detected', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'input' => $request->all(),
            ]);
        }
    }

    /**
     * Check if request is suspicious
     */
    protected function isSuspiciousRequest(Request $request): bool
    {
        $suspiciousPatterns = [
            '/admin/i',
            '/wp-admin/i',
            '/wp-login/i',
            '/phpmyadmin/i',
            '/test/i',
            '/debug/i',
            '/\.env/i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $request->fullUrl())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for XSS patterns
     */
    protected function containsXSS(Request $request): bool
    {
        $xssPatterns = [
            '/<script[^>]*>.*?<\/script>/im',
            '/<iframe[^>]*>.*?<\/iframe>/im',
            '/javascript:/im',
            '/on\w+\s*=/im',
            '/<img[^>]*src[^>]*javascript:/im',
            '/<object[^>]*>.*?<\/object>/im',
            '/<embed[^>]*>.*?<\/embed>/im',
        ];

        $inputData = json_encode($request->all());

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $inputData)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check for SQL injection patterns
     */
    protected function containsSQLInjection(Request $request): bool
    {
        $sqlPatterns = [
            '/(\s|^)(or|and)\s+[\w\d\s\'"]+=/im',
            '/union\s+select/im',
            '/select\s+.*\s+from/im',
            '/insert\s+into/im',
            '/update\s+.*\s+set/im',
            '/delete\s+from/im',
            '/drop\s+(table|database)/im',
            '/create\s+(table|database)/im',
            '/alter\s+table/im',
            '/exec\s*\(/im',
            '/execute\s*\(/im',
            '/sp_executesql/im',
            '/xp_cmdshell/im',
            '/--/im',
            '/\/\*/im',
            '/\*\/im',
            '/;/im',
        ];

        $inputData = json_encode($request->all());

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $inputData)) {
                return true;
            }
        }

        return false;
    }
}