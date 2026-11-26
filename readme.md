# Movistar Colombia

Landings de Internet + Móvil, Internet Hogar y Pospago con Laravel, Blade, Sass y Vite. Comparten la cabecera, el pie, los formularios y los recursos del rediseño Figma.

## Desarrollo

Instala las dependencias con `composer install` y `npm ci`, configura el entorno y ejecuta `php artisan serve` junto con `npm run dev`. `npm run build` genera los recursos de producción en `public/build`.

Las vistas activas están en `resources/views/vendor/tracking`, los estilos compartidos en `resources/sass/_landing-redesign.scss` y las imágenes en las carpetas `resources/img/*/redesign`. Las fuentes locales y sus licencias están en `resources/fonts`.

Las rutas disponibles son `/`, `/internet-movil`, `/internet-hogar`, `/movil`, `/gracias`, `/privacy` y `/cookies`. Las URL desconocidas muestran la página 404.

En `storage` solo se versionan los archivos `.gitignore` que conservan la
estructura. Logs, vistas compiladas, sesiones, cachés y archivos subidos se
generan en cada entorno y quedan fuera de Git. La imagen Docker crea los
directorios de ejecución y configura sus permisos durante la construcción.

## Indexación y dominio público

`SEO_PUBLIC_URL` define el origen que se anuncia a los buscadores; por defecto es `https://ofertastienda.co`. Es independiente de `APP_URL`, que puede apuntar a un servicio de Cloud Run. Las canónicas eliminan parámetros de campaña y barras finales; `/internet-movil` comparte la canónica de `/` porque muestra el mismo contenido. La navegación y los formularios conservan sus parámetros.

`/sitemap.xml` publica las tres landings distintas y `/robots.txt` anuncia ese sitemap. Ambos endpoints se sirven sin iniciar sesiones. Las páginas de cualquier host distinto del dominio público, incluido preview, envían `X-Robots-Tag: noindex, follow`; se permite rastrearlas para que los buscadores puedan leer la exclusión. Las páginas de confirmación y 404 conservan su etiqueta `noindex`.

La aplicación redirige las peticiones GET y HEAD de `www` al dominio público conservando ruta y parámetros. Para activar esa redirección también hay que configurar el DNS de `www` en Route 53 y su certificado/ruta en el balanceador de Google Cloud; un cambio de código no puede corregir un host que todavía apunta a otro alojamiento.

## Pruebas

Con SQLite disponible, ejecuta `DB_CONNECTION=sqlite DB_DATABASE=:memory: vendor/bin/phpunit`. Las pruebas de navegador usan Playwright con `npm run test:e2e`; ajusta `use.baseURL` en `playwright.config.ts` según el servidor local. `npm run build:coverage` prepara la instrumentación de cobertura.

Para comprobar el sitemap con la configuración de PHP que permite etiquetas cortas, ejecuta también `DB_CONNECTION=sqlite DB_DATABASE=:memory: php -d short_open_tag=1 vendor/bin/phpunit --filter=SeoTest`.

## Reparto de leads entre bases de GoContact

El destino principal es `GOCONTACT_DATABASE_ID=44` y el alternativo es
`GOCONTACT_ALTERNATE_DATABASE_ID=56`. `GOCONTACT_ALTERNATE_PERCENTAGE` admite
enteros de 0 a 100; por defecto es 40 (60 % para 44 y 40 % para 56). Cada bloque
completo de 10 nuevas asignaciones distribuye 4 a la BD 56 y 6 a la BD 44.
Los bloques incompletos se redondean hacia la principal y acumulan el resto.

El contador se guarda en la base de datos compartida, dentro de una transacción
con bloqueo de escritura. No depende de la memoria del contenedor ni de la caché.
Cada `forms.id` conserva su destino en `gocontact_routing_assignments`; la
asignación queda confirmada antes de llamar a GoContact. Los formularios, el
webhook y la cola comparten el reparto. Un lead en cola se asigna cuando se
intenta enviar por primera vez, no al guardarse en cola. El reparto cuenta
formularios distintos; dos formularios con el mismo teléfono son dos leads.

Los reintentos no consumen otra asignación ni cambian de destino aunque cambie
la configuración. Un cambio de IDs o porcentaje inicia una proporción nueva
para las próximas asignaciones. Los errores no provocan un envío automático
a la otra BD. El reparto no garantiza la deduplicación del proveedor ante una
respuesta perdida después de que GoContact haya aceptado el lead.

`/monitor/gocontact` permite filtrar por BD y muestra leads asignados e intentos
exitosos/fallidos. Los intentos anteriores a esta migración no tienen una BD
registrada y se muestran con «—». Las asignaciones empiezan desde la activación;
no se reenvían ni se redistribuyen leads históricos.

Antes de publicar el código, ejecuta las migraciones con la imagen nueva en el
job correspondiente. Después configura las tres variables en Cloud Run y
renueva las instancias. Si se usa `config:cache`, regenera esa caché. El ID
principal configurado en el entorno tiene prioridad sobre el valor 44 por
defecto: comprueba también el secreto `gocontact-database-id` del despliegue.
No modifiques el contador manualmente. Una configuración inválida o un error
al guardar la asignación impide el envío; no se selecciona un destino alternativo
sin registrar la decisión.

