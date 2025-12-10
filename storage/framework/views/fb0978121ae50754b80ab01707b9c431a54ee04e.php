<?php
	$path = request()->path();
?>

<div class="thankyou">

	<div class="container">
		<div class="thankyou_content" id="thankyou_container">
			<h1>¡GRACIAS!</h1>
			<h4>HEMOS RECIBIDO TU REGISTRO CORRECTAMENTE</h4>
			<p>Te estaremos llamando en un lapso de 10 a 15 minutos para brindarte toda la información</p>
			<p class="horario">
				Nuestro horarios de atención
				es de <b>Lunes a Viernes</b> de
				8:00 a.m. a 9:00 p.m.
				<b>Sábados</b> 9:00 a.m. a 4:00 p.m.
			</p>
			<p class="telefonos">
				Pronto te llamaremos desde los siguientes números
				<span>300 916 22 34 / 300 917 66 10</span>
			</p>
			<div>
				<a
					href="/?<?php echo e(request()->getQueryString()); ?>"
					class="btn-flex btn-accent-b"
				>
					Volver al home
				</a>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /home/konecta/htdocs/movistar/resources/views/partials/layouts/gracias/index.blade.php ENDPATH**/ ?>