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
    'hero_image' => 'assets/img/banco-drive/hero-fachada.jpg',
    'feature_dish_image' => 'assets/img/banco-drive/plato-adobo.jpg',
    'promo_image' => 'assets/img/banco-drive/bebida-chicha.jpg',
    'location_image' => 'assets/img/banco-drive/hero-fachada.jpg',
];

$navItems = [
    ['label' => 'Inicio', 'href' => '#inicio'],
    ['label' => 'Tradición', 'href' => '#tradicion'],
    ['label' => 'Carta', 'href' => '#carta'],
    ['label' => 'Reservas', 'href' => '#reservas'],
    ['label' => 'Ubicación', 'href' => '#ubicacion'],
];

$highlights = [
    ['title' => 'Domingos de adobo', 'text' => 'Adobo con panes, te y copita de anis para mantener la costumbre arequipena.'],
    ['title' => 'Piqueos para compartir', 'text' => 'Platos generosos para mesas familiares, reuniones y almuerzos con sabor casero.'],
    ['title' => 'Chicha de guinapo', 'text' => 'Bebida emblematica servida en jarra de barro para acompanar los platos de la casa.'],
];

$menuItems = [
    ['name' => 'Adobo de cogote de chancho', 'desc' => 'Preparado con chicha, te, panes, rocoto hervido y copita de anis. Disponible los domingos.', 'price' => 'S/ 24.00', 'tag' => 'Domingos'],
    ['name' => 'Piqueo Don Felix', 'desc' => 'Malaya dorada, costillar, chicharrones, torrejitas, sarza, papas y jarra de chicha.', 'price' => 'S/ 135.00', 'tag' => 'Para compartir'],
    ['name' => 'Chicharron crocante', 'desc' => 'Porcion acompanada con papas, mote y sarza criolla en el estilo tradicional de la casa.', 'price' => 'S/ 32.00', 'tag' => 'Favorito'],
    ['name' => 'Chairo arequipeno', 'desc' => 'Caldo tradicional con sabor intenso, ideal para el almuerzo del dia.', 'price' => 'S/ 22.00', 'tag' => 'Caldos'],
    ['name' => 'Chaque de tripas', 'desc' => 'Preparacion casera con identidad arequipena, servida en formato abundante.', 'price' => 'S/ 22.00', 'tag' => 'Tradicion'],
    ['name' => 'Chicha de guinapo', 'desc' => 'Bebida emblema de la picanteria, servida fresca para acompanar platos y piqueos.', 'price' => 'S/ 8.00', 'tag' => 'Bebidas'],
];

$dishShowcase = [
    [
        'title' => 'Adobo dominguero',
        'text' => 'Uno de los platos mas representativos de la casa, servido con panes y acompanado de la experiencia tradicional arequipena.',
        'image' => 'assets/img/banco-drive/plato-adobo.jpg',
        'alt' => 'Adobo servido en Picanteria Don Felix',
    ],
    [
        'title' => 'Piqueo de la casa',
        'text' => 'Una propuesta abundante para compartir con chicharron, torrejitas y acompanamientos sobre mantel tradicional.',
        'image' => 'assets/img/banco-drive/plato-piqueo.jpg',
        'alt' => 'Piqueo Don Felix servido sobre mantel a cuadros',
    ],
    [
        'title' => 'Chicha de guinapo',
        'text' => 'Servida en barro y vaso alto, refuerza la identidad de la picanteria y acompana los platos especiales.',
        'image' => 'assets/img/banco-drive/bebida-chicha.jpg',
        'alt' => 'Chicha de guinapo servida en Picanteria Don Felix',
    ],
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
    ['src' => 'assets/img/banco-drive/hero-fachada.jpg', 'alt' => 'Fachada real de Picanteria Don Felix'],
    ['src' => 'assets/img/banco-drive/plato-piqueo.jpg', 'alt' => 'Piqueo Don Felix servido en mesa'],
    ['src' => 'assets/img/banco-drive/plato-chicharron.jpg', 'alt' => 'Chicharron servido en Picanteria Don Felix'],
    ['src' => 'assets/img/banco-drive/plato-adobo.jpg', 'alt' => 'Adobo de la casa en Picanteria Don Felix'],
];

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function whatsapp_link($site, $message = '') {
    $text = $message ?: 'Hola, deseo información sobre reservas en Picantería Don Félix.';
    return 'https://wa.me/' . $site['phone_clean'] . '?text=' . rawurlencode($text);
}
