<?php require_once __DIR__ . '/includes/data.php'; ?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main>
    <section class="hero hero-restaurant" id="inicio">
        <div class="hero-bg"></div>
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="eyebrow">Picantería arequipeña</span>
                <h1><?= h($site['name']) ?></h1>
                <p>
                    Tradición, sabor y platos especiales en Arequipa. Revisa la carta completa,
                    reserva tu mesa o escríbenos directamente por WhatsApp.
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#carta">Ver carta</a>
                    <a class="btn btn-outline" href="#reservas">Reservar mesa</a>
                    <a class="btn btn-ghost" href="<?= h(whatsapp_link($site)) ?>" target="_blank" rel="noopener">WhatsApp</a>
                </div>
                <div class="hero-info">
                    <span><?= h($site['phone']) ?></span>
                    <span><?= h($site['address']) ?></span>
                </div>
            </div>
            <div class="hero-card reveal delay-1">
                <img src="<?= h($site['hero_image']) ?>" alt="Fachada de Picantería Don Félix">
                <div class="hero-card-badge">
                    <strong>Arequipa</strong>
                    <span>Nueva imagen, platos reales y sabor tradicional</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section about" id="tradicion">
        <div class="container two-col">
            <div class="section-copy reveal">
                <span class="eyebrow">Nuestra esencia</span>
                <h2>Una picanteria con platos reales, servicio cercano y sabor de barrio.</h2>
                <p>
                    Don Felix combina recetas arequipenas, porciones generosas y una presentacion
                    que conserva el espiritu de la picanteria tradicional. Esta version de la web
                    muestra platos y escenas reales del local para transmitir mejor la experiencia.
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

    <section class="section showcase-section">
        <div class="container">
            <div class="section-title reveal">
                <span class="eyebrow">Especialidades</span>
                <h2>Platos y bebidas con identidad Don Felix</h2>
                <p>
                    Seleccionamos imagenes reales del restaurante para destacar especialidades,
                    piqueos y bebidas que refuerzan la identidad de la casa.
                </p>
            </div>
            <div class="showcase-grid">
                <?php foreach ($dishShowcase as $item): ?>
                    <article class="showcase-card reveal">
                        <img src="<?= h($item['image']) ?>" alt="<?= h($item['alt']) ?>">
                        <div class="showcase-copy">
                            <h3><?= h($item['title']) ?></h3>
                            <p><?= h($item['text']) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section menu-section" id="carta">
        <div class="container">
            <div class="section-title reveal">
                <span class="eyebrow">Carta 2026</span>
                <h2>Explora la carta Don Félix</h2>
                <p>
                    Visualiza la carta en un visor compacto y responsive dentro de la página. También puedes abrirla en Google Drive
                    o descargar el PDF para verla completa.
                </p>
                <div class="menu-actions">
                    <a class="btn btn-primary" href="<?= h($site['menu_drive_url']) ?>" target="_blank" rel="noopener">Abrir carta en Drive</a>
                    <a class="btn btn-outline dark" href="<?= h($site['menu_pdf_url']) ?>" target="_blank" rel="noopener">Ver PDF local</a>
                </div>
            </div>

            <div class="menu-viewer drive-menu-viewer reveal" aria-label="Visor de carta desde Google Drive">
                <div class="viewer-top drive-viewer-top">
                    <div>
                        <span class="eyebrow">Vista desde Google Drive</span>
                        <h3>Carta completa Don Félix</h3>
                        <p class="viewer-help">
                            La carta se muestra desde Google Drive en un visor ajustado para computadora, tablet y celular.
                            Usa la barra del visor para bajar, cambiar de página o ampliar el documento sin hacer larga toda la página.
                        </p>
                    </div>
                    <a class="btn btn-primary" href="<?= h($site['menu_drive_url']) ?>" target="_blank" rel="noopener">
                        Abrir en Drive
                    </a>
                </div>

                <div class="drive-document-frame">
                    <iframe
                        src="<?= h($site['menu_drive_preview_url']) ?>"
                        title="Carta completa Picantería Don Félix"
                        loading="lazy"
                        allow="autoplay"
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="drive-viewer-note">
                    <strong>Nota:</strong> si el visor no carga en algún navegador, usa el botón
                    <a href="<?= h($site['menu_drive_url']) ?>" target="_blank" rel="noopener">Abrir en Drive</a>
                    o revisa el PDF local.
                </div>
            </div>

            <div class="section-title section-title-small reveal">
                <span class="eyebrow">Platos destacados</span>
                <h2>Opciones principales de la carta</h2>
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
            <img src="<?= h($site['promo_image']) ?>" alt="Chicha de guiñapo servida en Don Félix">
            <div>
                <span class="eyebrow">Experiencia real</span>
                <h2>Platos tradicionales, chicha de guiñapo y un local listo para recibirte.</h2>
                <p>La web ahora se apoya en fotos reales del restaurante para mostrar mejor el ambiente y las especialidades de la casa.</p>
            </div>
            <a class="btn btn-light" href="#ubicacion">Ver ubicación</a>
        </div>
    </section>

    <section class="section reservation" id="reservas">
        <div class="container reservation-grid">
            <div class="section-copy reveal">
                <span class="eyebrow">Reservas</span>
                <h2>Reserva tu mesa en Don Félix</h2>
                <p>
                    Completa el formulario con tus datos, fecha y hora. La reserva queda registrada
                    y puede revisarse desde el panel administrador del proyecto.
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
                    <label>Plato o servicio de interés
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
                <img src="<?= h($site['location_image']) ?>" alt="Fachada del nuevo local de Picantería Don Félix">
            </div>
            <div class="section-copy reveal delay-1">
                <span class="eyebrow">Nueva ubicación</span>
                <h2>Visítanos en Arequipa</h2>
                <p><?= h($site['address']) ?></p>
                <p>
                    El nuevo local mantiene una atmosfera calida y familiar, ideal para almuerzos,
                    reuniones y domingos de picanteria.
                </p>
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
                <h2>Platos reales y escenas del restaurante</h2>
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

