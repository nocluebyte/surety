@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('blacklist.edit_blacklist'),
    'back_action' => route('blacklist.show', encryptId($blacklist->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($blacklist, [
            'route' => ['blacklist.update', encryptId($blacklist->id)],
            'id' => 'blacklistForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $blacklist->id, ['id' => 'id']) !!}
        @include('blacklist.form', [
            'blacklist' => $blacklist,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
