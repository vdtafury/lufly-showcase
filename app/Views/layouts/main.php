<?php
declare(strict_types=1);

$htmlLang = $htmlLang ?? 'tr';
?>
<!DOCTYPE html>
<html lang="<?= $htmlLang ?>">
<head>
    <?php require __DIR__ . '/meta.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>

    <main id="main-content">
        <?= $content ?>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>
</body>
</html>
