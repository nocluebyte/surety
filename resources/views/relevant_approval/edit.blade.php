{!! Form::model($relevant_approval, [
    'route' => ['relevant_approval.update', encryptId($relevant_approval->id)],
    'id' => 'relevantApprovalForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $relevant_approval->id, ['id' => 'id']) !!}
@include('relevant_approval.form', [
    'relevant_approval' => $relevant_approval,
])
{!! Form::close() !!}
