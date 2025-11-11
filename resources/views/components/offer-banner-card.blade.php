@props([
    'top',
    'bottomleft',
    'bottomright',
])

<div {{ $attributes->class(['offer-promo-card']) }}>
    @if(isset($top))
        <div {{ $top->attributes->class(['top']) }} {{ $top->attributes}}>
            {{ $top ?? 'DUPLICA TU VELOCIDAD' }}
        </div>
    @else
        <div class="top">
            VIVA LA LIGA1 MAX CON CLAROTV
        </div>
    @endif

    @if(isset($bottomleft))
        <div {{ $bottomleft->attributes->class(['bottomleft']) }} {{ $bottomleft->attributes}}>
            {{ $bottomleft }}
        </div>
    @else
        <div class="bottomleft">
            <h1>
                <small>S/</small>79
            </h1>
            <p>al mes</p>
        </div>
    @endif

    @if(isset($bottomright))
        <div {{ $bottomright->attributes->class(['bottomright']) }} {{ $bottomright->attributes}}>
            {{ $bottomright }}
        </div>
    @else
        <div class="bottomright">
            <h1>
                100
                <small>
                    <span>Mbps</span>
                    de velocidad
                </small>
            </h1>
        </div>
    @endif
</div>