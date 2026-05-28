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
    'menu_drive_url' => 'https://drive.google.com/file/d/122plxbrF4ojh-bCIbZIgbChiK42TmdxD/view',
    'menu_drive_preview_url' => 'https://drive.google.com/file/d/122plxbrF4ojh-bCIbZIgbChiK42TmdxD/preview',
    'menu_pdf_url' => 'assets/pdf/Carta_Don_Felix_2026.pdf',
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
    ['title' => 'Tradición arequipeña', 'text' => 'Recetas representativas de Arequipa con presentación familiar y sabor de casa.'],
    ['title' => 'Carta completa', 'text' => 'El cliente puede revisar entradas, caldos, picantes, especiales, porciones y bebidas desde la misma web.'],
    ['title' => 'Reserva rápida', 'text' => 'Formulario conectado con PHP y botón directo a WhatsApp para confirmar pedidos o mesas.'],
];

$menuItems = [
    ['name' => 'Rocoto relleno con pastel de papas', 'desc' => 'Clásico arequipeño servido con una de las preparaciones más tradicionales de la casa.', 'price' => 'S/ 26.00', 'tag' => 'Entrada'],
    ['name' => 'Adobo de cogote de chancho', 'desc' => 'Preparado con chicha, té, panes, rocoto hervido y copita de anís. Disponible los domingos.', 'price' => 'S/ 24.00', 'tag' => 'Domingos'],
    ['name' => 'Piqueo Don Félix', 'desc' => 'Malaya dorada, costillar, chicharrones, torrejitas, sarza, papas y jarra de chicha.', 'price' => 'S/ 135.00', 'tag' => 'Para compartir'],
    ['name' => 'Súper americano', 'desc' => 'Rocoto relleno, pastel, estofado, locro, torrejitas, arroz, sarza y chicharrón.', 'price' => 'S/ 71.00', 'tag' => 'Arequipeño'],
    ['name' => 'Cuy chactado', 'desc' => 'Acompañado con papas doradas, mote de maíz o pastel de papas con sarza criolla.', 'price' => 'S/ 62.00', 'tag' => 'Especial'],
    ['name' => 'Chupe de camarones', 'desc' => 'Caldo concentrado con camarones, zapallo, habas, repollo, papas, choclo, queso y huevo.', 'price' => 'S/ 70.00', 'tag' => 'Camarones'],
];

$menuPages = [
    ['src' => 'assets/img/carta/carta-01.jpg', 'alt' => 'Portada de la carta Don Félix', 'label' => 'Portada'],
    ['src' => 'assets/img/carta/carta-02.jpg', 'alt' => 'Entradas de la carta Don Félix', 'label' => 'Entradas'],
    ['src' => 'assets/img/carta/carta-03.jpg', 'alt' => 'Caldos, piqueo y adobo de la carta Don Félix', 'label' => 'Caldos y adobo'],
    ['src' => 'assets/img/carta/carta-04.jpg', 'alt' => 'Picantes de mi Arequipa de la carta Don Félix', 'label' => 'Picantes'],
    ['src' => 'assets/img/carta/carta-05.jpg', 'alt' => 'Especiales de mi Arequipa de la carta Don Félix', 'label' => 'Especiales'],
    ['src' => 'assets/img/carta/carta-06.jpg', 'alt' => 'Camarones y chicharrones de la carta Don Félix', 'label' => 'Camarones'],
    ['src' => 'assets/img/carta/carta-07.jpg', 'alt' => 'Porciones y bebidas de la carta Don Félix', 'label' => 'Bebidas'],
    ['src' => 'assets/img/carta/carta-08.jpg', 'alt' => 'Información de contacto de la carta Don Félix', 'label' => 'Contacto'],
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
