<?php
	$top = isset($top)?$top:true;
	$nav = isset($nav)?$nav:true;
	$header_phone = isset($header_phone)?$header_phone:true;
	$phone = ($header_phone === true)?$phone:"0";
	$main_c2c = isset($main_c2c)?$main_c2c:true;
	$main_c2c_class = $main_c2c_class ?? "";
    $modals = isset($modals)?$modals:true;
	$keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';
?>

<!doctype html>
<html lang="es">
<head>
	<!-- Google Tag Manager -->
	<script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-W2XDDSK');
	</script>
	<!-- End Google Tag Manager -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="facebook-domain-verification" content="mtpr61q04or29fm9e5nv3t48up9th9" />
	<meta id="provider" name="provider" content="<?php echo e($provider); ?>">
	<link rel="icon" href="/favicon.ico" sizes="any">
	<link rel="icon" href="/favicon.svg" type="image/svg+xml">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	
	<link rel="canonical" href="<?php echo e(url()->current()); ?>/" />
<?php $__env->startSection('metadata'); ?>
	<?php echo $__env->yieldSection(); ?>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2XDDSK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="main">
	<?php if($top === true): ?>
		<?php echo $__env->make("partials.layouts.header.top-header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('partials.layouts.header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<nav class="navbar-collapse collapse" id="navbarMobileCollapse">
			<?php echo $__env->make("partials.layouts.navbar.nav-items", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</nav>

	<?php endif; ?>
	<?php if($main_c2c === true): ?>
		<?php echo $__env->make('partials.layouts.c2c.main', [ "c2c_class" => $main_c2c_class ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>

	<?php echo $__env->yieldContent('content'); ?>

	<?php echo $__env->make('partials.layouts.footer.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partials.layouts.cta.mobile-fixed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<!--<?php echo $__env->make('partials.components.buttons.whatsapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->

    <?php if($modals === true): ?>
        <?php $__env->startSection('modal'); ?>
            <?php echo $__env->make('partials.layouts.modal.c2c', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.c2c-velocidades', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.rgpd-config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.info-basica-privacidad', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.privacy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.loaded-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.legal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.response', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partials.layouts.modal.manual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php echo $__env->make('partials.layouts.modal.retencion', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldSection(); ?>
    <?php endif; ?>

	<div id="current-phone" class="d-none"><?php echo e($phone_formatted); ?></div>
	<div id="current-phone-link" class="d-none"><?php echo e($phone); ?></div>
</div>
<?php $__env->startSection('footer-scripts'); ?>
	
<?php echo $__env->yieldSection(); ?>
</body>
</html>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/extend/master.blade.php ENDPATH**/ ?>