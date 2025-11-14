@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('relationship_manager.add_relationship_manager'),
    'back_action' => route('relationship_manager.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'relationship_manager.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'relationshipManagerForm',
        ]) !!}
        @include('relationship_manager.form', [
            'relationship_manager' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
