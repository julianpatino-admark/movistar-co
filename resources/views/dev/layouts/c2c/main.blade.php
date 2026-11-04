@php
	$c2c_class = $c2c_class ?? "";
@endphp

<div class="container main-c2c_container {{ $c2c_class }}">
	<div class="main-c2c_wrapper">
		<div class="main-c2c box-shadow-sm">
			<p class="main-c2c_title">
				¿Deseas comprar uno de nuestros planes?
			</p>
			@include('dev.components.forms.simple', ['id' => 'c2c-main', 'class' => 'form-simple'])
		</div>
	</div>
</div>
