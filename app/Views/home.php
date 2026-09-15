<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\I18n;
use App\Helpers\Security;

/** @var array $featuredProducts */
/** @var array $categories */
$loc = I18n::getLocale();
?>

<!-- Cinematic Architectural Hero with Multi-Scene Video Transitions -->
<section class="hero-cinematic">
    <!-- Ambient Background Videos Layer -->
    <div class="hero-video-bg-wrapper">
        <video class="hero-bg-video active" id="hero-video-1" src="/assets/videos/hero_scene_1.mp4" autoplay loop muted playsinline poster="/assets/images/products/lufly_146_1620-111-a.jpg"></video>
        <video class="hero-bg-video" id="hero-video-2" src="/assets/videos/hero_scene_2.mp4" loop muted playsinline poster="/assets/images/products/lufly_205_ESINO.jpg"></video>
        <video class="hero-bg-video" id="hero-video-3" src="/assets/videos/hero_scene_3.mp4" loop muted playsinline poster="/assets/images/products/lufly_2109_1654-001.jpg"></video>
        <div class="hero-cinematic-overlay"></div>
    </div>

    <!-- Hero Content Layer -->
    <div class="hero-cinematic-inner">
        <div class="l-container">
            <div class="hero-cinematic-grid">
                <!-- Left Story Column -->
                <div class="hero-cinematic-story">
                    <div class="hero-pill-badge">
                        <span class="pulse-beacon"></span>
                        <span id="hero-scene-tag"><?= I18n::t('hero_scene_1_tag') ?></span>
                    </div>

                    <div class="hero-story-text">
                        <h1 class="hero-display-title" id="hero-scene-title">
                            <?= I18n::t('hero_scene_1_title') ?>
                        </h1>
                        <p class="hero-text-desc" id="hero-scene-desc">
                            <?= I18n::t('hero_scene_1_desc') ?>
                        </p>
                    </div>

                    <div class="hero-actions-bar">
                        <a href="<?= locale_url('/collections') ?>" class="btn btn-primary" style="padding: 0.85rem 1.75rem;">
                            <span><?= I18n::t('hero_cta_explore') ?></span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                        <button type="button" class="btn-reel" id="hero-watch-reel-btn" aria-label="<?= I18n::t('hero_watch_film') ?>">
                            <span class="reel-play-circle">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                            <span><?= I18n::t('hero_watch_film') ?></span>
                        </button>

                        <a href="<?= locale_url('/catalog') ?>" class="btn btn-secondary" style="color: #FFFFFF; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.06);">
                            <span><?= I18n::t('hero_cta_lookbook') ?></span>
                        </a>
                    </div>

                    <div class="hero-stats-bar">
                        <div class="hero-stat-item">
                            <h4>1,250°C</h4>
                            <p><?= $loc === 'tr' ? 'Vitreous Fırınlama' : ($loc === 'cs' ? 'Keramický výpal' : 'Dense Kiln Firing') ?></p>
                        </div>
                        <div class="hero-stat-item">
                            <h4>EN 997</h4>
                            <p><?= $loc === 'tr' ? 'Avrupa Normu' : ($loc === 'cs' ? 'Evropská norma' : 'European Standard') ?></p>
                        </div>
                        <div class="hero-stat-item">
                            <h4>10 <?= $loc === 'tr' ? 'Yıl' : ($loc === 'cs' ? 'let' : 'Years') ?></h4>
                            <p><?= I18n::t('topbar_guarantee') ?></p>
                        </div>
                        <div class="hero-stat-item">
                            <h4>34+</h4>
                            <p><?= $loc === 'tr' ? 'İhracat Ülkesi' : ($loc === 'cs' ? 'Zemí exportu' : 'Export Markets') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Right Spotlight Model Showcase Card -->
                <div class="hero-spotlight-wrap">
                    <div class="hero-spotlight-card" id="hero-spotlight-card">
                        <div class="hero-spotlight-header">
                            <span class="hero-spotlight-badge" id="hero-spotlight-badge">FLAGSHIP • EN 997</span>
                            <span class="hero-spotlight-sku" id="hero-spotlight-sku">SKU: 1620-111</span>
                        </div>

                        <div class="hero-spotlight-img-box">
                            <img src="/assets/images/products/lufly_146_1620-111-a.jpg" 
                                 alt="Lufly Rimless Wall-Hung WC Pan" 
                                 id="hero-spotlight-img"
                                 width="420" 
                                 height="300"
                                 loading="eager"
                                 fetchpriority="high">
                        </div>

                        <div class="hero-spotlight-title" id="hero-spotlight-title">
                            <?= $loc === 'tr' ? 'Kanalsız Asma Klozet' : ($loc === 'cs' ? 'Závěsná WC mísa Rimless' : 'Rimless Wall-Hung WC Pan') ?>
                        </div>
                        <div class="hero-spotlight-specs" id="hero-spotlight-specs">
                            <?= $loc === 'tr' ? '540 × 360 mm • Gizli Duvar Montajı' : ($loc === 'cs' ? '540 × 360 mm • Skrytá montáž na stěnu' : '540 × 360 mm • Concealed Wall-Hung') ?>
                        </div>

                        <div class="hero-spotlight-footer">
                            <a href="<?= locale_url('/products/rimless-wall-hung-wc-pan-ewo-sdh-128-146') ?>" class="btn btn-primary" id="hero-spotlight-link" style="padding: 0.55rem 1rem; font-size: 0.8125rem; width: 100%; justify-content: center;">
                                <span><?= I18n::t('view_specs') ?></span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline & Scene Switcher Bar -->
    <div class="hero-timeline-controls">
        <div class="l-container hero-timeline-grid">
            <div class="hero-tabs-group" role="tablist" aria-label="Hero Scene Tabs">
                <button type="button" class="hero-tab-btn active" data-scene="0" role="tab" aria-selected="true">
                    <div class="hero-tab-progress-track">
                        <div class="hero-tab-progress-fill" style="width: 0%;"></div>
                    </div>
                    <div class="hero-tab-meta">
                        <span class="hero-tab-num">01</span>
                        <span class="hero-tab-title"><?= I18n::t('hero_tab_1') ?></span>
                    </div>
                </button>

                <button type="button" class="hero-tab-btn" data-scene="1" role="tab" aria-selected="false">
                    <div class="hero-tab-progress-track">
                        <div class="hero-tab-progress-fill" style="width: 0%;"></div>
                    </div>
                    <div class="hero-tab-meta">
                        <span class="hero-tab-num">02</span>
                        <span class="hero-tab-title"><?= I18n::t('hero_tab_2') ?></span>
                    </div>
                </button>

                <button type="button" class="hero-tab-btn" data-scene="2" role="tab" aria-selected="false">
                    <div class="hero-tab-progress-track">
                        <div class="hero-tab-progress-fill" style="width: 0%;"></div>
                    </div>
                    <div class="hero-tab-meta">
                        <span class="hero-tab-num">03</span>
                        <span class="hero-tab-title"><?= I18n::t('hero_tab_3') ?></span>
                    </div>
                </button>
            </div>

            <div class="hero-playback-actions">
                <button type="button" class="hero-ctrl-btn" id="hero-prev-btn" aria-label="Previous Scene">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="hero-ctrl-btn" id="hero-play-pause-btn" aria-label="Play or Pause Rotation">
                    <svg class="icon-pause" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                    <svg class="icon-play" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display: none;"><path d="M8 5v14l11-7z"/></svg>
                </button>
                <button type="button" class="hero-ctrl-btn" id="hero-next-btn" aria-label="Next Scene">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Fullscreen Cinematic Theater Modal -->
