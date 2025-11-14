<div id="managementProfilesRepeater">
    @if (isset($management_profiles))
        <div class="repeaterRow mp_repeater_row" data-repeater-list="mp_items">
            @foreach ($management_profiles as $item)
                <div class="row mb-5 mp_row" data-row-index="{{ $loop->iteration }}" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden('mp_id', $item->id ?? '', ['class' => 'jsMpId mp_repeater_id']) !!}
                    {!! Form::hidden('mcfr_id', $item->contractor_fetch_reference_id ?? '') !!}
                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.designation'), __('proposals.designation')) !!}

                        {!! Form::select('designation', ['' => 'Select Designation'] + $designation, $item->designation, [
                            'class' => 'form-control jsClearContractorType designation_dropdown',
                            'style' => 'width:100%;',
                            'data-placeholder' => 'Select Designation',
                            $disabled,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.name'), __('proposals.name')) !!}
                        {!! Form::text('name', $item->name, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'name',
                            'id' => 'name',
                            'data-rule-AlphabetsV1' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.qualifications'), __('proposals.qualifications')) !!}
                        {!! Form::text('qualifications', $item->qualifications, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'qualifications',
                            'data-rule-AlphabetsAndNumbersV9' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.experience'), __('proposals.experience')) !!}
                        {!! Form::text('experience', $item->experience, [
                            'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                            'name' => 'experience',
                            'data-rule-DecimalV2' => true,
                            $readonly,
                        ]) !!}
                    </div>

                    <div class="col-lg-6 form-group">
                        <div class="d-block">
                            {!! Form::label(
                                __('proposals.management_profiles_attachment'),
                                __('proposals.management_profiles_attachment'),
                            ) !!}
                        </div>

                        <div class="d-block jsDivClass">
                            {!! Form::file('management_profiles_attachment', [
                                'class' => 'management_profiles_attachment jsDocument form-control',
                                'id' => 'management_profiles_attachment',
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
                                $data_management_profiles_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                                $dsbtcls = $data_management_profiles_attachment == 0 ? 'disabled' : '';
                            @endphp
                            {{-- <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-toggle="modal"
                                data-target-modal="#commonModalID"
                                data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'management_profiles_attachment', 'dmsable_type' => 'ManagementProfiles']) }}"
                                class="call-modal JsManagementProfilesAttachmentAttachment navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="management_profiles_attachment"
                                data-delete="jsManagementProfilesAttachmentDeleted">
                                <span class="navi-icon"><span class="length_management_profiles_attachment"
                                        data-management_profiles_attachment ='{{ $data_management_profiles_attachment }}'>{{ $data_management_profiles_attachment }}</span>&nbsp;Document</span>
                            </a> --}}

                            <a href="#" data-toggle="modal" data-modal="n" data-repeater-row="mp_row" data-target="#mp_attachment_{{ $item->id }}"
                                class="call-modal jsRepeaterProposalShowDocument navi-link {{ $dsbtcls }}" data-delete="jsManagementProfilesAttachmentDeleted" data-prefix="management_profiles_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                <span class = "count_management_profiles_attachment" data-count_management_profiles_attachment = "{{ $data_management_profiles_attachment }}">{{ $data_management_profiles_attachment }}&nbsp;document</span>
                            </a>

                            <div class="modal fade" tabindex="-1" id="mp_attachment_{{ $item->id }}">
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

                    <div class="col-lg-12 mb-5 delete_mp_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>

                <input type="hidden" name="delete_mp_id" value="" class="jsDeleteMpId">
            @endforeach
        </div>
    @else
        <div class="repeaterRow mp_repeater_row" data-repeater-list="mp_items">
            <div class="row mb-5 mp_row" data-row-index="1" data-repeater-item="" style="border-bottom: 1px solid grey;">
                <input type="hidden" name="mp_id" class="jsMpId mp_repeater_id">
                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.designation'), __('proposals.designation')) !!}

                    {!! Form::select('designation', ['' => 'Select Designation'] + $designation, null, [
                        'class' => 'form-control  designation_dropdown',
                        'style' => 'width:100%;',
                        'data-placeholder' => 'Select Designation',
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.name'), __('proposals.name')) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control jsClearContractorType',
                        'id' => 'name',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.qualifications'), __('proposals.qualifications')) !!}
                    {!! Form::text('qualifications', null, [
                        'class' => 'form-control jsClearContractorType',
                        'id' => 'qualifications',
                        'data-rule-AlphabetsAndNumbersV9' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.experience'), __('proposals.experience')) !!}
                    {!! Form::text('experience', null, [
                        'class' => 'form-control jsClearContractorType',
                        'name' => 'experience',
                        'data-rule-DecimalV2' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {{-- {!! Form::label(__('proposals.management_profiles_attachment'), __('proposals.management_profiles_attachment')) !!}
                    {!! Form::file('management_profiles_attachment', [
                        'id' => 'management_profiles_attachment',
                        'class' => 'management_profiles_attachment ',
                        'multiple',
                    ]) !!}
                    <div class="fileNamesContainer" class="mt-2"></div> --}}

                    <div class="d-block">
                        {!! Form::label(
                            __('proposals.management_profiles_attachment'),
                            __('proposals.management_profiles_attachment'),
                        ) !!}
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('management_profiles_attachment', [
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
                            $data_management_profiles_attachment = isset($item) && isset($item->dMS) ? count($item->dMS) : 0;
                            $dsbtcls = $data_management_profiles_attachment == 0 ? 'disabled' : '';
                        @endphp
                        <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-repeater-row="mp_row" data-modal="n" data-toggle="modal"
                            data-target-modal="#commonModalID"
                            data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'management_profiles_attachment', 'dmsable_type' => 'ManagementProfiles']) }}"
                            class="call-modal JsManagementProfilesAttachmentAttachment navi-link jsRepeaterProposalShowDocument {{ $dsbtcls }}" data-prefix="management_profiles_attachment"
                            data-delete="jsManagementProfilesAttachmentDeleted">
                            <span class = "count_management_profiles_attachment" data-count_management_profiles_attachment = "0"></span>
                        </a>

                        {{-- <a href="#" data-toggle="modal" data-target="#mp_attachment"
                            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsManagementProfilesAttachmentDeleted" data-prefix="management_profiles_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;<span class="navi-icon"><span class="length_management_profiles_attachment"
                                data-management_profiles_attachment ='{{ $data_management_profiles_attachment }}'>{{ $data_management_profiles_attachment }}</span>&nbsp;Document</span>
                        </a>

                        <div class="modal fade" tabindex="-1" id="mp_attachment">
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

                <div class="col-lg-12 mb-5 delete_mp_item" style="text-align: end;">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>

            <input type="hidden" name="delete_mp_id" value="" class="jsDeleteMpId">
        </div>
    @endif

    <div class="row  {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAddManagementProfiles">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div>
