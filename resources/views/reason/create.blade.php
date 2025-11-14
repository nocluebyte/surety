{!! Form::open(['route' => 'reason.store', 'id' => 'reasonForm']) !!}
@include('reason.form', [
    'reason' => null,
])
{!! Form::close() !!}
