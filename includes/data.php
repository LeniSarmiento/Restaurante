<?php
// Datos principales del sitio. Puedes editar aquí el teléfono, dirección, redes y servicios.
$site = [
    'name' => 'Picantería Don Félix',
    'tagline' => 'Tradición arequipeña, ricos almuerzos y platos especiales',
    'phone' => '+51 944 199 446',
    'phone_clean' => '51944199446',
    'address' => 'Urb. Pedro Diez Canseco O-15, José Luis Bustamante y Rivero, Arequipa',
    'hours' => 'Atención: almuerzos y platos especiales',
    'maps_url' => 'https://share.google/SCRUdSDpSLTtviGoL',
    'admin_password' => 'donfelix2026', // Cambiar antes de publicar el proyecto en internet.
];

$navItems = [
    ['label' => 'Inicio', 'href' => '#inicio'],
    ['label' => 'Tradición', 'href' => '#tradicion'],
    ['label' => 'Carta', 'href' => '#carta'],
    ['label' => 'Reservas', 'href' => '#reservas'],
    ['label' => 'Ubicación', 'href' => '#ubicacion'],
];

$highlights = [
    ['title' => 'Sabor arequipeño', 'text' => 'Platos preparados con el estilo tradicional de picantería.'],
    ['title' => 'Ambiente familiar', 'text' => 'Ideal para almuerzos, reuniones y celebraciones pequeñas.'],
    ['title' => 'Ubicación accesible', 'text' => 'Estamos en José Luis Bustamante y Rivero, Arequipa.'],
];

$menuItems = [
    ['name' => 'Adobo arequipeño', 'desc' => 'Clásico plato arequipeño, perfecto para una experiencia tradicional.', 'price' => 'Consultar', 'tag' => 'Tradicional'],
    ['name' => 'Chicharrón de chancho', 'desc' => 'Crocrante, jugoso y acompañado al estilo de casa.', 'price' => 'Consultar', 'tag' => 'Especial'],
    ['name' => 'Rocoto relleno', 'desc' => 'Una de las recetas más representativas de Arequipa.', 'price' => 'Consultar', 'tag' => 'Arequipeño'],
    ['name' => 'Soltero de queso', 'desc' => 'Fresco, colorido y con sabor típico de la región.', 'price' => 'Consultar', 'tag' => 'Entrada'],
    ['name' => 'Chupe de camarones', 'desc' => 'Plato contundente para quienes buscan sabor y tradición.', 'price' => 'Consultar', 'tag' => 'Especial'],
    ['name' => 'Almuerzo especial', 'desc' => 'Opciones del día para disfrutar en familia o con amigos.', 'price' => 'Consultar', 'tag' => 'Del día'],
];

$gallery = [
    ['src' => 'assets/img/fachada-don-felix.png', 'alt' => 'Fachada de Picantería Don Félix'],
    ['src' => 'assets/img/mapa-don-felix.png', 'alt' => 'Mapa de ubicación de Picantería Don Félix'],
    ['src' => 'assets/img/moodboard-don-felix.png', 'alt' => 'Moodboard de marca de Picantería Don Félix'],
];

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function whatsapp_link($site, $message = '') {
    $text = $message ?: 'Hola, deseo información sobre reservas en Picantería Don Félix.';
    return 'https://wa.me/' . $site['phone_clean'] . '?text=' . rawurlencode($text);
}
