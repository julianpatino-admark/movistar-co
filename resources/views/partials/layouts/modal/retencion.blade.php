<div id="modal-retencion" class="modal lead-modal lead-modal--retention fade" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="retention-title" data-show="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="lead-retention-promo">
                <div class="lead-retention-promo__copy">
                    <h2 id="retention-title">¡No te vayas!</h2>
                    <p>Aprovecha la <strong>oferta especial</strong><br>que tenemos para ti.</p>
                    <picture class="lead-retention-promo__apps">
                        <source media="(min-width: 800px)" srcset="{{ Vite::asset('resources/img/modals/redesign/retention-apps-desktop.svg') }}">
                        <img src="{{ Vite::asset('resources/img/modals/redesign/retention-apps-mobile.svg') }}" alt="Paramount+ y HBO">
                    </picture>
                    <p class="lead-retention-promo__terms">*Aplican términos y condiciones</p>
                </div>
                <picture class="lead-retention-promo__curve" aria-hidden="true">
                    <source media="(min-width: 800px)" srcset="{{ Vite::asset('resources/img/modals/redesign/retention-curve-top.svg') }}">
                    <img src="{{ Vite::asset('resources/img/modals/redesign/retention-curve-mobile.svg') }}" alt="">
                </picture>
                <div class="lead-retention-promo__bottom" aria-hidden="true"><img src="{{ Vite::asset('resources/img/modals/redesign/retention-curve-bottom.svg') }}" alt=""></div>
                @include('partials.components.modal-brand', ['brandVariant' => 'retention'])
            </div>
            <div class="lead-modal__body">
                <h3 class="lead-retention-intro">Tenemos asesores especializados<br>que resolverán tus dudas<strong>¡Te llamamos GRATIS!</strong></h3>
                @include('partials.components.forms.simple', [
                    'id' => 'c2c-retencion',
                    'class' => 'form-simple lead-modal-form',
                    'modalForm' => true,
                    'showServices' => true,
                    'servicePlaceholder' => 'Escoge tus servicios',
                    'submitText' => '¡Llámame!',
                    'formLayerPage' => '/c2c/retencion/conversion',
                ])
            </div>
            <button type="button" class="close lead-modal__close" data-dismiss="modal" aria-label="Cerrar">
                <img src="{{ Vite::asset('resources/img/modals/redesign/close-blue.svg') }}" width="16" height="15" alt="">
            </button>
        </div>
    </div>
</div>
