<?php
session_start();
require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/reservas.php';

$error = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if (hash_equals($site['admin_password'], $_POST['password'])) {
        $_SESSION['admin_logged'] = true;
        header('Location: admin.php');
        exit;
    }
    $error = 'Clave incorrecta.';
}

if (!empty($_SESSION['admin_logged']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['estado'], $_POST['id'])) {
    $reservas = read_reservas();
    foreach ($reservas as &$reserva) {
        if ($reserva['id'] === $_POST['id']) {
            $reserva['estado'] = in_array($_POST['estado'], ['Pendiente', 'Confirmada', 'Cancelada'], true) ? $_POST['estado'] : 'Pendiente';
            break;
        }
    }
    unset($reserva);
    save_reservas($reservas);
    header('Location: admin.php');
    exit;
}

$logged = !empty($_SESSION['admin_logged']);
$reservas = $logged ? read_reservas() : [];
$total = count($reservas);
$pendientes = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Pendiente'));
$confirmadas = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Confirmada'));
$canceladas = count(array_filter($reservas, fn($r) => ($r['estado'] ?? '') === 'Cancelada'));
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de reservas | <?= h($site['name']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="admin-body">
    <main class="admin-shell">
        <?php if (!$logged): ?>
            <section class="login-card">
                <img src="assets/img/logo-don-felix-transparente.png" alt="Logo Don Félix">
                <h1>Panel administrador</h1>
                <p>Ingresa la clave para revisar las reservas registradas.</p>
                <?php if ($error): ?><div class="alert error"><?= h($error) ?></div><?php endif; ?>
                <form method="POST">
                    <label>Clave de acceso
                        <input type="password" name="password" placeholder="Clave demo" required>
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
                        <h1>Reservas recibidas</h1>
                        <p>Gestiona las reservas guardadas en archivo CSV.</p>
                    </div>
                    <div class="admin-actions">
                        <a class="btn btn-outline dark" href="index.php">Ver web</a>
                        <a class="btn btn-primary" href="admin.php?logout=1">Salir</a>
                    </div>
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
                                <th>Teléfono</th>
                                <th>Personas</th>
                                <th>Servicio</th>
                                <th>Fecha y hora</th>
                                <th>Mensaje</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$reservas): ?>
                                <tr><td colspan="7" class="empty">Aún no hay reservas registradas.</td></tr>
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
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
