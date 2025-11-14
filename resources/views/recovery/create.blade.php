@extends($theme)
@section('content')
@section('title', __('recovery.recovery'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('recovery.recovery'),
    'back_action' =>route('recovery.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'recovery.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'recoveryForm',
        ]) !!}
        @include('recovery.form', [
            'recovery' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@include('recovery.script')
@endsection
