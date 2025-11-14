@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('adverse_information.edit_adverse_information'),
    'back_action' => route('adverse-information.show', encryptId($adverse_information->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($adverse_information, [
            'route' => ['adverse-information.update', encryptId($adverse_information->id)],
            'id' => 'adverseInformationForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $adverse_information->id, ['id' => 'id']) !!}
        @include('adverse_information.form', [
            'adverse_information' => $adverse_information,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
