<div class="float-whatsapp" id="mainChatFloatContainer">
    <div class="form-float">
        <h5>
            <img width="23" height="23" src="{{ asset('img/common/logo-whatsapp-mini.png') }}" alt="Logo WhatsApp mini formato PNG">
            Ventas por WhatsApp
            <button type="button" class="btn-close" aria-label="Close"></button>
        </h5>
        @include('dev.partials.components.forms.wppsimple',['id' => 'whatsapp-c2c', 'class'=>'form-whatsapp',  'showServices' => false])
    </div>
    <button class="btn-float" id="wppFloatButton">
        <img width="82" height="82" src="{{asset('img/common/logo-whatsapp.svg')}}" alt="WhatsApp Logo en formato SVG">
    </button>
</div>