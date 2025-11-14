@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('proposals.edit_proposals'),
    'back_action' => route('proposals.show', encryptId($proposals->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($proposals, [
            'route' => ['proposals.update', encryptId($proposals->id)],
            'id' => 'proposalsForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $proposals->id, ['id' => 'id']) !!}
        {!! Form::hidden('is_amendment', $is_amendment, ['id' => 'is_amendment']) !!}
        @include('proposals.form', [
            'proposals' => $proposals,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
