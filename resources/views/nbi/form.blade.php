@php
$terms_conditions = $nbi->bond_wording ?? getSetting('terms_conditions');
$proposal_code = $proposal->tender->code ?? '';
$proposal_tender_id = $proposal->tender->tender_id ?? '';
$tender_id_loa_ref_no = $proposal_code .' | '.$proposal_tender_id;
@endphp
<div class="container-fluid">
    @include('components.error')
    <div class="row">
        <div class="col-sm-12">
            <div class="card" id="default">
                <div class="card-body pt-5">

                    <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                        <h1 class="display-4 font-weight-boldest mb-10"></h1>
                        <div class="d-flex flex-column align-items-md-end px-0">
                            <div class="form-group row mt-3">
                                {!! Form::label('policy_no',trans("nbi.policy_no").':',['class' => 'col-lg-7 col-form-label text-right'])!!}
                                <div class="col-lg-5 pr-2">
                                    {!! Form::text('policy_no', $nbi->policy_no ?? $seriesNumber, [ 'class' => 'form-control form-control-solid required', 'readonly' => ''])
                                        !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <table class="w-100">
                                {{ Form::hidden('proposal_id', $proposal->id, ['id' => 'id']) }}
                                {{ Form::hidden('version', $proposal->version, ['id' => 'version']) }}
                                <tr>
                                    @php
                                        if(isset($proposal->proposalContractors) && count($proposal->proposalContractors) > 0){
                                            $contractorId = $proposal->proposalContractors->first()->proposal_contractor_id;
                                        }
                                    @endphp
                                    <td class="w-25"> {!! Form::label('insured_name_principal_debtor', trans('nbi.insured_name_principal_debtor')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('contractor_id', ['' => ''] + $contractors, $proposal->contractor_id ?? $contractorId ?? null, ['class' => 'form-control required jsSelect2ClearAllow jsContractorId jsDisabledField', 'data-placeholder' => 'Select Insured Name/ Principal Debtor','disabled'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('insured_address', trans('nbi.insured_address')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('insured_address', $nbi->insured_address ?? $proposal->register_address ?? null, ['class' => 'form-control jsDisabledField required','disabled'])!!}
                                        </div>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="w-25"> {!! Form::label('endorsement_number', trans('nbi.endorsement_number')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('endorsement_number', $nbi->endorsement_number ?? $proposal->Endorsement->endorsement_number ?? null, ['class' => 'form-control required jsDisabledField','disabled'])!!}                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('project_details', trans('nbi.project_details')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            @php
                                                $project_detail = $proposal->projectDetails->code.' | '.$proposal->projectDetails->project_name;
                                            @endphp
                                            {!! Form::text('project_details', $nbi->project_details ?? $project_detail ?? null, ['class' => 'form-control required jsDisabledField','disabled'])!!}                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('beneficiary', trans('nbi.beneficiary')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('beneficiary_id', ['' => ''] + $beneficiary, $proposal->beneficiary_id ?? $nbi->beneficiary_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow jsDisabledField', 'data-placeholder' => 'Select beneficiary','disabled'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('beneficiary_address', trans('nbi.beneficiary_address')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('beneficiary_address', $proposal->beneficiary_address ?? $nbi->beneficiary_address ?? null, ['class' => 'form-control form-control-solid required','data-rule-AlphabetsAndNumbersV3' => true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('beneficiary_contact_person_name', trans('nbi.beneficiary_contact_person_name')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('beneficiary_contact_person_name', $nbi->beneficiary_contact_person_name ?? null, ['class' => 'form-control required','data-rule-AlphabetsV1' => true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('beneficiary_contact_person_phone_no', trans('nbi.beneficiary_contact_person_phone_no')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('beneficiary_contact_person_phone_no', $nbi->beneficiary_contact_person_phone_no ?? null, ['class' => 'form-control required','data-rule-MobileNo'=>true,'maxLength' => 10])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_type', trans('nbi.bond_type')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('bond_type', ['' => ''] + $bondTypes, $proposal->bond_type ?? $nbi->bond_type, ['class' => 'form-control required jsSelect2ClearAllow jsDisabledField', 'data-placeholder' => 'Select bond type','disabled'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td class="w-25"> {!! Form::label('bond_number', trans('nbi.bond_number')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('bond_number', $nbi->bond_number ?? null, ['class' => 'form-control jsBondNumber required', 'data-rule-AlphabetsAndNumbersV5' => true,
                                                'data-rule-remote' => route('common.checkUniqueField', [
                                                    'field' => 'bond_number',
                                                    'model' => 'nbis',
                                                    'id' => $nbi->id ?? '',
                                                ]),'data-msg-remote' => 'The bond number has been already taken.'
                                            ])
                                            !!}
                                        </div>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_conditionality', trans('nbi.bond_conditionality')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('bond_conditionality', ['' => '','conditional'=>'Conditional','unconditional'=>'Unconditional'], $nbi->bond_conditionality ?? null, ['class' => 'form-control required jsSelect2ClearAllow', 'data-placeholder' => 'Select bond conditionality'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('contract_value', trans('nbi.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('contract_value', $proposal->contract_value ?? $nbi->contract_value ?? null, ['class' => 'form-control form-control-solid required jsOnlyNumber','min'=>'1','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('contract_currency_id', trans('nbi.contract_currency')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('contract_currency_id', ['' => ''] + $currencys, $proposal->contractor->country->currency->id ?? $nbi->contract_currency_id ?? '', ['class' => 'form-control required jsSelect2ClearAllow jsDisabledField', 'data-placeholder' => 'Select contract currency', 'disabled'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_value', trans('nbi.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    @php
                                        $bondValue = $proposal->status == 'Rejected' ? 0 : $proposal->bond_value;
                                    @endphp
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('bond_value', $bondValue ?? $nbi->bond_value ?? null, ['class' => 'form-control form-control-solid required jsOnlyNumber jsBondValue','min'=>'0','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('cash_margin_if_applicable', trans('nbi.cash_margin_if_applicable')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('cash_margin_if_applicable', $nbi->cash_margin_if_applicable ?? null, ['class' => 'form-control required jsCashMargin','data-rule-PercentageV1'=>true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25">
                                        {!! Form::label('cash_margin_amount', trans('nbi.cash_margin_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::number('cash_margin_amount', null, ['class' => 'form-control required jsCashMarginAmount', 'data-rule-Numbers' => true,]) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('tender_id_loa_ref_no', trans('nbi.tender_id_loa_ref_no')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('tender_id_loa_ref_no', $tender_id_loa_ref_no, ['class' => 'form-control required form-control-solid','readonly'=>true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_period_start_date', trans('nbi.bond_period_start_date')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::date('bond_period_start_date', $proposal->bond_start_date ?? $nbi->bond_period_start_date ?? null, ['class' => 'form-control required jsBondPeriodStartDate form-control-solid', 'min' => '1000-01-01',
                                            'max' => '9999-12-31','readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_period_end_date', trans('nbi.bond_period_end_date')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::date('bond_period_end_date', $proposal->bond_end_date ?? $nbi->bond_period_end_date ?? null, ['class' => 'form-control form-control-solid required jsBondPeriodEndDate', 'min' => '1000-01-01',
                                            'max' => '9999-12-31','readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_period_days', trans('nbi.bond_period_days')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('bond_period_days', $proposal->bond_period ?? $nbi->bond_period_days ?? null, ['class' => 'form-control required form-control-solid jsBondPeriodDays','data-rule-Numbers'=>true,'readonly'=>true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('initial_fd_validity', trans('nbi.initial_fd_validity')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::date('initial_fd_validity', $bond_nbi->initial_fd_validity ?? null, [
                                                'class' => 'form-control required jsInitialFDValidity',
                                            ]) !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('rate', trans('nbi.rate')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('rate', $nbi->rate ?? null, ['class' => 'form-control required jsRate','data-rule-PercentageV1'=>true])!!}
                                            <span class="text-danger rate-error jsRateError" for="rate"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('net_premium', trans('nbi.net_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('net_premium', $nbi->net_premium ?? null, ['class' => 'form-control form-control-solid required jsOnlyNumber jsNetPremium jsReadOnly','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('hsn_code_id', trans('nbi.gst')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('hsn_code_id', ['' => ''] + $hsn_codes, $nbi->gst ?? null, ['class' => 'form-control required jsHsnCodeId jsSelect2ClearAllow', 'data-placeholder' => 'Select gst'],$hsnAttr)
                                            !!}
                                            {{-- {!! Form::text('gst', $nbi->gst ?? null, ['class' => 'form-control required jsTwoDecimal jsGst','data-rule-decimal'=>true,'min'=>0,'max'=>100])!!} --}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('gst_amount', trans('nbi.gst_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::hidden('cgst', $nbi->cgst ?? null, ['class' => 'jsCgst'])!!}
                                            {!! Form::hidden('cgst_amount', $nbi->cgst_amount ?? null, ['class' => 'jsCgstAmount'])!!}
                                            {!! Form::hidden('sgst', $nbi->sgst ?? null, ['class' => 'jsSgst'])!!}
                                            {!! Form::hidden('sgst_amount', $nbi->sgst_amount ?? null, ['class' => 'jsSgstAmount'])!!}
                                            {!! Form::hidden('igst', $nbi->igst ?? null, ['class' => 'jsIgst'])!!}
                                            {!! Form::text('gst_amount', $nbi->gst_amount ?? null, ['class' => 'form-control form-control-solid required jsGstAmount','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('gross_premium', trans('nbi.gross_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('gross_premium', $nbi->gross_premium ?? null, ['class' => 'form-control form-control-solid required jsGrossPremium','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('stamp_duty_charges', trans('nbi.stamp_duty_charges')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('stamp_duty_charges', $nbi->stamp_duty_charges ?? null, ['class' => 'form-control required jsOnlyNumber jsStampDutyCharges','min'=>'1','data-rule-Numbers'=>true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('total_premium_including_stamp_duty', trans('nbi.total_premium_including_stamp_duty')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('total_premium_including_stamp_duty', $nbi->total_premium_including_stamp_duty ?? null, ['class' => 'form-control form-control-solid required jsTotalPremiumIncludingStampDuty','data-rule-Numbers'=>true,'readonly'])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('intermediary_name', trans('nbi.intermediary_name')) !!}:
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('intermediary_name', $nbi->intermediary_name ?? null, ['class' => 'form-control','data-rule-AlphabetsV1' => true])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('intermediary_code_and_contact_details', trans('nbi.intermediary_code_and_contact_details')) !!}:
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::text('intermediary_code_and_contact_details', $nbi->intermediary_code_and_contact_details ?? null, ['class' => 'form-control','data-rule-MobileNo'=>true,'maxLength' => 10])!!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('trade_sector_id', trans('nbi.sector')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('trade_sector_id', ['' => ''] + $sector, $nbi->trade_sector_id ?? $trade_sector_data->trade_sector_id ??  null, ['class' => 'form-control required jsSelect2ClearAllow jsDisabledField', 'data-placeholder' => 'Select Sector','disabled'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('re_insurance_grouping_id', trans('nbi.re_insurance_grouping')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('re_insurance_grouping_id', ['' => ''] + $re_insurance_grouping, $nbi->re_insurance_grouping_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow jsReInsuranceGroupingId', 'data-placeholder' => 'Select Re-Insurance Grouping'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('issuing_office_branch_id', trans('nbi.issuing_office_branch')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::select('issuing_office_branch_id', ['' => ''] + $issuingOfficeBranchs, $nbi->issuing_office_branch_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow', 'data-placeholder' => 'Select Issuing Office Branch'])
                                            !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-25"> {!! Form::label('bond_wording', trans('nbi.terms_conditions')) !!}:<span class="text-danger">*</span>
                                    </td>
                                    <td class="p-1 w-40 pr-10">
                                        <div class="form-group row">
                                            {!! Form::textArea('bond_wording', $terms_conditions, ['class' => 'form-control'])!!}
                                            {{-- <label id="bond_wording-error" class="text-danger" for="bond_wording-error"></label> --}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 text-right ">
                                {!! link_to(URL::full(), __('common.reset'), ['class' => 'btn btn-light mr-3']) !!}
                                @if($nbi)
                                <button type="submit" class="btn btn-primary jsBtnLoader">{{ __('common.generate') }}</button>
                                @else
                                <button type="submit" class="btn btn-primary jsBtnLoader">{{ __('common.save') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="load-modal"></div>
@section('scripts')
    <script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
    @include('nbi.script')
@endsection('scripts')
