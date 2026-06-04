<?php require_once __DIR__ . '/data.php'; ?>
<footer class="footer">
    <div class="container footer-grid">
        <div>
            <img class="footer-logo transparent-footer-logo" src="assets/img/logo-don-felix-blanco-profesional.png" alt="Picanteria Don Felix">
            <p><?= h($site['tagline']) ?></p>
        </div>
        <div>
            <h3>Contacto</h3>
            <p><?= h($site['phone']) ?></p>
            <p><?= h($site['address']) ?></p>
        </div>
        <div>
            <h3>Acciones rapidas</h3>
            <a href="<?= h(whatsapp_link($site)) ?>" target="_blank" rel="noopener">Escribir por WhatsApp</a>
            <a href="<?= h($site['maps_url']) ?>" target="_blank" rel="noopener">Abrir ubicacion</a>
            <a href="<?= h($site['menu_drive_url']) ?>" target="_blank" rel="noopener">Ver carta en Drive</a>
            <a class="footer-admin-link" href="admin.php" rel="nofollow">Panel de gestion</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= h($site['name']) ?>. Pagina web desarrollada en PHP.</p>
    </div>
</footer>

<a class="floating-whatsapp" href="<?= h(whatsapp_link($site)) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
    WhatsApp
</a>

<script src="assets/js/main.js"></script>
</body>
</html>


