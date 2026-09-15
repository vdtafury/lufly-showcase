<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

$activeNav = $activeNav ?? '';
$currentLocale = $activeLocale ?? I18n::getLocale();
$alternateUrls = $alternateUrls ?? I18n::getAlternateUrls($_SERVER['REQUEST_URI'] ?? '/');
?>
<!-- Topbar -->
<div class="site-topbar">
    <div class="l-container topbar-content">
        <div class="topbar-badges">
            <span class="topbar-badge-item">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                <span><?= I18n::t('topbar_cert') ?></span>
            </span>
            <span class="topbar-badge-item">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z"/></svg>
                <span><?= I18n::t('topbar_guarantee') ?></span>
            </span>
            <span class="topbar-badge-item" style="color: var(--c-champagne);">
                <span><?= I18n::t('topbar_export') ?></span>
            </span>
        </div>
        <div class="topbar-links">
            <a href="tel:<?= App::PHONE_CLEAN ?>">
                <span>Tel: <?= App::PHONE ?></span>
            </a>
            <span style="opacity: 0.3;">|</span>
            <a href="mailto:<?= App::EMAIL ?>">
                <span><?= App::EMAIL ?></span>
            </a>
            <span style="opacity: 0.3;">|</span>
            <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode(I18n::t('whatsapp_greeting')) ?>" target="_blank" rel="noopener" style="color: #25D366; font-weight: 500;">
                <span><?= I18n::t('topbar_whatsapp') ?></span>
            </a>
            <span style="opacity: 0.3;">|</span>
            <!-- Architectural Language Switcher (TR | EN | CS) -->
            <div class="lang-switcher" aria-label="Language selection">
                <a href="<?= Security::e($alternateUrls['tr']) ?>" class="lang-btn <?= $currentLocale === 'tr' ? 'active' : '' ?>" title="Türkçe">TR</a>
                <span class="lang-sep">/</span>
                <a href="<?= Security::e($alternateUrls['en']) ?>" class="lang-btn <?= $currentLocale === 'en' ? 'active' : '' ?>" title="English">EN</a>
                <span class="lang-sep">/</span>
                <a href="<?= Security::e($alternateUrls['cs']) ?>" class="lang-btn <?= $currentLocale === 'cs' ? 'active' : '' ?>" title="Čeština">CS</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="site-header" id="site-header">
    <div class="l-container header-inner">
        <!-- Brand Mark -->
        <a href="<?= locale_url('/') ?>" class="brand-link" aria-label="Lufly Architectural Ceramics">
            <img src="/assets/images/brand/logo.png" alt="Lufly Architectural Ceramics" class="brand-logo" width="140" height="38">
            <div class="brand-text-block">
                <span class="brand-subhead"><?= I18n::t('brand_subhead') ?></span>
                <span class="brand-origin"><?= I18n::t('brand_origin') ?></span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="site-nav" aria-label="Primary Navigation">
            <ul class="nav-menu">
                <li><a href="<?= locale_url('/') ?>" class="nav-link <?= $activeNav === 'home' ? 'active' : '' ?>"><?= I18n::t('nav_home') ?></a></li>
                <li><a href="<?= locale_url('/collections') ?>" class="nav-link <?= $activeNav === 'collections' ? 'active' : '' ?>"><?= I18n::t('nav_collections') ?></a></li>
                <li><a href="<?= locale_url('/products') ?>" class="nav-link <?= $activeNav === 'products' ? 'active' : '' ?>"><?= I18n::t('nav_all_products') ?></a></li>
                <li><a href="<?= locale_url('/catalog') ?>" class="nav-link <?= $activeNav === 'catalog' ? 'active' : '' ?>"><?= I18n::t('nav_lookbook') ?></a></li>
                <li><a href="<?= locale_url('/contact') ?>" class="nav-link <?= $activeNav === 'contact' ? 'active' : '' ?>"><?= I18n::t('nav_procurement') ?></a></li>
            </ul>
        </nav>

        <!-- Actions -->
        <div class="header-actions">
            <button type="button" class="search-trigger-btn" aria-label="<?= I18n::t('search_placeholder') ?>">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span><?= I18n::t('search_trigger') ?></span>
                <span class="search-shortcut">⌘K</span>
            </button>

            <a href="<?= locale_url('/contact') ?>" class="btn btn-primary" style="padding: 0.65rem 1.25rem; font-size: 0.8125rem;">
                <span><?= I18n::t('request_b2b_quote') ?></span>
            </a>

            <!-- Mobile Toggle -->
            <button type="button" class="mobile-nav-toggle" aria-label="<?= I18n::t('open_mobile_menu') ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="mobile-drawer" style="position: fixed; inset: 0; background: rgba(11,22,18,0.7); backdrop-filter: blur(4px); z-index: 300; display: none;">
    <div style="background: var(--c-white); width: 85%; max-width: 360px; height: 100%; padding: 2rem 1.5rem; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--c-divider); padding-bottom: 1rem;">
            <img src="/assets/images/brand/logo.png" alt="Lufly" width="110" height="30">
            <button type="button" id="mobile-drawer-close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>

        <!-- Mobile Language Selector -->
        <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--c-divider); font-family: var(--font-mono); font-size: 0.875rem;">
            <a href="<?= Security::e($alternateUrls['tr']) ?>" style="padding: 0.25rem 0.65rem; border: 1px solid <?= $currentLocale === 'tr' ? 'var(--c-forest)' : 'var(--c-divider)' ?>; background: <?= $currentLocale === 'tr' ? 'var(--c-forest)' : 'transparent' ?>; color: <?= $currentLocale === 'tr' ? '#fff' : 'var(--c-slate)' ?>; text-decoration: none; border-radius: 2px;">Türkçe (TR)</a>
            <a href="<?= Security::e($alternateUrls['en']) ?>" style="padding: 0.25rem 0.65rem; border: 1px solid <?= $currentLocale === 'en' ? 'var(--c-forest)' : 'var(--c-divider)' ?>; background: <?= $currentLocale === 'en' ? 'var(--c-forest)' : 'transparent' ?>; color: <?= $currentLocale === 'en' ? '#fff' : 'var(--c-slate)' ?>; text-decoration: none; border-radius: 2px;">English (EN)</a>
            <a href="<?= Security::e($alternateUrls['cs']) ?>" style="padding: 0.25rem 0.65rem; border: 1px solid <?= $currentLocale === 'cs' ? 'var(--c-forest)' : 'var(--c-divider)' ?>; background: <?= $currentLocale === 'cs' ? 'var(--c-forest)' : 'transparent' ?>; color: <?= $currentLocale === 'cs' ? '#fff' : 'var(--c-slate)' ?>; text-decoration: none; border-radius: 2px;">Čeština (CS)</a>
        </div>

        <nav style="display: flex; flex-direction: column; gap: 1.25rem; font-size: 1.125rem; font-weight: 600;">
            <a href="<?= locale_url('/') ?>" style="color: var(--c-forest);"><?= I18n::t('nav_home') ?></a>
            <a href="<?= locale_url('/collections') ?>"><?= I18n::t('nav_collections') ?></a>
            <a href="<?= locale_url('/products') ?>"><?= I18n::t('nav_all_products') ?></a>
            <a href="<?= locale_url('/catalog') ?>"><?= I18n::t('nav_lookbook') ?></a>
            <a href="<?= locale_url('/contact') ?>"><?= I18n::t('nav_procurement') ?></a>
            <a href="<?= locale_url('/search') ?>"><?= I18n::t('search_trigger') ?></a>
        </nav>
        <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--c-divider); font-size: 0.8125rem; color: var(--c-muted);">
            <div>Factory: +90 850 3040 817</div>
            <div>Email: info@lufly.tr</div>
        </div>
    </div>
</div>

<style>
.lang-switcher {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-family: var(--font-mono, monospace);
    font-size: 0.6875rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.lang-btn {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    padding: 0.15rem 0.35rem;
    border-radius: 2px;
    transition: all 0.2s ease;
}
.lang-btn:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
}
.lang-btn.active {
    color: var(--c-champagne, #BFA16F);
    font-weight: 700;
    border-bottom: 2px solid var(--c-champagne, #BFA16F);
}
.lang-sep {
    opacity: 0.35;
    font-size: 0.625rem;
}
#mobile-drawer.open { display: block !important; }
</style>
