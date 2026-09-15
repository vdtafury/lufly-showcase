<?php
declare(strict_types=1);

use App\Helpers\Security;

/** @var array $p */
$productUrl = '/products/' . $p['slug'];
$primaryImg = !empty($p['primary_image']) ? $p['primary_image'] : '/assets/images/brand/placeholder.png';
$categoryName = $p['category_name'] ?? 'Ceramics';
$sku = $p['sku'] ?? ('LUF-' . $p['id']);
$isFeatured = !empty($p['is_featured']);
$dims = !empty($p['dimensions']) ? $p['dimensions'] : 'Technical specs inside';
?>
<article class="product-card" itemscope itemtype="https://schema.org/Product">
    <div class="product-img-box">
        <span class="product-sku-tag" itemprop="sku"><?= Security::e($sku) ?></span>
        <?php if ($isFeatured): ?>
            <span class="product-badge-featured">Featured</span>
        <?php endif; ?>
        
        <a href="<?= Security::e($productUrl) ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
            <img src="<?= Security::e($primaryImg) ?>" 
                 alt="<?= Security::e($p['name']) ?> - Ceramic Sanitary Ware" 
                 width="400" 
                 height="400" 
                 loading="lazy" 
                 decoding="async"
                 itemprop="image">
        </a>
    </div>

    <div class="product-info">
        <span class="product-category-label"><?= Security::e($categoryName) ?></span>
        
        <h3 class="product-card-title" itemprop="name">
            <a href="<?= Security::e($productUrl) ?>"><?= Security::e($p['name']) ?></a>
        </h3>

        <div class="product-card-specs">
            <span class="product-dim-text"><?= Security::e($dims) ?></span>
            <a href="<?= Security::e($productUrl) ?>" class="product-view-link">
                <span>View Specs</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</article>
