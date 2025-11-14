@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('premium.edit_premium'),
    'back_action' => route('premium.show', encryptId($premium->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($premium, [
            'route' => ['premium.update', encryptId($premium->id)],
            'id' => 'premiumForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $premium->id, ['id' => 'id']) !!}
        @include('premium.form', [
            'premium' => $premium,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
