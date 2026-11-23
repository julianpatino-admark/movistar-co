@if($service->sources)
    <picture>
        @foreach($service->sources as $source)
            <source media="{{ $source['media'] }}" srcset="{{ Vite::asset($source['icon']) }}">
        @endforeach
        <img src="{{ Vite::asset($service->icon) }}" alt="{{ $service->altText ?? '' }}">
    </picture>
@else
    <img src="{{ Vite::asset($service->icon) }}" width="{{ $service->width }}" height="{{ $service->height }}" alt="{{ $service->altText ?? '' }}">
@endif
