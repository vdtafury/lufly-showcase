<?php
declare(strict_types=1);

use App\Helpers\Security;

/** @var string $errorMessage */
?>

<section style="padding: 6rem 0; text-align: center;">
    <div class="l-container" style="max-width: 640px;">
        <span style="font-family: var(--font-mono); font-size: 1rem; color: var(--c-champagne); font-weight: 600; letter-spacing: 0.15em;">ERROR 404 &bull; SPECIFICATION NOT FOUND</span>
        <h1 class="display-title" style="margin: 1rem 0; font-size: 3rem;">Page Not Found</h1>
        <p style="color: var(--c-muted); font-size: 1.0625rem; line-height: 1.6; margin-bottom: 2.5rem;">
            <?= Security::e($errorMessage ?? 'The requested model, collection, or document could not be located in our production database.') ?>
        </p>

        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="/" class="btn btn-primary">Return to Homepage</a>
            <a href="/products" class="btn btn-secondary">Browse All 282 Models</a>
            <a href="/collections" class="btn btn-secondary">View Collections</a>
        </div>
    </div>
</section>
