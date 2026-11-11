# Landing Madre
La landing madre es un proyecto que contiene una estructura básica de landing para el inicio rápido de proyectos. 

El repositorio contiene dos submódulos de GIT, uno para las vistas y otro para el CSS.

Si los submódulos no se clonan al mismo tiempo que la landing madre se puede lanzar el siguiente comando de git:
`git submodule update --init`

Antes de empezar a trabajar con este proyecto **hay que cerciorarse de que los dos submódulos se encuentran en su rama master**. Es posible que al clonar el proyecto estos dos submódulos no sean detectados por nuestro IDE o no estén en la rama correcta.

En PHPStorm podemos definir la ubicación de estos dos submódulos entrando en **PHP Storm > Preferences > Version Control**.
Se deben añadir las rutas correspondientes de los submódulos en esa ventana y seleccionar el tipo de repositorio correcto.

Las ubicaciones de los dos submódulos pueden encontrarse en el archivo [.gitmodules](https://bitbucket.org/rockethall/landing-madre/src/master/.gitmodules).

## Cómo usar este proyecto
Este proyecto debe mantenerse siempre actualizado con las últimas versiones y configuraciones de las herramientas utilizadas. 

Se propone un diseño de landing básica pero todos aquellos elementos necesarios que se suelen incluir en los proyectos.

Para iniciar un proyecto a través de esta landing se deben seguir los siguientes pasos (repetir con cada uno de los submódulos):

**El proyecto es una landing única:**

1. Clonar el proyecto
2. Definir la ubicación de los submódulos
3. Hacer checkout en master en todas las ramas
4. Copiar todo el contenido del submódulo sass-landing en la carpeta css/sass
5. Copiar todo el contenido del submódulo views landing en la carpeta resources/views/dev
6. Eliminar los submódulos siguiendo los siguientes pasos:

   1. Eliminar la sección correspondiente en el archivo .gitmodules
   2. Ejecutar el comando `git add .gitmodules`
   3. Ejecutar el comando `git rm --cached ruta_al_submodulo`
   4. Ejecutar el comando `rm -rf .git/modules/ruta_al_submodulo`
   5. Hacer commit `git commit -m "Submódulo SASS Lanmding eliminado"`
   6. Eliminar ahora los archivos del submódulo `rm -rf path_to_submodule`

**El proyecto son varias landings diferentes pero con un aspecto y contenido muy similar:** En este caso los submódulos nos pueden servir como herramienta para compartir vistas entra las diferentes landings.

1. Clonar el proyecto
2. Crear dos repositorios para los submódulos en bitbucket
3. Cambiar el repositorio remoto de los submódulos en el proyecto.
4. Modificar la URL de los submódulos en .gitmodules
5. Lanzar el comando `git submodule sync`
6. Lanzar comando `git submodule update --init --recursive --remote`

## Configuración del proyecto

Una vez se ha puesto a punto el proyecto se debe realizar la configuración de las herramientas utilizadas:

* gulpfile.config.js
* webpack.config.js
* config/inconcert.php
* config/anubis.php
* config/tracking.php

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
