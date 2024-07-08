@php
	$query = "";

	if($tsource !== 0){
		$query = "?tsource=$tsource";
	}

    $keyword = (app('request')->get('keyword') !== null)?app('request')->get('keyword'):'';

@endphp
<header id="header" class="header">
	<div class="header-container container">
		<div class="header_logo-wrapper">
			<a href="{{URL('/').$query}}">
                <span class="header_logo">
	                @include('dev.partials.components.icons.logo.brand-logo')
	            </span>
			</a>
		</div>
		@include('dev.partials.layouts.navbar.nav')
		<div class="header-right">
			@if(strlen($phone) >= 9 && $keyword !== 'nonum')
				<div class="header-phone_wrapper">
					<div class="header-phone">
						<p class="header-phone_title">Línea de Ventas</p>
						<div class="header-phone_link-wrapper d-inline-flex align-items-center">
							<a href="tel:{{$phone}}" class="header-phone_link goo-phone"
							   data-event="phone_cabecera_click"
							   title="Teléfono Nuevas Contrataciones">{{$phone_formatted}}</a>
						</div>
					</div>
				</div>
			@endif
			<img class="digital-partner-image" height="70" width="126" src="{{ asset('/img/common/partner-aliado-movistar.svg') }}" alt="Etiqueta de aliado digital Movistar" />
			<div class="header_hamburguer d-lg-none">
				@include('dev.partials.components.buttons.hamburger')
			</div>
		</div>
	</div>
</header>



