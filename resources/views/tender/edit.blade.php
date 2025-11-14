@extends($theme)
@section('content')
@section('title', __('tender.tender'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('tender.edit_tender'),
    'back_action' => route('tender.show', encryptId($tender->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($tender, [
            'route' => ['tender.update', encryptId($tender->id)],
            'enctype' => 'multipart/form-data',
            'id' => 'tenderForm',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $tender->id, ['id' => 'id']) !!}
        @include('tender.form', [
            'tender' => $tender,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
