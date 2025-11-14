 <div class="card card-custom gutter-b">
            <div class="card-body">
                <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10"></h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <h2 class="text-right"><b>{{ $code ?? ''}}</b></h2>                        
                    </div>
                </div>
                <form class="form">
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::hidden('invocation_notification_id', null, ['class' => 'jsInvocationNotification']) !!}
                            {!! Form::label('bond_number', __('recovery.bond_number')) !!}<i class="text-danger">*</i>
                            {{ Form::select('bond_policies_issue_id', ['' => ''] + $bond_numbers,null, ['class' => 'form-control jsSelect2ClearAllow required jsBondNumber','data-ajaxurl' => route('getRecovery'),'data-placeholder' => 'Select Bond Number']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('invocation_number', __('recovery.invocation_number')) !!}<i class="text-danger">*</i>
                            {!! Form::text('invocation_number',null, ['class' => 'form-control form-control-solid required jsInvocationNumber','readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('bond_value', __('recovery.bond_value')) !!}<span class="currency_symbol"></span><i class="text-danger">*</i>
                            {!! Form::number('bond_value',null, ['class' => 'form-control form-control-solid required jsBondValue','readonly'=>true]) !!}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('claimed_amount', __('recovery.claimed_amount')) !!}<span class="currency_symbol"></span><i class="text-danger">*</i>
                            {!! Form::number('claimed_amount',null, ['class' => 'form-control form-control-solid required jsClaimedAmount','readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('disallowed_amount', __('recovery.disallowed_amount')) !!}<span class="currency_symbol"></span><i class="text-danger">*</i>
                            {!! Form::number('disallowed_amount',null, ['class' => 'form-control form-control-solid required jsDisallowedAmount','readonly'=>true]) !!}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('total_approved_bond_value', __('recovery.total_approved_bond_value')) !!}<span class="currency_symbol"></span><i class="text-danger">*</i>
                            {!! Form::number('total_approved_bond_value',null, ['class' => 'form-control form-control-solid required jsTotalApprovedBondValue','readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('invocation_remark', __('recovery.invocation_remark')) !!}<i class="text-danger">*</i>
                            {!! Form::textarea('invocation_remark',null, ['class' => 'form-control form-control-solid required jsInvocationRemark','rows'=>2,'readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('recovery_date', __('recovery.recovery_date')) !!}<i class="text-danger">*</i>
                            {!! Form::date('recovery_date',null, ['class' => 'form-control required','max'=>now()]) !!}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('recovery_amount', __('recovery.recovery_amount')) !!}<span class="currency_symbol"></span><i class="text-danger">*</i>
                            {!! Form::number('recovery_amount',null, ['class' => 'form-control required jsRecoveryAmount']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('remark', __('recovery.remark')) !!}<i class="text-danger">*</i>
                            {!! Form::textarea('remark',null, ['class' => 'form-control required','rows'=>2]) !!}
                        </div>
                    </div>
                    <div class="card-footer pb-5 pt-5">
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="" class="mr-2">Reset</a>
                                <button type="submit" id="btn_loader" class="btn btn-primary bond_policies_issue_save"
                                    name="saveBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="load-modal"></div>
        </div>

@include('invocation_claims.script')
