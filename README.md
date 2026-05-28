# Picantería Don Félix - Sitio Web PHP

Proyecto web desarrollado en PHP para portafolio. La página está orientada a una picantería arequipeña y cuenta con diseño responsive, carta referencial, ubicación, botón de WhatsApp, formulario de reservas y panel administrador.

## Tecnologías utilizadas

- PHP 8+
- HTML5
- CSS3
- JavaScript
- CSV como almacenamiento simple de reservas

## Estructura del proyecto

```txt
picanteria-don-felix-php/
├── actions/
│   └── guardar_reserva.php
├── assets/
│   ├── css/styles.css
│   ├── img/
│   └── js/main.js
├── data/
│   └── reservas.csv  # se genera automáticamente
├── includes/
│   ├── data.php
│   ├── footer.php
│   ├── header.php
│   └── reservas.php
├── admin.php
└── index.php
```

## Cómo ejecutar en XAMPP

1. Copia la carpeta `picanteria-don-felix-php` dentro de `htdocs`.
2. Abre XAMPP y activa Apache.
3. Ingresa en el navegador:

```txt
http://localhost/picanteria-don-felix-php/
```

## Panel administrador

Ruta:

```txt
http://localhost/picanteria-don-felix-php/admin.php
```

Clave demo:

```txt
donfelix2026
```

> Importante: cambia la clave en `includes/data.php` antes de publicar el proyecto.

## Datos editables

Puedes modificar teléfono, dirección, servicios, carta y enlaces desde:

```txt
includes/data.php
```

## Reservas

Las reservas se guardan automáticamente en:

```txt
data/reservas.csv
```

Si no se guardan, revisa que la carpeta `data` tenga permisos de escritura.

## Funcionalidades

- Landing page moderna para negocio gastronómico.
- Carta referencial editable desde PHP.
- Botón de WhatsApp.
- Ubicación con imagen de mapa y botón a Google Maps.
- Formulario de reservas con validaciones.
- Almacenamiento básico en CSV.
- Panel administrador para ver reservas.
- Cambio de estado: Pendiente, Confirmada o Cancelada.
- Diseño responsive para celular, tablet y escritorio.

## Descripción para GitHub

Picantería Don Félix es una página web desarrollada con PHP, HTML, CSS y JavaScript para un negocio gastronómico arequipeño. Incluye presentación del negocio, carta, ubicación, formulario de reservas y panel administrador con almacenamiento CSV.


## Carta desde Google Drive

La sección **Carta** usa un visor embebido de Google Drive mediante la URL `preview`:

```txt
https://drive.google.com/file/d/122plxbrF4ojh-bCIbZIgbChiK42TmdxD/preview
```

También se mantiene una copia local del PDF en `assets/pdf/Carta_Don_Felix_2026.pdf` como respaldo.


## Ajuste de identidad visual

Se agregaron logos profesionales en PNG con fondo transparente:

- `assets/img/logo-don-felix-vino-profesional.png` para fondos claros.
- `assets/img/logo-don-felix-blanco-profesional.png` para fondos vino u oscuros.

Estos logos se usan en el encabezado, la franja principal, el footer y el panel administrador.
