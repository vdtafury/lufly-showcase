<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\Security;

$activeNav = $activeNav ?? '';
?>
<!-- Topbar -->
<div class="site-topbar">
    <div class="l-container topbar-content">
        <div class="topbar-badges">
            <span class="topbar-badge-item">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                <span>EN 997 &amp; CE Certified Vitreous China</span>
            </span>
            <span class="topbar-badge-item">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z"/></svg>
                <span>10-Year Factory Guarantee</span>
            </span>
            <span class="topbar-badge-item" style="color: var(--c-champagne);">
                <span>Exporting to 34+ Countries</span>
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
            <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode('Hello Lufly Export Department, I am inquiring regarding factory container procurement.') ?>" target="_blank" rel="noopener" style="color: #25D366; font-weight: 500;">
                <span>WhatsApp B2B Desk</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="site-header" id="site-header">
    <div class="l-container header-inner">
        <!-- Brand Mark -->
        <a href="/" class="brand-link" aria-label="Lufly Architectural Ceramics Homepage">
            <img src="/assets/images/brand/logo.png" alt="Lufly Architectural Ceramics" class="brand-logo" width="140" height="38">
            <div class="brand-text-block">
                <span class="brand-subhead">Architectural Ceramics</span>
                <span class="brand-origin">Gaziantep Factory &bull; EN 997</span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="site-nav" aria-label="Primary Navigation">
            <ul class="nav-menu">
                <li><a href="/" class="nav-link <?= $activeNav === 'home' ? 'active' : '' ?>">Home</a></li>
                <li><a href="/collections" class="nav-link <?= $activeNav === 'collections' ? 'active' : '' ?>">Collections</a></li>
                <li><a href="/products" class="nav-link <?= $activeNav === 'products' ? 'active' : '' ?>">All Products (282)</a></li>
                <li><a href="/catalog" class="nav-link <?= $activeNav === 'catalog' ? 'active' : '' ?>">Digital Lookbook</a></li>
                <li><a href="/contact" class="nav-link <?= $activeNav === 'contact' ? 'active' : '' ?>">Factory Procurement</a></li>
            </ul>
        </nav>

        <!-- Actions -->
        <div class="header-actions">
            <button type="button" class="search-trigger-btn" aria-label="Search catalog by SKU or title">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Search catalog...</span>
                <span class="search-shortcut">⌘K</span>
            </button>

            <a href="/contact" class="btn btn-primary" style="padding: 0.65rem 1.25rem; font-size: 0.8125rem;">
                <span>Request B2B Quote</span>
            </a>

            <!-- Mobile Toggle -->
            <button type="button" class="mobile-nav-toggle" aria-label="Open Mobile Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div id="mobile-drawer" style="position: fixed; inset: 0; background: rgba(11,22,18,0.7); backdrop-filter: blur(4px); z-index: 300; display: none;">
    <div style="background: var(--c-white); width: 85%; max-width: 360px; height: 100%; padding: 2rem 1.5rem; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--c-divider); padding-bottom: 1rem;">
            <img src="/assets/images/brand/logo.png" alt="Lufly" width="110" height="30">
            <button type="button" id="mobile-drawer-close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <nav style="display: flex; flex-direction: column; gap: 1.25rem; font-size: 1.125rem; font-weight: 600;">
            <a href="/" style="color: var(--c-forest);">Home</a>
            <a href="/collections">Collections</a>
            <a href="/products">All Products (282)</a>
            <a href="/catalog">Digital Lookbook</a>
            <a href="/contact">Factory Procurement</a>
            <a href="/search">Search Products</a>
        </nav>
        <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--c-divider); font-size: 0.8125rem; color: var(--c-muted);">
            <div>Factory: +90 850 3040 817</div>
            <div>Email: info@lufly.tr</div>
        </div>
    </div>
</div>

<style>
#mobile-drawer.open { display: block !important; }
</style>
