# 🍽️ Documentación Técnica Completa — Picantería Don Félix

> **Tipo de documento:** Especificación técnica y funcional
> **Proyecto:** Picantería Don Félix — Sitio Web PHP
> **Ubicación local:** `C:\xampp\htdocs\Restaurante`
> **Estado:** 🟢 Funcional / En mantenimiento
> **Tags:** `#proyecto` `#php` `#web` `#portfolio` `#gastronomia`

---

## 📑 Tabla de Contenidos

1. [Resumen Ejecutivo](#1-resumen-ejecutivo)
2. [Stack Tecnológico](#2-stack-tecnológico)
3. [Estructura del Proyecto](#3-estructura-del-proyecto)
4. [Arquitectura y Flujo de Datos](#4-arquitectura-y-flujo-de-datos)
5. [Módulos Detallados](#5-módulos-detallados)
6. [Base de Datos (Flat-File)](#6-base-de-datos-flat-file)
7. [Seguridad Implementada](#7-seguridad-implementada)
8. [APIs e Integraciones Externas](#8-apis-e-integraciones-externas)
9. [Frontend y UX](#9-frontend-y-ux)
10. [Guía de Despliegue](#10-guía-de-despliegue)
11. [Panel de Administración](#11-panel-de-administración)
12. [Problemas Conocidos y Bugs](#12-problemas-conocidos-y-bugs)
13. [Hoja de Ruta (Roadmap)](#13-hoja-de-ruta-roadmap)
14. [Glosario Técnico](#14-glosario-técnico)

---

## 1. Resumen Ejecutivo

**Picantería Don Félix** es una aplicación web desarrollada en PHP procedural, orientada a un negocio gastronómico arequipeño. El proyecto combina una landing page moderna y responsive con un sistema de gestión interno que incluye:

- Presentación del negocio con imágenes reales.
- Visor de carta embebido desde Google Drive.
- Formulario de reservas con validaciones.
- Panel administrador para gestionar reservas, editar contenido web y administrar usuarios autorizados.

El sistema **no requiere base de datos SQL**; utiliza almacenamiento plano (JSON y CSV), lo que facilita el despliegue en cualquier servidor Apache con PHP.

### Objetivos del Proyecto
- Mostrar la identidad visual y gastronómica del restaurante.
- Captar reservas de clientes de forma directa.
- Permitir al dueño gestionar reservas y contenido sin conocimientos técnicos.

---

## 2. Stack Tecnológico

| Capa          | Tecnología                        | Versión/Notas                     |
|---------------|-----------------------------------|-----------------------------------|
| Backend       | PHP                               | 8+ (procedimental, sin framework) |
| Frontend      | HTML5 + CSS3                      | Diseño responsive                 |
| JavaScript    | Vanilla JS (ES6+)                 | Sin librerías externas            |
| Almacenamiento| JSON + CSV                        | Flat-File, sin SQL                |
| Servidor      | Apache (XAMPP)                    | Windows                           |
| Tipografía    | Google Fonts (Playfair + Inter)   | Cargada vía CDN                   |
| Versionado    | Git                               | Limpio, sin cambios pendientes    |

---

## 3. Estructura del Proyecto

```
Restaurante/
├── index.php                      # Landing page principal
├── admin.php                      # Panel administrador
├── README.md                      # Documentación original
├── DOCUMENTACION.md              # Este documento
├── .gitignore
│
├── actions/
│   └── guardar_reserva.php        # Procesa el formulario de reservas
│
├── includes/
│   ├── data.php                   # Configuración global y datos del negocio
│   ├── header.php                 # Cabecera HTML reutilizable
│   ├── footer.php                 # Pie de página reutilizable
│   └── reservas.php               # Funciones de lectura/escritura de reservas
│
├── data/
│   ├── content.json               # Contenido editable desde el panel admin
│   ├── admin_users.json           # Usuarios autorizados del panel
│   ├── .gitkeep
│   └── reservas.csv               # Se genera automáticamente (ignorado por Git)
│
└── assets/
    ├── css/
    │   └── styles.css             # Estilos globales
    ├── js/
    │   └── main.js                # Interactividad del frontend
    ├── pdf/
    │   └── Carta_Don_Felix_2026.pdf   # Respaldo local de la carta
    └── img/
        ├── logo-don-felix.png
        ├── logo-don-felix-vino-profesional.png     # Para fondos claros
        ├── logo-don-felix-blanco-profesional.png   # Para fondos oscuros
        ├── moodboard-don-felix.png
        ├── mapa-don-felix.png
        ├── fachada-don-felix.png
        ├── carta/                  # Imágenes de páginas de la carta (01-08)
        ├── carta-especiales/       # Platos destacados (6 imágenes)
        └── banco-drive/            # Fotos reales del local (fachada, platos, bebidas)
```

---

## 4. Arquitectura y Flujo de Datos

### 4.1 Patrón Arquitectónico
El proyecto sigue un patrón **procedimental sin MVC**. Las páginas PHP incluyen módulos reutilizables mediante `require_once` y procesan solicitudes directamente.

### 4.2 Flujo de una Reserva

```
Usuario ( navegador )
    │
    ▼
index.php  →  Muestra formulario ( datos de $reservationServices )
    │
    ▼  POST
actions/guardar_reserva.php
    │  ├── Validación de campos (nombre, teléfono, fecha, servicio)
    │  ├── Validación de servicio contra $menuItems   ⚠️ BUG
    │  └── Si pasa → append_reserva()
    │
    ▼
includes/reservas.php
    │  ├── Abre data/reservas.csv ( LOCK_EX )
    │  ├── Escribe la fila con fputcsv()
    │  └── Cierra y libera el lock
    │
    ▼
Redirect → index.php?reserva=ok#reservas  ( mensaje de éxito )
```

### 4.3 Flujo del Panel Admin

```
admin.php
    │
    ├── GET no logueado  → Formulario de login
    │
    ├── POST action=login
    │     ├── Busca usuario en admin_users.json
    │     ├── Verifica password_hash
    │     ├── Verifica email_verified == true
    │     ├── Genera CSRF token
    │     └── Establece $_SESSION['admin_logged'] = true
    │
    ├── Logueado  →  Dashboard
    │     ├── Lee reservas desde CSV (read_reservas)
    │     ├── Muestra tabla con estados
    │     ├── Formulario de edición de contenido (imágenes + textos)
    │     └── Gestión de usuarios
    │
    └── POST actions (con CSRF):
          ├── update_status    → Cambia estado de reserva
          ├── save_content     → Guarda content.json + sube imágenes
          ├── add_user         → Crea usuario + envía email verificación
          ├── toggle_user      → Activa/desactiva usuario
          ├── change_password  → Actualiza password_hash
          └── resend_verification → Reenvía email de confirmación
```

---

## 5. Módulos Detallados

### 5.1 `includes/data.php` — Núcleo de Configuración

Este archivo es el **centro de configuración** del proyecto. Define:

| Variable                | Tipo     | Descripción                                |
|-------------------------|----------|--------------------------------------------|
| `$site`                 | Array    | Datos del negocio: teléfono, dirección, URLs|
| `$navItems`             | Array    | Items del menú de navegación               |
| `$highlights`           | Array    | 3 tarjetas de "Nuestra esencia"            |
| `$menuItems`            | Array    | 6 platos destacados con imagen y descripción|
| `$reservationServices`  | Array    | Opciones del select del formulario          |
| `$dishShowcase`         | Array    | 3 destacados principales con foto          |
| `$menuPages`            | Array    | Referencias a imágenes de la carta (01-08) |
| `$gallery`              | Array    | Imágenes de la galería del local           |

**Funciones clave:**

| Función                  | Descripción                                    |
|--------------------------|------------------------------------------------|
| `h($value)`              | Alias de `htmlspecialchars` para escapar HTML  |
| `whatsapp_link($site)`   | Genera URL de WhatsApp con mensaje precargado   |
| `read_content_config()`  | Lee `data/content.json`                        |
| `save_content_config()`  | Guarda `data/content.json`                     |
| `read_admin_users()`     | Lee `data/admin_users.json`                    |
| `save_admin_users()`     | Guarda `data/admin_users.json`                 |
| `ensure_admin_users()`   | Crea archivo de usuarios por defecto si no existe|
| `apply_content_config()` | Sobrescribe variables globales con content.json |

### 5.2 `includes/reservas.php` — Gestión de Reservas

Maneja la persistencia de reservas en CSV.

| Función               | Descripción                                       |
|-----------------------|---------------------------------------------------|
| `reservas_file_path()`| Retorna ruta absoluta a `data/reservas.csv`        |
| `reservas_headers()`  | Define los encabezados del CSV                     |
| `read_reservas()`     | Lee el CSV y devuelve array de reservas (orden inverso)|
| `append_reserva($row)`| Agrega una reserva nueva (con `LOCK_EX`)          |
| `save_reservas($r)`   | Reescribe todo el CSV (usado al cambiar estados)  |

### 5.3 `actions/guardar_reserva.php` — Procesamiento de Reservas

Recibe el POST del formulario y:
1. Valida que el método sea POST.
2. Limpia y valida cada campo:
   - `nombre`: mínimo 3 caracteres
   - `telefono`: regex `/^[0-9+\s-]{7,20}$/`
   - `personas`: entero entre 1 y 30
   - `servicio`: debe existir en lista permitida
   - `fecha`: no puede ser pasada
   - `hora`: no vacía
3. Genera un ID único con `uniqid('DF-', true)`.
4. Llama a `append_reserva()`.
5. Redirige con `?reserva=ok` o `?reserva=error`.

### 5.4 `includes/header.php` — Cabecera HTML

- Metaetiquetas SEO (`title`, `description`, `theme-color`)
- Open Graph para Facebook y Twitter Cards
- Favicon personalizado
- Carga de Google Fonts
- Logo con versión profesional transparente
- Menú de navegación responsive con botón hamburguesa (`data-menu-toggle`)

### 5.5 `includes/footer.php` — Pie de Página

- Tres columnas: Logo+tagline, Contacto, Acciones rápidas
- Enlaces a WhatsApp, Google Maps, Google Drive y panel admin
- Año dinámico con `date('Y')`
- Botón flotante de WhatsApp
- Carga de `assets/js/main.js`

### 5.6 `assets/js/main.js` — Interactividad Frontend

| Funcionalidad            | Implementación                              |
|--------------------------|---------------------------------------------|
| Menú hamburguesa mobile  | Toggle de clase `.open` en `data-main-nav`  |
| Fecha mínima en formulario| Establece `min` al día actual              |
| Scroll reveal            | `IntersectionObserver` con threshold 0.12  |
| Visor de carta           | Slider con navegación (prev/next/thumbnails)|

---

## 6. Base de Datos (Flat-File)

### 6.1 `data/content.json`

Almacena el contenido editable desde el panel admin:

```json
{
    "site": {
        "hero_image": "assets/img/banco-drive/hero-fachada.jpg",
        "promo_image": "assets/img/banco-drive/bebida-chicha.jpg",
        "location_image": "assets/img/banco-drive/hero-fachada.jpg"
    },
    "dishShowcase": [ /* 3 objetos con title, text, image, alt */ ],
    "menuItems":   [ /* 6 objetos con name, desc, tag, image, alt */ ]
}
```

**Nota:** La función `apply_content_config()` en `data.php` sobrescribe las variables globales `$site`, `$dishShowcase` y `$menuItems` con los valores de este JSON al cargar la página.

### 6.2 `data/admin_users.json`

Almacena los usuarios del panel:

```json
[
    {
        "username": "admin",
        "name": "Administrador",
        "email": "admin@donfelix.local",
        "email_verified": true,
        "email_verified_at": "2026-01-01T00:00:00+00:00",
        "verification_token_hash": "",
        "verification_sent_at": "",
        "role": "admin",
        "active": true,
        "password_hash": "$2y$10$..."
    }
]
```

### 6.3 `data/reservas.csv`

Formato de columnas:

```
id, fecha_registro, nombre, telefono, personas, servicio, fecha_visita, hora, mensaje, estado
```

- Se genera automáticamente la primera vez que se guarda una reserva.
- Ignorado por Git (configurado en `.gitignore`).
- El estado puede ser: `Pendiente`, `Confirmada` o `Cancelada`.

---

## 7. Seguridad Implementada

### 7.1 Panel Administrador

| Mecanismo              | Implementación                                  |
|------------------------|-------------------------------------------------|
| **Hash de contraseñas**| `password_hash()` + `password_verify()` con `$2y$10$` |
| **Rehash automático**  | `password_needs_rehash()` actualiza hash viejos |
| **CSRF Protection**    | Token aleatorio de 32 bytes por sesión          |
| **Verificación CSRF**  | `hash_equals()` para evitar timing attacks      |
| **Verificación de email**| Token SHA-256 enviado por correo, requerido antes del login |
| **Sesiones PHP**       | `session_start()` + variables `$_SESSION['admin_logged']` |
| **Escapado HTML**      | Función `h()` en toda salida de variables       |
| **Logout**             | `session_destroy()` + redirect                  |

### 7.2 Formulario de Reservas

| Mecanismo              | Implementación                                  |
|------------------------|-------------------------------------------------|
| **Validación servidor**| Todos los campos validados en `guardar_reserva.php` |
| **Validación cliente** | Atributos HTML5 (`required`, `minlength`, `min`, `max`) |
| **Sanitización**      | `trim()` en todos los campos                     |
| **Lock de archivo**    | `flock(LOCK_EX)` evita escrituras simultáneas   |
| **Fecha futura**       | `strtotime($fecha) < strtotime(date('Y-m-d'))`  |

### 7.3 Subida de Imágenes (Panel Admin)

| Mecanismo              | Implementación                                  |
|------------------------|-------------------------------------------------|
| **Validación MIME**    | `getimagesize()` + whitelist de MIME types      |
| **Tamaño máximo**      | 5 MB por imagen                                 |
| **Formatos permitidos**| JPEG, PNG, WEBP                                  |
| **Nombre seguro**      | `preg_replace` + `bin2hex(random_bytes(4))`     |
| **Directorio separado**| `assets/img/admin/`                              |

---

## 8. APIs e Integraciones Externas

### 8.1 Google Drive (Visor de Carta)

- **URL de visualización:** `https://drive.google.com/file/d/122plxbrF4ojh-bCIbZIgbChiK42TmdxD/preview`
- **Implementación:** `<iframe>` embebido con `loading="lazy"` y `allowfullscreen`
- **Respaldo local:** `assets/pdf/Carta_Don_Felix_2026.pdf`
- **Configuración:** Variables `$site['menu_drive_url']`, `$site['menu_drive_preview_url']`, `$site['menu_pdf_url']` en `data.php`

### 8.2 WhatsApp Business

- **Número:** +51 944 199 446
- **Formato:** `https://wa.me/51944199446?text=<mensaje_urlencoded>`
- **Función:** `whatsapp_link($site, $message)` en `data.php`
- **Mensaje por defecto:** "Hola, deseo informacion sobre reservas en Picanteria Don Felix."
- **Presencia:** Botón del hero, tarjeta de contacto, footer y botón flotante

### 8.3 Google Maps

- **URL:** `https://share.google/SCRUdSDpSLTtviGoL`
- **Uso:** Botón "Abrir en Google Maps" en sección de ubicación

### 8.4 Google Fonts

- **Familias:** Playfair Display (600, 700, 800) + Inter (400, 500, 600, 700, 800)
- **Carga:** Preconnect + CSS via `<link>`

### 8.5 Función `mail()` de PHP

- **Uso:** Envío de correo de verificación a nuevos usuarios admin
- **Cabeceras:** `MIME-Version`, `Content-Type: text/plain; charset=UTF-8`, `From`
- **Remitente configurable:** `$site['mailer_from_email']`, `$site['mailer_from_name']`
- **Limitación:** En localhost requiere configuración de SMTP/sendmail en `php.ini`

---

## 9. Frontend y UX

### 9.1 Diseño Responsive

- **Breakpoints:**mobile, tablet, desktop (definidos en `assets/css/styles.css`)
- **Grids:** `hero-grid`, `two-col`, `showcase-grid`, `menu-grid`, `gallery-grid`
- **Navegación móvil:** Botón hamburguesa con toggle de clase `.open`

### 9.2 Animaciones

- **Scroll Reveal:** Clase `.reveal` + `.visible` mediante `IntersectionObserver`
- **Delays escalonados:** Clases `.delay-1`, `.delay-2` para efecto cascada
- **Threshold:** 0.12 (12% visible para activar)

### 9.3 Identidad Visual

| Elemento                | Archivo                                       | Uso              |
|-------------------------|-----------------------------------------------|------------------|
| Logo fondo claro        | `logo-don-felix-vino-profesional.png`         | Header, Admin    |
| Logo fondo oscuro       | `logo-don-felix-blanco-profesional.png`       | Footer           |
| Color principal         | `#8f151b` (vino)                              | theme-color, botones |
| Fachada                 | `banco-drive/hero-fachada.jpg`                | Hero, Ubicación  |

### 9.4 Secciones de `index.php`

1. **Hero** (`#inicio`): Título, descripción, CTAs, imagen de fachada
2. **Tradición** (`#tradicion`): Texto de esencia + 3 highlights
3. **Especialidades**: Grid de 3 platos con foto real
4. **Carta** (`#carta`): Visor Drive + 6 platos destacados
5. **Banda promocional**: Imagen + texto + CTA ubicación
6. **Reservas** (`#reservas`): Formulario + contacto WhatsApp
7. **Ubicación** (`#ubicacion`): Imagen + datos + botones Maps y teléfono
8. **Galería**: Grid de 4 imágenes reales

---

## 10. Guía de Despliegue

### 10.1 Requisitos

- PHP 8.0 o superior
- Apache con `mod_rewrite` (opcional)
- Extensiones PHP: `json`, `mbstring`, `openssl`
- Permisos de escritura en carpeta `data/`

### 10.2 Despliegue en XAMPP (Windows)

1. Copiar carpeta `Restaurante` a `C:\xampp\htdocs\`
2. Iniciar Apache desde el panel de XAMPP
3. Abrir `http://localhost/Restaurante/` en el navegador
4. Panel admin: `http://localhost/Restaurante/admin.php`

### 10.3 Despliegue en Producción (Linux)

```bash
# 1. Subir archivos al servidor
scp -r Restaurante/ usuario@servidor:/var/www/html/

# 2. Permisos
chmod -R 775 /var/www/html/Restaurante/data/
chown -R www-data:www-data /var/www/html/Restaurante/

# 3. Configurar VirtualHost (opcional)
# DocumentRoot /var/www/html/Restaurante
```

### 10.4 ACCESO ADMINISTRADOR

- **URL:** `http://localhost/Restaurante/admin.php`
- **Usuario por defecto:** `admin`
- **Clave demo:** `donfelix2026`
- ⚠️ Cambiar la clave antes de publicar en producción

---

## 11. Panel de Administración

### 11.1 Funcionalidades

| Sección              | Acciones disponibles                                            |
|----------------------|-----------------------------------------------------------------|
| **Reservas**         | Ver total, pendientes, confirmadas, canceladas. Cambiar estado. |
| **Contenido Web**    | Subir imágenes (hero, ubicación, promo). Editar textos.        |
| **Destacados**       | Editar 3 platos/bebidas principales (título, texto, imagen).   |
| **Carta Destacada**  | Editar 6 platos del menú (nombre, etiqueta, descripción, foto). |
| **Usuarios**         | Crear usuario, activar/desactivar, cambiar clave, reenviar verificación. |

### 11.2 Estructura del Formulario de Contenido

El panel admin envía un POST multiformulario (`enctype="multipart/form-data"`) con:

- `action=save_content` + CSRF token
- `showcase[0..2][title|text|alt]` — Editar 3 destacados
- `menu[0..5][name|tag|desc|alt]` — Editar 6 platos
- Archivos: `site_hero_image`, `site_promo_image`, `site_location_image`
- Archivos: `showcase_image_0..2`, `menu_image_0..5`

### 11.3 Acciones POST Soportadas

| Acción                  | Descripción                                  |
|-------------------------|----------------------------------------------|
| `login`                 | Autenticar usuario                           |
| `update_status`         | Cambiar estado de una reserva               |
| `save_content`          | Guardar imágenes y textos editables         |
| `add_user`              | Crear nuevo usuario admin                   |
| `toggle_user`           | Activar/desactivar usuario                  |
| `change_password`       | Cambiar contraseña de un usuario            |
| `resend_verification`   | Reenviar email de verificación              |

---

## 12. Problemas Conocidos y Bugs

### 12.1 BUG CRÍTICO: Validación Inconsistente de Reservas

**Ubicación:** `actions/guardar_reserva.php`, línea 18  
**Severidad:** Alta  
**Descripción:**  
El formulario en `index.php` muestra opciones desde `$reservationServices` (12 opciones), pero `guardar_reserva.php` valida el campo `servicio` contra `$menuItems` (solo 6 opciones).

```php
// guardar_reserva.php línea 18 (INCORRECTO)
$serviciosPermitidos = array_map(fn($item) => $item['name'], $menuItems);
```

**Impacto:** Si un cliente selecciona "Adobo de domingo", "Piqueo Don Felix", "Chicharron", "Chicha de guinapo", "Mesa familiar" o "Consulta general", la reserva falla y redirige a `?reserva=error`.

**Solución propuesta:**
```php
$serviciosPermitidos = $reservationServices;
```

### 12.2 README Desactualizado

**Ubicación:** `README.md`  
**Descripción:** Indica que la clave admin está en `includes/data.php`, pero el sistema migró a `data/admin_users.json` con hashes bcrypt.

### 12.3 Verificación de Email en Localhost

**Descripción:** La función `mail()` de PHP no funciona en localhost sin configuración adicional.  
**Impacto:** Los nuevos usuarios admin no recibirán el email de verificación.  
**Solución:** Configurar SMTP en `php.ini` o usar un servicio como Mailtrap para desarrollo.

### 12.4 Exposición de Archivos JSON

**Descripción:** La carpeta `data/` es accesible vía web.  
**Impacto:** Un usuario podría acceder a `data/admin_users.json` mediante la URL y ver los hashes de contraseñas.  
**Solución recomendada:**  
- Mover `data/` fuera de la raíz pública, o
- Agregar `.htaccess` con `Deny from all` en `data/`.

### 12.5 Compatibilidad del Slider de Carta

**Ubicación:** `assets/js/main.js`  
**Descripción:** El código JS referencia elementos `data-menu-slider`, `data-menu-prev`, `data-menu-next`, `data-menu-thumb` y `data-menu-page`, pero `index.php` usa un `<iframe>` de Google Drive en lugar del slider.  
**Impacto:** Código JS muerto que no se ejecuta pero no causa errores.

---

## 13. Hoja de Ruta (Roadmap)

### Prioridad Alta
- [ ] **Fix Bug Validación:** Cambiar `$menuItems` por `$reservationServices` en `guardar_reserva.php`
- [ ] **Proteger `data/`:** Agregar `.htaccess` con `Deny from all`
- [ ] **Actualizar README:** Documentar sistema de usuarios en `admin_users.json`

### Prioridad Media
- [ ] **SMTP Config:** Integrar PHPMailer o configurar sendmail para verificación de email
- [ ] **Limpiar JS:** Eliminar código del slider de carta si no se usa
- [ ] **Exportar Reservas:** Permitir descarga de reservas en CSV/PDF desde el panel

### Prioridad Baja
- [ ] **PWA:** Convertir en Progressive Web App con manifest.json
- [ ] **Multiidioma:** Soporte i18n (Español/Inglés)
- [ ] **Base de Datos:** Migrar de CSV/JSON a SQLite o MySQL para escalabilidad
- [ ] **Galería Lightbox:** Implementar visor de imágenes a pantalla completa
- [ ] **Analytics:** Integrar Google Analytics o Plausible

---

## 14. Glosario Técnico

| Término          | Definición                                                   |
|------------------|--------------------------------------------------------------|
| **CSRF**         | Cross-Site Request Forgery. Ataque que fuerza acciones no autorizadas. |
| **Flat-File**    | Almacenamiento de datos en archivos planos (no relacional). |
| **flock**        | Función PHP para bloqueo de archivos y prevenir concurrencia.|
| **Hash**         | Transformación unidireccional de datos (contraseñas).       |
| **IntersectionObserver** | API JS que detecta cuando un elemento entra en viewport. |
| **MIME Type**    | Identificador de tipo de archivo (ej: `image/jpeg`).         |
| **Open Graph**   | Protocolo de metaetiquetas para previsualización en redes sociales. |
| **Password Hash**| Contraseña encriptada con algoritmo bcrypt (`$2y$10$`).      |
| **SMTP**         | Simple Mail Transfer Protocol. Protocolo para envío de correo. |
| **Vanilla JS**   | JavaScript puro sin librerías (jQuery, React, etc.).         |

---

## 15. Archivos de Referencia Rápida

| Archivo                          | Líneas | Función principal                          |
|----------------------------------|--------|--------------------------------------------|
| `index.php`                      | 278    | Landing page                                |
| `admin.php`                      | 646    | Panel administrativo completo              |
| `includes/data.php`              | 226    | Configuración + funciones helpers           |
| `includes/reservas.php`          | 98     | CRUD de reservas en CSV                    |
| `includes/header.php`            | 41     | Cabecera HTML + SEO                        |
| `includes/footer.php`            | 34     | Pie de página + WhatsApp flotante           |
| `actions/guardar_reserva.php`    | 61     | Validación y guardado de reservas          |
| `assets/js/main.js`              | 83     | Interactividad frontend                    |
| `data/content.json`              | 71     | Contenido editable del panel               |
| `.gitignore`                     | 3      | Excluye `reservas.csv`                     |

---

## 16. Configuración Actual del Negocio

```php
// includes/data.php
'name'        => 'Picanteria Don Felix',
'tagline'     => 'Tradicion arequipena, ricos almuerzos y platos especiales',
'phone'       => '+51 944 199 446',
'phone_clean' => '51944199446',
'address'     => 'Urb. Pedro Diez Canseco O-15, Jose Luis Bustamante y Rivero, Arequipa',
'hours'       => 'Atencion: almuerzos y platos especiales',
'maps_url'    => 'https://share.google/SCRUdSDpSLTtviGoL',
```

---

## 17. Enlaces y Referencias

| Recurso                  | URL                                                        |
|--------------------------|------------------------------------------------------------|
| Sitio local              | `http://localhost/Restaurante/`                            |
| Panel admin local        | `http://localhost/Restaurante/admin.php`                   |
| Carta en Google Drive    | `https://drive.google.com/file/d/122plxbrF4ojh-bCIbZIgbChiK42TmdxD/view` |
| Google Maps              | `https://share.google/SCRUdSDpSLTtviGoL`                  |
| WhatsApp                 | `https://wa.me/51944199446`                                |
| PHP ejecutable (Windows) | `C:\xampp\php\php.exe`                                     |

---

> **Última actualización de este documento:** 2026-07-21  
> **Generado por:** OpenCode (Análisis técnico automatizado del proyecto)  
> **Próxima revisión recomendada:** Tras aplicar fixes de la Hoja de Ruta (Sección 13)
