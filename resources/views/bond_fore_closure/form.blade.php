<div class="card" id="default">
    <div class="card-body pt-5">
        @php
            $currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
            $bond_number = ($reference_no ?? '') . (isset($bondNumber) ? " | $bondNumber" : '');
        @endphp
        <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
            <h1 class="display-4 font-weight-boldest mb-10"></h1>
            <div class="d-flex flex-column align-items-md-end px-0">
                <h2 class="text-right"><b>{{ $reference_no ?? ''}}</b></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-4 form-group">
                {!! Form::hidden('bond_number', $bondNumber ?? null) !!}
                {{ Form::label('issue_bond_number', __('bond_fore_closure.bond_number')) }}<i class="text-danger">*</i>
                {{ Form::text('issue_bond_number', $bond_number ?? '', ['class' => 'form-control form-control-solid required', 'readonly']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('contractor_id', __('bond_fore_closure.contractor')) }}<i class="text-danger">*</i>
                {{ Form::select('contractor_id', ['' => ''] + $contractors, $proposal->contractor_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow contractor_id', 'disabled']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('beneficiary_id', __('bond_fore_closure.beneficiary')) }}<i class="text-danger">*</i>
                {{ Form::select('beneficiary_id', ['' => ''] + $beneficiary, $proposal->beneficiary_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow beneficiary_id', 'disabled']) }}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {{ Form::label('project_details_id', __('bond_fore_closure.project_details')) }}<i class="text-danger">*</i>
                {{ Form::select('project_details_id', ['' => ''] + $project_details, $proposal->project_details ?? null, ['class' => 'form-control required jsSelect2ClearAllow project_details_id', 'disabled']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('tender_id', __('bond_fore_closure.tender')) }}<i class="text-danger">*</i>
                {{ Form::select('tender_id', ['' => ''] + $tenders, $proposal->tender_details_id ?? null, ['class' => 'form-control required jsSelect2ClearAllow tender_id', 'disabled']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('bond_type_id', __('bond_fore_closure.bond_type')) }}<i class="text-danger">*</i>
                {{ Form::select('bond_type_id', ['' => ''] + $bond_types, $proposal->bond_type ?? null, ['class' => 'form-control required jsSelect2ClearAllow bond_type_id', 'disabled']) }}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {{ Form::label('bond_start_date', __('bond_fore_closure.bond_start_date')) }}<i class="text-danger">*</i>
                {{ Form::date('bond_start_date', $proposal->bond_start_date ?? null, ['class' => 'form-control form-control-solid required', 'readonly']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('bond_end_date', __('bond_fore_closure.bond_end_date')) }}<i class="text-danger">*</i>
                {{ Form::date('bond_end_date', $proposal->bond_end_date ?? null, ['class' => 'form-control form-control-solid required', 'readonly']) }}
            </div>

            <div class="col-4 form-group">
                {!! Form::label('bond_conditionality', __('bond_fore_closure.bond_conditionality')) !!}<i class="text-danger">*</i>

                <div class="radio-inline">
                    <label class="radio">
                        {{ Form::radio('bond_conditionality', 'Conditional', isset($nbi->bond_conditionality) && $nbi->bond_conditionality == true ? true : false, ['class' => 'form-check-input bond_conditionality', 'id' => '', 'disabled',]) }}
                        <span></span>Conditional
                    </label>
                    <label class="radio">
                        {{ Form::radio('bond_conditionality', 'Unconditional', isset($nbi->bond_conditionality) && $nbi->bond_conditionality == true ? true : false, ['class' => 'form-check-input bond_conditionality', 'id' => '', 'disabled',]) }}
                        <span></span>Unconditional
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {{ Form::label('premium_amount', __('bond_fore_closure.premium_amount')) }} {{ $currencySymbol }}<i class="text-danger">*</i>
                {{ Form::text('premium_amount', $nbi->total_premium_including_stamp_duty ?? '', ['class' => 'form-control form-control-solid required text-right', 'readonly']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('type_of_foreclosure_id', __('bond_fore_closure.type_of_foreclosure')) }}<i class="text-danger">*</i>
                {{ Form::select('type_of_foreclosure_id', ['' => ''] + $type_of_foreclosure, null, ['class' => 'form-control required jsSelect2ClearAllow', 'data-placeholder' => 'Select Type of ForeClosure']) }}
            </div>

            <div class="col-4 form-group">
                {{ Form::label('foreclosure_date', __('bond_fore_closure.foreclosure_date')) }}<i class="text-danger">*</i>
                {{ Form::date('foreclosure_date', null, ['class' => 'form-control required', 'min' => $start_foreclosure_date ?? null]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-8 form-group">
                {{ Form::label('any_other_reasons', __('bond_fore_closure.any_other_reasons')) }}<i class="text-danger">*</i>
                {{ Form::textarea('any_other_reasons', null, ['class' => 'form-control required', 'rows' => 2, 'cols' => 2]) }}
            </div>

            <div class="col-4 form-group jsDivClass">
                {!! Form::label('proof_of_foreclosure', __('bond_fore_closure.proof_of_foreclosure')) !!}<i class="text-danger">*</i>
                {!! Form::file('proof_of_foreclosure[]', [
                    'class' => 'proof_of_foreclosure jsDocument',
                    'id' => 'proof_of_foreclosure',
                    empty($dms_data) ? 'required' : '',
                    'multiple',
                    'maxfiles' => 5,
                    'maxsizetotal' => '52428800',
                    'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                    'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                ]) !!}
                @php
                    $data_proof_of_foreclosure = isset($dms_data) ? count($dms_data) : 0;
                    $dsbtcls = $data_proof_of_foreclosure == 0 ? 'disabled' : '';
                @endphp
                <a href="{{ route('dMSDocument', '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                    data-url="{{ route('dMSDocument', ['id' => '', 'attachment_type' => 'proof_of_foreclosure', 'dmsable_type' => 'BondForeClosure']) }}"
                    class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="proof_of_foreclosure"
                    data-delete="jsProofOfForeclosureDeleted">
                    <span class = "count_proof_of_foreclosure" data-count_proof_of_foreclosure = "{{ $data_proof_of_foreclosure }}">{{ $data_proof_of_foreclosure }}&nbsp;document</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label('is_refund', __('bond_fore_closure.refund')) !!}<i class="text-danger">*</i>

                <div class="radio-inline">
                    <label class="radio">
                        {{ Form::radio('is_refund', 'Yes', true, ['class' => 'form-check-input is_refund', 'id' => '']) }}
                        <span></span>Yes
                    </label>
                    <label class="radio">
                        {{ Form::radio('is_refund', 'No', '', ['class' => 'form-check-input is_refund', 'id' => '']) }}
                        <span></span>No
                    </label>
                </div>
            </div>

            <div class="col-8 form-group jsShowRefundRemarks">
                {{ Form::label('refund_remarks', __('bond_fore_closure.refund_remarks')) }}<i class="text-danger">*</i>
                {{ Form::textarea('refund_remarks', null, ['class' => 'form-control required refund_remarks', 'rows' => 2, 'cols' => 2]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label('is_original_bond_received', __('bond_fore_closure.original_bond_received')) !!}<i class="text-danger">*</i>

                <div class="radio-inline">
                    <label class="radio">
                        {{ Form::radio('is_original_bond_received', 'Yes', true, ['class' => 'form-check-input is_original_bond_received', 'id' => '']) }}
                        <span></span>Yes
                    </label>
                    <label class="radio">
                        {{ Form::radio('is_original_bond_received', 'No', '', ['class' => 'form-check-input is_original_bond_received', 'id' => '']) }}
                        <span></span>No
                    </label>
                </div>
            </div>

            <div class="col-4 form-group jsDivClass jsShowOriginalBondReceived">
                <div class="d-block">
                    {!! Form::label('original_bond_received_attachment', __('bond_fore_closure.attachment')) !!}<i class="text-danger">*</i>
                </div>

                <div class="d-block">
                    {!! Form::file('original_bond_received_attachment[]', [
                        'class' => 'original_bond_received_attachment jsDocument required',
                        'id' => 'original_bond_received_attachment',
                        // empty($dms_data) ? 'required' : '',
                        'multiple',
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ]) !!}
                    @php
                        $data_original_bond_received_attachment = isset($dms_data) ? count($dms_data) : 0;
                        $dsbtcls = $data_original_bond_received_attachment == 0 ? 'disabled' : '';
                    @endphp
                    <a href="{{ route('dMSDocument', '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => '', 'attachment_type' => 'original_bond_received_attachment', 'dmsable_type' => 'BondForeClosure']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="original_bond_received_attachment"
                        data-delete="jsOriginalBondReceivedAttachmentDeleted">
                        <span class = "count_original_bond_received_attachment" data-count_original_bond_received_attachment = "{{ $data_original_bond_received_attachment }}">{{ $data_original_bond_received_attachment }}&nbsp;document</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label('is_confirming_foreclosure', __('bond_fore_closure.confirming_foreclosure')) !!}<i class="text-danger">*</i>

                <div class="radio-inline">
                    <label class="radio">
                        {{ Form::radio('is_confirming_foreclosure', 'Yes', true, ['class' => 'form-check-input is_confirming_foreclosure', 'id' => '']) }}
                        <span></span>Yes
                    </label>
                    <label class="radio">
                        {{ Form::radio('is_confirming_foreclosure', 'No', '', ['class' => 'form-check-input is_confirming_foreclosure', 'id' => '']) }}
                        <span></span>No
                    </label>
                </div>
            </div>

            <div class="col-4 form-group jsDivClass jsShowConfirmingForeclosure">
                <div class="d-block">
                    {!! Form::label('confirming_foreclosure_attachment', __('bond_fore_closure.attachment')) !!}<i class="text-danger">*</i>
                </div>

                <div class="d-block">
                    {!! Form::file('confirming_foreclosure_attachment[]', [
                        'class' => 'confirming_foreclosure_attachment jsDocument required',
                        'id' => 'confirming_foreclosure_attachment',
                        // empty($dms_data) ? 'required' : '',
                        'multiple',
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ]) !!}
                    @php
                        $data_confirming_foreclosure_attachment = isset($dms_data) ? count($dms_data) : 0;
                        $dsbtcls = $data_confirming_foreclosure_attachment == 0 ? 'disabled' : '';
                    @endphp
                    <a href="{{ route('dMSDocument', '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => '', 'attachment_type' => 'confirming_foreclosure_attachment', 'dmsable_type' => 'BondForeClosure']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="confirming_foreclosure_attachment"
                        data-delete="jsConfirmingForeclosureAttachmentDeleted">
                        <span class = "count_confirming_foreclosure_attachment" data-count_confirming_foreclosure_attachment = "{{ $data_confirming_foreclosure_attachment }}">{{ $data_confirming_foreclosure_attachment }}&nbsp;document</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label('is_any_other_proof', __('bond_fore_closure.any_other_proof')) !!}<i class="text-danger">*</i>

                <div class="radio-inline">
                    <label class="radio">
                        {{ Form::radio('is_any_other_proof', 'Yes', true, ['class' => 'form-check-input is_any_other_proof', 'id' => '']) }}
                        <span></span>Yes
                    </label>
                    <label class="radio">
                        {{ Form::radio('is_any_other_proof', 'No', '', ['class' => 'form-check-input is_any_other_proof', 'id' => '']) }}
                        <span></span>No
                    </label>
                </div>
            </div>

            <div class="col-4 form-group jsDivClass jsShowAnyOtherProof">
                <div class="d-block">
                    {!! Form::label('any_other_proof_attachment', __('bond_fore_closure.attachment')) !!}<i class="text-danger">*</i>
                </div>

                <div class="d-block">
                    {!! Form::file('any_other_proof_attachment[]', [
                        'class' => 'any_other_proof_attachment jsDocument required',
                        'id' => 'any_other_proof_attachment',
                        // empty($dms_data) ? 'required' : '',
                        'multiple',
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ]) !!}
                    @php
                        $data_any_other_proof_attachment = isset($dms_data) ? count($dms_data) : 0;
                        $dsbtcls = $data_any_other_proof_attachment == 0 ? 'disabled' : '';
                    @endphp
                    <a href="{{ route('dMSDocument', '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => '', 'attachment_type' => 'any_other_proof_attachment', 'dmsable_type' => 'BondForeClosure']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="any_other_proof_attachment"
                        data-delete="jsAnyOtherProofAttachmentDeleted">
                        <span class = "count_any_other_proof_attachment" data-count_any_other_proof_attachment = "{{ $data_any_other_proof_attachment }}">{{ $data_any_other_proof_attachment }}&nbsp;document</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 form-group">
                {{ Form::label('other_remarks', __('bond_fore_closure.remarks')) }}<i class="text-danger">*</i>
                {{ Form::textarea('other_remarks', null, ['class' => 'form-control required other_remarks', 'rows' => 2, 'cols' => 2]) }}
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-12 text-right ">
                    {!! link_to(URL::full(), __('common.reset'), ['class' => 'btn btn-light mr-3']) !!}
                    <button type="submit" id="btn_loader" class="btn btn-primary jsBtnLoader">{{ __('common.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>
</div>
@include('bond_fore_closure.script')