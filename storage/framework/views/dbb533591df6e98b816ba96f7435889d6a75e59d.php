<!-- 
<nav class="carousel-ciudades">
    <ul>
        <li class="<?php if(!str_contains(request()->path(), 'antioquia-eje-cafetero')): ?> active <?php endif; ?>">
            <a href="/internet-hogar?<?php echo e(request()->getQueryString()); ?>">Nacional</a>
        </li>
        <li class="<?php if(str_contains(request()->path(), 'antioquia-eje-cafetero')): ?> active <?php endif; ?>">
            <a href="/antioquia-eje-cafetero?<?php echo e(request()->getQueryString()); ?>">Antioquia y Eje Cafetero</a>
        </li>
    </ul>
</nav>
-->

<nav class="carousel-navbar" style="--cols: 2">
    <ul>
        <?php $__env->startSection('navitems'); ?>
            <li class="<?php if(request()->path() == 'internet-hogar'): ?> active <?php endif; ?>">
                <a href="/internet-hogar?<?php echo e(request()->getQueryString()); ?>">
                    <b>Internet</b>
                    Fibra
                </a>
            </li>
            <li class="<?php if(request()->path() == 'trio-fibra'): ?> active <?php endif; ?>">
                <a href="/trio-fibra?<?php echo e(request()->getQueryString()); ?>">
                    <b>Internet</b>
                    Fibra + TV
                </a>
            </li>
        <?php echo $__env->yieldSection(); ?>
    </ul>
</nav><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/id_version/main-carousel-nav.blade.php ENDPATH**/ ?>