<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

$activeNav = $activeNav ?? '';
$currentLocale = $activeLocale ?? I18n::getLocale();
$alternateUrls = $alternateUrls ?? I18n::getAlternateUrls($_SERVER['REQUEST_URI'] ?? '/');
?>
<!-- Main Header (Single Architectural Navigation Bar) -->
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

            <!-- Minimalist Language Switcher (TR | EN | CS) -->
            <div class="header-lang-switcher" aria-label="Language selection">
                <a href="<?= Security::e($alternateUrls['tr']) ?>" class="header-lang-btn <?= $currentLocale === 'tr' ? 'active' : '' ?>" title="Türkçe">TR</a>
                <a href="<?= Security::e($alternateUrls['en']) ?>" class="header-lang-btn <?= $currentLocale === 'en' ? 'active' : '' ?>" title="English">EN</a>
                <a href="<?= Security::e($alternateUrls['cs']) ?>" class="header-lang-btn <?= $currentLocale === 'cs' ? 'active' : '' ?>" title="Čeština">CS</a>
            </div>

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
.header-lang-switcher {
    display: inline-flex;
    align-items: center;
    background-color: var(--c-dolomite, #F9FAF7);
    border: 1px solid var(--c-divider, #E5ECE8);
    border-radius: var(--radius-sm, 4px);
    padding: 2px;
    font-family: var(--font-mono, monospace);
    font-size: 0.6875rem;
    letter-spacing: 0.05em;
}
.header-lang-btn {
    color: var(--c-muted, #5A6D63);
    text-decoration: none;
    padding: 0.35rem 0.6rem;
    border-radius: 2px;
    transition: all 0.2s ease;
    font-weight: 500;
}
.header-lang-btn:hover {
    color: var(--c-forest, #122920);
}
.header-lang-btn.active {
    color: var(--c-forest, #122920);
    background-color: var(--c-white, #FFFFFF);
    font-weight: 700;
    box-shadow: 0 1px 3px rgba(11, 22, 18, 0.08);
}
#mobile-drawer.open { display: block !important; }
@media (max-width: 768px) {
    .header-lang-switcher {
        display: none;
    }
}
</style>
