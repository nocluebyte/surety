@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('blacklist.add_blacklist'),
    'back_action' => route('blacklist.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'blacklist.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'blacklistForm',
        ]) !!}
        @include('blacklist.form', [
            'blacklist' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
