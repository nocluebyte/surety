@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
    'back_action'=> route('proposals.show', encryptId($proposal_id)),
    'text' => __('common.back'),
    'permission' => $current_user->hasAnyAccess(['users.superadmin', 'proposals.issue_bond']),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'bond_policies_issue.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'bondPoliciesIssueForm',
        ]) !!}
        <div class="card card-custom gutter-b">

            <div class="card-body">
                <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10"></h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <h2 class="text-right"><b>{{ $reference_no ?? ''}}</b></h2>
                    </div>
                </div>
                <form class="form">
                    <div class="row">
                        {!! Form::hidden('proposal_id', $proposal_id ?? null) !!}
                        {!! Form::hidden('version', $nbiData->version ?? null) !!}
                        {!! Form::hidden('contractor_id', $nbiData->contractor_id ?? null) !!}
                        {!! Form::hidden('tender_details_id', $nbiData->proposal->tender_details_id ?? null) !!}
                        {!! Form::hidden('reference_no', $reference_no ?? null) !!}
                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.insured_name'), __('bond_policies_issue.insured_name')) !!}<i class="text-danger">*</i>
                            {!! Form::text('insured_name', $nbiData->contractor->company_name ?? null, ['class' => 'form-control required jsDisabledField','disabled']) !!}
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="form-group col-lg-6">
                            {!! Form::label('bond_number', __('bond_policies_issue.bond_number')) !!}
                            {!! Form::text('bond_number', null, [
                                'class' => 'form-control',
                                'data-rule-Remarks' => true,
                                'data-rule-remote' => route('common.checkUniqueField', [
                                    'field' => 'bond_number',
                                    'model' => 'bond_policies_issue',
                                    'id' => '',
                                ]),
                                'data-msg-remote' => 'The Bond Number has already been taken.',
                            ]) !!}
                        </div>
                        <div class="col-6 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('bond_stamp_paper', __('bond_policies_issue.bond_stamp_paper')) !!}
                            </div>
                            <div class="d-block">
                                {!! Form::file('bond_stamp_paper[]', [
                                    'class' => 'bond_stamp_paper jsDocument',
                                    'multiple',
                                    'maxfiles' => 5,
                                    'maxsizetotal' => '52428800',
                                    'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                    'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                    'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                ]) !!}
                                @php
                                    $data_bond_stamp_paper = isset($dms_data) ? count($dms_data) : 0;
                                    $dsbtcls = $data_bond_stamp_paper == 0 ? 'disabled' : '';
                                @endphp
                                <a href="{{ route('dMSDocument', '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                                    data-url="{{ route('dMSDocument', ['id' => '', 'attachment_type' => 'bond_stamp_paper', 'dmsable_type' => 'BondPoliciesIssue']) }}"
                                    class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="bond_stamp_paper"
                                    data-delete="jsBondStampPaperDeleted">
                                    <span class="navi-icon"><span class="length_bond_stamp_paper"
                                            data-bond_stamp_paper ='{{ $data_bond_stamp_paper }}'>{{ $data_bond_stamp_paper }}</span>&nbsp;Document</span>
                                </a>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.insured_address'), __('bond_policies_issue.insured_address')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('insured_address', $nbiData->proposal->contractor_bond_address ?? null, ['class' => 'form-control required jsDisabledField', 'rows' => 2,'disabled']) }}
                        </div>

                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.project_details'), __('bond_policies_issue.project_details')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('project_details', $nbiData->project_details ?? null, ['class' => 'form-control required jsDisabledField', 'rows' => 2,'disabled']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.beneficiary_id'), __('bond_policies_issue.beneficiary')) !!}<i class="text-danger">*</i>
                            {!! Form::select('beneficiary_id', ['' => 'Select Beneficiary'] + $beneficiaries,  $nbiData->beneficiary_id ?? null, [
                                'class' => 'form-control required jsDisabledField',
                                'style' => 'width:100%;',
                                'id' => 'beneficiary_id',
                                'data-placeholder' => 'Select Beneficiary',
                                'disabled'
                            ]) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.beneficiary_address'), __('bond_policies_issue.beneficiary_address')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('beneficiary_address', $nbiData->beneficiary_address ?? null, ['class' => 'form-control required jsDisabledField', 'rows' => 2,'disabled']) }}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.beneficiary_phone_no'), __('bond_policies_issue.beneficiary_phone_no')) !!}<i class="text-danger">*</i>
                            {!! Form::text('beneficiary_phone_no', $nbiData->beneficiary_contact_person_phone_no ?? null, ['class' => 'form-control required number jsDisabledField', 'minlength' => 10, 'maxlength' => 10,'disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.bond_conditionality'), __('bond_policies_issue.bond_conditionality')) !!}<i class="text-danger">*</i>

                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('bond_conditionality', 'Conditional',  $nbiData->bond_conditionality == 'conditional' ? true : false, ['class' => 'form-check-input jsDisabledField', 'id' => '','disabled']) }}
                                    <span></span>Conditional
                                </label>
                                <label class="radio">
                                    {{ Form::radio('bond_conditionality', 'Unconditional', $nbiData->bond_conditionality == 'unconditional' ? true : false, ['class' => 'form-check-input jsDisabledField', 'id' => '','disabled']) }}
                                    <span></span>Unconditional
                                </label>
                            </div>
                        </div>

                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.contract_value'), __('bond_policies_issue.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('contract_value', $nbiData->contract_value ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {!! Form::label('bond_type', __('bond_policies_issue.bond_type')) !!}<i class="text-danger">*</i>
                            {!! Form::select('bond_type_id', ['' => ''] + $bond_types,  $nbiData->bond_type ?? null, [
                                'class' => 'form-control required jsDisabledField jsSelect2ClearAllow',
                                'style' => 'width:100%;',
                                'id' => 'bond_type_id',
                                'data-placeholder' => 'Select Bond Type',
                                'disabled'
                            ]) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.contract_currency'), __('bond_policies_issue.contract_currency')) !!}<i class="text-danger">*</i>
                            {{-- {!! Form::text('contract_currency', null, ['class' => 'form-control required']) !!} --}}
                             {!! Form::select('contract_currency', ['' => ''] + $currencys, $nbiData->contract_currency_id ?? null, ['class' => 'form-control required jsDisabledField jsSelect2ClearAllow', 'data-placeholder' => 'Select contract currency','disabled'])
                                            !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.bond_value'), __('bond_policies_issue.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('bond_value', $nbiData->bond_value ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group">
                            {!! Form::label('cash_margin', __('bond_policies_issue.cash_margin')) !!}<i class="text-danger">*</i>
                            {!! Form::text('cash_margin', $nbiData->cash_margin_if_applicable ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.tender_id'), __('bond_policies_issue.tender_id')) !!}<i class="text-danger">*</i>
                            {!! Form::text('tender_id', $nbiData->tender_id_loa_ref_no ?? null, ['class' => 'form-control jsDisabledField required','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {{ Form::label(__('bond_policies_issue.bond_period_start_date'), __('bond_policies_issue.bond_period_start_date')) }}<i
                                class="text-danger">*</i>
                            {!! Form::date('bond_period_start_date', $nbiData->bond_period_start_date ?? null, [
                                'class' => 'form-control required jsDisabledField minDate',
                                'min' => '1000-01-01',
                                'max' => '9999-12-31',
                                'id' => 'bond_period_start_date',
                                'data-msg-min' => 'Please enter a value greater than or equal to 01/01/1000.',
                                'disabled'
                            ]) !!}
                        </div>

                        <div class="col-4 form-group">
                            {{ Form::label(__('bond_policies_issue.bond_period_end_date'), __('bond_policies_issue.bond_period_end_date')) }}<i
                                class="text-danger">*</i>
                            {!! Form::date('bond_period_end_date', $nbiData->bond_period_end_date ?? null, [
                                'class' => 'form-control required jsDisabledField minDate',
                                'min' => '1000-01-01',
                                'max' => '9999-12-31',
                                'id' => 'bond_period_end_date',
                                'disabled'
                            ]) !!}
                        </div>

                        <div class="col-4 form-group">
                            {{ Form::label(__('bond_policies_issue.bond_period'), __('bond_policies_issue.bond_period')) }}<i
                                class="text-danger">*</i>
                            {!! Form::number('bond_period', $nbiData->bond_period_days ?? null, [
                                'class' => 'form-control jsDisabledField form-control-solid required',
                                'name' => 'bond_period',
                                'min' => '1',                               
                                'id' => 'bond_period',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {!! Form::label('rate', __('bond_policies_issue.rate')) !!}<i class="text-danger">*</i>
                            {!! Form::text('rate', $nbiData->rate ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.net_premium'), __('bond_policies_issue.net_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('net_premium', $nbiData->net_premium ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.gst'), __('bond_policies_issue.gst')) !!}<i class="text-danger">*</i>
                            {!! Form::text('gst', $nbiData->hsn_code->gst ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.gst_amount'), __('bond_policies_issue.gst_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('gst_amount', $nbiData->gst_amount ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.gross_premium'), __('bond_policies_issue.gross_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('gross_premium', $nbiData->gross_premium ?? null, ['class' => 'form-control  jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.stamp_duty_charges'), __('bond_policies_issue.stamp_duty_charges')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('stamp_duty_charges', $nbiData->stamp_duty_charges ?? null, ['class' => 'form-control required  jsDisabledField number','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.total_premium'), __('bond_policies_issue.total_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                            {!! Form::text('total_premium', $nbiData->total_premium_including_stamp_duty ?? null, ['class' => 'form-control jsDisabledField required number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.intermediary_name'), __('bond_policies_issue.intermediary_name')) !!}
                            {!! Form::text('intermediary_name', $nbiData->intermediary_name ?? null, ['class' => 'form-control jsDisabledField','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.intermediary_code'), __('bond_policies_issue.intermediary_code')) !!}
                            {!! Form::text('intermediary_code', $nbiData->intermediary_code_and_contact_details ?? null, ['class' => 'form-control jsDisabledField','disabled']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 form-group">
                            {{ Form::label(__('bond_policies_issue.premium_date'), __('bond_policies_issue.premium_date')) }}
                            {!! Form::date('premium_date', $checklistData->date_of_receipt ?? null, [
                                'class' => 'form-control jsDisabledField',
                                'min' => '1000-01-01',
                                'max' => '9999-12-31',
                                'id' => 'premium_date',
                                'disabled'
                            ]) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.premium_amount'), __('bond_policies_issue.premium_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            {!! Form::text('premium_amount', $checklistData->premium_amount ?? null, ['class' => 'form-control jsDisabledField number','disabled']) !!}
                        </div>

                        <div class="col-4 form-group">
                            {!! Form::label(__('bond_policies_issue.additional_premium'), __('bond_policies_issue.additional_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            {!! Form::text('additional_premium', null, ['class' => 'form-control number']) !!}
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.phone_no'), __('bond_policies_issue.phone_no')) !!}<i class="text-danger">*</i>
                            {!! Form::text('phone_no', null, ['class' => 'form-control required number', 'minlength' => 10, 'maxlength' => 10]) !!}
                        </div> --}}

                        <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.special_condition'), __('bond_policies_issue.special_condition')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('special_condition', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-Remarks' => true,]) }}
                        </div>

                        {{-- <div class="col-6 form-group">
                            {!! Form::label(__('bond_policies_issue.bond_validity'), __('bond_policies_issue.bond_validity')) !!}<i class="text-danger">*</i>
                            {!! Form::text(
                                'bond_validity',
                                // Carbon::parse($bid_bond->bond_start_date)->diffInDays(Carbon::parse($bid_bond->bond_end_date)),
                                null,
                                ['class' => 'form-control required number'],
                            ) !!}
                        </div> --}}
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
        </div>
        <div id="load-modal"></div>

        @section('scripts')
            @include('bond.bond_policies_issue.script')
        @endsection
        {!! Form::close() !!}
    </div>
</div>

@endsection
