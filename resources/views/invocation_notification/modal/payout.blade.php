<!-- Modal -->
<div class="modal fade" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!!Form::open(['route' => ['invocationPayout', $invocationData->id], 'id' => 'invocationPayoutForm'])!!}
      <div class="modal-body">
        <div class="form-group">
          {!!Form::label('bond_value',__('invocation_notification.bond_value'))!!}
          {!!Form::number('invocation_amount', $invocationData->invocation_amount ?? '', [
            'class' => 'form-control form-control-solid required text-right','readonly'])
          !!}
        </div>
        <div class="form-group">
          {!!Form::label('claimed_amount', __('invocation_notification.claimed_amount'))!!}
          {!!Form::number('claimed_amount', null, ['class' => 'form-control claimed_amount required text-right','max'=>$invocationData->invocation_amount ?? 0])!!}
        </div>
        <div class="form-group">
          {!!Form::label('disallowed_amount', __('invocation_notification.disallowed_amount'))!!}
          {!!Form::number('disallowed_amount', null, ['class' => 'form-control disallowed_amount required text-right','max'=>$invocationData->invocation_amount ?? 0])!!}
        </div>
        <div class="form-group">
          {!!Form::label('total_approved_bond_value',__('invocation_notification.total_approved_bond_value'))!!}
          {!!Form::number('total_approved_bond_value', null, ['class' => 'form-control total_approved_bond_value required text-right','max'=>$invocationData->invocation_amount ?? 0, 'readonly'])
                  !!}
        </div>
        <div class="form-group">
          {!!Form::label('remark',__('invocation_notification.remark'))!!}
          {!!Form::textarea('payout_remark', null, ['class' => 'form-control required','rows'=>2])!!}
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