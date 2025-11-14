{!! Form::open(['route' => 'relevant_approval.store', 'id' => 'relevantApprovalForm']) !!}
@include('relevant_approval.form', [
    'relevant_approval' => null,
])
{!! Form::close() !!}
