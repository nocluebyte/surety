{!! Form::open(['route' => 'principle_type.store', 'id' => 'principleTypeForm']) !!}
@include('principle_type.form', [
    'principle_type' => null,
])
{!! Form::close() !!}
