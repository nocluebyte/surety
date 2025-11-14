{!! Form::open(['route' => 'agency.store', 'id' => 'agencyForm']) !!}
@include('agency.form', [
    'agency' => null,
])
{!! Form::close() !!}
