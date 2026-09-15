<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

/** @var array $featuredProducts */
/** @var array $categories */
$loc = I18n::getLocale();
?>

<!-- Editorial Hero Section -->
<section class="hero-editorial">
    <div class="l-container hero-grid">
        <div class="hero-content">
            <span class="section-eyebrow">
                <?= $loc === 'tr' ? 'Doğrudan Fabrikadan &bull; Avrupa Mühendisliği' : ($loc === 'cs' ? 'Přímo z továrny &bull; Evropská preciznost' : 'Factory Direct &bull; European Engineering') ?>
            </span>
            <h1 class="display-title">
                <?= I18n::t('hero_title') ?>
            </h1>
            <p class="hero-description">
                <?= I18n::t('hero_description') ?>
            </p>
            <div class="hero-actions">
                <a href="<?= locale_url('/collections') ?>" class="btn btn-primary">
                    <span><?= I18n::t('hero_cta_explore') ?></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="<?= locale_url('/catalog') ?>" class="btn btn-secondary">
                    <span><?= I18n::t('hero_cta_lookbook') ?></span>
                </a>
            </div>

            <div class="hero-badges-strip">
                <div class="hero-badge-cell">
                    <h4>1,250°C</h4>
                    <p><?= I18n::t('eng_1_desc') ?></p>
                </div>
                <div class="hero-badge-cell">
                    <h4>EN 997</h4>
                    <p><?= I18n::t('eng_2_desc') ?></p>
                </div>
                <div class="hero-badge-cell">
                    <h4>10 <?= $loc === 'tr' ? 'Yıl' : ($loc === 'cs' ? 'let' : 'Years') ?></h4>
                    <p><?= I18n::t('topbar_guarantee') ?></p>
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
                        <div class="hero-card-sku">FLAGSHIP &bull; SKU: 1620-111</div>
                        <div class="hero-card-title"><?= $loc === 'tr' ? 'Kanalsız Asma Klozet' : ($loc === 'cs' ? 'Závěsná WC mísa Rimless' : 'Rimless Wall-Hung WC Pan') ?></div>
                    </div>
                    <a href="<?= locale_url('/products/rimless-wall-hung-wc-pan-ewo-sdh-128-146') ?>" class="btn btn-primary" style="padding: 0.5rem 0.9rem; font-size: 0.75rem;">
                        <span><?= I18n::t('view_specs') ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Curated Architectural Collections -->
<section style="padding: 5rem 0; background-color: var(--c-white); border-bottom: 1px solid var(--c-divider);">
    <div class="l-container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <span class="section-eyebrow"><?= $loc === 'tr' ? 'Ürün Sınıflandırması' : ($loc === 'cs' ? 'Kategorie produktů' : 'Product Classification') ?></span>
                <h2 class="section-title"><?= I18n::t('section_collections_title') ?></h2>
            </div>
            <a href="<?= locale_url('/collections') ?>" class="btn btn-secondary">
                <span><?= I18n::t('footer_view_all_collections') ?></span>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem;">
            <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
                <a href="<?= locale_url('/collections/' . $cat['slug']) ?>" class="category-card">
                    <div class="category-card-header">
                        <div class="category-icon-box">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                        </div>
                        <span class="category-count-badge"><?= (int)$cat['product_count'] ?> <?= I18n::t('models_found') ?></span>
                    </div>
                    <h3 class="category-card-title"><?= Security::e($cat['name']) ?></h3>
                    <p class="category-card-desc"><?= Security::e($cat['description']) ?></p>
                    <span style="font-size: 0.8125rem; font-weight: 600; color: var(--c-forest); display: inline-flex; align-items: center; gap: 0.35rem;">
                        <span><?= $loc === 'tr' ? 'Koleksiyonu Keşfet' : ($loc === 'cs' ? 'Prozkoumat kolekci' : 'Explore Collection') ?></span>
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
                <span class="section-eyebrow"><?= $loc === 'tr' ? 'İmza Portföy' : ($loc === 'cs' ? 'Výběr z katalogu' : 'Signature Portfolio') ?></span>
                <h2 class="section-title"><?= I18n::t('section_featured_title') ?></h2>
                <p style="color: var(--c-muted); font-size: 0.9375rem; margin-top: 0.5rem; max-width: 540px;">
                    <?= I18n::t('section_featured_desc') ?>
                </p>
            </div>
            <a href="<?= locale_url('/products') ?>" class="btn btn-primary">
                <span><?= $loc === 'tr' ? 'Tüm 282 Modeli İncele &rarr;' : ($loc === 'cs' ? 'Všech 282 modelů &rarr;' : 'Browse Full 282 Models &rarr;') ?></span>
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
            <span class="section-eyebrow"><?= $loc === 'tr' ? 'Endüstriyel Standartlar' : ($loc === 'cs' ? 'Průmyslové standardy' : 'Industrial Standards') ?></span>
            <h2 class="section-title" style="margin-top: 0.5rem;"><?= I18n::t('section_engineering_title') ?></h2>
            <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 1rem; line-height: 1.65;">
                <?= I18n::t('section_engineering_desc') ?>
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem;">
            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">01 &bull; MATERIAL SCIENCE</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);"><?= I18n::t('eng_1_title') ?></h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    <?= I18n::t('eng_1_desc') ?>
                </p>
            </div>

            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">02 &bull; HYDRAULIC DYNAMICS</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);"><?= I18n::t('eng_2_title') ?></h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    <?= I18n::t('eng_2_desc') ?>
                </p>
            </div>

            <div style="border-left: 2px solid var(--c-forest); padding-left: 1.5rem;">
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-champagne); font-weight: 600;">03 &bull; SURFACE HYGIENE</span>
                <h3 style="font-size: 1.25rem; margin: 0.5rem 0; color: var(--c-obsidian);"><?= I18n::t('eng_3_title') ?></h3>
                <p style="color: var(--c-muted); font-size: 0.875rem; line-height: 1.6;">
                    <?= I18n::t('eng_3_desc') ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Direct Factory Procurement CTA Strip -->
<section style="padding: 4.5rem 0; background: linear-gradient(135deg, var(--c-forest) 0%, var(--c-obsidian) 100%); color: var(--c-white);">
    <div class="l-container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
        <div>
            <span style="font-family: var(--font-mono); font-size: 0.75rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--c-champagne);"><?= $loc === 'tr' ? 'B2B Konteyner İhracat Masası' : ($loc === 'cs' ? 'B2B kontejnerový export' : 'B2B Container Export Desk') ?></span>
            <h2 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--c-white); margin-top: 0.5rem;"><?= I18n::t('section_quote_title') ?></h2>
            <p style="color: #9fb5ab; font-size: 0.9375rem; margin-top: 0.5rem; max-width: 580px;">
                <?= I18n::t('section_quote_desc') ?>
            </p>
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="<?= locale_url('/contact') ?>" class="btn btn-champagne">
                <span><?= I18n::t('request_b2b_quote') ?></span>
            </a>
            <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode(I18n::t('whatsapp_greeting')) ?>" target="_blank" rel="noopener" class="btn" style="background: rgba(255,255,255,0.1); color: var(--c-white); border-color: rgba(255,255,255,0.2);">
                <span><?= $loc === 'tr' ? 'WhatsApp ile İletişim' : ($loc === 'cs' ? 'Kontakt přes WhatsApp' : 'Chat on WhatsApp') ?></span>
            </a>
        </div>
    </div>
</section>
