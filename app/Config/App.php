<?php
declare(strict_types=1);

namespace App\Config;

use App\Helpers\I18n;

class App
{
    public const NAME = 'Lufly';
    public const FULL_LEGAL_NAME = 'LUFLY İNŞAAT SANAYİ VE TİCARET LİMİTED ŞİRKETİ';
    public const TAGLINE = 'Architectural Sanitary Ceramics Engineered for European Living';
    public const DESCRIPTION = 'European manufacturer of luxury vitreous china sanitary ceramics, rimless wall-hung toilets, designer countertop washbasins, and architectural tapware. Certified to EN 997 and CE standards.';
    public const FOUNDED_YEAR = 2012;
    
    // Official Corporate Contact Details
    public const PHONE = '+90 850 3040 817';
    public const PHONE_CLEAN = '+908503040817';
    public const WHATSAPP = '+908503040817';
    public const EMAIL = 'info@lufly.tr';
    public const SALES_EMAIL = 'export@lufly.tr';
    public const ADDRESS = 'Sanayi Mah. 60001 Nolu Cad. No: 28/A, Şehitkamil, 27110 Gaziantep, Turkey';
    public const FACTORY_LOCATION = 'Gaziantep Industrial Ceramic Export Zone, Turkey';
    
    // International Standards
    public const STANDARDS = ['EN 997:2018 (Class 1 Rimless)', 'EN 14688:2015', 'CE 14528', 'ISO 9001:2015 Quality Management', 'ISO 14001:2015 Environmental'];
    public const WARRANTY_YEARS = 10;
    
    public static function baseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'lufly-showcase.vercel.app';
        return rtrim($protocol . $host, '/');
    }

    public static function url(string $path = '', ?string $locale = null): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        $base = self::baseUrl();
        $locPath = I18n::url($path, $locale);
        $cleanPath = '/' . ltrim($locPath, '/');
        return $cleanPath === '/' ? $base : $base . $cleanPath;
    }
}
