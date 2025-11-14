{!! Form::open(['route' => 'hsn-code.store', 'id' => 'hsnCodeForm']) !!}
@include('hsn-code.form', [
    'hsn-code' => null,
])
{!! Form::close() !!}
