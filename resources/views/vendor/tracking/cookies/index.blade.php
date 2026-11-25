@extends('partials.layouts.extend.status', ['statusContentId' => 'legal-content'])

@section('body-class', 'movil-redesign legal-page')
@section('title', 'Movistar Co | Política de cookies')

@section('metadata')
    @vite(['resources/sass/legal.scss', 'resources/js/landing.js'])
@stop

@section('content')
    <main class="legal-content" id="legal-content">
        <h1>Política de cookies</h1>
        <div class="modal_content-data">
            @include('partials.layouts.texts.cookies')
        </div>
    </main>
@stop
