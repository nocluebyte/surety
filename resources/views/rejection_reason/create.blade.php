{!! Form::open(['route' => 'rejection-reason.store', 'id' => 'rejectionReasonForm']) !!}
@include('rejection_reason.form', [
    'rejection_reason' => null,
])
{!! Form::close() !!}
