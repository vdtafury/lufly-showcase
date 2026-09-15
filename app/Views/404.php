<?php
declare(strict_types=1);

use App\Helpers\I18n;
use App\Helpers\Security;

/** @var string $errorMessage */
$loc = I18n::getLocale();
?>

<section style="padding: 6rem 0; text-align: center;">
    <div class="l-container" style="max-width: 640px;">
        <span style="font-family: var(--font-mono); font-size: 1rem; color: var(--c-champagne); font-weight: 600; letter-spacing: 0.15em;">ERROR 404 &bull; <?= $loc === 'tr' ? 'SAYFA BULUNAMADI' : ($loc === 'cs' ? 'STRÁNKA NENALEZENA' : 'PAGE NOT FOUND') ?></span>
        <h1 class="display-title" style="margin: 1rem 0; font-size: 3rem;"><?= I18n::t('page_not_found_title') ?></h1>
        <p style="color: var(--c-muted); font-size: 1.0625rem; line-height: 1.6; margin-bottom: 2.5rem;">
            <?= Security::e($errorMessage ?: I18n::t('page_not_found_desc')) ?>
        </p>

        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="<?= locale_url('/') ?>" class="btn btn-primary"><?= I18n::t('back_to_home') ?></a>
            <a href="<?= locale_url('/products') ?>" class="btn btn-secondary"><?= I18n::t('nav_all_products') ?></a>
            <a href="<?= locale_url('/collections') ?>" class="btn btn-secondary"><?= I18n::t('nav_collections') ?></a>
        </div>
    </div>
</section>
