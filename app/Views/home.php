<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\Security;

/** @var array $featuredProducts */
/** @var array $categories */
?>

<!-- Editorial Hero Section -->
<section class="hero-editorial">
    <div class="l-container hero-grid">
        <div class="hero-content">
            <span class="section-eyebrow">Factory Direct &bull; European Engineering</span>
            <h1 class="display-title">
                Architectural Sanitary Ceramics Engineered for European Living.
            </h1>
            <p class="hero-description">
                Lufly manufactures high-temperature vitreous china sanitary ware in Gaziantep, Turkey. Engineered to EN 997 and CE standards with ultra-clean rimless flushing dynamics and sustainable water-saving precision.
            </p>
            <div class="hero-actions">
                <a href="/collections" class="btn btn-primary">
                    <span>Explore Master Collections</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="/catalog" class="btn btn-secondary">
                    <span>Download 2025 Lookbook</span>
                </a>
            </div>

            <div class="hero-badges-strip">
                <div class="hero-badge-cell">
                    <h4>1,250°C</h4>
                    <p>High-temperature kiln firing for near-zero water absorption (&lt;0.5%).</p>
                </div>
                <div class="hero-badge-cell">
                    <h4>EN 997</h4>
                    <p>Class 1 certified rimless vortex flush dynamics saving 40% water.</p>
                </div>
                <div class="hero-badge-cell">
                    <h4>10 Years</h4>
                    <p>Comprehensive manufacturer warranty on all vitreous ceramic bodies.</p>
                </div>
            </div>
        </div>

        <div class="hero-visual-frame">
            <div class="hero-visual-card">
                <div class="hero-img-wrap">
                    <img src="/assets/images/products/lufly_156_1620-111.jpg" 
                         alt="Lufly Rimless Wall-Hung WC Suite - Model 1620-111" 
                         width="500" 
                         height="500" 
                         loading="eager"
                         fetchpriority="high">
                </div>
                <div class="hero-card-meta">
                    <div>
                        <div class="hero-card-sku">FLAGSHIP MODEL &bull; SKU: 1620-111</div>
                        <div class="hero-card-title">Rimless Wall-Hung WC Pan</div>
                    </div>
                    <a href="/products/rimless-wall-hung-wc-pan-ewo-sdh-128-146" class="btn btn-primary" style="padding: 0.5rem 0.9rem; font-size: 0.75rem;">
                        <span>View Specs</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Curated Architectural Collections -->
<section style="padding: 5rem 0; background-color: var(--c-white); border-bottom: 1px solid var(--c-divider);">
    <div class="l-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; flex-wrap: gap; gap: 1.5rem;">
            <div>
                <span class="section-eyebrow">Product Classification</span>
                <h2 class="section-title">Architectural Collections</h2>
            </div>
            <a href="/collections" class="btn btn-secondary">
                <span>View All 14 Collections &rarr;</span>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem;">
            <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
                <a href="/collections/<?= Security::e($cat['slug']) ?>" class="category-card">
                    <div class="category-card-header">
                        <div class="category-icon-box">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                        </div>
                        <span class="category-count-badge"><?= (int)$cat['product_count'] ?> Models</span>
                    </div>
                    <h3 class="category-card-title"><?= Security::e($cat['name']) ?></h3>
                    <p class="category-card-desc"><?= Security::e($cat['description']) ?></p>
                    <span style="font-size: 0.8125rem; font-weight: 600; color: var(--c-forest); display: inline-flex; align-items: center; gap: 0.35rem;">
                        <span>Explore Collection</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Signature Production Models (Live Database Query) -->
<section style="padding: 5rem 0; border-bottom: 1px solid var(--c-divider);">
    <div class="l-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <span class="section-eyebrow">Signature Portfolio</span>
                <h2 class="section-title">Verified Production Models</h2>
                <p style="color: var(--c-muted); font-size: 0.9375rem; margin-top: 0.5rem; max-width: 540px;">
                    Queried directly from our production facility database. All models feature authentic factory SKUs, real multi-angle imagery, and European dimensional tolerances.
                </p>
            </div>
            <a href="/products" class="btn btn-primary">
                <span>Browse Full 282 Models &rarr;</span>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
            <?php foreach ($featuredProducts as $p): ?>
                <?php require __DIR__ . '/components/product-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Manufacturing Craftsmanship & Engineering Values -->
<section style="padding: 5.5rem 0; background-color: var(--c-white); border-bottom: 1px solid var(--c-divider);">
    <div class="l-container">
        <div style="text-align: center; max-width: 760px; margin: 0 auto 4rem;">
            <span class="section-eyebrow">Industrial Standards</span>
            <h2 class="section-title" style="margin-top: 0.5rem;">Engineering Purity. Uncompromising Integrity.</h2>
            <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 1rem; line-height: 1.65;">
                Every Lufly sanitary ceramic piece undergoes rigorous robotic pressure casting, triple-dip micro-glazing, and computerized 1,250°C tunnel kiln firing to ensure dimensional precision and antibacterial hygiene.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">01 &bull; MATERIAL SCIENCE</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);">100% High-Density Vitreous China</h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    Formulated with refined kaolin clay, quartz, and feldspar. High firing temperatures melt glass components to eliminate micro-pores, ensuring lifetime impermeability against moisture and odor.
                </p>
            </div>

            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">02 &bull; HYDRAULIC DYNAMICS</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);">Aerodynamic Rimless Vortex</h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    Eliminating traditional concealed box rims removes breeding grounds for bacteria and limescale. A calibrated 360° water sheet sweeps the entire vitreous bowl using only 4.5/3.0 liters per flush.
                </p>
            </div>

            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">03 &bull; SURFACE HYGIENE</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);">Nano-Shield Antibacterial Glaze</h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    Permanent silver-ion antimicrobial coating fused during kiln firing. Repels grime, water droplets, and bacteria, requiring 70% fewer chemical cleaning agents over its operational lifespan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Direct Factory Procurement CTA Strip -->
<section style="padding: 4.5rem 0; background: linear-gradient(135deg, var(--c-forest) 0%, var(--c-obsidian) 100%); color: var(--c-white);">
    <div class="l-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
        <div>
            <span style="font-family: var(--font-mono); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--c-champagne);">B2B Container Export Desk</span>
            <h2 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--c-white); margin-top: 0.5rem;">Direct Factory Quotations for Architects &amp; Distributors</h2>
            <p style="color: #9fb5ab; font-size: 0.9375rem; margin-top: 0.5rem; max-width: 580px;">
                Direct procurement from Gaziantep industrial facility. Full container load (FCL) shipping, custom OEM branding, and complete technical CAD documentation.
            </p>
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="/contact" class="btn btn-champagne">
                <span>Request B2B Export Pricing</span>
            </a>
            <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode('Hello, I am requesting technical pricing for Lufly sanitary ceramics.') ?>" target="_blank" rel="noopener" class="btn" style="background: rgba(255,255,255,0.1); color: var(--c-white); border-color: rgba(255,255,255,0.2);">
                <span>Chat on WhatsApp</span>
            </a>
        </div>
    </div>
</section>
