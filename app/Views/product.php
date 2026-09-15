<?php
declare(strict_types=1);

use App\Config\App;
use App\Helpers\Security;

/** @var array $product */
/** @var array $gallery */
/** @var array $related */
/** @var array $breadcrumbs */

$primaryImg = !empty($product['primary_image']) ? $product['primary_image'] : '/assets/images/brand/placeholder.png';
$sku = $product['sku'];
$name = $product['name'];
$catName = $product['category_name'];
$dims = $product['dimensions'] ?: '600 x 420 x 145 mm';
$mounting = $product['mounting_type'] ?: 'Concealed Wall-Hung / Countertop';
$material = $product['material'] ?: '100% High-Grade Vitreous China';
$warranty = $product['warranty'] ?: '10-Year Factory Guarantee';
$standards = $product['standards'] ?: 'CE & EN 997 Certified';
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 1rem 0 4rem;">
    <div class="l-container">
        <div class="product-detail-layout">
            <!-- Left: Interactive Gallery -->
            <div class="gallery-container">
                <div class="gallery-stage" id="gallery-stage">
                    <img src="<?= Security::e($primaryImg) ?>" 
                         alt="<?= Security::e($name) ?> - Primary View" 
                         id="product-main-image" 
                         width="600" 
                         height="600"
                         loading="eager"
                         fetchpriority="high">
                </div>

                <?php if (!empty($gallery) && count($gallery) > 1): ?>
                    <div class="gallery-thumbs" aria-label="Product Alternative Angles">
                        <?php foreach ($gallery as $idx => $img): ?>
                            <button type="button" 
                                    class="gallery-thumb-btn <?= $idx === 0 ? 'active' : '' ?>" 
                                    data-img-src="<?= Security::e($img['image_url']) ?>"
                                    aria-label="View angle <?= $idx + 1 ?>">
                                <img src="<?= Security::e($img['image_url']) ?>" 
                                     alt="Thumbnail angle <?= $idx + 1 ?>" 
                                     width="90" 
                                     height="90" 
                                     loading="lazy">
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Architectural Badge Strip -->
                <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-sm); padding: 1.25rem; display: flex; justify-content: space-around; text-align: center; margin-top: 1rem;">
                    <div>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-forest); font-weight: 600; display: block;">1,250°C</span>
                        <span style="font-size: 0.6875rem; color: var(--c-muted);">Tunnel Kiln Fired</span>
                    </div>
                    <div style="border-left: 1px solid var(--c-divider); height: 28px;"></div>
                    <div>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-forest); font-weight: 600; display: block;">&lt; 0.5%</span>
                        <span style="font-size: 0.6875rem; color: var(--c-muted);">Water Absorption</span>
                    </div>
                    <div style="border-left: 1px solid var(--c-divider); height: 28px;"></div>
                    <div>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-forest); font-weight: 600; display: block;">EN 997</span>
                        <span style="font-size: 0.6875rem; color: var(--c-muted);">European Class 1</span>
                    </div>
                </div>
            </div>

            <!-- Right: Technical Specification Details -->
            <div class="product-summary-pane">
                <div class="product-meta-pills">
                    <span class="meta-pill" style="font-weight: 600;"><?= Security::e($catName) ?></span>
                    <span class="meta-pill">SKU: <strong><?= Security::e($sku) ?></strong></span>
                    <?php if (!empty($product['is_featured'])): ?>
                        <span class="meta-pill meta-pill-featured">Signature Model</span>
                    <?php endif; ?>
                    <span class="meta-pill" style="color: #2e7d32; border-color: #c8e6c9; background-color: #f1f8e9;">Production Ready</span>
                </div>

                <h1 class="product-detail-title"><?= Security::e($name) ?></h1>
                
                <div class="product-detail-sku">
                    Manufactured by <?= App::FULL_LEGAL_NAME ?> &bull; Gaziantep, Turkey
                </div>

                <div class="product-detail-desc">
                    <?= nl2br(Security::e($product['description'])) ?>
                </div>

                <!-- Technical Specification Grid -->
                <h3 style="font-size: 1rem; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 0.08em; color: var(--c-forest); margin-bottom: 0.75rem;">
                    Engineering Specifications
                </h3>

                <table class="product-specs-table">
                    <tbody>
                        <tr>
                            <th scope="row">Factory SKU Code</th>
                            <td><?= Security::e($sku) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Nominal Dimensions</th>
                            <td><?= Security::e($dims) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Material Composition</th>
                            <td><?= Security::e($material) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Installation &amp; Mounting</th>
                            <td><?= Security::e($mounting) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Glaze Technology</th>
                            <td>Nano-Shield Antibacterial Hygienic Glaze</td>
                        </tr>
                        <tr>
                            <th scope="row">European Certification</th>
                            <td><?= Security::e($standards) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Manufacturer Guarantee</th>
                            <td><?= Security::e($warranty) ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Origin of Manufacture</th>
                            <td><?= App::FACTORY_LOCATION ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- B2B Procurement Actions -->
                <div class="product-b2b-actions">
                    <a href="/contact?sku=<?= urlencode($sku) ?>&product=<?= urlencode($name) ?>" class="btn btn-primary" style="flex: 1;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>Request B2B Factory Quote</span>
                    </a>

                    <a href="https://wa.me/<?= App::WHATSAPP ?>?text=<?= urlencode('Hello Lufly Export Department, I require pricing and technical drawings for Model: ' . $name . ' (SKU: ' . $sku . ').') ?>" 
                       target="_blank" 
                       rel="noopener" 
                       class="btn btn-secondary" 
                       style="border-color: #25D366; color: #128C7E;">
                        <span>WhatsApp Inquiry</span>
                    </a>

                    <a href="/catalog" class="btn btn-secondary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Download 2025 Binder</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cross-Sell & Related Models -->
        <?php if (!empty($related)): ?>
            <div style="margin-top: 5rem; padding-top: 3rem; border-top: 1px solid var(--c-divider);">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
                    <div>
                        <span class="section-eyebrow">Compatible Architectural Suite</span>
                        <h2 class="section-title" style="font-size: 2rem;">Related Production Models</h2>
                    </div>
                    <a href="/collections/<?= Security::e($product['category_slug'] ?? 'designer-washbasins') ?>" class="btn btn-text">
                        <span>View more in <?= Security::e($catName) ?> &rarr;</span>
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
                    <?php foreach ($related as $p): ?>
                        <?php require __DIR__ . '/components/product-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
