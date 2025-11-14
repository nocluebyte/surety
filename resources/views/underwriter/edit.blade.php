@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('underwriter.edit_underwriter'),
    'back_action' => route('underwriter.show', encryptId($underwriter->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($underwriter, [
            'route' => ['underwriter.update', encryptId($underwriter->id)],
            'id' => 'underWriterForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $underwriter->id, ['id' => 'id']) !!}
        @include('underwriter.form', [
            'underwriter' => $underwriter,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
