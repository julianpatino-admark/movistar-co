@php
	$query = "";

	if($tsource !== 0){
		$query = "?tsource=$tsource";
	}
@endphp
<header id="header" class="header">
	<div class="header-container container">
		<div class="header_logo-wrapper">
			<a href="{{URL('/').$query}}">
                <span class="header_logo d-none d-lg-block">
	                @include('dev.partials.components.icons.logo.brand-logo')
	            </span>
				<span class="header_logo d-lg-none">
                    @include('dev.partials.components.icons.logo.brand-logo')
                </span>
			</a>
		</div>
		@include('dev.partials.layouts.navbar.nav')
		<div class="header-right">
			<div class="header-phone_wrapper">
				<div class="header-phone">
					<p class="header-phone_title">Llámanos al</p>
					<div class="header-phone_link-wrapper d-inline-flex align-items-center">
						<a href="tel:{{$phone}}" class="header-phone_link goo-phone"
						   data-tag-page="/phone/cabecera/click"
						   title="Teléfono Nuevas Contrataciones">{{$phone_formatted}}</a>
					</div>
				</div>
			</div>
			<img class="digital-partner-image" height="70" width="126" src="{{ asset('/img/common/partner-aliado-movistar.svg') }}" alt="Etiqueta de aliado digital Movistar" />

			@if(strlen($phone) === 9)

			@endif
			<div class="header_hamburguer d-lg-none">
				@include('dev.partials.components.buttons.hamburger')
			</div>
		</div>
	</div>
</header>



