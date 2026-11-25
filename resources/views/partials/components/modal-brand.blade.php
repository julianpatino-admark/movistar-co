@php($variants = $brandVariant === 'retention' ? ['vertical', 'horizontal'] : ['form'])
<div class="lead-modal-brand lead-modal-brand--{{ $brandVariant }}" role="img" aria-label="Movistar y Tigo">
    @foreach($variants as $variant)
        <div class="lead-modal-brand__variant lead-modal-brand__variant--{{ $variant }}" aria-hidden="true">
            @for($part = 0; $part < 9; $part++)
                <img class="lead-modal-brand__part lead-modal-brand__part--{{ $part }}" src="{{ Vite::asset('resources/img/modals/redesign/'.$variant.'-brand-'.$part.'.svg') }}" alt="">
            @endfor
        </div>
    @endforeach
</div>
