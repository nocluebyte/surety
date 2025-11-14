{!! Form::open(['route' => 'type-of-foreclosure.store', 'id' => 'typeofForeClosureForm']) !!}
@include('type_of_foreclosure.form', [
    'type_of_foreclosure' => null,
])
{!! Form::close() !!}
