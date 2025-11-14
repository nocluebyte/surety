{!! Form::model($work_type, [
    'route' => ['work-type.update', encryptId($work_type->id)],
    'id' => 'workTypeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $work_type->id, ['id' => 'id']) !!}
@include('work_type.form', [
    'work_type' => $work_type,
])
{!! Form::close() !!}
