# Movistar Colombia

Landings de Internet + Móvil, Internet Hogar y Pospago con Laravel, Blade, Sass y Vite. Comparten la cabecera, el pie, los formularios y los recursos del rediseño Figma.

## Desarrollo

Instala las dependencias con `composer install` y `npm ci`, configura el entorno y ejecuta `php artisan serve` junto con `npm run dev`. `npm run build` genera los recursos de producción en `public/build`.

Las vistas activas están en `resources/views/vendor/tracking`, los estilos compartidos en `resources/sass/_landing-redesign.scss` y las imágenes en las carpetas `resources/img/*/redesign`. Las fuentes locales y sus licencias están en `resources/fonts`.

Las rutas disponibles son `/`, `/internet-movil`, `/internet-hogar`, `/movil`, `/gracias`, `/privacy` y `/cookies`. Las URL desconocidas muestran la página 404.

## Indexación y dominio público

`SEO_PUBLIC_URL` define el origen que se anuncia a los buscadores; por defecto es `https://ofertastienda.co`. Es independiente de `APP_URL`, que puede apuntar a un servicio de Cloud Run. Las canónicas eliminan parámetros de campaña y barras finales; `/internet-movil` comparte la canónica de `/` porque muestra el mismo contenido. La navegación y los formularios conservan sus parámetros.

`/sitemap.xml` publica las tres landings distintas y `/robots.txt` anuncia ese sitemap. Ambos endpoints se sirven sin iniciar sesiones. Las páginas de cualquier host distinto del dominio público, incluido preview, envían `X-Robots-Tag: noindex, follow`; se permite rastrearlas para que los buscadores puedan leer la exclusión. Las páginas de confirmación y 404 conservan su etiqueta `noindex`.

La aplicación redirige las peticiones GET y HEAD de `www` al dominio público conservando ruta y parámetros. Para activar esa redirección también hay que configurar el DNS de `www` en Route 53 y su certificado/ruta en el balanceador de Google Cloud; un cambio de código no puede corregir un host que todavía apunta a otro alojamiento.

## Pruebas

Con SQLite disponible, ejecuta `DB_CONNECTION=sqlite DB_DATABASE=:memory: vendor/bin/phpunit`. Las pruebas de navegador usan Playwright con `npm run test:e2e`; ajusta `use.baseURL` en `playwright.config.ts` según el servidor local. `npm run build:coverage` prepara la instrumentación de cobertura.

Para comprobar el sitemap con la configuración de PHP que permite etiquetas cortas, ejecuta también `DB_CONNECTION=sqlite DB_DATABASE=:memory: php -d short_open_tag=1 vendor/bin/phpunit --filter=SeoTest`.

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
