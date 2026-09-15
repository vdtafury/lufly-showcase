<?php
declare(strict_types=1);

use App\Helpers\Security;

/** @var array $category */
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
        <!-- Collection Header -->
        <div style="border-bottom: 1px solid var(--c-divider); padding-bottom: 2.5rem; margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 720px;">
                <span class="section-eyebrow">Product Classification &bull; <?= (int)$total ?> Certified Models</span>
                <h1 class="display-title" style="font-size: clamp(2.2rem, 3.5vw, 3.25rem); margin-top: 0.35rem;">
                    <?= Security::e($category['name']) ?>
                </h1>
                <p style="color: var(--c-muted); font-size: 1.0625rem; margin-top: 0.85rem; line-height: 1.6;">
                    <?= Security::e($category['description']) ?>
                </p>
            </div>

            <!-- Sort Controls -->
            <form method="GET" action="/collections/<?= Security::e($category['slug']) ?>" style="display: flex; align-items: center; gap: 0.75rem;">
                <label for="sort-select" style="font-size: 0.8125rem; font-family: var(--font-mono); color: var(--c-muted); text-transform: uppercase;">Sort By:</label>
                <select id="sort-select" name="sort" onchange="this.form.submit()" class="form-control" style="width: auto; padding: 0.5rem 0.85rem; font-size: 0.8125rem;">
                    <option value="default" <?= $sort === 'default' ? 'selected' : '' ?>>Featured &bull; Default</option>
                    <option value="sku-asc" <?= $sort === 'sku-asc' ? 'selected' : '' ?>>SKU Code (A &rarr; Z)</option>
                    <option value="name-asc" <?= $sort === 'name-asc' ? 'selected' : '' ?>>Model Name (A &rarr; Z)</option>
                    <option value="price-asc" <?= $sort === 'price-asc' ? 'selected' : '' ?>>Price (Low &rarr; High)</option>
                    <option value="price-desc" <?= $sort === 'price-desc' ? 'selected' : '' ?>>Price (High &rarr; Low)</option>
                </select>
            </form>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div style="padding: 4rem 1.5rem; text-align: center; background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md);">
                <h3 style="font-size: 1.25rem; color: var(--c-obsidian);">No models found in this collection.</h3>
                <p style="color: var(--c-muted); margin-top: 0.5rem;">Try selecting a different architectural collection or browse the complete catalog.</p>
                <a href="/products" class="btn btn-primary" style="margin-top: 1.5rem;">Browse All Products</a>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
                <?php foreach ($products as $p): ?>
                    <?php require __DIR__ . '/components/product-card.php'; ?>
                <?php endforeach; ?>
            </div>

            <!-- SSR Pagination -->
            <?php if ($totalPages > 1): ?>
                <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-top: 4rem;">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&sort=<?= Security::e($sort) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;">&larr; Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="btn btn-primary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem; min-width: 38px;"><?= $i ?></span>
                        <?php elseif ($i <= 3 || $i >= $totalPages - 1 || abs($i - $page) <= 1): ?>
                            <a href="?page=<?= $i ?>&sort=<?= Security::e($sort) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem; min-width: 38px;"><?= $i ?></a>
                        <?php elseif ($i == 4 && $page > 4): ?>
                            <span style="padding: 0.5rem; color: var(--c-muted);">&hellip;</span>
                        <?php elseif ($i == $totalPages - 2 && $page < $totalPages - 3): ?>
                            <span style="padding: 0.5rem; color: var(--c-muted);">&hellip;</span>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?>&sort=<?= Security::e($sort) ?>" class="btn btn-secondary" style="padding: 0.5rem 0.85rem; font-size: 0.8125rem;">Next &rarr;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
