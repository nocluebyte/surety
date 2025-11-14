{!! Form::model($bond_types, ['route' => ['bond_types.update', encryptId($bond_types->id)], 'id' => 'bondTypesForm']) !!}
@method('PUT')
{!! Form::hidden('id', $bond_types->id, ['id' => 'id']) !!}
@include('bond_types.form', [
    'bond_types' => $bond_types,
])
{!! Form::close() !!}
