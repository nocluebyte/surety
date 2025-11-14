@extends($theme)
@section('content')
@section('title', __('principle.principle'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('principle.edit_principle'),
    'back_action' => route('principle.show', encryptId($principle->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($principle, [
            'route' => ['principle.update', encryptId($principle->id)],
            'id' => 'principleForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $principle->id, ['id' => 'id']) !!}
        @include('principle.form', [
            'principle' => $principle,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
