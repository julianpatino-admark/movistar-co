@php
	$path = request()->path();
@endphp

<nav class="navbar-collapse collapse" id="navbarMobileCollapse">
	<ul>
		<li class="nav-item @if($path == '/') active font-weight-bold @endif">
			<a class="nav-link" href="/?{{request()->getQueryString()}}">
				<img class="icono-default" src="{{ asset('img/menu/icons-wifi.png') }}" alt="Icono de señal de wifi">
				<img class="icono-active" src="{{ asset('img/menu/icons-wifi-active.png') }}" alt="Icono de señal de wifi azul">
				Internet Hogar
			</a>
		</li>
		<li class="nav-item @if($path == 'movil') active font-weight-bold @endif">
			<a class="nav-link" href="/movil?{{request()->getQueryString()}}">
				<img class="icono-default" src="{{ asset('img/menu/icons-movil.png') }}" alt="Icono de un móvil">
				<img class="icono-active" src="{{ asset('img/menu/icons-movil-active.png') }}" alt="Icono de un móvil azul">
				Móvil
			</a>
		</li>
		<li class="nav-item @if($path == 'negocios') active font-weight-bold @endif">
			<a class="nav-link" href="/negocios?{{request()->getQueryString()}}">
				<img class="icono-default" src="{{ asset('img/menu/icons-pymes.png') }}" alt="Icono de un ordenador de escritorio">
				<img class="icono-active" src="{{ asset('img/menu/icons-pymes-active.png') }}" alt="Icono de un ordenador de escritorio">
				Pymes
			</a>
		</li>
	</ul>
</nav>
