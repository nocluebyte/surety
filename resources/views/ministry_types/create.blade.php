{!! Form::open(['route' => 'ministry_types.store', 'id' => 'ministryTypesForm']) !!}
@include('ministry_types.form', [
    'ministry_types' => null,
])
{!! Form::close() !!}
