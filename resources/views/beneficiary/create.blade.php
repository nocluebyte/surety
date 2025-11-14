@extends($theme)
@section('content')
@section('title', __('beneficiary.beneficiary'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('beneficiary.add_beneficiary'),
    'back_action' => route('beneficiary.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'beneficiary.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'beneficiaryForm',
        ]) !!}
        @include('beneficiary.form', [
            'beneficiary' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
