<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

$title = $pageTitle ?? (App::NAME . ' | ' . I18n::t('hero_title'));
$description = $metaDescription ?? I18n::t('hero_description');
$canonical = $canonicalUrl ?? App::url('/');
$ogImage = $metaImage ?? (App::baseUrl() . '/assets/images/brand/logo.png');
$currentLocale = $activeLocale ?? I18n::getLocale();
$alternateUrls = $alternateUrls ?? I18n::getAlternateUrls($_SERVER['REQUEST_URI'] ?? '/');
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= Security::e($title) ?></title>
<meta name="description" content="<?= Security::e($description) ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="<?= Security::e($canonical) ?>">

<!-- Multilingual Hreflang Alternates (TR default, EN, CS) -->
<?php if (!empty($alternateUrls)): ?>
<link rel="alternate" hreflang="tr" href="<?= Security::e(App::baseUrl() . ($alternateUrls['tr'] === '/' ? '' : $alternateUrls['tr'])) ?>">
<link rel="alternate" hreflang="en" href="<?= Security::e(App::baseUrl() . $alternateUrls['en']) ?>">
<link rel="alternate" hreflang="cs" href="<?= Security::e(App::baseUrl() . $alternateUrls['cs']) ?>">
<link rel="alternate" hreflang="x-default" href="<?= Security::e(App::baseUrl() . ($alternateUrls['tr'] === '/' ? '' : $alternateUrls['tr'])) ?>">
<?php endif; ?>

<!-- Open Graph / Social -->
<meta property="og:site_name" content="<?= Security::e(App::NAME) ?> Architectural Sanitary Ceramics">
<meta property="og:type" content="<?= Security::e($ogType ?? 'website') ?>">
<meta property="og:url" content="<?= Security::e($canonical) ?>">
<meta property="og:title" content="<?= Security::e($title) ?>">
<meta property="og:description" content="<?= Security::e($description) ?>">
<meta property="og:image" content="<?= Security::e($ogImage) ?>">
<meta property="og:locale" content="<?= Security::e($ogLocale ?? 'tr_TR') ?>">
<?php foreach (['tr' => 'tr_TR', 'en' => 'en_GB', 'cs' => 'cs_CZ'] as $lCode => $lOg): ?>
    <?php if ($lCode !== $currentLocale): ?>
<meta property="og:locale:alternate" content="<?= $lOg ?>">
    <?php endif; ?>
<?php endforeach; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= Security::e($title) ?>">
<meta name="twitter:description" content="<?= Security::e($description) ?>">
<meta name="twitter:image" content="<?= Security::e($ogImage) ?>">

<!-- Geo & Technical Metadata -->
<meta name="geo.region" content="TR-27">
<meta name="geo.placename" content="Gaziantep">
<meta name="geo.position" content="37.0662;37.3833">
<meta name="ICBM" content="37.0662, 37.3833">

<!-- Favicon -->
<link rel="icon" type="image/png" href="/assets/images/brand/favicon.png">

<!-- Fonts & Stylesheet -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="/assets/css/lufly-luxury.css">

<!-- Structured Data (JSON-LD) -->
<?php if (!empty($jsonLd)): ?>
    <?php foreach ((array)$jsonLd as $schema): ?>
        <script type="application/ld+json">
            <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
        </script>
    <?php endforeach; ?>
<?php endif; ?>
