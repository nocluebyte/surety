@php
    $current_user_role = $current_user->roles->first();
   // $readonly = ($bid_bond) ? 'readonly' : '';
    //$readonly_cls = ($bid_bond) ? 'form-control-solid' : '';
    $disabled = (isset($proposalData) && $proposalData->count()>0) ? 'disabled' : '';
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
                        {{-- {!! Form::hidden('bond_id', $bond_id ?? null) !!}--}}
                        {!! Form::hidden('version', $proposalData->version ?? 0,['class' => 'version']) !!} 
                        {!! Form::hidden('proposal_id', null,['class' => 'proposal_id']) !!}
                        {!! Form::hidden('contractor_id', null,['class' => 'contractor_id']) !!}
                        {!! Form::hidden('beneficiary_id', null,['class' => 'beneficiary_id']) !!}
                        {!! Form::hidden('tender_id', null,['class' => 'tender_id']) !!}
                        {!! Form::hidden('project_details_id', null,['class' => 'project_details_id']) !!}
                        {!! Form::hidden('bond_type_id', null,['class' => 'bond_type_id']) !!}
                        {!! Form::hidden('bond_number', null,['class' => 'bond_number']) !!}
                        {{-- <div class="col-6 form-group">
                            {!! Form::label('bond_type', __('invocation_notification.bond_type')) !!}<i class="text-danger">*</i>
                            {{ Form::select('bond_type', ['' => ''] + $bond_types, $proposalData->bond_type_id ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required bond_type', 'data-placeholder' => 'Select Bond Type', 'data-ajaxurl' => route('getProposalList')]) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('proposal_id', __('invocation_notification.proposal')) !!}<i class="text-danger">*</i>
                            {{ Form::select('proposal_id', ['' => ''], $proposalData->id ?? null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required proposal_id', 'data-placeholder' => 'Select Bond',$disabled]) }}
                        </div> --}}
                        <div class="col-6 form-group">
                            {!! Form::label('bond_policies_issue_id', __('invocation_notification.bond_number')) !!}<i class="text-danger">*</i>
                            {{ Form::select('bond_policies_issue_id', ['' => ''] + $bond_number, null, ['class' => 'form-control jsSelect2ClearAllow jsDisabled required bond_policies_issue_id', 'data-placeholder' => 'Select Bond Number', 'data-ajaxurl' => route('getBondData')]) }}
                            <span class="is_bond_number"></span>
                            <a class="add_bond_number d-none" href="" target="_blank"><i class="fas fa-edit cursor-pointer"></i></a>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('contractor', __('invocation_notification.contractor')) !!}
                            {{ Form::text('contractor', null, ['class' => 'form-control contractor form-control-solid', 'disabled']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('beneficiary', __('invocation_notification.beneficiary')) !!}
                            {{ Form::text('beneficiary', null, ['class' => 'form-control beneficiary form-control-solid', 'disabled']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('project_name', __('invocation_notification.project_name')) !!}
                            {{ Form::text('project_name', null, ['class' => 'form-control project_name form-control-solid', 'disabled']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('tender', __('invocation_notification.tender')) !!}
                            {{ Form::text('tender', null, ['class' => 'form-control tender form-control-solid', 'disabled']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('bond_type', __('invocation_notification.bond_type')) !!}
                            {{ Form::text('bond_type', null, ['class' => 'form-control bond_type form-control-solid', 'disabled']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_notification.amount'), __('invocation_notification.bond_amount')) !!}<span class="currency_symbol"></span>
                            {!! Form::text('invocation_amount', $proposalData->bond_value ?? null, ['class' => 'form-control form-control-solid text-right required number invocation_amount bond_value','readonly']) !!}
                        </div>  
                        <div class="col-6 form-group">
                            {!! Form::label('bond_start_date', __('invocation_notification.bond_start_date')) !!}
                            {{ Form::date('bond_start_date', null, ['class' => 'form-control bond_start_date form-control-solid', 'readonly']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('bond_end_date', __('invocation_notification.bond_end_date')) !!}
                            {{ Form::date('bond_end_date', null, ['class' => 'form-control bond_end_date form-control-solid', 'readonly']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('bond_conditionality', __('invocation_notification.bond_conditionality')) !!}
                            {{ Form::text('bond_conditionality', null, ['class' => 'form-control bond_conditionality form-control-solid', 'readonly']) }}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label('invocation_date', __('invocation_notification.invocation_date')) !!}<i class="text-danger">*</i>
                            {!! Form::date('invocation_date', $invocation_date ?? null, ['class' => 'form-control required form-control-solid', 'readonly']) !!}
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_notification.invocation_ext'), __('invocation_notification.invocation_ext')) !!}<i class="text-danger">*</i>
                            <div class="radio-inline">
                                <label class="radio">
                                    {{ Form::radio('invocation_ext', 'Yes',true, ['class' => 'invocation_ext required', 'id' => 'invocation_ext']) }}
                                    <span></span>Yes
                                </label>
                                <label class="radio">
                                    {{ Form::radio('invocation_ext', 'No', NULL, ['class' => 'invocation_ext required', 'id' => 'invocation_ext']) }}
                                    <span></span>No
                                </label>
                            </div>
                        </div>                                              
                    </div>

                    <div class="row">
                        <div class="col-12 form-group">
                            {!! Form::label('reason_for_invocation', __('invocation_notification.reason_for_invocation')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('reason_for_invocation', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-Remarks' => true,]) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_notification.officer_invoking')}}</strong></h6>
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label('officer_name', __('invocation_notification.name')) !!}<i class="text-danger">*</i>
                            {!! Form::text('officer_name',null, ['class' => 'form-control required','data-rule-Remarks' => true]) !!}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label('officer_designation', __('invocation_notification.designation')) !!}<i class="text-danger">*</i>
                            {!! Form::text('officer_designation',null, ['class' => 'form-control required','data-rule-Remarks' => true]) !!}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.email'), __('invocation_notification.email')) !!}<i class="text-danger">*</i>
                            {{ Form::email('officer_email',  null, ['class' => 'form-control email required']) }}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.mobile'), __('invocation_notification.mobile')) !!}
                            {{ Form::text('officer_mobile', null, [
                                'class' => 'form-control number',
                                'data-rule-MobileNo' => true,
                                'maxLength' => 10                           
                            ]) }}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.land_line'), __('invocation_notification.land_line')) !!}
                            {{ Form::text('officer_land_line', null, [
                                'class' => 'form-control',
                                'data-rule-LandLine' => true,                           
                            ]) }}
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_notification.official_incharge')}}</strong></h6>
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label('incharge_name', __('invocation_notification.name')) !!}
                            {!! Form::text('incharge_name',null, ['class' => 'form-control' ,'data-rule-Remarks' => true]) !!}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label('incharge_designation', __('invocation_notification.designation')) !!}
                            {!! Form::text('incharge_designation',null, ['class' => 'form-control','data-rule-Remarks' => true]) !!}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.email'), __('invocation_notification.email')) !!}
                            {{ Form::text('incharge_email',  null, ['class' => 'form-control email']) }}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.mobile'), __('invocation_notification.mobile')) !!}
                            {{ Form::text('incharge_mobile', null, [
                                'class' => 'form-control number',
                                'data-rule-MobileNo' => true, 
                                 'maxLength' => 10                               
                            ]) }}
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label(__('invocation_notification.land_line'), __('invocation_notification.land_line')) !!}
                            {{ Form::text('incharge_land_line', null, [
                                'class' => 'form-control',
                                'data-rule-LandLine' => true,                           
                            ]) }}
                        </div>
				    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_notification.beneficiary_office_details')}}</strong></h6>
                        </div>
                        <div class="col-4 form-group">
                            {!! Form::label('office_branch', __('invocation_notification.branch')) !!}<i class="text-danger">*</i>
                            {!! Form::text('office_branch',null, ['class' => 'form-control required','data-rule-Remarks' => true]) !!}
                        </div>
                        <div class="col-4 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('attachment', __('invocation_notification.attachment')) !!}<i class="text-danger">*</i>
                            </div>

                            {!! Form::file('invocation_notification_attachment[]', [
                                'class' => 'invocation_notification_attachment jsDocument',
                                'id' => 'invocation_notification_attachment',
                                empty($dms_data) ? 'required' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_invocation_notification_attachment = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_invocation_notification_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#invocation_notification_attachment_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsInvocationNotificationAttachDocumentDeleted" data-prefix="invocation_notification_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_invocation_notification_attachment" data-count_invocation_notification_attachment = "{{ $data_invocation_notification_attachment }}">{{ $data_invocation_notification_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="invocation_notification_attachment_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Invocation Notification Attachment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_notification.address'), __('invocation_notification.address')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('office_address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-Remarks' => true,]) }}
                        </div>
                        {{-- <div class="col-6 form-group">
                            {!! Form::label(__('invocation_notification.reason'), __('invocation_notification.reason')) !!}<i class="text-danger">*</i>
                            {{ Form::textarea('reason', null, ['class' => 'form-control required', 'rows' => 2]) }}
                        </div>                         --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_notification.notice_details')}}</strong></h6>
                        </div>
                        <div class="col-6 form-group">
                            {!! Form::label(__('invocation_notification.remark'), __('invocation_notification.remark')) !!}
                            {{ Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 2, 'data-rule-Remarks' => true,]) }}
                        </div>    
                        <div class="col-4 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('attachment', __('invocation_notification.attachment')) !!}
                            </div>
                            {{-- {!! Form::file('notice_attachment', [
                                'id' => 'notice_attachment',
                                'class' => 'notice_attachment required',	
                                'data-rule-extension' => 'xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-msg-extension' => 'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-rule-filesize' => '20971520',
                                'data-msg-filesize' => 'File size must be less than 20 MB',								
                            ]) !!} --}}

                            {!! Form::file('notice_attachment[]', [
                                'class' => 'notice_attachment jsDocument',
                                'id' => 'notice_attachment',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_notice_attachment = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_notice_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#notice_attachment_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsNoticeAttachDocumentDeleted" data-prefix="notice_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_notice_attachment" data-count_notice_attachment = "{{ $data_notice_attachment }}">{{ $data_notice_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="notice_attachment_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Notice Attachment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                             
                    </div>
                    {{-- <div class="row">
                        <div class="col-12">
                            <h6 class="card-title"><strong>{{__('invocation_notification.invocation_closed')}}</strong></h6>
                        </div>
                        <div class="col-6 form-group">
                            {{ Form::label('closed_reason', __('invocation_notification.reason')) }}
                            {{ Form::select('closed_reason', ['' => 'Select','Extended' => 'Extended','Issue Resolved' => 
                            'Issue Resolved'], null, ['class' => 'form-control closed_reason jsDisabled', 'data-placeholder' => 'Select Reason','id' => 'closed_reason']) }}
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-6 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('contract_agreement', __('invocation_notification.contract_agreement')) !!}
                            </div>
                            {{-- {!! Form::file('notice_attachment', [
                                'id' => 'notice_attachment',
                                'class' => 'notice_attachment required',	
                                'data-rule-extension' => 'xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-msg-extension' => 'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-rule-filesize' => '20971520',
                                'data-msg-filesize' => 'File size must be less than 20 MB',								
                            ]) !!} --}}

                            {!! Form::file('contract_agreement[]', [
                                'class' => 'contract_agreement jsDocument',
                                'id' => 'contract_agreement',
                                // empty($dms_data) ? 'required' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx',
                                'extension' => 'pdf|xlsx|xls|doc|docx',
                            ]) !!}
                            @php
                                $data_contract_agreement = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_contract_agreement == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#contract_agreement_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsContractAgreementDeleted" data-prefix="contract_agreement"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_contract_agreement" data-count_contract_agreement = "{{ $data_contract_agreement }}">{{ $data_contract_agreement }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="contract_agreement_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Contract Agreement</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('beneficiary_communication_attachment', __('invocation_notification.beneficiary_communication_attachment')) !!}<i class="text-danger">*</i>
                            </div>
                            {{-- {!! Form::file('notice_attachment', [
                                'id' => 'notice_attachment',
                                'class' => 'notice_attachment required',	
                                'data-rule-extension' => 'xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-msg-extension' => 'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-rule-filesize' => '20971520',
                                'data-msg-filesize' => 'File size must be less than 20 MB',								
                            ]) !!} --}}

                            {!! Form::file('beneficiary_communication_attachment[]', [
                                'class' => 'beneficiary_communication_attachment jsDocument',
                                'id' => 'beneficiary_communication_attachment',
                                empty($dms_data) ? 'required' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx',
                                'extension' => 'pdf|xlsx|xls|doc|docx',
                            ]) !!}
                            @php
                                $data_beneficiary_communication_attachment = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_beneficiary_communication_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#beneficiary_communication_attachment_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBeneficiaryCommunicationAttachmentDeleted" data-prefix="beneficiary_communication_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_beneficiary_communication_attachment" data-count_beneficiary_communication_attachment = "{{ $data_beneficiary_communication_attachment }}">{{ $data_beneficiary_communication_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="beneficiary_communication_attachment_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Beneficiary Communication Attachment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('legal_documents', __('invocation_notification.legal_documents')) !!}
                            </div>
                            {{-- {!! Form::file('notice_attachment', [
                                'id' => 'notice_attachment',
                                'class' => 'notice_attachment required',	
                                'data-rule-extension' => 'xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-msg-extension' => 'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-rule-filesize' => '20971520',
                                'data-msg-filesize' => 'File size must be less than 20 MB',								
                            ]) !!} --}}

                            {!! Form::file('legal_documents[]', [
                                'class' => 'legal_documents jsDocument',
                                'id' => 'legal_documents',
                                // empty($dms_data) ? 'required' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx',
                                'extension' => 'pdf|xlsx|xls|doc|docx',
                            ]) !!}
                            @php
                                $data_legal_documents = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_legal_documents == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#legal_documents_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBeneficiaryCommunicationAttachmentDeleted" data-prefix="legal_documents"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_legal_documents" data-count_legal_documents = "{{ $data_legal_documents }}">{{ $data_legal_documents }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="legal_documents_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Legal Documents</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 form-group jsDivClass">
                            <div class="d-block">
                                {!! Form::label('any_other_documents', __('invocation_notification.any_other_documents')) !!}
                            </div>
                            {{-- {!! Form::file('notice_attachment', [
                                'id' => 'notice_attachment',
                                'class' => 'notice_attachment required',	
                                'data-rule-extension' => 'xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-msg-extension' => 'please upload valid file xls|xlsx|doc|docx|pdf|jpg|jpeg|png',
                                'data-rule-filesize' => '20971520',
                                'data-msg-filesize' => 'File size must be less than 20 MB',								
                            ]) !!} --}}

                            {!! Form::file('any_other_documents[]', [
                                'class' => 'any_other_documents jsDocument',
                                'id' => 'any_other_documents',
                                // empty($dms_data) ? 'required' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx',
                                'extension' => 'pdf|xlsx|xls|doc|docx',
                            ]) !!}
                            @php
                                $data_any_other_documents = isset($dms_data) ? count($dms_data) : 0;

                                $dsbtcls = $data_any_other_documents == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#any_other_documents_modal"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBeneficiaryCommunicationAttachmentDeleted" data-prefix="any_other_documents"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_any_other_documents" data-count_any_other_documents = "{{ $data_any_other_documents }}">{{ $data_any_other_documents }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="any_other_documents_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Any Other Documents</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        </div>
        <div id="load-modal"></div>

@include('invocation_notification.script')
