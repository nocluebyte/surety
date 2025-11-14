{!! Form::open(['route' => 'designation.store', 'id' => 'designationForm']) !!}
@include('designation.form', [
    'designation' => null,
])
{!! Form::close() !!}
