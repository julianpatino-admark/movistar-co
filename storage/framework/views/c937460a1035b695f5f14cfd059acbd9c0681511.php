<?php
    $menuItems = [
        [
            'label' => 'Internet Hogar + Móvil',
            'url' => '/internet-movil',
            'icon' => 'movistar',
            'patterns' => [
                '/',
                'internet-movil*'
            ]
        ],
        [
            'label' => 'Internet Hogar',
            'url' => '/internet-hogar',
            'icon' => 'wifi',
            'patterns' => [
                'internet-hogar*', 
                'duo-fibra*', 
                'trio-fibra*', 
                'antioquia-eje-cafetero*'
            ]
        ],
        [
            'label' => 'Móvil',
            'url' => '/movil',
            'icon' => 'movil',
            'patterns' => ['movil']
        ],
    ];

?>

<ul>
    <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isActive = request()->is($item['patterns']);
        ?>

        <li class="nav-item <?php echo e($isActive ? 'active font-weight-bold' : ''); ?>">
            <a class="nav-link" href="<?php echo e(url($item['url'], request()->query())); ?>">
                <div class="icono-default <?php echo e($item['icon']); ?>"></div>
                <?php echo e($item['label']); ?>

            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/navbar/nav-items.blade.php ENDPATH**/ ?>