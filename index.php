<?php require_once __DIR__ . '/includes/data.php'; ?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main>
    <section class="hero" id="inicio">
        <div class="hero-bg"></div>
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="eyebrow">Picantería arequipeña</span>
                <h1><?= h($site['name']) ?></h1>
                <p><?= h($site['tagline']) ?>.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#reservas">Reservar mesa</a>
                    <a class="btn btn-outline" href="<?= h(whatsapp_link($site)) ?>" target="_blank" rel="noopener">Consultar por WhatsApp</a>
                </div>
                <div class="hero-info">
                    <span><?= h($site['phone']) ?></span>
                    <span><?= h($site['address']) ?></span>
                </div>
            </div>
            <div class="hero-card reveal delay-1">
                <img src="assets/img/fachada-don-felix.png" alt="Fachada de Picantería Don Félix">
                <div class="hero-card-badge">
                    <strong>Arequipa</strong>
                    <span>Almuerzos y especiales</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section about" id="tradicion">
        <div class="container two-col">
            <div class="section-copy reveal">
                <span class="eyebrow">Nuestra esencia</span>
                <h2>Una página web para mostrar tradición, ubicación y reservas.</h2>
                <p>
                    Este sitio está pensado para que la picantería tenga presencia digital clara: presentación del local,
                    carta editable, botón de WhatsApp, mapa de ubicación y formulario de reservas conectado con PHP.
                </p>
            </div>
            <div class="highlight-grid reveal delay-1">
                <?php foreach ($highlights as $item): ?>
                    <article class="highlight-card">
                        <h3><?= h($item['title']) ?></h3>
                        <p><?= h($item['text']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section menu-section" id="carta">
        <div class="container">
            <div class="section-title reveal">
                <span class="eyebrow">Carta referencial</span>
                <h2>Platos para destacar en la web</h2>
                <p>Los precios y nombres se pueden editar fácilmente desde el archivo <strong>includes/data.php</strong>.</p>
            </div>
            <div class="menu-grid">
                <?php foreach ($menuItems as $item): ?>
                    <article class="menu-card reveal">
                        <div class="tag"><?= h($item['tag']) ?></div>
                        <h3><?= h($item['name']) ?></h3>
                        <p><?= h($item['desc']) ?></p>
                        <div class="menu-card-footer">
                            <strong><?= h($item['price']) ?></strong>
                            <a href="#reservas">Reservar</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section promo-band">
        <div class="container promo-content reveal">
            <img src="assets/img/logo-don-felix.png" alt="Logo Don Félix">
            <div>
                <span class="eyebrow">Hecho para portafolio</span>
                <h2>PHP + diseño responsive + formulario funcional</h2>
                <p>Una web distinta al proyecto SmartBusiness: más comercial, visual y orientada a un negocio real.</p>
            </div>
            <a class="btn btn-light" href="#ubicacion">Ver ubicación</a>
        </div>
    </section>

    <section class="section reservation" id="reservas">
        <div class="container reservation-grid">
            <div class="section-copy reveal">
                <span class="eyebrow">Reservas</span>
                <h2>Formulario de reserva con PHP</h2>
                <p>
                    El formulario guarda las reservas en <strong>data/reservas.csv</strong> y luego pueden revisarse desde
                    el panel administrador.
                </p>
                <div class="contact-card">
                    <strong>También puedes reservar por WhatsApp</strong>
                    <a href="<?= h(whatsapp_link($site, 'Hola, quiero reservar una mesa en Picantería Don Félix.')) ?>" target="_blank" rel="noopener">
                        <?= h($site['phone']) ?>
                    </a>
                </div>
            </div>

            <form class="reservation-form reveal delay-1" action="actions/guardar_reserva.php" method="POST">
                <?php if (($_GET['reserva'] ?? '') === 'ok'): ?>
                    <div class="alert success">Reserva registrada correctamente. Revisa el panel administrador o confirma por WhatsApp.</div>
                <?php elseif (($_GET['reserva'] ?? '') === 'error'): ?>
                    <div class="alert error">Revisa los campos del formulario. Hay datos incompletos o incorrectos.</div>
                <?php elseif (($_GET['reserva'] ?? '') === 'save_error'): ?>
                    <div class="alert error">No se pudo guardar la reserva. Verifica permisos de escritura en la carpeta data.</div>
                <?php endif; ?>

                <div class="form-row">
                    <label>Nombre completo
                        <input type="text" name="nombre" placeholder="Ej. Luis Mamani" required minlength="3">
                    </label>
                    <label>Teléfono
                        <input type="tel" name="telefono" placeholder="Ej. 944 199 446" required>
                    </label>
                </div>

                <div class="form-row">
                    <label>Número de personas
                        <input type="number" name="personas" min="1" max="30" value="2" required>
                    </label>
                    <label>Servicio o plato de interés
                        <select name="servicio" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($menuItems as $item): ?>
                                <option value="<?= h($item['name']) ?>"><?= h($item['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="form-row">
                    <label>Fecha
                        <input type="date" name="fecha" required data-today>
                    </label>
                    <label>Hora
                        <input type="time" name="hora" required>
                    </label>
                </div>

                <label>Mensaje adicional
                    <textarea name="mensaje" rows="4" placeholder="Ej. Mesa familiar, cumpleaños, consulta de platos..."></textarea>
                </label>

                <button class="btn btn-primary full" type="submit">Enviar reserva</button>
            </form>
        </div>
    </section>

    <section class="section location" id="ubicacion">
        <div class="container location-grid">
            <div class="map-card reveal">
                <img src="assets/img/mapa-don-felix.png" alt="Mapa de ubicación de Picantería Don Félix">
            </div>
            <div class="section-copy reveal delay-1">
                <span class="eyebrow">Nueva ubicación</span>
                <h2>Visítanos en Arequipa</h2>
                <p><?= h($site['address']) ?></p>
                <div class="location-actions">
                    <a class="btn btn-primary" href="<?= h($site['maps_url']) ?>" target="_blank" rel="noopener">Abrir en Google Maps</a>
                    <a class="btn btn-outline dark" href="tel:<?= h(str_replace(' ', '', $site['phone'])) ?>">Llamar ahora</a>
                </div>
                <div class="mini-info">
                    <div><strong>Teléfono</strong><span><?= h($site['phone']) ?></span></div>
                    <div><strong>Horario</strong><span><?= h($site['hours']) ?></span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section gallery-section">
        <div class="container">
            <div class="section-title reveal">
                <span class="eyebrow">Galería</span>
                <h2>Identidad visual del proyecto</h2>
            </div>
            <div class="gallery-grid">
                <?php foreach ($gallery as $image): ?>
                    <figure class="gallery-item reveal">
                        <img src="<?= h($image['src']) ?>" alt="<?= h($image['alt']) ?>">
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
