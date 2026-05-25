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

## Descripción para GitHub

Picantería Don Félix es una página web desarrollada con PHP, HTML, CSS y JavaScript para un negocio gastronómico arequipeño. Incluye presentación del negocio, carta, ubicación, formulario de reservas y panel administrador con almacenamiento CSV.
