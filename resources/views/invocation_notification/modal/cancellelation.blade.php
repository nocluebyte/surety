<!-- Modal -->
<div class="modal fade" id="cancellelationModal" tabindex="-1" role="dialog" aria-labelledby="cancellelationModal"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancellelationModalLabel">{{__('invocation_notification.invocatiom_cancellelation')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!!Form::open(['route' => ['invocationCancellelation', $invocationData->id], 'id' => 'claimExaminerForm'])!!}
      <div class="modal-body">
        <div class="form-group">
          {!!Form::label('claim_examiner',__('invocation_notification.cancellelation_reason'))!!}
          {!!Form::select('cancellelation_reason_id',[''=>'']+$cancellelation_reason,null, ['class' => 'form-control jsSelect2ClearAllow required','data-placeholder'=>'Select Cancellelation Reason'])!!}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      {!!Form::close()!!}
    </div>
  </div>
</div>