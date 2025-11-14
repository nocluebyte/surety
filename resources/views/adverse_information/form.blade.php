<div class="card card-custom gutter-b">
    <div class="card-body">
        <form class="form">
            <div class="row g-3">
                <div class="col-md-8"></div>
                <div class=" form-group col-4 mb-5">
                    <label class=" col-form-label text-right">{{ __('adverse_information.ain') }} <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-12">
                        @if ($adverse_information)
                            {!! Form::text('code', $adverse_information->code ?? null, [
                                'class' => 'form-control form-control-solid required',
                                'readonly' => '',
                            ]) !!}
                        @else
                            {!! Form::text('code', $seriesNumber, ['class' => 'form-control form-control-solid required', 'readonly' => '']) !!}
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group w-50">
                {!! Form::hidden('id', $adverse_information->id ?? null) !!}
                {!! Form::label(__('adverse_information.contractor_id'), __('adverse_information.contractor')) !!}<i class="text-danger">*</i>
                {!! Form::select('contractor_id', ['' => ''] + $contractors, null, [
                    'class' => 'form-control contractor required',
                    'style' => 'width: 100%;',
                    'data-placeholder' => 'Select Contractor',
            ]) !!}
            </div>

            <div class="row">
                <div class="form-group col-6">
                    {!! Form::label('source_of_adverse_information', __('adverse_information.source_of_adverse_information')) !!}<i class="text-danger">*</i>
                    {!! Form::select('source_of_adverse_information', ['' => ''] + $sources, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Source',
                    ]) !!}
                </div>

                <div class="form-group col-6">
                    {!! Form::label('source_date', __('adverse_information.source_date')) !!}<i class="text-danger">*</i>
                    {!! Form::date('source_date', null, ['class' => 'form-control required', 'min' => '1000-01-01', 'max' => '9999-12-31']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('adverse_information', __('adverse_information.adverse_information')) !!}<i class="text-danger">*</i>
                {!! Form::textArea('adverse_information', null, [
                    'class' => 'form-control',
                    'id' => 'adverse_information',
                ]) !!}
                {{-- <label id="adverse_information-error" class="text-danger" for="adverse_information-error"></label> --}}
            </div>

            <div class="form-group jsDivClass">
                <div class="d-block">
                    {!! Form::label('adverse_information_attachment', __('adverse_information.attachment')) !!}<i class="text-danger">*</i>
                </div>

                <div class="d-block">
                    {!! Form::file('adverse_information_attachment[]', [
                        'id' => 'adverse_information_attachment',
                        'multiple',
                        'class' => 'adverse_information_attachment jsDocument',
                        empty($adverse_information->dMS) ? 'required' : '',
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ]) !!}
                    @php
                        $data_adverse_information_attachment = isset($adverse_information->dMS)
                            ? count($adverse_information->dMS)
                            : 0;

                        $dsbtcls = $data_adverse_information_attachment == 0 ? 'disabled' : '';
                    @endphp
                    {{-- <a href="{{ route('dMSDocument', $adverse_information->id ?? '') }}" data-toggle="modal"
                        data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => $adverse_information->id ?? '', 'attachment_type' => 'adverse_information_attachment', 'dmsable_type' => 'AdverseInformation']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}"
                        data-prefix="adverse_information_attachment"
                        data-delete="jsAdverseInformationAttachmentDeleted">
                        <span class="navi-icon"><span class="length_adverse_information_attachment"
                                data-adverse_information_attachment ='{{ $data_adverse_information_attachment }}'>{{ $data_adverse_information_attachment }}</span>&nbsp;Document</span>
                    </a> --}}

                    <a href="#" data-toggle="modal" data-target="#adverse_information_attachment_modal"
                    class="call-modal JsAdverseInformationAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsAdverseInformationAttachmentDeleted" data-prefix="adverse_information_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                        <span class = "count_adverse_information_attachment" data-count_adverse_information_attachment = "{{ $data_adverse_information_attachment }}">{{ $data_adverse_information_attachment }}&nbsp;document</span>
                    </a>

                    <div class="modal fade" tabindex="-1" id="adverse_information_attachment_modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Adverse Information Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <a class="jsFileRemove"></a>
                                    @if (isset($adverse_information) && isset($adverse_information->dMS) && count($adverse_information->dMS) > 0)
                                        @foreach ($adverse_information->dMS as $index => $documents)
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="dms_adverse_information_attachment">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="adverse_information_attachment" data-url="{{ route('removeDmsAttachment') }}"
                                                                data-id="{{ $documents->id }}"></i></a>
                                                            <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                            </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @else
                                        {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row card-footer pb-5 pt-5">
                <div class="col-12 text-right">
                    <input class="jsSaveType" name="save_type" type="hidden">
                    <a href="" class="mr-2">{{ __('common.cancel') }}</a>
                    <button type="submit" id="btn_loader_save" class="btn btn-primary jsBtnLoader"
                        name="saveBtn">{{ __('common.save') }}</button>
                    <button type="submit" id="btn_loader" class="btn btn-primary jsBtnLoader"
                        name="saveExitBtn">{{ __('common.save_exit') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div id="load-modal"></div>
</div>

@include('adverse_information.script')
{{-- <script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