La prueba `GoContactRoutingConcurrencyTest` requiere MySQL y `pcntl`; con SQLite
se omite. Ejecútala con `vendor/bin/phpunit --filter=GoContactRoutingConcurrencyTest`
apuntando a una base MySQL **exclusiva para pruebas**, porque reconstruye sus
tablas. Verifica 10 procesos simultáneos, incluyendo reintentos del mismo lead.

## Acceso al monitor

El monitor usa cuentas individuales de Laravel con Fortify, sesiones y un
permiso `monitor_access` que está deshabilitado por defecto. No hay registro
público. Las credenciales compartidas `GOCONTACT_MONITOR_USERNAME` y
`GOCONTACT_MONITOR_PASSWORD` dejan de usarse; sus secretos se pueden conservar
durante una eventual reversión del despliegue.

Las pantallas están en `/monitor/login`, `/monitor/forgot-password`,
`/monitor/reset-password/{token}` y `/monitor/account`. El historial conserva
`/monitor/gocontact`. Los filtros y las métricas de intentos se aplican juntos;
la distribución por BD muestra el histórico de asignaciones sin filtros.

Después de migrar, crea la primera cuenta desde una terminal conectada a la
base del entorno correspondiente:

```bash
php artisan monitor:user julian.patino@konecta.com --name="Julián Patiño"
```

El comando solicita y confirma la contraseña sin mostrarla. También permite
actualizar una contraseña o revocar el permiso con
`php artisan monitor:user correo@empresa.com --revoke`. No existe una contraseña
inicial fija ni se crean usuarios automáticamente al arrancar la aplicación.
Para un job no interactivo de Cloud Run, utiliza `--name` y
`--password-file=/ruta/del/secreto` con un archivo montado desde Secret Manager;
la contraseña no debe ir en los argumentos del proceso.

`MONITOR_CACHE_STORE=database` mantiene los límites de intentos entre peticiones
y contenedores en las tablas `cache` y `cache_locks`. Es independiente de
`CACHE_DRIVER`, de la caché de tokens de GoContact y de los límites de la landing.
Se necesitan estas tablas y la migración `add_monitor_access_to_users` antes de
publicar la versión. La cuenta debe estar preparada antes de sustituir el
acceso compartido en producción.

La recuperación por correo está desactivada hasta disponer de un proveedor.
La pantalla lo indica y permite volver al inicio de sesión. Para activarla,
configura `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`,
`MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` y
`MONITOR_PASSWORD_RESET_EMAIL_ENABLED=true`. Guarda las credenciales en Secret
Manager. Ajusta `MONITOR_PUBLIC_URL` al origen HTTPS del entorno; este origen
fijo evita generar enlaces a partir de cabeceras Host no confiables. Prueba
la entrega real antes de habilitarla. El enlace caduca en 60 minutos, se utiliza
una vez y la respuesta no revela si un correo pertenece a una cuenta.

Las contraseñas se almacenan con hash. El cambio de contraseña requiere la
contraseña actual y las otras sesiones deberán volver a autenticarse. La
revocación del permiso bloquea inmediatamente la consulta del monitor y la
recuperación con tokens previamente emitidos.

Para probar las cuatro pruebas del monitor en navegador, instala Chromium con
`npx playwright install chromium` y ejecuta `npm run test:e2e:monitor` después de
`npm run build`. Esta configuración inicia su propio servidor en el puerto 8091,
migra una base SQLite exclusiva en `/tmp/movistar-monitor-browser.sqlite` y carga
datos ficticios. No utiliza la base configurada en `.env` ni envía correos o leads.
La cuenta de las pruebas no se crea en otros entornos. Estas pruebas se ejecutan
por separado de las pruebas de las landings.

### Primera activación en producción

Construir la imagen nueva y ejecutar `movistar-migrations` en `us-east1` con esa
misma imagen antes de publicar el servicio. La base de producción es independiente
de la local: crear la cuenta una sola vez mediante el job administrativo
`movistar-monitor-user`. Su contraseña se obtiene del archivo montado desde
`monitor-initial-password` en Secret Manager y se guarda como hash en Cloud SQL.
No colocar el valor de la contraseña en Terraform ni en argumentos del job.

El job administrativo se ejecuta manualmente; un despliegue no lo ejecuta.
Volver a ejecutarlo restablece la contraseña al valor actual del secreto y
revoca las otras sesiones, por lo que no debe ejecutarse en cada publicación.
Para recuperar el acceso mientras no hay correo, cargar una contraseña nueva
en el secreto y ejecutar el job deliberadamente.

Después de activar la versión, acceder a `https://ofertastienda.co/monitor/login`
con `julian.patino@konecta.com`. Consultar la contraseña inicial en Secret Manager,
iniciar sesión y cambiarla desde **Mi cuenta**. La cuenta persiste en Cloud SQL
entre reinicios y despliegues. La recuperación por correo permanece desactivada.
La compilación Docker incluye las vistas del paquete GoContact para conservar
los estilos de su tabla al procesar el CSS.

## Catálogo de fuentes

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
