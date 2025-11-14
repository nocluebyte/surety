{!! Form::open(['route' => 'establishment_types.store', 'id' => 'establishmentTypesForm']) !!}
@include('establishment_types.form', [
    'establishment_types' => null,
])
{!! Form::close() !!}
