<div id="modal-velocidades" class="modal modal-brand modal-velocidades fade" tabindex="-1" role="dialog" data-show="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="brands">
					@include('partials.components.icons.logo.brand-logo')
					<img class="digital-partner-image" height="70" width="126" src="{{ Vite::asset('resources/img/common/partner-aliado-movistar.svg') }}" alt="Etiqueta de aliado digital Movistar" />
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
				</div>
				<div class="modal-header-text">
					<h2 class="modal_title">(Velocidad del producto)</h2>
				</div>
			</div>
			<div class="modal-body">
				<div class="modal-velocidades_title">
					<p>Déjanos tu número y nos pondremos en contacto contigo</p>
					<p>Te llamamos GRATIS</p>
				</div>
				<div class="modal-velocidades_form">
					@include('partials.components.forms.simple',['id' => 'c2c-velocidades', 'class' => 'form-simple black-theme', 'showServices' => false])
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>