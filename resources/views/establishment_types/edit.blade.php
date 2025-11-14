{!! Form::model($establishment_types, [
    'route' => ['establishment_types.update', encryptId($establishment_types->id)],
    'id' => 'establishmentTypesForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $establishment_types->id, ['id' => 'id']) !!}
@include('establishment_types.form', [
    'establishment_types' => $establishment_types,
])
{!! Form::close() !!}