<div class="hero-theater-modal" id="hero-theater-modal" role="dialog" aria-modal="true" aria-label="<?= I18n::t('hero_watch_film') ?>">
    <div class="theater-inner">
        <button type="button" class="theater-close-btn" id="hero-theater-close" aria-label="<?= I18n::t('hero_close_video') ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <div class="theater-video-frame">
            <video id="hero-theater-video" controls playsinline preload="none" src="/assets/videos/hero_scene_1.mp4"></video>
        </div>
    </div>
</div>

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
                <div class="category-card">
                    <a href="<?= locale_url('/collections/' . $cat['slug']) ?>" class="category-card-thumb" aria-label="<?= Security::e($cat['name']) ?>">
                        <img src="<?= Security::e($cat['thumbnail']) ?>" 
                             alt="<?= Security::e($cat['name']) ?>" 
                             loading="lazy" 
                             decoding="async"
                             width="400" 
                             height="260">
                        <span class="category-count-badge"><?= (int)$cat['product_count'] ?> <?= I18n::t('models_suffix') ?></span>
                    </a>
                    <div class="category-card-body">
                        <h3 class="category-card-title">
                            <a href="<?= locale_url('/collections/' . $cat['slug']) ?>"><?= Security::e($cat['name']) ?></a>
                        </h3>
                        <p class="category-card-desc"><?= Security::e($cat['description']) ?></p>
                        <div class="category-card-footer">
                            <a href="<?= locale_url('/collections/' . $cat['slug']) ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">
                                <span><?= $loc === 'tr' ? 'Koleksiyonu Keşfet' : ($loc === 'cs' ? 'Prozkoumat kolekci' : 'Explore Collection') ?></span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                            <span class="category-spec-tag">EN 997</span>
                        </div>
                    </div>
                </div>
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
