{!! Form::model($ministry_types, [
    'route' => ['ministry_types.update', encryptId($ministry_types->id)],
    'id' => 'ministryTypesForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $ministry_types->id, ['id' => 'id']) !!}
@include('ministry_types.form', [
    'ministry_types' => $ministry_types,
])
{!! Form::close() !!}
