@php
	$path = request()->path();
@endphp

<nav class="navbar-collapse collapse" id="navbarMobileCollapse">
	<ul>
		<li class="nav-item @if($path == '/') active font-weight-bold @endif">
			<a class="nav-link" href="/?{{request()->getQueryString()}}">
				@include('dev.partials.components.icons.menu.wifi-icon')
				Internet Hogar
			</a>
		</li>
		<li class="nav-item @if($path == 'movil') active font-weight-bold @endif">
			<a class="nav-link" href="/movil?{{request()->getQueryString()}}">
				@include('dev.partials.components.icons.menu.movil')
				Móvil
			</a>
		</li>
		<li class="nav-item @if($path == 'negocios') active font-weight-bold @endif">
			<a class="nav-link" href="/negocios?{{request()->getQueryString()}}">
				@include('dev.partials.components.icons.menu.pymes')
				Pymes
			</a>
		</li>
	</ul>
</nav>
