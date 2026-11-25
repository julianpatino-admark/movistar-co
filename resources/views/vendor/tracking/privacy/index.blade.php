@extends('partials.layouts.extend.status', ['statusContentId' => 'legal-content'])

@section('body-class', 'movil-redesign legal-page')
@section('title', 'Movistar Co | Política de privacidad')

@section('metadata')
	@vite(['resources/sass/legal.scss', 'resources/js/landing.js'])
@stop

@section('content')
	<main class="legal-content" id="legal-content">
		<h1>Política de privacidad</h1>
		<div class="modal_content-data">
			@include('partials.layouts.texts.privacy')
		</div>
	</main>
@stop




