<div class="modal fade bd-example-modal-lg" id="tfaction" tabindex="-5" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{ __('cases.transfer') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('transfer-underwriter') }}" enctype="multipart/form-data" id="transferFormAction">
                    @csrf
                    @php
                        $nowDate = date('Y-m-d', strtotime(Carbon\Carbon::now()));
                    @endphp
                    <input type="hidden" name="cases_action_plan_id" value="{{ $case_action_plan->id ?? '' }}">
                    <input type="hidden" name="cases_id" value="{{ $case->id ?? '' }}">
                    <input type="hidden" name="transfer_decision_notes" value="{{ $case->transfer_decision_notes ?? '' }}">
                    <input type="hidden" name="transfer_date" value="{{ $nowDate }}">
                    <input type="hidden" class="jscasesactionData" name="casesactiondata" value="">
                    <div class="form-group">
                        {{ Form::label('transfer', __('cases.underwriter')) }}<i class="text-danger">*</i>
                        {{ Form::select('transfer', ['' => 'Select'] + $underwriter, null, [
                            'class' => 'form-control  jsUnderwriter required',
                            'data-placeholder' => 'Select Underwriter',
                            'id' => 'transfer_action',
                        ]) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('transfernote', __('cases.notes')) }}<i class="text-danger">*</i>
                        {!! Form::textarea('transfernote', null, ['class' => 'form-control required ', 'rows' => '3']) !!}
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary jsTrasferCloseBtn" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary jsTrasferSaveBtn" type="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>