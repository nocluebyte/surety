@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('group.add_group'),
    'back_action' => route('group.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'group.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'groupForm',
        ]) !!}
        @include('group.form', [
            'group' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
@include('group.script')