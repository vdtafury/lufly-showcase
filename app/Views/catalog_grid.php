<?php
declare(strict_types=1);

use App\Helpers\I18n;
use App\Helpers\Security;

/** @var array $products */
/** @var int $total */
/** @var int $page */
/** @var int $totalPages */
/** @var string $sort */
/** @var array $categories */
/** @var array $breadcrumbs */
$loc = I18n::getLocale();
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <!-- Header & Filter Toolbar -->
        <div style="border-bottom: 1px solid var(--c-divider); padding-bottom: 2rem; margin-bottom: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1.5rem;">
                <div>
                    <span class="section-eyebrow">
                        <?= $loc === 'tr' ? 'Fabrika Envanteri &bull; 282 Model' : ($loc === 'cs' ? 'Tovární inventář &bull; 282 modelů' : 'Factory Inventory &bull; 282 Models') ?>
                    </span>
                    <h1 class="display-title" style="font-size: clamp(2.2rem, 3.5vw, 3.25rem); margin-top: 0.35rem;">
                        <?= $loc === 'tr' ? 'Tüm Üretim Kataloğu' : ($loc === 'cs' ? 'Kompletní výrobní katalog' : 'Complete Production Catalog') ?>
                    </h1>
                    <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 0.5rem;">
                        <?= $loc === 'tr' ? 'Lufly Gaziantep entegre tesislerinde üretilen sertifikalı vitrifiye seramikler, kanalsız klozetler ve tasarım lavabolar.' : ($loc === 'cs' ? 'Certifikovaná sanitární keramika, rimless toalety a designová umyvadla přímo z výroby Lufly.' : 'Verified architectural ceramics, rimless toilets, and designer washbasins directly from Lufly manufacturing facilities.') ?>
                    </p>
                </div>

                <!-- Filters & Sort -->
                <form method="GET" action="<?= locale_url('/products') ?>" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <div>
                        <select name="category" onchange="this.form.submit()" class="form-control" style="padding: 0.55rem 0.85rem; font-size: 0.8125rem;">
                            <option value=""><?= $loc === 'tr' ? 'Tüm Koleksiyonlar (14)' : ($loc === 'cs' ? 'Všechny kolekce (14)' : 'All Collections (14)') ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= (!empty($_GET['category']) && (int)$_GET['category'] === (int)$cat['id']) ? 'selected' : '' ?>>
                                    <?= Security::e($cat['name']) ?> (<?= (int)$cat['product_count'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <select name="sort" onchange="this.form.submit()" class="form-control" style="padding: 0.55rem 0.85rem; font-size: 0.8125rem;">
                            <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>><?= I18n::t('sort_default') ?></option>
                            <option value="sku-asc" <?= $sort === 'sku-asc' ? 'selected' : '' ?>><?= I18n::t('sort_sku_asc') ?></option>
                            <option value="name-asc" <?= $sort === 'name-asc' ? 'selected' : '' ?>><?= I18n::t('sort_name_asc') ?></option>
                            <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>><?= I18n::t('sort_price_asc') ?></option>
                            <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>><?= I18n::t('sort_price_desc') ?></option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
            <?php foreach ($products as $p): ?>
                <?php require __DIR__ . '/components/product-card.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- SSR Pagination -->
        <?php if ($totalPages > 1): ?>
            <?php 
                $queryParams = $_GET;
            ?>
            <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 4rem;">
                <?php if ($page > 1): ?>
                    <?php $queryParams['page'] = $page - 1; ?>
                    <a href="?<?= http_build_query($queryParams) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;">&larr; <?= $loc === 'tr' ? 'Önceki' : ($loc === 'cs' ? 'Předchozí' : 'Previous') ?></a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php $queryParams['page'] = $i; ?>
                    <?php if ($i == $page): ?>
                        <span class="btn btn-primary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem; min-width: 38px;"><?= $i ?></span>
                    <?php elseif ($i <= 3 || $i >= $totalPages - 1 || abs($i - $page) <= 1): ?>
                        <a href="?<?= http_build_query($queryParams) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem; min-width: 38px;"><?= $i ?></a>
                    <?php elseif ($i == 4 && $page > 4): ?>
                        <span style="padding: 0.5rem; color: var(--c-muted);">&hellip;</span>
                    <?php elseif ($i == $totalPages - 2 && $page < $totalPages - 3): ?>
                        <span style="padding: 0.5rem; color: var(--c-muted);">&hellip;</span>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <?php $queryParams['page'] = $page + 1; ?>
                    <a href="?<?= http_build_query($queryParams) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;"><?= $loc === 'tr' ? 'Sonraki' : ($loc === 'cs' ? 'Další' : 'Next') ?> &rarr;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
