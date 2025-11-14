@php
    $current_user_role = $current_user->roles->first();
   // $readonly = ($bid_bond) ? 'readonly' : '';
    //$readonly_cls = ($bid_bond) ? 'form-control-solid' : '';
    $disabled = (isset($invocationData) && $invocationData->count()>0) ? 'disabled' : '';
@endphp
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
                        {!! Form::hidden('invocation_id', $invocation_id ?? null) !!}
                        {!! Form::hidden('version', $invocationData->version ?? null) !!}
                        <div class="col-6 form-group">
                            {!! Form::label('bond_type', __('invocation_notification.bond_type')) !!}<i class="text-danger">*</i>
                            {{ Form::select('bond_type', ['' => ''] + $bond_types , $bond_type ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required bond_type', 'data-placeholder' => 'Select Bond Type',$disabled]) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('proposal_id', __('invocation_notification.proposal')) !!}<i class="text-danger">*</i>
                            {{ Form::select('proposal_id', ['' => ''] + $proposals, $invocationData->proposal_id ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required proposal_id', 'data-placeholder' => 'Select Proposal',$disabled]) }}
                        </div>
                         <div class="col-6 form-group">
                            {!! Form::label(__('invocation_claims.bond_detail'), __('invocation_claims.bond_detail')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('bond_detail', null, ['class' => 'form-control required', 'rows' => 2,'data-rule-Remarks' => true]) }}
                        </div> 
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_claims.conditional'), __('invocation_claims.conditional')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('conditional', 'Conditional',true, ['class' => 'conditional required', 'id' => 'conditional']) }}
                                    <span></span>Conditional
                                </label>
                                <label class="radio">
                                    {{ Form::radio('conditional', 'Unconditional', NULL, ['class' => 'conditional required', 'id' => 'conditional']) }}
                                    <span></span>Unconditional
                                </label>
                            </div>
                        </div>                        
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_claims.bond_wordings'), __('invocation_claims.bond_wordings')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('bond_wording', null, ['class' => 'form-control required', 'rows' => 2,'data-rule-Remarks' => true]) }}
                        </div>                          
                        <div class="col-3 form-group">
                            {!! Form::label('invocation_notice_date', __('invocation_claims.invocation_notice_date')) !!}<i class="text-danger">*</i>
                            {!! Form::date('invocation_notice_date',null, ['class' => 'form-control required', 'max' => '9999-12-31']) !!}
                        </div>
                         <div class="col-3 form-group">
                            {!! Form::label('invocation_claim_date', __('invocation_claims.invocation_claim_date')) !!}<i class="text-danger">*</i>
                            {!! Form::date('invocation_claim_date',null, ['class' => 'form-control required', 'max' => '9999-12-31']) !!}
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.claim_form'), __('invocation_claims.claim_form')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('claim_form', 'Yes',true, ['class' => 'claim_form chkRadio required', 'id' => 'claim_form']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('claim_form', 'No', NULL, ['class' => 'claim_form chkRadio required', 'id' => 'claim_form']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group claimAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('claim_form_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('claim_form_attachment[]', [
                                'id' => 'claim_form_attachment',
                                'multiple',
                                'class' => 'claim_form_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_claim_form_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_claim_form_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'claim_form_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="claim_form_attachment"
                            data-delete="jsClaimFormAttachmentDeleted">
                            <span class="navi-icon"><span class="length_claim_form_attachment"
                                    data-claim_form_attachment ='{{ $data_claim_form_attachment }}'>{{ $data_claim_form_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.invocation_notice'), __('invocation_claims.invocation_notice')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('invocation_notice', 'Yes',true, ['class' => 'invocation_notice chkRadio required', 'id' => 'invocation_notice']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('invocation_notice', 'No', NULL, ['class' => 'invocation_notice chkRadio required', 'id' => 'invocation_notice']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group noticeAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('invocation_notice_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('invocation_notice_attachment[]', [
                                'id' => 'invocation_notice_attachment',
                                'multiple',
                                'class' => 'invocation_notice_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_invocation_notice_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_invocation_notice_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'invocation_notice_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="invocation_notice_attachment"
                            data-delete="jsInvocationNoticeAttachmentDeleted">
                            <span class="navi-icon"><span class="length_invocation_notice_attachment"
                                    data-invocation_notice_attachment ='{{ $data_invocation_notice_attachment }}'>{{ $data_invocation_notice_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.contract_copy'), __('invocation_claims.contract_copy')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('contract_copy', 'Yes',true, ['class' => 'contract_copy chkRadio required', 'id' => 'contract_copy']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('contract_copy', 'No', NULL, ['class' => 'contract_copy chkRadio required', 'id' => 'contract_copy']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group contractCopyAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('contract_copy_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('contract_copy_attachment[]', [
                                'id' => 'contract_copy_attachment',
                                'multiple',
                                'class' => 'contract_copy_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_contract_copy_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_contract_copy_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'contract_copy_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="contract_copy_attachment"
                            data-delete="jsContractCopyAttachmentDeleted">
                            <span class="navi-icon"><span class="length_contract_copy_attachment"
                                    data-contract_copy_attachment ='{{ $data_contract_copy_attachment }}'>{{ $data_contract_copy_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.correspondence_details'), __('invocation_claims.correspondence_details')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('correspondence_details', 'Yes',true, ['class' => 'correspondence_details chkRadio required', 'id' => 'correspondence_details']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('correspondence_details', 'No', NULL, ['class' => 'correspondence_details chkRadio required', 'id' => 'correspondence_details']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group corresAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('correspondence_detail_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('correspondence_detail_attachment[]', [
                                'id' => 'correspondence_detail_attachment',
                                'multiple',
                                'class' => 'correspondence_detail_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_correspondence_detail_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_correspondence_detail_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'correspondence_detail_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="correspondence_detail_attachment"
                            data-delete="jsCorrespondenceDetailAttachmentDeleted">
                            <span class="navi-icon"><span class="length_correspondence_detail_attachment"
                                    data-correspondence_detail_attachment ='{{ $data_correspondence_detail_attachment }}'>{{ $data_correspondence_detail_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.arbitration'), __('invocation_claims.arbitration')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('arbitration', 'Yes',true, ['class' => 'arbitration chkRadio required', 'id' => 'arbitration']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('arbitration', 'No', NULL, ['class' => 'arbitration chkRadio required', 'id' => 'arbitration']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group arbitrationAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('arbitration_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('arbitration_attachment[]', [
                                'id' => 'arbitration_attachment',
                                'multiple',
                                'class' => 'arbitration_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_arbitration_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_arbitration_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'arbitration_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="arbitration_attachment"
                            data-delete="jsArbitrationAttachmentDeleted">
                            <span class="navi-icon"><span class="length_arbitration_attachment"
                                    data-arbitration_attachment ='{{ $data_arbitration_attachment }}'>{{ $data_arbitration_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.dispute'), __('invocation_claims.dispute')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('dispute', 'Yes',true, ['class' => 'dispute chkRadio required', 'id' => 'dispute']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('dispute', 'No', NULL, ['class' => 'dispute chkRadio required', 'id' => 'dispute']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group disputeAttachment jsDivClass">
                            <div class="d-block">
                                {!! Form::label('dispute_attachment', __('invocation_claims.attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('dispute_attachment[]', [
                                'id' => 'dispute_attachment',
                                'multiple',
                                'class' => 'dispute_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_dispute_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_dispute_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'dispute_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="dispute_attachment"
                            data-delete="jsDisputeAttachmentDeleted">
                            <span class="navi-icon"><span class="length_dispute_attachment"
                                    data-dispute_attachment ='{{ $data_dispute_attachment }}'>{{ $data_dispute_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>                        
                    </div>
                        <hr/>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_claims.banking_details')}}</strong></h6>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('bank_name', __('invocation_claims.bank_name')) !!}<i class="text-danger">*</i>
                            {!! Form::text('bank_name',null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV2' => true]) !!}
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('account_number', __('invocation_claims.account_number')) !!}<i class="text-danger">*</i>
                            {!! Form::text('account_number',null, ['class' => 'form-control required number']) !!}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_claims.address'), __('invocation_claims.address')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('bank_address', null, ['class' => 'form-control required', 'rows' => 2]) }}
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('account_type', __('invocation_claims.account_type')) !!}<i class="text-danger">*</i>
                            {!! Form::text('account_type',null, ['class' => 'form-control required']) !!}
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('micr', __('invocation_claims.micr')) !!}<i class="text-danger">*</i>
                            {!! Form::text('micr',null, ['class' => 'form-control required']) !!}
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('ifsc_code', __('invocation_claims.ifsc_code')) !!}<i class="text-danger">*</i>
                            {!! Form::text('ifsc_code',null, ['class' => 'form-control required']) !!}
                        </div>
                        
                        <div class="col-3 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('cancelled_cheque', __('invocation_claims.cancelled_cheque')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('cancelled_cheque[]', [
                                'id' => 'cancelled_cheque',
                                'multiple',
                                'class' => 'cancelled_cheque jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_cancelled_cheque = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_cancelled_cheque == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'cancelled_cheque', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="cancelled_cheque"
                            data-delete="jsCancelledChequeDeleted">
                            <span class="navi-icon"><span class="length_cancelled_cheque"
                                    data-cancelled_cheque ='{{ $data_cancelled_cheque }}'>{{ $data_cancelled_cheque }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.claimed_amount'), __('invocation_claims.claimed_amount')) !!}<i class="text-danger">*</i>
                            {!! Form::text('claimed_amount', $bondData->bond_value ?? null, ['class' => 'form-control required number claimed_amount']) !!}
                        </div> 
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.claimed_disallowed'), __('invocation_claims.claimed_disallowed')) !!}<i class="text-danger">*</i>
                            {!! Form::text('claimed_disallowed', $bondData->bond_value ?? null, ['class' => 'form-control required number claimed_disallowed']) !!}
                        </div> 
                        <div class="col-3 form-group">
                            {!! Form::label(__('invocation_claims.total_claim_approved'), __('invocation_claims.total_claim_approved')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('total_claim_approved', 'Approved',true, ['class' => 'total_claim_approved required', 'id' => 'total_claim_approved']) }}
                                    <span></span>Approved
                                </label>
                                <label class="radio">
                                    {{ Form::radio('total_claim_approved', 'Rejected', NULL, ['class' => 'total_claim_approved required', 'id' => 'total_claim_approved']) }}
                                    <span></span>Rejected
                                </label>
                            </div>
                        </div> 
                        <div class="col-3 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('assessment_note', __('invocation_claims.assessment_note')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('assessment_note_attachment[]', [
                                'id' => 'assessment_note_attachment',
                                'multiple',
                                'class' => 'assessment_note_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_assessment_note_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_assessment_note_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'assessment_note_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="assessment_note_attachment"
                            data-delete="jsAssessmentNoteAttachmentDeleted">
                            <span class="navi-icon"><span class="length_assessment_note_attachment"
                                    data-assessment_note_attachment ='{{ $data_assessment_note_attachment }}'>{{ $data_assessment_note_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_claims.remarks'), __('invocation_claims.remarks')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('remark', null, ['class' => 'form-control required', 'rows' => 2]) }}
                        </div>  
                        <div class="col-3 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('approval_note', __('invocation_claims.approval_note')) !!}<i class="text-danger">*</i>
                            </div>
                            {!! Form::file('approval_note_attachment[]', [
                                'id' => 'approval_note_attachment',
                                'multiple',
                                'class' => 'approval_note_attachment jsDocument required',                               
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                            @php
                            $data_approval_note_attachment = isset($dms_data) ? count($dms_data) : 0;

                            $dsbtcls = $data_approval_note_attachment == 0 ? 'disabled' : '';
                            @endphp
                            <a href="{{ route('dMSDocument', $invocationClaims->id ?? '') }}" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $invocationClaims->id ?? '', 'attachment_type' => 'approval_note_attachment', 'dmsable_type' => 'InvocationClaims']) }}"
                            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="approval_note_attachment"
                            data-delete="jsApprovalNoteAttachmentDeleted">
                            <span class="navi-icon"><span class="length_approval_note_attachment"
                                    data-approval_note_attachment ='{{ $data_approval_note_attachment }}'>{{ $data_approval_note_attachment }}</span>&nbsp;Document</span>
                            </a>
                        </div>
                        <div class="col-3 form-group">
                            {!! Form::label('status', __('invocation_claims.status')) !!}<i class="text-danger">*</i>
                            {{ Form::select('status', ['' => ''] + $claim_status ,null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required status', 'data-placeholder' => 'Select Status']) }}
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
