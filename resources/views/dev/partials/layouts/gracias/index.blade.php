@php
	$path = request()->path();
@endphp

<div class="thankyou">

	<div class="container">
		<div class="thankyou_content" id="thankyou_container">
			<h1>GRACIAS</h1>
			<h4>HEMOS RECIBIDO TU <br>REGISTRO CORRECTAMENTE</h4>
			<p>En breve te contactaremos para brindarte toda la información</p>
			<p class="horario">
Nuestro horarios de atención
es de <b>Lunes a Viernes</b> de
8:00 a.m. a 9:00 p.m. 
<b>Sábados</b> 9:00 a.m. a 4:00 p.m.
			</p>
			<div>
				<a
						href="/?{{request()->getQueryString()}}"
						class="btn-flex btn-accent-b"
				>
					Volver al home
				</a>
			</div>
		</div>
	</div>
</div>