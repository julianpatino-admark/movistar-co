# Movistar Colombia

Landings de Internet + Móvil, Internet Hogar y Pospago con Laravel, Blade, Sass y Vite. Comparten la cabecera, el pie, los formularios y los recursos del rediseño Figma.

## Desarrollo

Instala las dependencias con `composer install` y `npm ci`, configura el entorno y ejecuta `php artisan serve` junto con `npm run dev`. `npm run build` genera los recursos de producción en `public/build`.

Las vistas activas están en `resources/views/vendor/tracking`, los estilos compartidos en `resources/sass/_landing-redesign.scss` y las imágenes en las carpetas `resources/img/*/redesign`. Las fuentes locales y sus licencias están en `resources/fonts`.

Las rutas disponibles son `/`, `/internet-movil`, `/internet-hogar`, `/movil`, `/gracias`, `/privacy` y `/cookies`. Las URL desconocidas muestran la página 404.

## Pruebas

Con SQLite disponible, ejecuta `DB_CONNECTION=sqlite DB_DATABASE=:memory: vendor/bin/phpunit`. Las pruebas de navegador usan Playwright con `npm run test:e2e`; ajusta `use.baseURL` en `playwright.config.ts` según el servidor local. `npm run build:coverage` prepara la instrumentación de cobertura.

## Arranque de la landing

El catálogo de fuentes de tráfico está en `config/tracking.php`. La fuente
`0` y el respaldo para fuentes desconocidas comparten teléfono, proveedor,
lote y prioridad. Para agregar una campaña, registra su fuente en
`source_phones` con los valores de enrutamiento correspondientes.

Publica la nueva imagen, actualiza `movistar_runtime_image` en Terraform y
configura las credenciales y la base de destino de GoContact. Con una base
nueva, aplica primero la configuración del job de migraciones y ejecútalo
antes de actualizar los servicios de Cloud Run. Los
contenedores leen el catálogo de la aplicación en cada arranque, incluso
cuando la tabla `tsources` está vacía.
