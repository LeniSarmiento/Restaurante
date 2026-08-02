<?php
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/reservas.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php#reservas');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$personas = trim($_POST['personas'] ?? '');
$servicio = trim($_POST['servicio'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$hora = trim($_POST['hora'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

$serviciosPermitidos = $reservationServices;
$errors = [];

if ($nombre === '' || mb_strlen($nombre) < 3) {
    $errors[] = 'nombre';
}
if ($telefono === '' || !preg_match('/^[0-9+\s-]{7,20}$/', $telefono)) {
    $errors[] = 'telefono';
}
if (!ctype_digit($personas) || (int)$personas < 1 || (int)$personas > 30) {
    $errors[] = 'personas';
}
if (!in_array($servicio, $serviciosPermitidos, true)) {
    $errors[] = 'servicio';
}
if ($fecha === '' || strtotime($fecha) < strtotime(date('Y-m-d'))) {
    $errors[] = 'fecha';
}
if ($hora === '') {
    $errors[] = 'hora';
}

if ($errors) {
    header('Location: ../index.php?reserva=error#reservas');
    exit;
}

$row = [
    'id' => uniqid('DF-', true),
    'fecha_registro' => date('Y-m-d H:i:s'),
    'nombre' => $nombre,
    'telefono' => $telefono,
    'personas' => (int)$personas,
    'servicio' => $servicio,
    'fecha_visita' => $fecha,
    'hora' => $hora,
    'mensaje' => $mensaje,
    'estado' => 'Pendiente',
];

$ok = append_reserva($row);
$query = $ok ? 'reserva=ok' : 'reserva=save_error';
header('Location: ../index.php?' . $query . '#reservas');
exit;
