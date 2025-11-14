<div id="proposalBankingLimitsRepeater">
    @if (isset($proposal_banking_limits))
        <div class="repeaterRow pbl_repeater_row" data-repeater-list="pbl_items">
            @foreach ($proposal_banking_limits as $item)
                <div class="row mb-5 pbl_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden('pbl_id', $item->id ?? '', ['class' => 'jsPblId']) !!}
                    {!! Form::hidden('cfr_id', $item->contractor_fetch_reference_id ?? '') !!}
                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.banking_category_id'), __('proposals.banking_category_label')) !!}

                        {!! Form::select(
                            'banking_category_id',
                            ['' => 'Select Banking Category'] + $banking_limit_category,
                            $item->banking_category_id,
                            [
                                'class' => 'form-control jsClearContractorType banking_category_id ',
                                'style' => 'width:100%;',
                                'data-placeholder' => 'Select Banking Category',
                                $disabled,
                            ],
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.facility_type_id'), __('proposals.facility_types_label')) !!}

                        {!! Form::select('facility_type_id', ['' => 'Select Facility Type'] + $facility_types, $item->facility_type_id, [
                            'class' => 'form-control jsClearContractorType facility_type_id ',
                            'style' => 'width:100%;',
                            'data-placeholder' => 'Select Facility Type',
                            $disabled,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.sanctioned_amount'), __('proposals.sanctioned_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('sanctioned_amount', $item->sanctioned_amount, [
                            'class' => 'form-control jsClearContractorType  number ' . $readonly_cls,
                            'name' => 'sanctioned_amount',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.bank_name'), __('proposals.bank_name')) !!}
                        {!! Form::text('bank_name', $item->bank_name, [
                            'class' => ' jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'bank_name',
                            'data-rule-AlphabetsV1' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {{-- {{ Form::label(__('proposals.latest_limit_utilized_date'), __('proposals.latest_limit_utilized_date')) }}
                        {!! Form::date('latest_limit_utilized_date', $item->latest_limit_utilized_date, [
                            'class' => 'form-control  latest_limit_utilized_date ' . $readonly_cls,
                            'min' => '1000-01-01',
                            'max' => '9999-12-31',
                            'name' => 'latest_limit_utilized_date',
                            $readonly,
                        ]) !!} --}}

                        {!! Form::label(__('proposals.latest_limit_utilized'), __('proposals.latest_limit_utilized')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('latest_limit_utilized', $item->latest_limit_utilized, [
                            'class' => 'form-control jsClearContractorType  number ' . $readonly_cls,
                            'name' => 'latest_limit_utilized',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.unutilized_limit'), __('proposals.unutilized_limit')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('unutilized_limit', $item->unutilized_limit, [
                            'class' => 'form-control jsClearContractorType  number ' . $readonly_cls,
                            'name' => 'unutilized_limit',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.commission_on_pg'), __('proposals.commission_on_pg')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('commission_on_pg', $item->commission_on_pg, [
                            'class' => 'form-control jsClearContractorType number ' . $readonly_cls,
                            'name' => 'commission_on_pg',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.commission_on_fg'), __('proposals.commission_on_fg')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('commission_on_fg', $item->commission_on_fg, [
                            'class' => 'form-control jsClearContractorType number ' . $readonly_cls,
                            'name' => 'commission_on_fg',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group 111">
                        {!! Form::label(__('proposals.margin_collateral'), __('proposals.margin_collateral')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('margin_collateral', $item->margin_collateral, [
                            'class' => 'form-control jsClearContractorType  number ' . $readonly_cls,
                            'name' => 'margin_collateral',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.other_banking_details'), __('proposals.other_banking_details')) !!}
                        {!! Form::textarea('other_banking_details', $item->other_banking_details, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'rows' => 2,
                            'name' => 'other_banking_details',
                            'data-rule-AlphabetsAndNumbersV3' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(
                            __('proposals.proposal_banking_limits_attachment'),
                            __('proposals.proposal_banking_limits_attachment'),
                        ) !!}
                        {!! Form::file('proposal_banking_limits_attachment', [
                            'id' => 'proposal_banking_limits_attachment',
                            'class' => 'proposal_banking_limits_attachment',
                            'multiple',
                            $disabled,
                        ]) !!}
                        <div class="fileNamesContainer mt-2"></div>
                        <hr>
                        @if (isset($item->id))
                            @foreach ($item->dMS as $attachment)
                                @if ($attachment->file_name)
                                    <div class="dms_data" data-id="{{ $attachment->id }}">
                                        <input type="hidden" class="dms_data_id">
                                        {{ $attachment->file_name }}&nbsp;
                                        <i class="fa fa-trash-alt" style="font-size:10px;color:red"></i>
                                    </div>
                                @endif
                            @endforeach
                        @endif --}}

                        <div class="d-block">
                            {!! Form::label(
                                __('proposals.proposal_banking_limits_attachment'),
                                __('proposals.proposal_banking_limits_attachment'),
                            ) !!}
                        </div>
    
                        <div class="d-block jsDivClass">
                            {!! Form::file('banking_limits_attachment', [
                                'class' => 'banking_limits_attachment jsDocument form-control',
                                'id' => 'banking_limits_attachment',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                $disabled,
                            ]) !!}
                            @php
                                $data_banking_limits_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                                $dsbtcls = $data_banking_limits_attachment == 0 ? 'disabled' : '';
                            @endphp
                            {{-- <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                                data-target-modal="#commonModalID"
                                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'banking_limits_attachment', 'dmsable_type' => 'BankingLimits']) }}"
                                class="call-modal JsBankingLimitsAttachment navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="banking_limits_attachment"
                                data-delete="jsBankingLimitsAttachmentDeleted">
                                <span class="navi-icon"><span class="length_banking_limits_attachment"
                                        data-banking_limits_attachment ='{{ $data_banking_limits_attachment }}'>{{ $data_banking_limits_attachment }}</span>&nbsp;Document</span>
                            </a> --}}

                            <a href="#" data-toggle="modal" data-modal="n" data-repeater-row="pbl_row" data-target="#pbl_attachment_{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBankingLimitsAttachmentDeleted" data-prefix="banking_limits_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                {{-- <span class="navi-icon"><span class="length_banking_limits_attachment"
                                    data-banking_limits_attachment ='{{ $data_banking_limits_attachment }}'>{{ $data_banking_limits_attachment }}</span>&nbsp;Document</span> --}}
                                <span class = "count_banking_limits_attachment" data-count_banking_limits_attachment = "{{ $data_banking_limits_attachment }}">{{ $data_banking_limits_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="pbl_attachment_{{ $item->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Proposal Documents</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                                @foreach ($item->dMS as $documents)
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    {!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp; {{ $documents->file_name ?? '' }}
                                                                    <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>
                                                                {{-- <td>&nbsp;
                                                                    <a type="button">
                                                                        <i class="flaticon2-cross small dms_attachment_remove" data-prefix=""
                                                                        data-url="{{ route('removeDmsAttachment') }}"
                                                                        data-id="{{ $documents->id }}">
                                                                        </i>
                                                                    </a>
                                                                </td> --}}
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endforeach
                                                {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                                        target="_blanck">
                                                                                        {{ $dms_data->file_name }}
                                                                                    </a> --}}
                                            @else
                                                {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-5 delete_pbl_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>

                <input type="hidden" name="delete_pbl_id" value="" class="jsDeletePblId">
            @endforeach
        </div>
    @else
        <div class="repeaterRow pbl_repeater_row" data-repeater-list="pbl_items">
            <div class="row mb-5 pbl_row" data-row-index="1" data-repeater-item="" style="border-bottom: 1px solid grey;">
                {!! Form::hidden('pbl_id', '', ['class' => 'jsPblId']) !!}
                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.banking_category_id'), __('proposals.banking_category_label')) !!}

                    {!! Form::select('banking_category_id', ['' => 'Select Banking Category'] + $banking_limit_category, null, [
                        'class' => 'form-control jsClearContractorType banking_category_id ',
                        'style' => 'width:100%;',
                        'data-placeholder' => 'Select Banking Category',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.facility_type_id'), __('proposals.facility_types_label')) !!}

                    {!! Form::select('facility_type_id', ['' => 'Select Facility Type'] + $facility_types, null, [
                        'class' => 'form-control jsClearContractorType facility_type_id ',
                        'style' => 'width:100%;',
                        'data-placeholder' => 'Select Facility Type',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.sanctioned_amount'), __('proposals.sanctioned_amount')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('sanctioned_amount', null, [
                        'class' => 'form-control jsClearContractorType number ',
                        'name' => 'sanctioned_amount',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.bank_name'), __('proposals.bank_name')) !!}
                    {!! Form::text('bank_name', null, [
                        'class' => 'form-control jsClearContractorType ',
                        'name' => 'bank_name',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {{-- {{ Form::label(__('proposals.latest_limit_utilized_date'), __('proposals.latest_limit_utilized_date')) }}
                    {!! Form::date('latest_limit_utilized_date', null, [
                        'class' => 'form-control  latest_limit_utilized_date',
                        'min' => '1000-01-01',
                        'max' => '9999-12-31',
                        'name' => 'latest_limit_utilized_date',
                    ]) !!} --}}

                    {!! Form::label(__('proposals.latest_limit_utilized'), __('proposals.latest_limit_utilized')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('latest_limit_utilized', null, [
                        'class' => 'form-control jsClearContractorType  number',
                        'name' => 'latest_limit_utilized',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.unutilized_limit'), __('proposals.unutilized_limit')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('unutilized_limit', null, [
                        'class' => 'form-control jsClearContractorType  number',
                        'name' => 'unutilized_limit',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.commission_on_pg'), __('proposals.commission_on_pg')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('commission_on_pg', null, [
                        'class' => 'form-control jsClearContractorType number',
                        'name' => 'commission_on_pg',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.commission_on_fg'), __('proposals.commission_on_fg')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('commission_on_fg', null, [
                        'class' => 'form-control jsClearContractorType number',
                        'name' => 'commission_on_fg',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.margin_collateral'), __('proposals.margin_collateral')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('margin_collateral', null, [
                        'class' => 'form-control jsClearContractorType  number',
                        'name' => 'margin_collateral',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.other_banking_details'), __('proposals.other_banking_details')) !!}
                    {!! Form::textarea('other_banking_details', null, [
                        'class' => 'form-control jsClearContractorType',
                        'rows' => 2,
                        'data-rule-AlphabetsAndNumbersV3' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {{-- {!! Form::label(
                        __('proposals.proposal_banking_limits_attachment'),
                        __('proposals.proposal_banking_limits_attachment'),
                    ) !!}
                    {!! Form::file('proposal_banking_limits_attachment', [
                        'id' => 'proposal_banking_limits_attachment',
                        'class' => 'proposal_banking_limits_attachment',
                        'multiple',
                    ]) !!}
                    <div class="fileNamesContainer" class="mt-2"></div> --}}

                    <div class="d-block">
                        {!! Form::label(
                            __('proposals.proposal_banking_limits_attachment'),
                            __('proposals.proposal_banking_limits_attachment'),
                        ) !!}
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('banking_limits_attachment', [
                            'class' => 'banking_limits_attachment jsDocument form-control',
                            'id' => 'banking_limits_attachment',
                            'multiple',
                            'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}
                        @php
                            $data_banking_limits_attachment = isset($dms_data) && isset($dms_data['banking_limits_attachment']) ? count($dms_data['banking_limits_attachment']) : 0;
                            $dsbtcls = $data_banking_limits_attachment == 0 ? 'disabled' : '';
                        @endphp
                        <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-modal="n" data-repeater-row="pbl_row" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'banking_limits_attachment', 'dmsable_type' => 'BankingLimits']) }}"
                            class="call-modal JsBankingLimitsAttachment navi-link jsRepeaterProposalShowDocument {{ $dsbtcls }}" data-prefix="banking_limits_attachment"
                            data-delete="jsBankingLimitsAttachmentDeleted">
                            {{-- <span class="navi-icon"><span class="length_banking_limits_attachment"
                                    data-banking_limits_attachment ='{{ $data_banking_limits_attachment }}'>{{ $data_banking_limits_attachment }}</span>&nbsp;Document</span> --}}
                            <span class = "count_banking_limits_attachment" data-count_banking_limits_attachment = "0"></span>
                        </a>

                        {{-- <a href="#" data-toggle="modal" data-target="#pbl_attachment_{{ $loop->iteration }}"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBankingLimitsAttachmentDeleted" data-prefix="banking_limits_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;<span class="navi-icon"><span class="length_banking_limits_attachment"
                                data-banking_limits_attachment ='{{ $data_banking_limits_attachment }}'>{{ $data_banking_limits_attachment }}</span>&nbsp;Document</span>
                        </a>

                        <div class="modal fade" tabindex="-1" id="pbl_attachment_{{ $loop->iteration }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Proposal Documents</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <a class="jsFileRemove"></a>
                                        @if (isset($item->dMS) && count($item->dMS) > 0)
                                            @foreach ($item->dMS as $documents)
                                                <div class="mb-3">
                                                    <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? asset($documents->attachment) : asset('/default.jpg') }}"
                                                        target="_blanck">
                                                        {!! getdmsFileIcon($documents->file_name) !!}
                                                    </a>
                                                    {!! $documents->file_name !!}
                                                </div>
                                            @endforeach
                                        @else
                                            <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="col-lg-12 mb-5 delete_pbl_item" style="text-align: end;">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>

            <input type="hidden" name="delete_pbl_id" value="" class="jsDeletePblId">
        </div>
    @endif

    <div class="row {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAddProposalBankingLimits">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div>