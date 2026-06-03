<?php
session_start();
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/reservas.php';

$error = '';
$success = '';
$users = ensure_admin_users();

function admin_csrf_token() {
    if (empty($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf'];
}

function admin_check_csrf() {
    return isset($_POST['csrf']) && hash_equals($_SESSION['admin_csrf'] ?? '', $_POST['csrf']);
}

function admin_current_user($users) {
    $username = $_SESSION['admin_user'] ?? '';
    foreach ($users as $user) {
        if (($user['username'] ?? '') === $username) {
            return $user;
        }
    }

    return null;
}

function admin_find_user($users, $username) {
    foreach ($users as $user) {
        if (($user['username'] ?? '') === $username) {
            return $user;
        }
    }

    return null;
}

function admin_clean_text($value, $max = 500) {
    $value = trim((string) $value);
    return mb_substr($value, 0, $max);
}

function admin_upload_image($field, $prefix, $current) {
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $current;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return $current;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $info = @getimagesize($tmp);
    if (!$info || empty($info['mime'])) {
        return $current;
    }

    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($extensions[$info['mime']])) {
        return $current;
    }

    if (($_FILES[$field]['size'] ?? 0) > 5 * 1024 * 1024) {
        return $current;
    }

    $dir = __DIR__ . '/assets/img/admin';
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $filename = preg_replace('/[^a-z0-9-]+/', '-', strtolower($prefix));
    $filename = trim($filename, '-') . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $extensions[$info['mime']];
    $target = $dir . '/' . $filename;

    if (!move_uploaded_file($tmp, $target)) {
        return $current;
    }

    return 'assets/img/admin/' . $filename;
}

function admin_content_payload($site, $dishShowcase, $menuItems) {
    $content = [
        'site' => [
            'hero_image' => $site['hero_image'] ?? '',
            'promo_image' => $site['promo_image'] ?? '',
            'location_image' => $site['location_image'] ?? '',
        ],
        'dishShowcase' => array_values($dishShowcase),
        'menuItems' => array_values($menuItems),
    ];

    $content['site']['hero_image'] = admin_upload_image('site_hero_image', 'portada', $content['site']['hero_image']);
    $content['site']['promo_image'] = admin_upload_image('site_promo_image', 'banda-promocional', $content['site']['promo_image']);
    $content['site']['location_image'] = admin_upload_image('site_location_image', 'visitanos', $content['site']['location_image']);

    $postedShowcase = $_POST['showcase'] ?? [];
    foreach ($content['dishShowcase'] as $index => &$item) {
        $posted = $postedShowcase[$index] ?? [];
        $item['title'] = admin_clean_text($posted['title'] ?? $item['title'] ?? '', 90);
        $item['text'] = admin_clean_text($posted['text'] ?? $item['text'] ?? '', 420);
        $item['alt'] = admin_clean_text($posted['alt'] ?? $item['alt'] ?? '', 150);
        $item['image'] = admin_upload_image('showcase_image_' . $index, 'identidad-' . ($index + 1), $item['image'] ?? '');
    }
    unset($item);

    $postedMenu = $_POST['menu'] ?? [];
    foreach ($content['menuItems'] as $index => &$item) {
        $posted = $postedMenu[$index] ?? [];
        $item['name'] = admin_clean_text($posted['name'] ?? $item['name'] ?? '', 90);
        $item['tag'] = admin_clean_text($posted['tag'] ?? $item['tag'] ?? '', 40);
        $item['desc'] = admin_clean_text($posted['desc'] ?? $item['desc'] ?? '', 420);
        $item['alt'] = admin_clean_text($posted['alt'] ?? $item['alt'] ?? '', 150);
        $item['image'] = admin_upload_image('menu_image_' . $index, 'carta-' . ($index + 1), $item['image'] ?? '');
    }
    unset($item);

    return $content;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $username = admin_clean_text($_POST['username'] ?? '', 60);
    $password = (string) ($_POST['password'] ?? '');
    $user = admin_find_user($users, $username);

    if ($user && !empty($user['active']) && password_verify($password, $user['password_hash'] ?? '')) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_user'] = $user['username'];
        admin_csrf_token();
        header('Location: admin.php');
        exit;
    }

    $error = 'Usuario o clave incorrectos.';
}

$logged = !empty($_SESSION['admin_logged']) && admin_current_user($users);

