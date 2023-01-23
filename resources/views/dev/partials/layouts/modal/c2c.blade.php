<div id="modal-c2c" class="modal modal-brand modal-c2c fade" tabindex="-1" role="dialog" data-show="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				@if(strlen($phone) === 9)
					<div id="modal-header-phone" class="modal-header-phone">
						<p class="modal-header-phone_title">Infórmate gratis</p>
						<a href="tel:{{$phone}}" data-tag-page="/phone/modal/click" aria-label="telefono informate"
						   class="goo-phone modal-header-phone_link">{{$phone_formatted}}</a>
					</div>
				@endif
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>
			<div class="modal-body">
				<div class="modal-c2c_title">
					<p class="text-uppercase font-family-bold">o te llamamos GRATIS</p>
				</div>
				<div class="modal-c2c_form">
					@include('dev.partials.components.forms.simple',['id' => 'modal-c2c', 'class' => 'form-underline'])
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>