{!! Form::model($type_of_foreclosure, [
    'route' => ['type-of-foreclosure.update', encryptId($type_of_foreclosure->id)],
    'id' => 'typeofForeClosureForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $type_of_foreclosure->id, ['id' => 'id']) !!}
@include('type_of_foreclosure.form', [
    'type_of_foreclosure' => $type_of_foreclosure,
])
{!! Form::close() !!}
