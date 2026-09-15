<?php
declare(strict_types=1);

use App\Helpers\I18n;
use App\Helpers\Security;

/** @var string $query */
/** @var array $results */
/** @var int $total */
/** @var array $breadcrumbs */
$loc = I18n::getLocale();
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2rem 0 5rem;">
    <div class="l-container">
        <div style="max-width: 760px; margin-bottom: 3rem;">
            <span class="section-eyebrow"><?= $loc === 'tr' ? 'Veri Tabanı Arama' : ($loc === 'cs' ? 'Vyhledávání v databázi' : 'Database Search') ?></span>
            <h1 class="display-title" id="search-page-title" style="font-size: clamp(2rem, 3.5vw, 3rem); margin-top: 0.35rem;">
                <?= $query !== '' ? (I18n::t('search_results_for') . ' "' . Security::e($query) . '"') : ($loc === 'tr' ? 'Ürün & Model Arama' : ($loc === 'cs' ? 'Vyhledávání produktů' : 'Product & Model Search')) ?>
            </h1>
            <p id="search-page-desc" style="color: var(--c-muted); font-size: 1rem; margin-top: 0.5rem;">
                <?= $query !== '' ? ($loc === 'tr' ? "Arama kriterlerinize uyan {$total} onaylı model bulundu." : ($loc === 'cs' ? "Nalezeno {$total} certifikovaných modelů odpovídajících vašemu dotazu." : "Found {$total} certified models matching your criteria.")) : ($loc === 'tr' ? 'Tüm 282 model arasında ürün kodu (SKU), koleksiyon veya boyutlara göre arama yapabilirsiniz.' : ($loc === 'cs' ? 'Vyhledávejte mezi všemi 282 modely podle kódu SKU, kolekce nebo rozměrů.' : 'Search across all 282 models by factory SKU code, collection, or dimensions.')) ?>
            </p>

            <form method="GET" action="<?= locale_url('/search') ?>" id="search-page-form" style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
                <input type="text" 
                       id="search-page-input"
                       name="q" 
                       value="<?= Security::e($query) ?>" 
                       placeholder="<?= Security::e(I18n::t('search_placeholder')) ?>" 
                       class="form-control" 
                       style="font-size: 1rem; padding: 0.85rem 1.25rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0 1.75rem;">
                    <span><?= I18n::t('search_trigger') ?></span>
                </button>
            </form>
        </div>

        <div id="search-results-container">
            <?php if ($query !== ''): ?>
                <?php if ($total === 0): ?>
                    <div style="background-color: var(--c-white); border: 1px solid var(--c-divider); border-radius: var(--radius-md); padding: 4rem 2rem; text-align: center;">
                        <h3 style="font-size: 1.25rem; color: var(--c-obsidian);"><?= I18n::t('no_results_found') ?></h3>
                        <p style="color: var(--c-muted); margin-top: 0.75rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                            <?= $loc === 'tr' ? 'Lütfen girdiğiniz ürün kodunu (örn. 1620-111 veya 1610-242) kontrol ediniz veya doğrudan mimari koleksiyonlarımızı inceleyiniz.' : ($loc === 'cs' ? 'Zkontrolujte prosím formát kódu SKU (např. 1620-111 nebo 1610-242) nebo si prohlédněte naše kolekce přímo.' : 'Please verify your SKU code formatting or browse our architectural collections directly.') ?>
                        </p>
                        <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                            <a href="<?= locale_url('/products') ?>" class="btn btn-primary"><?= I18n::t('nav_all_products') ?></a>
                            <a href="<?= locale_url('/collections') ?>" class="btn btn-secondary"><?= I18n::t('nav_collections') ?></a>
                        </div>
                    </div>
                <?php else: ?>
                    <div id="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;">
                        <?php foreach ($results as $p): ?>
                            <?php require __DIR__ . '/components/product-card.php'; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div id="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.75rem;"></div>
            <?php endif; ?>
        </div>
    </div>
</section>
