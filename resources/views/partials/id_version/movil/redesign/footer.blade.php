@php($keyword = request()->query('keyword', ''))
<footer class="movil-footer" id="footer">
    <div class="movil-footer__inner">
        <ul class="movil-footer__policies">
            @foreach(['privacy' => 'Política de privacidad', 'cookies' => 'Política de cookies'] as $path => $label)
                <li><a href="{{ url($path) }}" data-toggle="modal" data-target="#modal-content" data-content="{{ url($path) }}" data-modal-title="{{ $label }}" data-tag-page="/modal/{{ $path }}">{{ $label }}</a></li>
            @endforeach
        </ul>
        @if($keyword !== 'nonum' && strlen($phone) >= 9)
            <div class="movil-footer__phone">
                <span>Llámanos al</span>
                <a href="tel:{{ $phone }}" data-event="phone_footer_click">{{ $phone_formatted }}</a>
            </div>
        @endif
    </div>
</footer>
