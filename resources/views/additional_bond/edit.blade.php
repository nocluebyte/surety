{!! Form::model($additional_bond, [
    'route' => ['additional-bond.update', encryptId($additional_bond->id)],
    'id' => 'additionalBondForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $additional_bond->id, ['id' => 'id']) !!}
@include('additional_bond.form', [
    'additional_bond' => $additional_bond,
])
{!! Form::close() !!}
