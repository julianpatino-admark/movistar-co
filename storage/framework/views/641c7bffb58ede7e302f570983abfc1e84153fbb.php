<?php
	$query = "";

	if($tsource !== 0){
		$query = "?tsource=$tsource";
	}

    $keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';

?>
<header id="header" class="header">
	<div class="header-container container">
		<nav class="navbar-nav">
			<?php echo $__env->make("partials.layouts.navbar.nav-items", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</nav>
		<div class="header-right">
			<?php if(strlen($phone) >= 9 && $keyword !== 'nonum'): ?>
				<div class="header-phone_wrapper">
					<div class="header-phone">
						<p class="header-phone_title">Línea de Ventas</p>
						<div class="header-phone_link-wrapper d-inline-flex align-items-center">
							<a href="tel:<?php echo e($phone); ?>" class="header-phone_link goo-phone"
							   data-event="phone_cabecera_click"
							   title="Teléfono Nuevas Contrataciones"><?php echo e($phone_formatted); ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<img class="digital-partner-image" height="70" width="126" src="<?php echo e(Vite::asset('resources/img/common/partner-aliado-movistar.webp')); ?>" alt="Etiqueta de aliado digital Movistar" />
			<div class="header_hamburguer d-lg-none">
				<?php echo $__env->make('partials.components.buttons.hamburger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
		</div>
	</div>
</header>



<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/header/header.blade.php ENDPATH**/ ?>