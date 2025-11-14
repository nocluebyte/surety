<div id="projectTrackRecordsRepeater">
    @if (isset($project_track_records))
        <div class="repeaterRow ptr_repeater_row" data-repeater-list="ptr_items">
            @foreach ($project_track_records as $index => $item)
                <div class="row mb-5 ptr_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden("ptr_items[{$index}][ptr_id]", $item->id ?? '', ['class' => 'jsPtrId ptr_repeater_id']) !!}
                    {!! Form::hidden("ptr_items[{$index}][pcfr_id]", $item->id ?? '') !!}
                    {!! Form::hidden("ptr_items[{$index}][autoFetch]", 'autoFetch') !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.project_name'), __('principle.project_name')) !!}
                        {!! Form::text("ptr_items[{$index}][project_name]", $item->project_name ?? null, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-AlphabetsAndNumbersV8' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('principle.project_cost'), __('principle.project_cost')) !!}<span class="currency_symbol"></span>
                        {!! Form::text("ptr_items[{$index}][project_cost]", $item->project_cost ?? null, [
                            'class' => 'form-control jsClearContractorType number',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('principle.project_description'), __('principle.project_description')) !!}
                        {!! Form::textarea("ptr_items[{$index}][project_description]", $item->project_description ?? '', [
                            'class' => 'form-control jsClearContractorType',
                            'rows' => 2,
                            'data-rule-Remarks' => true,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_start_date'), __('principle.project_start_date')) !!}
                        {!! Form::date("ptr_items[{$index}][project_start_date]", $item->project_start_date ?? null, ['class' => 'form-control ptr_project_start_date jsClearContractorType jsPtrPeriod', 'min' => '1000-01-01', 'max' => '9999-12-31',]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_end_date'), __('principle.project_end_date')) !!}
                        {!! Form::date("ptr_items[{$index}][project_end_date]", $item->project_end_date ?? null, ['class' => 'form-control ptr_project_end_date jsClearContractorType jsPtrPeriod jsPtrEndDate', 
                        // 'min' => '1000-01-01',
                        // 'max' => '9999-12-31',
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.project_tenor'), __('principle.project_tenor')) !!}
                        {!! Form::text("ptr_items[{$index}][project_tenor]", $item->project_tenor ?? null, [
                            'class' => 'form-control number jsClearContractorType form-control-solid jsPtrProjectTenor',
                            'data-rule-Numbers' => true,
                            'readonly',
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('principle.bank_guarantees_details'), __('principle.bank_guarantees_details')) !!}
                        {!! Form::textarea("ptr_items[{$index}][bank_guarantees_details]", $item->bank_guarantees_details ?? null, [
                            'class' => 'form-control jsClearContractorType',
                            'rows' => 2,
                            'data-rule-AlphabetsAndNumbersV3' => true,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {{ Form::label(__('principle.actual_date_completion'), __('principle.actual_date_completion')) }}
                        {!! Form::date("ptr_items[{$index}][actual_date_completion]", $item->actual_date_completion ?? null, [
                            'class' => 'form-control jsClearContractorType actual_date_completion minDate statusDate',
                            'min' => '1000-01-01',
                            'max' => '9999-12-31',
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('principle.bg_amount'), __('principle.bg_amount')) !!}<span class="currency_symbol"></span>
                        {!! Form::text("ptr_items[{$index}][bg_amount]", $item->bg_amount ?? null, [
                            'class' => 'form-control jsClearContractorType number',
                            'data-rule-Numbers' => true,
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(
                            __('principle.project_track_records_attachment'),
                            __('principle.project_track_records_attachment'),
                        ) !!}
                        {!! Form::file("ptr_items[{$index}][project_track_records_attachment]", [
                            'class' => 'project_track_records_attachment',
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
                                __('proposals.project_track_records_attachment'),
                                __('proposals.project_track_records_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file("ptr_items[{$index}][project_track_records_attachment][]", [
                                'class' => 'project_track_records_attachment jsDocument form-control',
                                'id' => 'project_track_records_attachment',
                                // empty($dms_data) ? '' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_project_track_records_attachment = isset($dms_data) && isset($dms_data['project_track_records_attachment']) ? count($dms_data['project_track_records_attachment']) : 0;
                                $dsbtcls = $data_project_track_records_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-modal="p" data-repeater-row="ptr_row" data-target="#loaDocuments{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsProjectTrackRecordsAttachmentDeleted" data-prefix="project_track_records_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_project_track_records_attachment" data-count_project_track_records_attachment = "{{ $item->dMS->count() }}">{{ $item->dMS->count() }}&nbsp;document</span>
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

                    {{-- <div class="col-lg-12 mb-5 delete_ptr_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div> --}}
                </div>

                {!! Form::hidden("ptr_items[{$index}][delete_ptr_id]", null, ['class' => 'jsDeletePtrId']) !!}
            @endforeach
        </div>
    @endif
</div>