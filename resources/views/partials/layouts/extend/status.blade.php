@extends('partials.layouts.extend.master')

@section('page-header')
    @include('partials.id_version.movil.redesign.header', [
        'contentId' => $statusContentId,
        'navigationHasActivePage' => false,
        'brandAssetPath' => 'resources/img/thankyou/redesign',
        'headerIconPaths' => [
            'movistar' => 'resources/img/internet-movil/redesign/header-movistar.svg',
            'wifi' => 'resources/img/hogar/redesign/header-wifi.svg',
            'movil' => 'resources/img/movil/redesign/header-movil.svg',
        ],
    ])
@endsection

@section('page-footer')
    @include('partials.layouts.conditions.collapse')
    @include('partials.id_version.movil.redesign.footer')
@endsection

@section('modal')
    @include('partials.layouts.modal.legal-document', ['modalId' => 'modal-content', 'modalTitle' => 'Políticas de privacidad'])
    @include('partials.layouts.modal.legal-document', ['modalId' => 'modal-manual', 'modalTitle' => 'Tratamiento de datos personales', 'documentPartial' => 'partials.layouts.texts.tratamiento-datos', 'preserveText' => true])
@endsection
