<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\Security;
?>
<!-- Footer -->
<footer class="site-footer">
    <div class="l-container">
        <div class="footer-top-grid">
            <!-- Col 1: Brand & Factory Heritage -->
            <div class="footer-brand-pane">
                <img src="/assets/images/brand/logo.png" alt="Lufly" width="130" height="35" style="filter: brightness(0) invert(1); opacity: 0.95;">
                <p>
                    Precision architectural sanitary ceramics engineered in Gaziantep, Turkey for luxury residential developments, commercial hospitality, and European export distribution.
                </p>
                <div style="margin-top: 1.5rem; font-size: 0.8125rem; font-family: var(--font-mono); color: #8fa79c;">
                    <strong><?= App::FULL_LEGAL_NAME ?></strong><br>
                    <?= App::ADDRESS ?>
                </div>
            </div>

            <!-- Col 2: Architectural Collections -->
            <div>
                <h4 class="footer-col-title">Collections</h4>
                <ul class="footer-nav-list">
                    <li><a href="/collections/rimless-wall-hung-toilets">Rimless Wall-Hung WCs</a></li>
                    <li><a href="/collections/designer-washbasins">Designer Washbasins</a></li>
                    <li><a href="/collections/luxury-ceramic-bidets">Luxury Ceramic Bidets</a></li>
                    <li><a href="/collections/vanity-cabinet-systems">Vanity &amp; Cabinet Systems</a></li>
                    <li><a href="/collections/architectural-washbasin-mixers">Architectural Tapware</a></li>
                    <li><a href="/collections/touchless-sensor-systems">Touchless Sensor Systems</a></li>
                    <li><a href="/collections">View All Collections &rarr;</a></li>
                </ul>
            </div>

            <!-- Col 3: Technical & B2B -->
            <div>
                <h4 class="footer-col-title">Documentation</h4>
                <ul class="footer-nav-list">
                    <li><a href="/catalog">2025 Master Lookbook</a></li>
                    <li><a href="/catalog/export-json">Technical JSON Datafeed</a></li>
                    <li><a href="/contact">B2B Container Inquiries</a></li>
                    <li><a href="/contact">OEM Factory Specifications</a></li>
                    <li><a href="/sitemap.xml">XML Product Sitemap</a></li>
                    <li><a href="tel:<?= App::PHONE_CLEAN ?>"><?= App::PHONE ?></a></li>
                    <li><a href="mailto:<?= App::EMAIL ?>"><?= App::EMAIL ?></a></li>
                </ul>
            </div>

            <!-- Col 4: European Certifications & Standards -->
            <div>
                <h4 class="footer-col-title">Manufacturing Standards</h4>
                <div class="footer-cert-badges">
                    <div class="footer-cert-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        <span>EN 997:2018 (WC Pans &amp; Suites)</span>
                    </div>
                    <div class="footer-cert-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        <span>EN 14688:2015 (Sanitary Basins)</span>
                    </div>
                    <div class="footer-cert-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        <span>CE Declaration of Performance</span>
                    </div>
                    <div class="footer-cert-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        <span>ISO 9001 &amp; ISO 14001 Quality Certified</span>
                    </div>
                    <div class="footer-cert-item" style="color: var(--c-champagne);">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z"/></svg>
                        <span>10-Year Factory Guarantee on Vitreous China</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom-bar">
            <div>
                &copy; <?= date('Y') ?> <?= App::FULL_LEGAL_NAME ?>. All rights reserved.
            </div>
            <div>
                Architectural Sanitary Ceramics &bull; Designed to European Standards &bull; Export Edition (en-GB)
            </div>
        </div>
    </div>
</footer>

<!-- Global Search Modal Dialog -->
<div id="search-modal" class="search-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-search-title">
    <div class="search-modal-card">
        <div class="search-input-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="search-input" placeholder="Search 282 certified models by SKU code or name (e.g. 1620, Washbasin, Mixer)..." aria-label="Search models">
            <button type="button" id="search-modal-close" class="search-close-btn" aria-label="Close search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div id="search-results-box" class="search-live-results">
            <div style="padding: 1.5rem; text-align: center; color: var(--c-muted); font-size: 0.875rem;">
                Type a product code (e.g. <strong>1620-111</strong>) or category name to search.
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/app.js" defer></script>
<?php if (isset($product)): ?>
<script src="/assets/js/gallery.js" defer></script>
<?php endif; ?>
