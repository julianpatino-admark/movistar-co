<div id="{{ $modalId }}" class="modal lead-modal lead-modal--conversion fade" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title" data-show="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="lead-modal__header">
                @include('partials.components.modal-brand', ['brandVariant' => 'form'])
                <button type="button" class="close lead-modal__close" data-dismiss="modal" aria-label="Cerrar">
                    <img src="{{ Vite::asset('resources/img/modals/redesign/close-white.svg') }}" alt="" width="15" height="14.996">
                </button>
            </div>
            <div class="lead-modal__body">
                <h2 id="{{ $modalId }}-title">¿Deseas comprar uno de nuestros planes?</h2>
                @if($isOffer)
                    <p class="modal_title sr-only" aria-live="polite"></p>
                @endif
                @include('partials.components.forms.simple', [
                    'id' => $isOffer ? 'c2c-velocidades' : 'c2c-general',
                    'class' => 'form-simple lead-modal-form',
                    'modalForm' => true,
                    'showServices' => !$isOffer,
                    'submitText' => '¡Llámame!',
                    'phonePlaceholder' => '*Número de celular',
                    'namePlaceholder' => '*Nombres y Apellidos',
                ])
            </div>
        </div>
    </div>
</div>
