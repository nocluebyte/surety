@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('project_details.edit_project_details'),
    'back_action' => route('project-details.show', encryptId($project_details->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($project_details, [
            'route' => ['project-details.update', encryptId($project_details->id)],
            'id' => 'projectDetailsForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $project_details->id, ['id' => 'id']) !!}
        @include('project_details.form', [
            'project_details' => $project_details,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
