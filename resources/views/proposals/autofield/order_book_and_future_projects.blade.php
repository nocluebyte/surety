<div id="orderBookAndFutureProjectsRepeater">
    @if (isset($order_book_and_future_projects))
        <div class="repeaterRow obfp_repeater_row" data-repeater-list="obfp_items">
            @foreach ($order_book_and_future_projects as $index => $item)
                <div class="row mb-5 obfp_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden("obfp_items[{$index}][obfp_id]", $item->id ?? '', ['class' => 'jsObfpId obfp_repeater_id']) !!}
                    {!! Form::hidden("obfp_items[{$index}][ocfr_id]", $item->id ?? '') !!}
                    {!! Form::hidden("obfp_items[{$index}][autoFetch]", 'autoFetch') !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.project_name'), __('proposals.project_name')) !!}
                        {!! Form::text("obfp_items[{$index}][project_name]", $item->project_name ?? null, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-AlphabetsAndNumbersV8' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.project_cost'), __('proposals.project_cost')) !!}<span class="currency_symbol"></span>
                        {!! Form::text("obfp_items[{$index}][project_cost]", $item->project_cost ?? null, [
                            'class' => 'form-control number jsClearContractorType',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('proposals.project_description'), __('proposals.project_description')) !!}
                        {!! Form::textarea("obfp_items[{$index}][project_description]", $item->project_description ?? '', [
                            'class' => 'form-control jsClearContractorType',
                            'rows' => 2,
                            'data-rule-Remarks' => true,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_start_date'), __('proposals.project_start_date')) !!}
                        {!! Form::date("obfp_items[{$index}][project_start_date]", $item->project_start_date ?? null, ['class' => 'form-control obfp_project_start_date jsClearContractorType jsObfpPeriod', 'min' => '1000-01-01', 'max' => '9999-12-31',]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_end_date'), __('proposals.project_end_date')) !!}
                        {!! Form::date("obfp_items[{$index}][project_end_date]", $item->project_end_date ?? null, ['class' => 'form-control obfp_project_end_date jsClearContractorType jsObfpPeriod jsObfpEndDate', 
                        // 'max' => '9999-12-31',
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_tenor'), __('proposals.project_tenor')) !!}
                        {!! Form::text("obfp_items[{$index}][project_tenor]", $item->project_tenor ?? null, [
                            'class' => 'form-control jsClearContractorType number jsObfpProjectTenor form-control-solid',
                            'data-rule-Numbers' => true,
                            'readonly',
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('proposals.bank_guarantees_details'), __('proposals.bank_guarantees_details')) !!}
                        {!! Form::textarea("obfp_items[{$index}][bank_guarantees_details]", $item->bank_guarantees_details ?? null, [
                            'class' => 'form-control jsClearContractorType',
                            'rows' => 2,
                            'data-rule-AlphabetsAndNumbersV3' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.project_share'), __('proposals.project_share')) !!}
                        {!! Form::text("obfp_items[{$index}][project_share]", $item->project_share ?? null, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.guarantee_amount'), __('proposals.guarantee_amount')) !!}<span class="currency_symbol"></span>
                        {!! Form::text("obfp_items[{$index}][guarantee_amount]", $item->guarantee_amount ?? null, [
                            'class' => 'form-control number jsClearContractorType',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.current_status'), __('proposals.current_status')) !!}
                        {!! Form::select("obfp_items[{$index}][current_status]", ['' => 'Select Current Status'] + $current_status, $item->current_status ?? null, [
                            'class' => 'form-control jsClearContractorType current_status_dropdown jsSelect2ClearAllow',
                            'data-placeholder' => 'Select Current Status',
                            'style' => 'width: 100%;',
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(
                            __('proposals.order_book_and_future_projects_attachment'),
                            __('proposals.order_book_and_future_projects_attachment'),
                        ) !!}
                        {!! Form::file("obfp_items[{$index}][order_book_and_future_projects_attachment]", [
                            'class' => 'order_book_and_future_projects_attachment',
                            'multiple',
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
                                __('proposals.order_book_and_future_projects_attachment'),
                                __('proposals.order_book_and_future_projects_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file("obfp_items[{$index}][order_book_and_future_projects_attachment][]", [
                                'class' => 'order_book_and_future_projects_attachment jsDocument form-control',
                                'id' => 'order_book_and_future_projects_attachment',
                                // empty($dms_data) ? '' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_order_book_and_future_projects_attachment = isset($dms_data) && isset($dms_data['order_book_and_future_projects_attachment']) ? count($dms_data['order_book_and_future_projects_attachment']) : 0;
                                $dsbtcls = $data_order_book_and_future_projects_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-modal="p" data-repeater-row="obfp_row" data-target="#loaDocuments{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsOrderBookAndFutureProjectsAttachmentDeleted" data-prefix="order_book_and_future_projects_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                {{-- <span class="navi-icon"><span class="length_order_book_and_future_projects_attachment"
                                    data-order_book_and_future_projects_attachment ='{{ $data_order_book_and_future_projects_attachment }}'>{{ $data_order_book_and_future_projects_attachment }}</span>&nbsp;Document</span> --}}
                                <span class = "count_order_book_and_future_projects_attachment" data-count_order_book_and_future_projects_attachment = "{{ $item->dMS->count() }}">{{ $item->dMS->count() }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="loaDocuments{{ $item->id }}">
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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-12 mb-5 delete_obfp_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div> --}}
                </div>
                {!! Form::hidden("obfp_items[{$index}][delete_obfp_id]", null, ['class' => 'jsDeleteObfpId']) !!}
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript">
        $('.current_status_dropdown').select2({
            allowClear: true,
        });
    </script>
@endpush