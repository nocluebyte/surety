{!! Form::model($rejection_reason, [
    'route' => ['rejection-reason.update', encryptId($rejection_reason->id)],
    'id' => 'rejectionReasonForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $rejection_reason->id, ['id' => 'id']) !!}
@include('rejection_reason.form', [
    'rejection_reason' => $rejection_reason,
])
{!! Form::close() !!}
