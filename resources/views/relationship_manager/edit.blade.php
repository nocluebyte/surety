@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('relationship_manager.edit_relationship_manager'),
    'back_action' => route('relationship_manager.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($relationship_manager, [
            'route' => ['relationship_manager.update', encryptId($relationship_manager->id)],
            'id' => 'relationshipManagerForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $relationship_manager->id, ['id' => 'id']) !!}
        @include('relationship_manager.form', [
            'relationship_manager' => $relationship_manager,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
