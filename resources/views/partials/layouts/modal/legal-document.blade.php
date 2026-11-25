<div id="{{ $modalId }}" class="modal legal-modal fade" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title" data-show="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header legal-modal__header">
                <img class="legal-modal__background" src="{{ Vite::asset('resources/img/modals/redesign/legal-header.svg') }}" alt="" aria-hidden="true">
                <img class="legal-modal__brand" src="{{ Vite::asset('resources/img/modals/redesign/legal-brand.svg') }}" alt="Movistar y Tigo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <img src="{{ Vite::asset('resources/img/modals/redesign/legal-close.svg') }}" alt="">
                </button>
            </div>
            <h2 class="modal_title legal-modal__title" id="{{ $modalId }}-title">{{ $modalTitle }}</h2>
            <div class="modal-body">
                <div class="modal_content @if($preserveText ?? false) preserve-text @endif">@if($documentPartial ?? null)@include($documentPartial)@endif</div>
                @unless($documentPartial ?? null)
                    <div class="modal_loader"><span class="loader"></span></div>
                @endunless
            </div>
        </div>
    </div>
</div>
