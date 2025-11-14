<div id="managementProfilesRepeater">
    @if (isset($management_profiles))
        <div class="repeaterRow mp_repeater_row" data-repeater-list="mp_items">
            @foreach ($management_profiles as $index => $item)
                <div class="row mb-5 mp_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden("mp_items[{$index}][mp_id]", $item->id ?? '', ['class' => 'jsMpId mp_repeater_id']) !!}
                    {!! Form::hidden("mp_items[{$index}][mcfr_id]", $item->id ?? '') !!}
                    {!! Form::hidden("mp_items[{$index}][autoFetch]", 'autoFetch') !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.designation'), __('proposals.designation')) !!}
                        {!! Form::select("mp_items[{$index}][designation]", ['' => 'Select Designation'] + $designation, $item->designation, [
                            'class' => 'form-control jsClearContractorType designation_dropdown',
                            'style' => 'width:100%;',
                            'data-placeholder' => 'Select Designation',
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.name'), __('proposals.name')) !!}
                        {!! Form::text("mp_items[{$index}][name]", $item->name, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-AlphabetsV1' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.qualifications'), __('proposals.qualifications')) !!}
                        {!! Form::text("mp_items[{$index}][qualifications]", $item->qualifications, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-AlphabetsAndNumbersV9' => true,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.experience'), __('proposals.experience')) !!}
                        {!! Form::text("mp_items[{$index}][experience]", $item->experience, [
                            'class' => 'form-control jsClearContractorType',
                            'data-rule-DecimalV2' => true,
                        ]) !!}
                    </div>

                    <!-- Attachment Section -->
                    <div class="col-lg-6 form-group">
                        {{-- {!! Form::label(__('proposals.management_profiles_attachment'), __('proposals.management_profiles_attachment')) !!}
                        {!! Form::file("mp_items[{$index}][management_profiles_attachment]", [
                            'class' => 'management_profiles_attachment',
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
                                __('proposals.management_profiles_attachment'),
                                __('proposals.management_profiles_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file("mp_items[{$index}][management_profiles_attachment][]", [
                                'class' => 'management_profiles_attachment jsDocument form-control',
                                'id' => 'management_profiles_attachment',
                                // empty($dms_data) ? '' : '',
                                'multiple',
                                'maxfiles' => 5,
                                'maxsizetotal' => '52428800',
                                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}
                            @php
                                $data_management_profiles_attachment = isset($dms_data) && isset($dms_data['management_profiles_attachment']) ? count($dms_data['management_profiles_attachment']) : 0;
                                $dsbtcls = $data_management_profiles_attachment == 0 ? 'disabled' : '';
                            @endphp

                            <a href="#" data-toggle="modal" data-modal="p" data-repeater-row="mp_row" data-target="#loaDocuments{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsManagementProfilesAttachmentDeleted" data-prefix="management_profiles_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_management_profiles_attachment" data-count_management_profiles_attachment = "{{ $item->dMS->count() }}">{{ $item->dMS->count() }}&nbsp;document</span>
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

                    <!-- Delete Button -->
                    {{-- <div class="col-lg-12 mb-5 delete_mp_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div> --}}
                </div>

                {!! Form::hidden("mp_items[{$index}][delete_mp_id]", null, ['class' => 'jsDeleteMpId']) !!}
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript">
        $('.designation_dropdown').select2({
            allowClear: true,
        });
    </script>
@endpush