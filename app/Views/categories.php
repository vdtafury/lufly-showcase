<?php
declare(strict_types=1);

use App\Helpers\I18n;
use App\Helpers\Security;

/** @var array $categories */
/** @var array $breadcrumbs */
$loc = I18n::getLocale();
?>

<?php require __DIR__ . '/components/breadcrumbs.php'; ?>

<section style="padding: 2.5rem 0 5rem;">
    <div class="l-container">
        <div style="margin-bottom: 3.5rem; max-width: 780px;">
            <span class="section-eyebrow"><?= $loc === 'tr' ? 'Mimari Sınıflandırma' : ($loc === 'cs' ? 'Architektonická klasifikace' : 'Architectural Classifications') ?></span>
            <h1 class="display-title" style="margin-top: 0.5rem;"><?= I18n::t('nav_collections') ?></h1>
            <p style="color: var(--c-muted); font-size: 1.125rem; margin-top: 1rem; line-height: 1.65;">
                <?= $loc === 'tr' ? 'Lufly\'nin yüksek mühendislikle üretilmiş tüm vitrifiye seramik koleksiyonlarını keşfedin. Aerodinamik kanalsız asma klozetlerden çanak lavabolara ve temassız fotoselli armatürlere kadar geniş ürün yelpazesi.' : ($loc === 'cs' ? 'Objevte ucelený sortiment precizní sanitární keramiky Lufly. Od aerodynamických závěsných WC mís bez oplachového kruhu po designová umyvadla na desku a bezdotykové systémy.' : 'Explore Lufly\'s full spectrum of precision-engineered sanitary ceramics. From aerodynamic rimless wall-hung WC bowls and architectural vessel basins to touchless commercial sensor fixtures.') ?>
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            <?php foreach ($categories as $cat): ?>
                <div class="category-card">
                    <div class="category-card-header">
                        <div class="category-icon-box">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                        </div>
                        <span class="category-count-badge"><?= (int)$cat['product_count'] ?> <?= I18n::t('models_found') ?></span>
                    </div>
                    <h2 class="category-card-title">
                        <a href="<?= locale_url('/collections/' . $cat['slug']) ?>"><?= Security::e($cat['name']) ?></a>
                    </h2>
                    <p class="category-card-desc"><?= Security::e($cat['description']) ?></p>
                    <div style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--c-divider-subtle); display: flex; justify-content: space-between; align-items: center;">
                        <a href="<?= locale_url('/collections/' . $cat['slug']) ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8125rem;">
                            <span><?= $loc === 'tr' ? 'Koleksiyonu İncele' : ($loc === 'cs' ? 'Zobrazit kolekci' : 'View Collection') ?></span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--c-eucalyptus);">EN 997 / CE</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
