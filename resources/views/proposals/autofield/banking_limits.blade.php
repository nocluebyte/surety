<div id="proposalBankingLimitsRepeater">
    @if (isset($proposal_banking_limits))
        <div class="repeaterRow pbl_repeater_row" data-repeater-list="pbl_items">
            @foreach ($proposal_banking_limits as $index => $item)
                <div class="row mb-5 pbl_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden("pbl_items[{$index}][pbl_id]", $item->id ?? '', ['class' => 'jsPblId']) !!}
                    {!! Form::hidden("pbl_items[{$index}][cfr_id]", $item->id ?? '') !!}
                    {!! Form::hidden("pbl_items[{$index}][autoFetch]", 'autoFetch') !!}

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.banking_category_id'), __('proposals.banking_category_label')) !!}

                        {!! Form::select(
                            "pbl_items[{$index}][banking_category_id]",
                            ['' => 'Select Banking Category'] + $banking_limit_category,
                            $item->banking_category_id,
                            [
                                'class' => 'form-control jsClearContractorType banking_category_id',
                                'style' => 'width:100%;',
                                'data-placeholder' => 'Select Banking Category',
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.facility_type_id'), __('proposals.facility_types_label')) !!}

                        {!! Form::select(
                            "pbl_items[{$index}][facility_type_id]",
                            ['' => 'Select Facility Type'] + $facility_types,
                            $item->facility_type_id,
                            [
                                'class' => 'form-control jsClearContractorType facility_type_id',
                                'style' => 'width:100%;',
                                'data-placeholder' => 'Select Facility Type',
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.sanctioned_amount'), __('proposals.sanctioned_amount')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][sanctioned_amount]",
                            $item->sanctioned_amount,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.bank_name'), __('proposals.bank_name')) !!}
                        {!! Form::text(
                            "pbl_items[{$index}][bank_name]",
                            $item->bank_name,
                            [
                                'class' => 'form-control jsClearContractorType',
                                'data-rule-AlphabetsV1' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {{-- {{ Form::label(__('proposals.latest_limit_utilized_date'), __('proposals.latest_limit_utilized_date')) }}
                        {!! Form::date(
                            "pbl_items[{$index}][latest_limit_utilized_date]",
                            $item->latest_limit_utilized_date,
                            [
                                'class' => 'form-control latest_limit_utilized_date required',
                                'min' => '1000-01-01',
                                'max' => '9999-12-31',
                            ]
                        ) !!} --}}

                        {!! Form::label(__('proposals.latest_limit_utilized'), __('proposals.latest_limit_utilized')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][latest_limit_utilized]",
                            $item->latest_limit_utilized,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.unutilized_limit'), __('proposals.unutilized_limit')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][unutilized_limit]",
                            $item->unutilized_limit,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.commission_on_pg'), __('proposals.commission_on_pg')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][commission_on_pg]",
                            $item->commission_on_pg,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.commission_on_fg'), __('proposals.commission_on_fg')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][commission_on_fg]",
                            $item->commission_on_fg,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-4 form-group 111">
                        {!! Form::label(__('proposals.margin_collateral'), __('proposals.margin_collateral')) !!}<span class="currency_symbol"></span>
                        {!! Form::text(
                            "pbl_items[{$index}][margin_collateral]",
                            $item->margin_collateral,
                            [
                                'class' => 'form-control jsClearContractorType number',
                                'data-rule-Numbers' => true,
                            ]
                        ) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.other_banking_details'), __('principle.other_banking_details')) !!}
                        {!! Form::textarea("pbl_items[{$index}][other_banking_details]", $item->other_banking_details, [
                            'class' => 'form-control jsClearContractorType',
                            'rows' => 2,
                            'data-rule-AlphabetsAndNumbersV3' => true,
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        <div class="d-block">
                            {!! Form::label(
                                __('proposals.proposal_banking_limits_attachment'),
                                __('proposals.proposal_banking_limits_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file("pbl_items[{$index}][banking_limits_attachment][]", [
                                'class' => 'banking_limits_attachment jsDocument form-control',
                                'id' => 'banking_limits_attachment',
                                // empty($dms_data) ? '' : '',
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

                            {{-- @dd($item->dMS->count()) --}}
                            <a href="#" data-toggle="modal" data-modal="p" data-repeater-row="pbl_row" data-target="#pbl_autofetch_{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBankingLimitsAttachmentDeleted" data-prefix="banking_limits_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                {{-- <span class="navi-icon"><span class="length_banking_limits_attachment"
                                    data-banking_limits_attachment ='{{ $data_banking_limits_attachment }}'>{{ $data_banking_limits_attachment }}</span>&nbsp;Document</span> --}}
                                <span class = "count_banking_limits_attachment" data-count_banking_limits_attachment = "{{ $item->dMS->count() }}">{{ $item->dMS->count() }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="pbl_autofetch_{{ $item->id }}">
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
                                            @php
                                                $dsbtcls = count($item->dMS);
                                            @endphp
                                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                                @foreach ($item->dMS as $documents)
                                                    <div class="mb-3">
                                                        {{-- <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? asset($documents->attachment) : asset('/default.jpg') }}"
                                                            target="_blanck">
                                                            {!! getdmsFileIcon($documents->file_name) !!}
                                                        </a>
                                                        {!! $documents->file_name !!} --}}

                                                        {!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp; {{ $documents->file_name ?? '' }} <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}"
                                                            target="_blanck" download>
                                                            <i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                                {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                                        target="_blanck">
                                                                                        {{ $dms_data->file_name }}
                                                                                    </a> --}}
                                            {{-- @else
                                                <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-12 mb-5 delete_pbl_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div> --}}
                </div>
                {!! Form::hidden("pbl_items[{$index}][delete_pbl_id]", null, ['class' => 'jsDeletePblId']) !!}
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript">
        $('.banking_category_id, .facility_type_id').select2({
            allowClear: true,
        });
    </script>
@endpush