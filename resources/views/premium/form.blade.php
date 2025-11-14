<div class="card card-custom gutter-b">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
            <h1 class="display-4 font-weight-boldest mb-10"></h1>
            <div class="d-flex flex-column align-items-md-end px-0">
                <h2 class="text-right"><b>{{ $generateCode ?? ''}}</b></h2>                        
            </div>
        </div>
        <form class="form">
            
            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('bond_type', __('invocation_notification.bond_type')) !!}<i class="text-danger">*</i>
                    {{ Form::select('bond_type', ['' => ''] + $bond_types, $proposalData->bond_type_id ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required bond_type', 'data-placeholder' => 'Select Bond Type', 'data-ajaxurl' => route('getProposalbyBond')]) }}
                </div>
                <div class="col-6 form-group">
                    {!! Form::label('proposal_id', __('invocation_notification.proposal')) !!}<i class="text-danger">*</i>
                    {{ Form::select('proposal_id', ['' => ''], $proposalData->id ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required proposal_id', 'data-placeholder' => 'Select Bond', 'data-ajaxurl' => route('getProposalId'),]) }}
                </div>
                {{-- <div class="col-6 form-group">
                    {!! Form::label('bond_id', __('premium.bond_number')) !!}<i class="text-danger">*</i>
                    {!! Form::select('bond_id', ['' => ''] + $bond, null, [
                        'class' => 'form-control required bond_number jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Bond Number',
                        'data-ajaxurl' => route('getBondId'),
                ]) !!}
                </div> --}}
            </div>
            {{-- @dd($bondType) --}}

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('tender_id', __('premium.tender')) !!}<i class="text-danger">*</i>
                    {!! Form::select('tender_id', ['' => ''] + $tenders, null, [
                        'class' => 'form-control form-control-solid required tender_id jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Tender',
                        'disabled',
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('beneficiary_id', __('premium.beneficiary')) !!}<i class="text-danger">*</i>
                    {!! Form::select('beneficiary_id', ['' => ''] + $beneficiary, null, [
                        'class' => 'form-control form-control-solid required beneficiary_id jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Beneficiary',
                        'disabled',
                    ]) !!}
                </div>
            </div>

            <div class="contractor_data">

            </div>

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('payment_received', __('premium.payment_received')) !!}<i class="text-danger">*</i>
                    {!! Form::text('payment_received', null, ['class' =>'form-control required', 'data-rule-Numbers' => true]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('payment_received_date', __('premium.payment_received_date')) !!}<i class="text-danger">*</i>
                    {!! Form::date('payment_received_date', null, ['class' => 'form-control required payment_received_date', 'min' => '1000-01-01', 'max' => '9999-12-31']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('bond_value', __('premium.bond_value')) !!}<i class="text-danger">*</i>
                    {!! Form::text('bond_value', null, ['class' =>'form-control bond_value required form-control-solid', 'data-rule-Numbers' => true, 'readonly']) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('remarks', __('premium.remarks')) !!}<i class="text-danger">*</i>
                    {!! Form::textarea('remarks', null, ['class' => 'form-control required', 'rows' => 2, 'cols' => 2, 'data-rule-Remarks' => true,]) !!}
                </div>
            </div>

            <div class="row card-footer pb-5 pt-5">
                <div class="col-12 text-right">
                    <input class="jsSaveType" name="save_type" type="hidden">
                    <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                    <button type="submit" id="btn_loader_save" class="btn btn-primary jsBtnLoader"
                        name="saveBtn">{{ __('common.save') }}</button>
                    <button type="submit" id="btn_loader" class="btn btn-primary jsBtnLoader"
                        name="saveExitBtn">{{ __('common.save_exit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
    @include('premium.script')
@endsection
