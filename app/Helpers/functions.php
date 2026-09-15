<?php
declare(strict_types=1);

use App\Helpers\I18n;

if (!function_exists('__')) {
    function __(string $key, array $replace = []): string
    {
        return I18n::t($key, $replace);
    }
}

if (!function_exists('locale_url')) {
    function locale_url(string $path = '', ?string $locale = null): string
    {
        return I18n::url($path, $locale);
    }
}
