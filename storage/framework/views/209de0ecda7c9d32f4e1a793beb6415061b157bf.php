<nav class="carousel-navbar">
    <ul>
        <li class="<?php if(request()->path() == 'internet-movil' || request()->path() == '/'): ?> active <?php endif; ?>">
            <a href="/internet-movil?<?php echo e(request()->getQueryString()); ?>">
                <b>Solo Internet + Pospago</b>
            </a>
        </li>
        <li class="<?php if(request()->path() == 'internet-movil/duo'): ?> active <?php endif; ?>">
            <a href="/internet-movil/duo?<?php echo e(request()->getQueryString()); ?>">
                <b>Dúo + Pospago</b>
            </a>
        </li>
        <li class="<?php if(request()->path() == 'internet-movil/trio'): ?> active <?php endif; ?>">
            <a href="/internet-movil/trio?<?php echo e(request()->getQueryString()); ?>">
                <b>Trío + Pospago</b>
            </a>
        </li>
    </ul>
</nav><?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/id_version/internet-movil/carousel/carousel-navbar.blade.php ENDPATH**/ ?>