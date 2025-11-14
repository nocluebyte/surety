<div class="row">
    <div class="col-sm-12">
        <div class="card" id="default">
            <div class="card-body pt-5">
                <div class="d-flex justify-content-between pb-5 pb-md-5 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10"></h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <div class="form-group row mt-3">
                            {!! Form::label('code', __('common.code') . ':', [
                                'class' => 'col-lg-6 col-form-label text-right',
                            ]) !!}
                            <div class="col-lg-6 pr-2">
                                {!! Form::text('code', $proposalData->code . '/V' . $proposalData->version ?? 0, [
                                    'class' => 'form-control form-control-solid required',
                                    'readonly' => '',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        {!! Form::hidden('bond_type', $proposalData->bond_type, ['class' => 'form-control']) !!}
                        {!! Form::hidden('proposal_id', $proposalData->id, ['class' => 'form-control']) !!}
                        {!! Form::label('progress_date', __('bond_progress.progress_date')) !!}<span class="text-danger">*</span>
                        {!! Form::date('progress_date', null, ['class' => 'form-control required']) !!}
                    </div>

                    <div class="col-6 form-group">
                        <div class="d-block">
                            {!! Form::label('progress_attachment', __('bond_progress.attachment')) !!}<span class="text-danger">*</span>
                        </div>
                        <div class="d-block jsDivClass">
                            {!! Form::file('progress_attachment[]', ['class' => 'progress_attachment jsDocument', empty($dms_data) ? 'required' : '', 'multiple', 'maxfiles' => 5,
                            'id' => 'progress_attachment',
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',]) !!}

                            @php
                                $data_progress_attachment = isset($dms_data) ? count($dms_data) : 0;
                                $dsbtcls = $data_progress_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#progress_attachment_modal"
                            class="call-modal JsBondAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBondAttachmentDeleted" data-prefix="progress_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_progress_attachment" data-count_progress_attachment = "{{ $data_progress_attachment }}">{{ $data_progress_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="progress_attachment_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Progress Attachment</h5>
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

                <div class="row">
                    <div class="col-12 form-group">
                        {!! Form::label('progress_remarks', __('bond_progress.progress_remarks')) !!}<span class="text-danger">*</span>
                        {!! Form::textarea('progress_remarks', null, ['class' => 'form-control required', 'rows' => 2, 'cols' => 2]) !!}
                    </div>
                </div>

                <h5><b>{{__('bond_progress.adverse_information')}} : </b></h5>

                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="font-weight-bolder">
                                            {{ __('common.no') }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder">
                                            {{ __('common.code') }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder">
                                            {{ __('bond_progress.source_information') }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder">
                                            {{ __('bond_progress.adverse_information') }}</div>
                                    </th>
                                    <th>
                                        <div class="font-weight-bolder">
                                            {{ __('bond_progress.adverse_information_date') }}</div>
                                    </th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @if ($adverseInfo)
                                    @foreach ($adverseInfo as $item)
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ $loop->index + 1 }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ $item->code ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ $item->source_of_adverse_information ?? '-' }}
                                                </div>
                                            </td>
                                            <td width="50%">
                                                <div class="font-weight-bold">
                                                    {{ strip_tags($item->adverse_information) ?? '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">
                                                    {{ custom_date_format($item->created_at, 'd/m/Y') ?? '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">{{ __('common.no_records_found') }}</td>
                                    </tr>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        {!! Form::label('physical_completion_remarks', __('bond_progress.physical_completion_remarks')) !!}<span class="text-danger">*</span>
                        {!! Form::textarea('physical_completion_remarks', null, [
                            'class' => 'form-control required',
                            'rows' => 2,
                            'cols' => 2,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        <div class="d-block">
                            {!! Form::label('physical_completion_attachment', __('bond_progress.physical_completion_attachment')) !!}<span class="text-danger">*</span>
                        </div>
                        <div class="d-block jsDivClass">
                            {!! Form::file('physical_completion_attachment[]', ['class' => 'physical_completion_attachment jsDocument', empty($dms_data) ? 'required' : '', 'multiple', 'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'id' => 'physical_completion_attachment',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',]) !!}

                            @php
                                $data_physical_completion_attachment = isset($dms_data) ? count($dms_data) : 0;
                                $dsbtcls = $data_physical_completion_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-target="#physical_completion_attachment_modal"
                            class="call-modal JsPhysicalCompletionAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsPhysicalCompletionAttachmentDeleted" data-prefix="physical_completion_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_physical_completion_attachment" data-count_physical_completion_attachment = "{{ $data_physical_completion_attachment }}">{{ $data_physical_completion_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="physical_completion_attachment_modal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Physical Completion Attachment</h5>
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

                <h5>{{__('bond_progress.financial_fulfillment_details')}} : </h5>

                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <div class="font-weight-bolder text-center">
                                        {{ __('premium.payment_received') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                    </div>
                                </th>
                                <th>
                                    <div class="font-weight-bolder text-center">
                                        {{ __('premium.payment_received_date') }}
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(isset($premiumDetails) && $premiumDetails->count()>0)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-center">
                                            {{ numberFormatPrecision($premiumDetails->premium_amount, 0) ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-center">
                                            {{ custom_date_format($premiumDetails->date_of_receipt, 'd/m/Y') ?? '-' }}
                                        </div>
                                    </td>
                                </tr>                               
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">{{ __('common.no_records_found') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-6 form-group">
                        {!! Form::label('dispute_initiated', __('bond_progress.dispute_initiated')) !!}<i class="text-danger">*</i>

                        <div class="radio-inline">
                            <label class="radio">
                                {{ Form::radio('dispute_initiated', 'Yes', true, ['class' => 'form-check-input dispute_initiated']) }}
                                <span></span>Yes
                            </label>
                            <label class="radio">
                                {{ Form::radio('dispute_initiated', 'No', '', ['class' => 'form-check-input dispute_initiated']) }}
                                <span></span>No
                            </label>
                        </div>
                    </div>

                    <div class="col-6 form-group disputeInitiatedRemarks">
                        {!! Form::label('dispute_initiated_remarks', __('bond_progress.dispute_initiated_remarks')) !!}<i class="text-danger">*</i>
                        {!! Form::textarea('dispute_initiated_remarks', null, ['class' => 'form-control dispute_initiated_remarks', 'rows' => 2, 'cols' => 2]) !!}
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-right ">
                            {!! link_to(URL::full(), __('common.reset'), ['class' => 'btn btn-light mr-3']) !!}
                            <button type="submit" class="btn btn-primary jsBtnLoader">{{ __('common.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="load-modal"></div>
        </div>
    </div>
</div>
@include('bond_progress.script')