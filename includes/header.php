<?php require_once __DIR__ . '/data.php'; ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($site['meta_title'] ?? ($site['name'] . ' | Tradicion arequipena en Arequipa')) ?></title>
    <meta name="description" content="<?= h($site['meta_description'] ?? ($site['name'] . ': tradicion arequipena, carta completa, reservas y ubicacion en Arequipa.')) ?>">
    <meta name="theme-color" content="#8f151b">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= h($site['meta_title'] ?? $site['name']) ?>">
    <meta property="og:description" content="<?= h($site['meta_description'] ?? '') ?>">
    <meta property="og:image" content="<?= h($site['meta_image'] ?? $site['hero_image']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" type="image/png" href="<?= h($site['favicon'] ?? 'assets/img/logo-don-felix.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="site-header" id="top">
    <div class="container nav-wrap">
        <a class="brand brand-transparent" href="index.php#inicio" aria-label="Ir al inicio">
            <img src="assets/img/logo-don-felix-vino-profesional.png" alt="Logo Picanteria Don Felix">
        </a>

        <button class="menu-toggle" type="button" aria-label="Abrir menu" data-menu-toggle>
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" data-main-nav>
            <?php foreach ($navItems as $item): ?>
                <a href="<?= h($item['href']) ?>"><?= h($item['label']) ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>



