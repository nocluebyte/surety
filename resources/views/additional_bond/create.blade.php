{!! Form::open(['route' => 'additional-bond.store', 'id' => 'additionalBondForm']) !!}
@include('additional_bond.form', [
    'additional_bond' => null,
])
{!! Form::close() !!}
