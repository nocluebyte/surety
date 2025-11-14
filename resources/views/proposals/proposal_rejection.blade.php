{!! Form::open(['route' => ['proposals-status', [$proposal_id, $tender_evaluation_id]], 'role' => 'form', 'method'=>'POST', 'id' => 'proposalRejection']) !!}
@csrf
@include('proposals.proposal_rejection_form')

{!! Form::close() !!}