if ($logged && $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') !== 'login') {
    if (!admin_check_csrf()) {
        $error = 'La sesion expiro. Vuelve a intentar.';
    } elseif (($_POST['action'] ?? '') === 'update_status' && isset($_POST['estado'], $_POST['id'])) {
        $reservas = read_reservas();
        foreach ($reservas as &$reserva) {
            if ($reserva['id'] === $_POST['id']) {
                $reserva['estado'] = in_array($_POST['estado'], ['Pendiente', 'Confirmada', 'Cancelada'], true) ? $_POST['estado'] : 'Pendiente';
                break;
            }
        }
        unset($reserva);
        save_reservas($reservas);
        header('Location: admin.php?ok=estado');
        exit;
    } elseif (($_POST['action'] ?? '') === 'save_content') {
        $content = admin_content_payload($site, $dishShowcase, $menuItems);
        save_content_config($content);
        header('Location: admin.php?ok=contenido');
        exit;
    } elseif (($_POST['action'] ?? '') === 'add_user') {
        $username = strtolower(preg_replace('/[^a-z0-9_.-]+/', '', admin_clean_text($_POST['new_username'] ?? '', 40)));
        $name = admin_clean_text($_POST['new_name'] ?? '', 80);
        $password = (string) ($_POST['new_password'] ?? '');

        if (!$username || strlen($password) < 8) {
            $error = 'El usuario es obligatorio y la clave debe tener minimo 8 caracteres.';
        } elseif (admin_find_user($users, $username)) {
            $error = 'Ese usuario ya existe.';
        } else {
            $users[] = [
                'username' => $username,
                'name' => $name ?: $username,
                'role' => 'admin',
                'active' => true,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ];
            save_admin_users($users);
            header('Location: admin.php?ok=usuario');
            exit;
        }
    } elseif (($_POST['action'] ?? '') === 'toggle_user') {
        $target = admin_clean_text($_POST['username'] ?? '', 60);
        foreach ($users as &$user) {
            if (($user['username'] ?? '') === $target && $target !== ($_SESSION['admin_user'] ?? '')) {
                $user['active'] = empty($user['active']);
                break;
            }
        }
        unset($user);
        save_admin_users($users);
        header('Location: admin.php?ok=usuario');
        exit;
    } elseif (($_POST['action'] ?? '') === 'change_password') {
        $target = admin_clean_text($_POST['username'] ?? '', 60);
        $password = (string) ($_POST['password'] ?? '');
        if (strlen($password) < 8) {
            $error = 'La nueva clave debe tener minimo 8 caracteres.';
        } else {
            foreach ($users as &$user) {
                if (($user['username'] ?? '') === $target) {
                    $user['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                    break;
                }
            }
            unset($user);
            save_admin_users($users);
            header('Location: admin.php?ok=usuario');
            exit;
        }
    }
}

if (isset($_GET['ok'])) {
    $messages = [
        'estado' => 'Estado de reserva actualizado.',
        'contenido' => 'Contenido de la web actualizado.',
        'usuario' => 'Usuarios actualizados.',
    ];
    $success = $messages[$_GET['ok']] ?? '';
}

$users = ensure_admin_users();
$logged = !empty($_SESSION['admin_logged']) && admin_current_user($users);
$currentUser = $logged ? admin_current_user($users) : null;
$reservas = $logged ? read_reservas() : [];
$total = count($reservas);
$pendientes = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Pendiente'));
$confirmadas = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Confirmada'));
$canceladas = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Cancelada'));
$csrf = admin_csrf_token();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel administrador | <?= h($site['name']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="admin-body">
    <main class="admin-shell">
        <?php if (!$logged): ?>
            <section class="login-card">
                <img src="assets/img/logo-don-felix-vino-profesional.png" alt="Logo Don Felix">
                <h1>Panel administrador</h1>
                <p>Ingresa con un usuario autorizado. La clave se guarda cifrada.</p>
                <?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <label>Usuario
                        <input type="text" name="username" placeholder="admin" required autocomplete="username">
                    </label>
                    <label>Clave de acceso
                        <input type="password" name="password" placeholder="Clave demo" required autocomplete="current-password">
                    </label>
                    <button class="btn btn-primary full" type="submit">Ingresar</button>
                </form>
                <a class="back-link" href="index.php">Volver a la web</a>
            </section>
        <?php else: ?>
            <section class="admin-panel">
                <div class="admin-top">
                    <div>
                        <span class="eyebrow">Panel PHP</span>
                        <h1>Administracion Don Felix</h1>
                        <p>Reservas, contenido editable y usuarios autorizados.</p>
                        <small>Sesion: <?= h($currentUser['name'] ?? $currentUser['username'] ?? '') ?></small>
                    </div>
                    <div class="admin-actions">
                        <a class="btn btn-outline dark" href="index.php">Ver web</a>
                        <a class="btn btn-primary" href="admin.php?logout=1">Salir</a>
                    </div>
                </div>

                <?php if ($success): ?><div class="alert success"><?= h($success) ?></div><?php endif; ?>
                <?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>

                <div class="admin-section">
                    <div class="admin-section-title">
                        <span class="eyebrow">Reservas</span>
                        <h2>Reservas recibidas</h2>
                    </div>

                    <div class="stats-grid">
                        <article><span>Total</span><strong><?= $total ?></strong></article>
                        <article><span>Pendientes</span><strong><?= $pendientes ?></strong></article>
                        <article><span>Confirmadas</span><strong><?= $confirmadas ?></strong></article>
                        <article><span>Canceladas</span><strong><?= $canceladas ?></strong></article>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Telefono</th>
                                    <th>Personas</th>
                                    <th>Servicio</th>
                                    <th>Fecha y hora</th>
                                    <th>Mensaje</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!$reservas): ?>
                                    <tr><td colspan="7" class="empty">Aun no hay reservas registradas.</td></tr>
                                <?php endif; ?>
                                <?php foreach ($reservas as $reserva): ?>
                                    <tr>
                                        <td><?= h($reserva['nombre'] ?? '') ?><small><?= h($reserva['fecha_registro'] ?? '') ?></small></td>
                                        <td><?= h($reserva['telefono'] ?? '') ?></td>
                                        <td><?= h($reserva['personas'] ?? '') ?></td>
                                        <td><?= h($reserva['servicio'] ?? '') ?></td>
                                        <td><?= h(($reserva['fecha_visita'] ?? '') . ' ' . ($reserva['hora'] ?? '')) ?></td>
                                        <td><?= h($reserva['mensaje'] ?? '') ?></td>
                                        <td>
                                            <form method="POST" class="status-form">
                                                <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="id" value="<?= h($reserva['id'] ?? '') ?>">
                                                <select name="estado" onchange="this.form.submit()">
                                                    <?php foreach (['Pendiente', 'Confirmada', 'Cancelada'] as $estado): ?>
                                                        <option value="<?= h($estado) ?>" <?= (($reserva['estado'] ?? '') === $estado) ? 'selected' : '' ?>><?= h($estado) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form class="admin-section admin-edit-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                    <input type="hidden" name="action" value="save_content">

                    <div class="admin-section-title">
                        <span class="eyebrow">Contenido web</span>
                        <h2>Imagenes y textos editables</h2>
                        <p>Formatos permitidos: JPG, PNG o WEBP. Peso maximo recomendado: 5 MB.</p>
                    </div>

                    <div class="admin-editor-grid">
                        <article class="admin-editor-card admin-editor-card-wide">
                            <h3>Imagen de portada</h3>
                            <img src="<?= h($site['hero_image']) ?>" alt="Portada actual">
                            <p>Recomendado: 1600 x 1000 px para escritorio, buen encuadre central para celular.</p>
                            <input type="file" name="site_hero_image" accept="image/jpeg,image/png,image/webp">
                        </article>

                        <article class="admin-editor-card admin-editor-card-wide">
                            <h3>Visitanos en Arequipa</h3>
                            <img src="<?= h($site['location_image']) ?>" alt="Imagen de ubicacion actual">
                            <p>Recomendado: 1400 x 900 px.</p>
                            <input type="file" name="site_location_image" accept="image/jpeg,image/png,image/webp">
                        </article>

                        <article class="admin-editor-card admin-editor-card-wide">
                            <h3>Banda promocional</h3>
                            <img src="<?= h($site['promo_image']) ?>" alt="Imagen promocional actual">
                            <p>Recomendado: 1200 x 800 px, con el sujeto principal centrado.</p>
                            <input type="file" name="site_promo_image" accept="image/jpeg,image/png,image/webp">
                        </article>
                    </div>

                    <div class="admin-section-title compact">
                        <span class="eyebrow">3 destacados</span>
                        <h2>Platos y bebidas con identidad Don Felix</h2>
                    </div>

                    <div class="admin-editor-grid">
                        <?php foreach ($dishShowcase as $index => $item): ?>
                            <article class="admin-editor-card">
                                <h3>Destacado <?= $index + 1 ?></h3>
                                <img src="<?= h($item['image'] ?? '') ?>" alt="<?= h($item['alt'] ?? '') ?>">
                                <label>Titulo
                                    <input type="text" name="showcase[<?= $index ?>][title]" value="<?= h($item['title'] ?? '') ?>" maxlength="90">
                                </label>
                                <label>Texto
                                    <textarea name="showcase[<?= $index ?>][text]" rows="4" maxlength="420"><?= h($item['text'] ?? '') ?></textarea>
                                </label>
                                <label>Texto alternativo
                                    <input type="text" name="showcase[<?= $index ?>][alt]" value="<?= h($item['alt'] ?? '') ?>" maxlength="150">
                                </label>
                                <p>Recomendado: 900 x 650 px.</p>
                                <input type="file" name="showcase_image_<?= $index ?>" accept="image/jpeg,image/png,image/webp">
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="admin-section-title compact">
                        <span class="eyebrow">Carta destacada</span>
                        <h2>Opciones principales de la carta</h2>
                    </div>

                    <div class="admin-editor-grid">
                        <?php foreach ($menuItems as $index => $item): ?>
                            <article class="admin-editor-card">
                                <h3>Plato <?= $index + 1 ?></h3>
                                <img src="<?= h($item['image'] ?? '') ?>" alt="<?= h($item['alt'] ?? '') ?>">
                                <label>Nombre
                                    <input type="text" name="menu[<?= $index ?>][name]" value="<?= h($item['name'] ?? '') ?>" maxlength="90">
                                </label>
                                <label>Etiqueta
                                    <input type="text" name="menu[<?= $index ?>][tag]" value="<?= h($item['tag'] ?? '') ?>" maxlength="40">
                                </label>
                                <label>Descripcion
                                    <textarea name="menu[<?= $index ?>][desc]" rows="4" maxlength="420"><?= h($item['desc'] ?? '') ?></textarea>
                                </label>
                                <label>Texto alternativo
                                    <input type="text" name="menu[<?= $index ?>][alt]" value="<?= h($item['alt'] ?? '') ?>" maxlength="150">
                                </label>
                                <p>Recomendado: 900 x 700 px.</p>
                                <input type="file" name="menu_image_<?= $index ?>" accept="image/jpeg,image/png,image/webp">
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <button class="btn btn-primary full" type="submit">Guardar cambios de la web</button>
                </form>

                <div class="admin-section">
                    <div class="admin-section-title">
                        <span class="eyebrow">Seguridad</span>
                        <h2>Usuarios autorizados</h2>
                        <p>Las claves se guardan con hash seguro de PHP, no como texto visible.</p>
                    </div>

                    <div class="admin-users-grid">
                        <form class="admin-user-card" method="POST">
                            <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                            <input type="hidden" name="action" value="add_user">
                            <h3>Agregar usuario</h3>
                            <label>Usuario
                                <input type="text" name="new_username" required maxlength="40" placeholder="ej. cocina">
                            </label>
                            <label>Nombre
                                <input type="text" name="new_name" maxlength="80" placeholder="Nombre visible">
                            </label>
                            <label>Clave inicial
                                <input type="password" name="new_password" required minlength="8" autocomplete="new-password">
                            </label>
                            <button class="btn btn-primary full" type="submit">Crear usuario</button>
                        </form>

                        <?php foreach ($users as $user): ?>
                            <article class="admin-user-card">
                                <h3><?= h($user['name'] ?? $user['username'] ?? '') ?></h3>
                                <p><strong>Usuario:</strong> <?= h($user['username'] ?? '') ?></p>
                                <p><strong>Estado:</strong> <?= !empty($user['active']) ? 'Activo' : 'Inactivo' ?></p>
                                <form method="POST">
                                    <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                                    <input type="hidden" name="action" value="change_password">
                                    <input type="hidden" name="username" value="<?= h($user['username'] ?? '') ?>">
                                    <label>Nueva clave
                                        <input type="password" name="password" minlength="8" autocomplete="new-password">
                                    </label>
                                    <button class="btn btn-outline dark full" type="submit">Cambiar clave</button>
                                </form>
                                <?php if (($user['username'] ?? '') !== ($_SESSION['admin_user'] ?? '')): ?>
                                    <form method="POST">
                                        <input type="hidden" name="csrf" value="<?= h($csrf) ?>">
                                        <input type="hidden" name="action" value="toggle_user">
                                        <input type="hidden" name="username" value="<?= h($user['username'] ?? '') ?>">
                                        <button class="btn btn-ghost full" type="submit"><?= !empty($user['active']) ? 'Desactivar' : 'Activar' ?></button>
                                    </form>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
