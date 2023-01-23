@php
	$keyword = app('request')->get('keyword');
	$modalShow = ($keyword == 'calcula')?"true":"false";
@endphp

<div id="modal-c2c-calcula" class="modal modal-brand modal-c2c-calcula fade" tabindex="-1" role="dialog"
     data-show="{{$modalShow}}">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-header-text">
					@include('dev.partials.components.icons.buttons.euro-circle')
					<p>Configura tu <span class="font-family-bold">Tarifa personalizada</span></p>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div>


			<div class="modal-body">

				<div class="modal-c2c_form">
					@include('dev.partials.components.forms.calcula',['id' => 'modal-c2c-calcula', 'class' => 'form-underline'])
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>