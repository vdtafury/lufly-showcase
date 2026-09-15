<?php
declare(strict_types=1);

use App\Helpers\Security;

/** @var string $query */
/** @var array $results */
/** @var int $total */
/** @var array $breadcrumbs */
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <div style="max-width: 760px; margin-bottom: 3rem;">
            <span class="section-eyebrow">Database Search</span>
            <h1 class="display-title" style="font-size: clamp(2rem, 3.5vw, 3rem); margin-top: 0.35rem;">
                <?= $query !== '' ? 'Results for "' . Security::e($query) . '"' : 'Product &amp; Specification Search' ?>
            </h1>
            <p style="color: var(--c-muted); font-size: 1rem; margin-top: 0.5rem;">
                <?= $query !== '' ? "Found {$total} certified models matching your technical search criteria." : 'Search across all 282 models by factory SKU code, collection, or dimensions.' ?>
            </p>

            <form method="GET" action="/search" style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
                <input type="text" 
                       name="q" 
                       value="<?= Security::e($query) ?>" 
                       placeholder="e.g. 1620-111, Washbasin, Mixer, Bidet, 600 mm..." 
                       class="form-control" 
                       style="font-size: 1rem; padding: 0.85rem 1.25rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0 1.75rem;">
                    <span>Search</span>
                </button>
            </form>
        </div>

        <?php if ($query !== ''): ?>
            <?php if ($total === 0): ?>
                <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 4rem 2rem; text-align: center;">
                    <h3 style="font-size: 1.25rem; color: var(--c-obsidian);">No certified models found matching "<?= Security::e($query) ?>"</h3>
                    <p style="color: var(--c-muted); margin-top: 0.75rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                        Please verify your SKU code formatting (e.g. <strong>1620-111</strong> or <strong>1610-242</strong>) or browse our architectural collections directly.
                    </p>
                    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem;">
                        <a href="/products" class="btn btn-primary">Browse All 282 Products</a>
                        <a href="/collections" class="btn btn-secondary">Explore 14 Collections</a>
                    </div>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
                    <?php foreach ($results as $p): ?>
                        <?php require __DIR__ . '/components/product-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
