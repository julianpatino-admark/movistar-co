@extends('dev.partials.layouts.extend.master',[
    'nav' => false,
    'header_phone' => false,
    'main_c2c' => false
])

@section('metadata')
	<title>{{config('app.name')}}. Política de Cookies</title>
	<!-- inject-style src="../../css/purged/generica.css" -->
@stop

@section('content')
	<div class="main_wrapper pt-4 pb-3">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="modal_content-data">
						@include('dev.partials.layouts.texts.cookies')
					</div>
				</div>
			</div>
		</div>
	</div>
@stop




