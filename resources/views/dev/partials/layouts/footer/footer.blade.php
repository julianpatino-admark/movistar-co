<div id="footer" class="footer">
	<div class="footer-content container">
		<div class="footer_content-logo">
			@include('dev.partials.components.icons.logo.brand-logo')
		</div>
		<div class="footer_link-container">
			<ul class="footer_list">
				<li class="footer-text-privacy">
					<a href="#"
					   data-toggle="modal"
					   data-target="#modal-content"
					   data-content="{{url('privacy')}}"
					   data-modal-title="Política de privacidad"
					   data-tag-page="/modal/privacy"
					   title="Política de privacidad"
					   aria-label="politica privacidad">Política de privacidad</a>
				</li>
				<li class="separator">|</li>
				<li class="footer-text-cookies">
					<a href="#"
					   data-toggle="modal"
					   data-target="#modal-content"
					   data-content="{{url('cookies')}}"
					   data-modal-title="Política de Cookies"
					   data-tag-page="/modal/cookies"
					   title="Política de cookies"
					   aria-label="politica de cookies">Política de cookies</a>
				</li>
			</ul>
			<div class="customer-service">
				Llámanos al
				<a href="tel:01800000000" class="big-number">
					01800000000
				</a>
			</div>
		</div>
	</div>
</div>