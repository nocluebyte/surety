{!! Form::open(['route' => 'bond_types.store', 'id' => 'bondTypesForm']) !!}
@include('bond_types.form', [
    'bond_types' => null,
])
{!! Form::close() !!}