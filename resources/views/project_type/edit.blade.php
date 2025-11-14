{!! Form::model($project_type, [
    'route' => ['project_type.update', encryptId($project_type->id)],
    'id' => 'projectTypeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $project_type->id, ['id' => 'id']) !!}
@include('project_type.form', [
    'project_type' => $project_type,
])
{!! Form::close() !!}
