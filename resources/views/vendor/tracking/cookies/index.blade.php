@extends('partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false
])

@section('metadata')
    <title>Movistar Co | Política de cookies</title>
    @vite(['resources/sass/generica.scss'])
@stop

@section('content')
    <div class="main_wrapper pt-4 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="modal_content-data">
                        @include('partials.layouts.texts.cookies')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
