@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('project_details.add_project_details'),
    'back_action' => route('project-details.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'project-details.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'projectDetailsForm',
        ]) !!}
        @include('project_details.form', [
            'project_details' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
