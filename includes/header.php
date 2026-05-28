<?php require_once __DIR__ . '/data.php'; ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($site['name']) ?> | Tradición arequipeña en Arequipa</title>
    <meta name="description" content="<?= h($site['name']) ?>: tradición arequipeña, carta completa, reservas y ubicación en Arequipa.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="site-header" id="top">
    <div class="container nav-wrap">
        <a class="brand brand-transparent" href="index.php#inicio" aria-label="Ir al inicio">
            <img src="assets/img/logo-don-felix-transparente.png" alt="Logo Picantería Don Félix">
        </a>

        <button class="menu-toggle" type="button" aria-label="Abrir menú" data-menu-toggle>
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav" data-main-nav>
            <?php foreach ($navItems as $item): ?>
                <a href="<?= h($item['href']) ?>"><?= h($item['label']) ?></a>
            <?php endforeach; ?>
            <a class="admin-link" href="admin.php">Admin</a>
        </nav>
    </div>
</header>
