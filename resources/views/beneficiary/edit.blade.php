@extends($theme)
@section('content')
@section('title', __('beneficiary.beneficiary'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('beneficiary.edit_beneficiary'),
    'back_action' => route('beneficiary.show', encryptId($beneficiary->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($beneficiary, [
            'route' => ['beneficiary.update', encryptId($beneficiary->id)],
            'id' => 'beneficiaryForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $beneficiary->id, ['id' => 'id']) !!}
        @include('beneficiary.form', [
            'beneficiary' => $beneficiary,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
