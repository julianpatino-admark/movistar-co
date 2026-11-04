<picture class="{{ $attributes->get('class') }}">
    {!! $srcSet !!}
    <img src="{{ $routeImage }}" {{ $attributes->filter(fn (string $value, string $key) => $key !== 'class') }} />
</picture>
