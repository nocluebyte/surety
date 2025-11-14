@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
	'back_action'=> route('proposals.show', encryptId($proposal_id)),
    'text' => __('common.back'),
	'permission' => $current_user->hasAnyAccess(['users.superadmin', 'proposals.bond_issue_checklist']),
])
@endcomponent
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open(['route' => 'bondPoliciesChecklistStore','role' => 'form','enctype' => 'multipart/form-data','id' => 'bondIssueChecklistForm',]) !!}
        <div class="card card-custom gutter-b">
            <div class="card-body">
				<div class="row">
					<div class="col-10"></div>
					<div class="col-2 form-group">
						{!! Form::label('policy_no', __('nbi.policy_no')) !!} :
						{!! Form::text('policy_no', $nbiData->policy_no ?? null, ['class' => 'form-control required form-control-solid', 'disabled']) !!}
					</div>
				</div>
                <div class="row">
                    {!! Form::hidden('proposal_id', $proposal_id,['id' => 'proposal_id']) !!}
                    {!! Form::hidden('version', $proposals->version,['id' => 'version']) !!}
                    {!! Form::hidden('contractor_id', $proposals->contractor_id,['id' => 'contractor_id']) !!}
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.premium_collection')}}</strong></h6>
					</div>
                    <div class="col-4 form-group">
                        {!! Form::label('premium_amount', __('bond_policies_issue.premium_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                        {!! Form::text('premium_amount', $policyChecklist->premium_amount ?? $nbiData->total_premium_including_stamp_duty, ['class' => 'form-control number required form-control-solid','min' => '1','step' => '1', 'data-rule-Numbers' => true, 'readonly']) !!}
                    </div>
					 <div class="col-4 form-group">
                        {!! Form::label('past_premium', __('bond_policies_issue.past_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                        {!! Form::text('past_premium', $policyChecklist->premium_amount ?? $past_premium, ['class' => 'form-control number required form-control-solid','min' => '0','step' => '1', 'data-rule-Numbers' => true, 'readonly']) !!}
                    </div>
					 <div class="col-4 form-group">
					 	@php
							$premium_amount = $nbiData->total_premium_including_stamp_duty;
							$net_premium = $premium_amount - $past_premium;
						@endphp
                        {!! Form::label('net_premium', __('bond_policies_issue.net_premium')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                        {!! Form::text('net_premium', $policyChecklist->premium_amount ?? $net_premium, ['class' => 'form-control number required form-control-solid', 'readonly']) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label('utr_neft_details', __('bond_policies_issue.utr_neft_details')) !!}<i class="text-danger">*</i>
                        {!! Form::text('utr_neft_details', $policyChecklist->utr_neft_details ?? null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV2' => true]) !!}
                    </div>
                    <div class="col-4 form-group">
                        {!! Form::label('date_of_receipt', __('bond_policies_issue.date_of_receipt')) !!}<i class="text-danger">*</i>
                        {!! Form::date('date_of_receipt', $policyChecklist->date_of_receipt ?? null, ['class' => 'form-control required']) !!}
                    </div>
                    <div class="col-4 form-group">
                        {!! Form::label('booking_office_detail', __('bond_policies_issue.booking_office_detail')) !!}<i class="text-danger">*</i>
                        {!! Form::text('booking_office_detail', $policyChecklist->booking_office_detail ?? $nbiData->issuingOfficeBranch->branch_name, ['class' => 'form-control required form-control-solid','data-rule-AlphabetsAndNumbersV3' => true, 'readonly']) !!}
                    </div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.deed_of_indemnity')}}</strong></h6>
					</div>
					<div class="col-4 form-group">
						{!! Form::label(__('bond_policies_issue.executed_deed_indemnity'), __('bond_policies_issue.executed_deed_indemnity')) !!}<i class="text-danger">*</i>

						<div class="radio-inline">
							<label class="radio">
								{{ Form::radio('executed_deed_indemnity', 'Yes', isset($policyChecklist) && $policyChecklist->executed_deed_indemnity == 'Yes' ? true : true, ['class' => 'executed_deed_indemnity required', 'id' => 'executed_deed_indemnity']) }}
								<span></span>Yes
							</label>
							<label class="radio">
								{{ Form::radio('executed_deed_indemnity', 'No', isset($policyChecklist) && $policyChecklist->executed_deed_indemnity == 'No' ? true : NULL, ['class' => 'executed_deed_indemnity required', 'id' => 'executed_deed_indemnity']) }}
								<span></span>No
							</label>
						</div>
					</div>

					<div class="col-8 form-group deedAttach {{isset($policyChecklist) && $policyChecklist->executed_deed_indemnity == 'No' ? 'd-none' : ''}}">
						<div class="isdeedAttachData">
							<div class="d-block">
								{!! Form::label(__('bond_policies_issue.attach_document'), __('bond_policies_issue.attach_document')) !!}<i class="text-danger">*</i>
							</div>
							<div class="d-block jsDivClass">
								{!! Form::file('deed_attach_document[]', [
									'class' => 'deed_attach_document jsDocument required',
									'id' => 'deed_attach_document',
									'multiple',
									'maxfiles' => 5,
									'maxsizetotal' => '52428800',
									'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
									'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
									'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
								]) !!}
								@php
									$data_deed_attach_document = isset($dms_data) ? count($dms_data) : 0;

									$dsbtcls = $data_deed_attach_document == 0 ? 'disabled' : '';
								@endphp
								{{-- <a href="{{ route('dMSDocument', $policyChecklist->id ?? '') }}" data-toggle="modal" data-target-modal="#commonModalID"
									data-url="{{ route('dMSDocument', ['id' => $policyChecklist->id ?? '', 'attachment_type' => 'deed_attach_document', 'dmsable_type' => 'BondPoliciesIssueChecklist']) }}"
									class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="deed_attach_document"
									data-delete="jsDeedAttachDocumentDeleted">
									<span class="navi-icon"><span class="length_deed_attach_document"
											data-deed_attach_document ='{{ $data_deed_attach_document }}'>{{ $data_deed_attach_document }}</span>&nbsp;Document</span>
								</a> --}}

								<a href="#" data-toggle="modal" data-target="#deed_attach_document_modal"
								class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsDeedAttachDocumentDeleted" data-prefix="deed_attach_document"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
									<span class = "count_deed_attach_document" data-count_deed_attach_document = "{{ $data_deed_attach_document }}">{{ $data_deed_attach_document }}&nbsp;document</span>
								</a>

								<div class="modal fade" tabindex="-1" id="deed_attach_document_modal">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Deed Attach Document</h5>
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
					</div>

					 <div class="col-8 form-group deedRemark {{ isset($policyChecklist) ? $policyChecklist->executed_deed_indemnity == 'No' ? '' : 'd-none' : 'd-none' }}">
                        {!! Form::label('deed_remarks', __('bond_policies_issue.remarks')) !!}<span class="text-danger">*</span>
                        {!! Form::textArea('deed_remarks', $policyChecklist->deed_remarks ?? null, ['class' => 'form-control deed_remarks','rows' => 3])!!}                        
                    </div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.board_resolution')}}</strong></h6>
					</div>
					<div class="col-4 form-group">
						{!! Form::label(__('bond_policies_issue.executed_board_resolution_company'), __('bond_policies_issue.executed_board_resolution_company')) !!}<i class="text-danger">*</i>

						<div class="radio-inline">
							<label class="radio">
								{{ Form::radio('executed_board_resolution', 'Yes', isset($policyChecklist) && $policyChecklist->executed_board_resolution == 'Yes' ? true : true, ['class' => 'executed_board_resolution', 'id' => 'executed_board_resolution']) }}
								<span></span>Yes
							</label>
							<label class="radio">
								{{ Form::radio('executed_board_resolution', 'No', isset($policyChecklist) && $policyChecklist->executed_board_resolution == 'No' ? true : NULL, ['class' => 'executed_board_resolution', 'id' => 'executed_board_resolution']) }}
								<span></span>No
							</label>
						</div>
					</div>

					<div class="col-8 form-group boardAttach {{ isset($policyChecklist) && $policyChecklist->executed_board_resolution == 'No' ? 'd-none' : '' }}">
						<div class="isboardAttachData">
							<div class="d-block">
								{!! Form::label(__('bond_policies_issue.attach_document'), __('bond_policies_issue.attach_document')) !!}<i class="text-danger">*</i>
							</div>
							<div class="d-block jsDivClass">
								{!! Form::file('board_attach_document[]', [
									'class' => 'board_attach_document jsDocument required',
									'id' => 'board_attach_document',
									'multiple',
									'maxfiles' => 5,
									'maxsizetotal' => '52428800',
									'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
									'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
									'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
								]) !!}
								@php
									$data_board_attach_document = isset($dms_data) ? count($dms_data) : 0;

									$dsbtcls = $data_board_attach_document == 0 ? 'disabled' : '';
								@endphp

								<a href="#" data-toggle="modal" data-target="#board_attach_document_modal"
								class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBoardAttachDocumentDeleted" data-prefix="board_attach_document"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
									<span class = "count_board_attach_document" data-count_board_attach_document = "{{ $data_board_attach_document }}">{{ $data_board_attach_document }}&nbsp;document</span>
								</a>

								<div class="modal fade" tabindex="-1" id="board_attach_document_modal">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Board Attach Document</h5>
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
					</div>

					 <div class="col-8 form-group boardRemark {{ isset($policyChecklist) ? $policyChecklist->executed_board_resolution == 'No' ? '' : 'd-none' : 'd-none' }}">
                        {!! Form::label('board_remarks', __('bond_policies_issue.remarks')) !!}<span class="text-danger">*</span>
                        {!! Form::textArea('board_remarks', $policyChecklist->board_remarks ?? null, ['class' => 'form-control board_remarks','rows' => 3])!!}                        
                    </div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.intermediary_details')}}</strong></h6>
					</div>
					<div class="col-12 form-group">
						<div class="row">
							<div class="col-3">
								{!! Form::label(__('bond_policies_issue.intermediary_details'), __('bond_policies_issue.intermediary_details')) !!}
						<div class="radio-inline">
							<label class="radio">
								{{ Form::radio('intermediary_detail_type', 'Broker',false, ['class' => 'intermediary_detail', 'id' => 'intermediary_detail']) }}
								<span></span>Broker
							</label>
							<label class="radio">
								{{ Form::radio('intermediary_detail_type', 'Agent',false, ['class' => 'intermediary_detail', 'id' => 'intermediary_detail']) }}
								<span></span>Agent
							</label>
							<label class="radio">
								{{ Form::radio('intermediary_detail_type', 'Direct',false, ['class' => 'intermediary_detail', 'id' => 'intermediary_detail']) }}
								<span></span>Direct
							</label>
						</div>
							</div>
							<div class="col-3">
								<div class="intermediaryParentDetailSection d-none">
									<div class="form-group">
										{!!Form::label('intermediary_detail_id',__('bond_policies_issue.intermediary'))!!}
										{!!Form::select('intermediary_detail_id',[''=>'']+[],null,['class'=>'form-control jsSelect2ClearAllow intermediaryDetailId intermediaryChildDetailSection','data-placeholder'=>'Select'])!!}
									</div>
								</div>
							</div>
						</div>
						<div class="row intermediaryParentDetailSection d-none">
							<div class="col">
								<div class="form-group">
										{!!Form::label('intermediary_detail_code',__('bond_policies_issue.intermediary_code'))!!}
										{!!Form::text('intermediary_detail_code',null,['class'=>'form-control form-control-solid intermediaryChildDetailSection',
										'readonly'=>true,
										'data-rule-AlphabetsAndNumbersV8'=>true])!!}
								</div>
							</div>
							<div class="col">
								<div class="form-group">
										{!!Form::label('intermediary_detail_name',__('bond_policies_issue.intermediary_name'))!!}
										{!!Form::text('intermediary_detail_name',null,['class'=>'form-control form-control-solid intermediaryChildDetailSection',
										'readonly'=>true,
										'data-rule-AlphabetsAndNumbersV8'=>true])!!}
									</div>
							</div>
							<div class="col">
								<div class="form-group">
										{!!Form::label('intermediary_detail_email',__('bond_policies_issue.intermediary_email'))!!}
										{!!Form::text('intermediary_detail_email',null,['class'=>'form-control form-control-solid intermediaryChildDetailSection',
										'readonly'=>true,
										'data-rule-email'=>true])!!}
									</div>
							</div>
							<div class="col">
								<div class="form-group">
										{!!Form::label('intermediary_detail_mobile',__('bond_policies_issue.intermediary_mobile'))!!}
										{!!Form::number('intermediary_detail_mobile',null,['class'=>'form-control intermediaryChildDetailSection','rows'=>1,'data-rule-MobileNo'=>true])!!}
								</div>
							</div>
							<div class="col">
								<div class="form-group">
										{!!Form::label('intermediary_detail_address',__('bond_policies_issue.intermediary_address'))!!}
										{!!Form::textarea('intermediary_detail_address',null,['class'=>'form-control intermediaryChildDetailSection','rows'=>1,'data-rule-AlphabetsAndNumbersV3'=>true])!!}
								</div>
							</div>
						</div>
						<hr/>
					</div>
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.broker_mandate')}}</strong></h6>
					</div>
					<div class="col-4 form-group">
						{!! Form::label(__('bond_policies_issue.broker_mandate'), __('bond_policies_issue.broker_mandate')) !!}<i class="text-danger">*</i>

						<div class="radio-inline">
							<label class="radio">
								{{ Form::radio('broker_mandate', 'Broker', isset($policyChecklist) && $policyChecklist->broker_mandate == 'Broker' ? true : true, ['class' => 'broker_mandate', 'id' => 'broker_mandate']) }}
								<span></span>Broker
							</label>
							<label class="radio">
								{{ Form::radio('broker_mandate', 'Agent', isset($policyChecklist) && $policyChecklist->broker_mandate == 'Agent' ? true : NULL, ['class' => 'broker_mandate', 'id' => 'broker_mandate']) }}
								<span></span>Agent
							</label>
							<label class="radio">
								{{ Form::radio('broker_mandate', 'Direct', isset($policyChecklist) && $policyChecklist->broker_mandate == 'Direct' ? true : NULL, ['class' => 'broker_mandate', 'id' => 'broker_mandate']) }}
								<span></span>Direct
							</label>
						</div>
					</div>

					<div class="col-8 form-group brokerAttach {{ isset($policyChecklist) && in_array($policyChecklist->broker_mandate, ['Agent', 'Direct']) ? 'd-none' : '' }}">
						<div class="isbrokerAttachData">
							<div class="d-block">
								{!! Form::label(__('bond_policies_issue.attach_document'), __('bond_policies_issue.attach_document')) !!}<i class="text-danger">*</i>
							</div>
							<div class="d-block jsDivClass">
								{!! Form::file('broker_attach_document[]', [
									'class' => 'broker_attach_document jsDocument required',
									'id' => 'broker_attach_document',
									'multiple',
									'maxfiles' => 5,
									'maxsizetotal' => '52428800',
									'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
									'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
									'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
								]) !!}
								@php
									$data_broker_attach_document = isset($dms_data) ? count($dms_data) : 0;

									$dsbtcls = $data_broker_attach_document == 0 ? 'disabled' : '';
								@endphp

								<a href="#" data-toggle="modal" data-target="#broker_attach_document_modal"
								class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBrokerAttachDocumentDeleted" data-prefix="broker_attach_document"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
									<span class = "count_broker_attach_document" data-count_broker_attach_document = "{{ $data_broker_attach_document }}">{{ $data_broker_attach_document }}&nbsp;document</span>
								</a>

								<div class="modal fade" tabindex="-1" id="broker_attach_document_modal">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Broker Attach Document</h5>
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
					</div>
					<div class="col-8 form-group agentAttach {{ isset($policyChecklist) ? in_array($policyChecklist->broker_mandate, ['Broker', 'Direct']) ? 'd-none' : '' : 'd-none' }}">
						<div class="isagentAttachData">
							<div class="d-block">
								{!! Form::label(__('bond_policies_issue.attach_document'), __('bond_policies_issue.attach_document')) !!}<i class="text-danger">*</i>
							</div>
							<div class="d-block jsDivClass">
								{!! Form::file('agent_attach_document[]', [
									'class' => 'agent_attach_document jsDocument',
									'id' => 'agent_attach_document',
									// empty($dms_data) ? 'required' : '',
									'multiple',
									'maxfiles' => 5,
									'maxsizetotal' => '52428800',
									'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
									'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
									'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
								]) !!}
								@php
									$data_agent_attach_document = isset($dms_data) ? count($dms_data) : 0;

									$dsbtcls = $data_agent_attach_document == 0 ? 'disabled' : '';
								@endphp

								<a href="#" data-toggle="modal" data-target="#agent_attach_document_modal"
								class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsAgentAttachDocumentDeleted" data-prefix="agent_attach_document"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
									<span class = "count_agent_attach_document" data-count_agent_attach_document = "{{ $data_agent_attach_document }}">{{ $data_agent_attach_document }}&nbsp;document</span>
								</a>

								<div class="modal fade" tabindex="-1" id="agent_attach_document_modal">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Agent Attach Document</h5>
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
					</div>

					 
				</div>
				<hr/>
				<div class="row">
					<div class="col-12">
						<h6 class="card-title"><strong>{{__('bond_policies_issue.collateral_details')}}</strong></h6>
					</div>
					<div class="col-4 form-group">
						{!! Form::label(__('bond_policies_issue.collateral_available'), __('bond_policies_issue.collateral_available')) !!}<i class="text-danger">*</i>

						<div class="radio-inline">
							<label class="radio">
								{{ Form::radio('collateral_available', 'Yes', isset($policyChecklist) && $policyChecklist->collateral_available == 'Yes' ? true : true, ['class' => 'collateral_available', 'id' => 'collateral_available']) }}
								<span></span>Yes
							</label>
							<label class="radio">
								{{ Form::radio('collateral_available', 'No', isset($policyChecklist) && $policyChecklist->collateral_available == 'No' ? true : NULL, ['class' => 'collateral_available', 'id' => 'collateral_available']) }}
								<span></span>No
							</label>
						</div>
					</div>
					
					<div class="col-8 form-group collateralAvailableRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'No' ? '' : 'd-none' : 'd-none' }}">
						{!! Form::label('collateral_remarks', __('bond_policies_issue.remarks')) !!}<span class="text-danger">*</span>
						{!! Form::textArea('collateral_remarks', $policyChecklist->collateral_remarks ?? null, ['class' => 'form-control collateral_remarks','rows' => 3])!!}                        
					</div>

					
					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none' : '' }}">
						{!! Form::label('fd_amount', __('bond_policies_issue.fd_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
						{!! Form::text('fd_amount', $policyChecklist->fd_amount ?? null, ['class' => 'form-control fd_amount number required','min' => '1','step' => '1', 'data-rule-Numbers' => true]) !!}
					</div>

					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none' : '' }}">
						{!! Form::label('fd_issuing_bank_name', __('bond_policies_issue.fd_issuing_bank_name')) !!}<i class="text-danger">*</i>
						{!! Form::text('fd_issuing_bank_name', $policyChecklist->fd_issuing_bank_name ?? $nbiData->issuingOfficeBranch->bank, ['class' => 'form-control fd_issuing_bank_name required','data-rule-AlphabetsAndNumbersV3' => true,]) !!}
					</div>

					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none' : '' }}">
						{!! Form::label('fd_issuing_branch_name', __('bond_policies_issue.fd_issuing_branch_name')) !!}<i class="text-danger">*</i>
						{!! Form::text('fd_issuing_branch_name', $policyChecklist->fd_issuing_branch_name ?? $nbiData->issuingOfficeBranch->bank_branch, ['class' => 'form-control fd_issuing_branch_name required','data-rule-AlphabetsAndNumbersV3' => true]) !!}
					</div>

					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none' : ''}}">
						{!! Form::label('fd_receipt_number', __('bond_policies_issue.fd_receipt_number')) !!}<i class="text-danger">*</i>
						{!! Form::text('fd_receipt_number', $policyChecklist->fd_receipt_number ?? null, ['class' => 'form-control required fd_receipt_number','data-rule-AlphabetsAndNumbersV3' => true]) !!}
					</div>

					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none': '' }}">
						{!! Form::label('bank_address', __('bond_policies_issue.bank_address')) !!}<i class="text-danger">*</i>
						{!! Form::text('bank_address', $policyChecklist->bank_address ?? $nbiData->issuingOfficeBranch->address, ['class' => 'form-control bank_address required','data-rule-AlphabetsAndNumbersV3' => true]) !!}
					</div>

					<div class="col-4 form-group collateralRemark {{ isset($policyChecklist) ? $policyChecklist->collateral_available == 'Yes' ? '' : 'd-none': '' }}">
						<div class="iscollateralAttachData">
							<div class="d-block">
								{!! Form::label(__('bond_policies_issue.attach_document'), __('bond_policies_issue.attach_document')) !!}<i class="text-danger">*</i>
							</div>
							<div class="d-block jsDivClass">
								{!! Form::file('collateral_attach_document[]', [
									'class' => 'collateral_attach_document jsDocument required',
									'id' => 'collateral_attach_document',
									'multiple',
									'maxfiles' => 5,
									'maxsizetotal' => '52428800',
									'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
									'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
									'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
								]) !!}
								@php
									$data_collateral_attach_document = isset($dms_data) ? count($dms_data) : 0;

									$dsbtcls = $data_collateral_attach_document == 0 ? 'disabled' : '';
								@endphp

								<a href="#" data-toggle="modal" data-target="#collateral_attach_document_modal"
								class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCollateralAttachDocumentDeleted" data-prefix="collateral_attach_document"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
									<span class = "count_collateral_attach_document" data-count_collateral_attach_document = "{{ $data_collateral_attach_document }}">{{ $data_collateral_attach_document }}&nbsp;document</span>
								</a>

								<div class="modal fade" tabindex="-1" id="collateral_attach_document_modal">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Collateral Attach Document</h5>
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
					</div>
				
				</div>
								
				
                <div class="row card-footer pb-5 pt-5">
                    <div class="col-12 text-right">                       
                        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                        <button type="submit" id="btn_loader" class="btn btn-primary jsBtnLoader">{{ __('common.save_exit') }}</button>                       
                    </div>
                </div>
            </div>
        </div>
		<div id="load-modal"></div>
        {!! Form::close() !!}
    </div>
</div>
   @section('scripts')
		@include('bond.bond_policies_issue.script')
	@endsection
@endsection
