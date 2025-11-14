{!! Form::open(['route' => 'project_type.store', 'id' => 'projectTypeForm']) !!}
@include('project_type.form', [
    'project_type' => null,
])
{!! Form::close() !!}
