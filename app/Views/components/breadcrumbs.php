<?php
declare(strict_types=1);

use App\Helpers\Security;

if (empty($breadcrumbs)) return;
?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <div class="l-container">
        <ol class="breadcrumb-list">
            <li>
                <a href="/">Home</a>
            </li>
            <?php 
            $keys = array_keys($breadcrumbs);
            $lastIndex = count($keys) - 1;
            $i = 0;
            foreach ($breadcrumbs as $name => $url): 
                $isLast = ($i === $lastIndex);
            ?>
                <li class="breadcrumb-separator" aria-hidden="true">/</li>
                <li>
                    <?php if ($isLast): ?>
                        <span class="breadcrumb-current" aria-current="page"><?= Security::e($name) ?></span>
                    <?php else: ?>
                        <a href="<?= Security::e($url) ?>"><?= Security::e($name) ?></a>
                    <?php endif; ?>
                </li>
            <?php 
                $i++;
            endforeach; 
            ?>
        </ol>
    </div>
</nav>
