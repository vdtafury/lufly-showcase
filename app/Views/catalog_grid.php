<?php
declare(strict_types=1);

use App\Helpers\Security;

/** @var array $products */
/** @var int $total */
/** @var int $page */
/** @var int $totalPages */
/** @var string $sort */
/** @var array $categories */
/** @var array $breadcrumbs */
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <!-- Header & Filter Toolbar -->
        <div style="border-bottom: 1px solid var(--c-divider); padding-bottom: 2rem; margin-bottom: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1.5rem;">
                <div>
                    <span class="section-eyebrow">Factory Inventory &bull; 282 Models</span>
                    <h1 class="display-title" style="font-size: clamp(2.2rem, 3.5vw, 3.25rem); margin-top: 0.35rem;">Complete Production Catalog</h1>
                    <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 0.5rem;">
                        Verified architectural ceramics, rimless toilets, and designer washbasins directly from Lufly manufacturing facilities.
                    </p>
                </div>

                <!-- Filters & Sort -->
                <form method="GET" action="/products" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <div>
                        <select name="category" onchange="this.form.submit()" class="form-control" style="padding: 0.55rem 0.85rem; font-size: 0.8125rem;">
                            <option value="">All Collections (14)</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= (!empty($_GET['category']) && (int)$_GET['category'] === (int)$cat['id']) ? 'selected' : '' ?>>
                                    <?= Security::e($cat['name']) ?> (<?= (int)$cat['product_count'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <select name="sort" onchange="this.form.submit()" class="form-control" style="padding: 0.55rem 0.85rem; font-size: 0.8125rem;">
                            <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Featured First</option>
                            <option value="sku-asc" <?= $sort === 'sku-asc' ? 'selected' : '' ?>>SKU (A &rarr; Z)</option>
                            <option value="name-asc" <?= $sort === 'name-asc' ? 'selected' : '' ?>>Name (A &rarr; Z)</option>
                            <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>Price (Low &rarr; High)</option>
                            <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>Price (High &rarr; Low)</option>
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
                    <a href="?<?= http_build_query($queryParams) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;">&larr; Previous</a>
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
                    <a href="?<?= http_build_query($queryParams) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;">Next &rarr;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
