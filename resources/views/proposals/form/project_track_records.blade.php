<div id="projectTrackRecordsRepeater">
    @if (isset($project_track_records))
        <div class="repeaterRow ptr_repeater_row" data-repeater-list="ptr_items">
            @foreach ($project_track_records as $item)
                <div class="row mb-5 ptr_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden('ptr_id', $item->id ?? '', ['class' => 'jsPtrId ptr_repeater_id']) !!}
                    {!! Form::hidden('pcfr_id', $item->contractor_fetch_reference_id ?? '') !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.project_name'), __('proposals.project_name')) !!}
                        {!! Form::text('project_name', $item->project_name ?? null, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'project_name',
                            'data-rule-AlphabetsAndNumbersV8' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.project_cost'), __('proposals.project_cost')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('project_cost', $item->project_cost ?? null, [
                            'class' => 'form-control jsClearContractorType number ' . $readonly_cls,
                            'name' => 'project_cost',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('proposals.project_description'), __('proposals.project_description')) !!}
                        {!! Form::textarea('project_description', $item->project_description ?? '', [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'project_description',
                            'rows' => 2,
                            'data-rule-Remarks' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_start_date'), __('proposals.project_start_date')) !!}
                        {!! Form::date('project_start_date', $item->project_start_date ?? null, ['class' => 'ptr_project_start_date jsClearContractorType jsPtrPeriod form-control ' . $readonly_cls, 'min' => '1000-01-01', 'max' => '9999-12-31', $readonly,]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_end_date'), __('proposals.project_end_date')) !!}
                        {!! Form::date('project_end_date', $item->project_end_date ?? null, ['class' => 'ptr_project_end_date jsClearContractorType jsPtrEndDate jsPtrPeriod form-control ' . $readonly_cls, $readonly, 
                        // 'max' => '9999-12-31',
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.project_tenor'), __('proposals.project_tenor')) !!}
                        {!! Form::text('project_tenor', $item->project_tenor ?? null, [
                            'class' => 'form-control jsClearContractorType form-control-solid jsPtrProjectTenor number ' . $readonly_cls,
                            'name' => 'project_tenor',
                            'data-rule-Numbers' => true,
                            'readonly',
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-12 form-group">
                        {!! Form::label(__('proposals.bank_guarantees_details'), __('proposals.bank_guarantees_details')) !!}
                        {!! Form::textarea('bank_guarantees_details', $item->bank_guarantees_details ?? null, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'bank_guarantees_details',
                            'rows' => 2,
                            'data-rule-AlphabetsAndNumbersV3' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {{ Form::label(__('proposals.actual_date_completion'), __('proposals.actual_date_completion')) }}
                        {!! Form::date('actual_date_completion', $item->actual_date_completion ?? null, [
                            'class' => 'form-control jsClearContractorType actual_date_completion minDate statusDate ' . $readonly_cls,
                            'min' => '1000-01-01',
                            'max' => '9999-12-31',
                            'name' => 'actual_date_completion',
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-4 form-group">
                        {!! Form::label(__('proposals.bg_amount'), __('proposals.bg_amount')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                        {!! Form::text('bg_amount', $item->bg_amount ?? null, [
                            'class' => 'form-control jsClearContractorType number ' . $readonly_cls,
                            'name' => 'bg_amount',
                            'data-rule-Numbers' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(
                            __('proposals.project_track_records_attachment'),
                            __('proposals.project_track_records_attachment'),
                        ) !!}
                        {!! Form::file('project_track_records_attachment', [
                            'id' => 'project_track_records_attachment',
                            'class' => 'project_track_records_attachment',
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
                                __('proposals.project_track_records_attachment'),
                                __('proposals.project_track_records_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file('project_track_records_attachment', [
                                'class' => 'project_track_records_attachment jsDocument form-control',
                                'id' => 'project_track_records_attachment',
                                // empty($dms_data) ? '' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                $disabled,
                            ]) !!}
                            @php
                                $data_project_track_records_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                                $dsbtcls = $data_project_track_records_attachment == 0 ? 'disabled' : '';
                            @endphp
                            {{-- <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-toggle="modal"
                                data-target-modal="#commonModalID"
                                data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'project_track_records_attachment', 'dmsable_type' => 'ProjectTrackRecords']) }}"
                                class="call-modal JsProjectTrackRecordsAttachmentAttachment navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="project_track_records_attachment"
                                data-delete="jsProjectTrackRecordsAttachmentDeleted">
                                <span class="navi-icon"><span class="length_project_track_records_attachment"
                                        data-project_track_records_attachment ='{{ $data_project_track_records_attachment }}'>{{ $data_project_track_records_attachment }}</span>&nbsp;Document</span>
                            </a> --}}

                            <a href="#" data-toggle="modal" data-modal="n" data-repeater-row="ptr_row" data-target="#ptr_attachment_{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsProjectTrackRecordsAttachmentDeleted" data-prefix="project_track_records_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_project_track_records_attachment" data-count_project_track_records_attachment = "{{ $data_project_track_records_attachment }}">{{ $data_project_track_records_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="ptr_attachment_{{ $item->id }}">
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

                    <div class="col-lg-12 mb-5 delete_ptr_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>

                <input type="hidden" name="delete_ptr_id" value="" class="jsDeletePtrId">
            @endforeach
        </div>
    @else
        <div class="repeaterRow ptr_repeater_row" data-repeater-list="ptr_items">
            <div class="row mb-5 ptr_row" data-row-index="1" data-repeater-item="" style="border-bottom: 1px solid grey;">
                <input type="hidden" name="ptr_id" class="jsPtrId ptr_repeater_id">
                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.project_name'), __('proposals.project_name')) !!}
                    {!! Form::text('project_name', null, [
                        'class' => 'form-control jsClearContractorType',
                        'name' => 'project_name',
                        'data-rule-AlphabetsAndNumbersV8' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.project_cost'), __('proposals.project_cost')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('project_cost', null, [
                        'class' => 'form-control jsClearContractorType number',
                        'name' => 'project_cost',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-12 form-group">
                    {!! Form::label(__('proposals.project_description'), __('proposals.project_description')) !!}
                    {!! Form::textarea('project_description', null, [
                        'class' => 'form-control jsClearContractorType',
                        'name' => 'project_description',
                        'rows' => 2,
                        'data-rule-Remarks' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.project_start_date'), __('proposals.project_start_date')) !!}
                    {!! Form::date('project_start_date', null, ['class' => 'form-control jsClearContractorType jsPtrPeriod ptr_project_start_date', 'min' => '1000-01-01', 'max' => '9999-12-31',]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.project_end_date'), __('proposals.project_end_date')) !!}
                    {!! Form::date('project_end_date', null, ['class' => 'form-control jsPtrPeriod ptr_project_end_date jsClearContractorType jsPtrEndDate', 
                    // 'min' => '1000-01-01', 'max' => '9999-12-31',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.project_tenor'), __('proposals.project_tenor')) !!}
                    {!! Form::text('project_tenor', null, [
                        'class' => 'form-control jsClearContractorType form-control-solid number jsPtrProjectTenor',
                        'name' => 'project_tenor',
                        'data-rule-Numbers' => true,
                        'readonly',
                    ]) !!}
                </div>

                <div class="col-12 form-group">
                    {!! Form::label(__('proposals.bank_guarantees_details'), __('proposals.bank_guarantees_details')) !!}
                    {!! Form::textarea('bank_guarantees_details', null, [
                        'class' => 'form-control jsClearContractorType',
                        'name' => 'bank_guarantees_details',
                        'rows' => 2,
                        'data-rule-AlphabetsAndNumbersV3' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {{ Form::label(__('proposals.actual_date_completion'), __('proposals.actual_date_completion')) }}
                    {!! Form::date('actual_date_completion', null, [
                        'class' => 'form-control jsClearContractorType actual_date_completion minDate statusDate',
                        'min' => '1000-01-01',
                        'max' => '9999-12-31',
                        'name' => 'actual_date_completion',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('proposals.bg_amount'), __('proposals.bg_amount')) !!}<span class="currency_symbol"></span>
                    {!! Form::text('bg_amount', null, [
                        'class' => 'form-control jsClearContractorType number',
                        'name' => 'bg_amount',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {{-- {!! Form::label(
                        __('proposals.project_track_records_attachment'),
                        __('proposals.project_track_records_attachment'),
                    ) !!}
                    {!! Form::file('project_track_records_attachment', [
                        'id' => 'project_track_records_attachment',
                        'class' => 'project_track_records_attachment',
                        'multiple',
                    ]) !!}
                    <div class="fileNamesContainer" class="mt-2"></div> --}}

                    <div class="d-block">
                        {!! Form::label(
                            __('proposals.project_track_records_attachment'),
                            __('proposals.project_track_records_attachment'),
                        ) !!}
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('project_track_records_attachment', [
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
                            $data_project_track_records_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                            $dsbtcls = $data_project_track_records_attachment == 0 ? 'disabled' : '';
                        @endphp
                        <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-repeater-row="ptr_row" data-modal="n" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'project_track_records_attachment', 'dmsable_type' => 'ProjectTrackRecords']) }}"
                            class="call-modal JsProjectTrackRecordsAttachmentAttachment navi-link jsRepeaterProposalShowDocument {{ $dsbtcls }}" data-prefix="project_track_records_attachment"
                            data-delete="jsProjectTrackRecordsAttachmentDeleted">
                            <span class = "count_project_track_records_attachment" data-count_project_track_records_attachment = "0"></span>
                        </a>

                        {{-- <a href="#" data-toggle="modal" data-target="#ptr_attachment"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsProjectTrackRecordsAttachmentDeleted" data-prefix="project_track_records_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;<span class="navi-icon"><span class="length_project_track_records_attachment"
                                data-project_track_records_attachment ='{{ $data_project_track_records_attachment }}'>{{ $data_project_track_records_attachment }}</span>&nbsp;Document</span>
                        </a>

                        <div class="modal fade" tabindex="-1" id="ptr_attachment">
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

                <div class="col-lg-12 mb-5 delete_ptr_item" style="text-align: end;">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>

            <input type="hidden" name="delete_ptr_id" value="" class="jsDeletePtrId">
        </div>
    @endif

    <div class="row {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAddProjectTrackRecords">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div>