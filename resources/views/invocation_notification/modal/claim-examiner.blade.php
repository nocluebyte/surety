<!-- Modal -->
<div class="modal fade" id="ClaimExaminerModal" tabindex="-1" role="dialog" aria-labelledby="ClaimExaminerModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ClaimExaminerModalLabel">{{__('invocation_notification.claim_examiner')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!!Form::open(['route' => ['invocationClaimExaminer', $invocationData->id], 'id' => 'claimExaminerForm'])!!}
      <div class="modal-body">
        <div class="form-group">
          {!! Form::hidden('invocation_amount', $invocationData->invocation_amount ?? null) !!}
          {!! Form::hidden('invocation_notification_id', $invocationData->id ?? null) !!}
          {!!Form::label('claim_examiner',__('invocation_notification.claim_examiner'))!!}
          {!!Form::select('claim_examiner_id',[''=>'']+$claim_examiner,null, [
            'class' => 'form-control jsSelect2ClearAllow required claim_examiner_id','data-placeholder'=>'Select Claim Examiner', 
            'data-ajaxUrl' => route('checkClaimExaminerApprovedLimit', ['invocationData' => $invocationData->id])
          ])!!}
        </div>
        <span class="JsApprovedLimit text-danger"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="JsAssignClaimExaminer btn btn-primary">Submit</button>
      </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>