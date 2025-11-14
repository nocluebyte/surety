<div class="card card-custom gutter-b">
    <div class="card-body">
        <form class="form">
            <div class="row g-3">
                <div class="col-md-8"></div>
                <div class=" form-group col-4 mb-5">
                    <label class=" col-form-label text-right">{{ __('blacklist.bln') }} <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-12">
                        @if ($blacklist)
                            {!! Form::text('code', $blacklist->code ?? null, [
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
                {!! Form::hidden('id', $blacklist->id ?? null) !!}
                {!! Form::label(__('blacklist.contractor_id'), __('blacklist.contractor')) !!}<i class="text-danger">*</i>
                {!! Form::select('contractor_id', ['' => ''] + $contractors, null, [
                    'class' => 'form-control required contractor',
                    'style' => 'width: 100%;',
                    'data-placeholder' => 'Select Contractor',
                    isset($blacklist) && $blacklist->count() > 0 ? 'disabled' : '',
                ]) !!}
            </div>

            <div class="row">
                <div class="form-group col-6">
                    {!! Form::label('source', __('blacklist.source')) !!}<i class="text-danger">*</i>
                    {!! Form::select('source', ['' => ''] + $sources ?? [], null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Source',
                    ]) !!}
                </div>

                <div class="form-group col-6">
                    {!! Form::label('blacklist_date', __('common.date')) !!}<i class="text-danger">*</i>
                    {!! Form::date('blacklist_date', null, ['class' => 'form-control required', 'min' => '1000-01-01', 'max' => '9999-12-31']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('reason', __('blacklist.reason')) !!}<i class="text-danger">*</i>
                {!! Form::textArea('reason', null, [
                    'class' => 'form-control',
                    'id' => 'reason',
                ]) !!}
            </div>

            <div class="form-group jsDivClass">
                <div class="d-block">
                    {!! Form::label('blacklist_attachment', __('blacklist.attachment')) !!}<i class="text-danger">*</i>
                </div>
                {{-- @dd($blacklist->dMS) --}}
                <div class="d-block">
                    {!! Form::file('blacklist_attachment[]', [
                        'id' => 'blacklist_attachment',
                        'class' => 'blacklist_attachment jsDocument',
                        empty($blacklist->dMS) ? 'required' : '',
                        'multiple',
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ]) !!}
                    @php
                        $data_blacklist_attachment = isset($blacklist->dMS) ? count($blacklist->dMS) : 0;

                        $dsbtcls = $data_blacklist_attachment == 0 ? 'disabled' : '';
                    @endphp
                    {{-- <a href="{{ route('dMSDocument', $blacklist->id ?? '') }}" data-toggle="modal"
                        data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => $blacklist->id ?? '', 'attachment_type' => 'blacklist_attachment', 'dmsable_type' => 'Blacklist']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}"
                        data-prefix="blacklist_attachment" data-delete="jsBlacklistAttachmentDeleted">
                        <span class = "count_blacklist_attachment" data-count_blacklist_attachment = "{{ $data_blacklist_attachment }}">{{ $data_blacklist_attachment }}&nbsp;document</span>
                    </a> --}}
                    {{-- @dd($data_blacklist_attachment) --}}

                    <a href="#" data-toggle="modal" data-target="#blacklist_attachment_modal"
                    class="call-modal JsBlacklistAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBlacklistAttachmentDeleted" data-prefix="blacklist_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                        <span class = "count_blacklist_attachment" data-count_blacklist_attachment = "{{ $data_blacklist_attachment }}">{{ $data_blacklist_attachment }}&nbsp;document</span>
                    </a>

                    <div class="modal fade" tabindex="-1" id="blacklist_attachment_modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Blacklist Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <a class="jsFileRemove"></a>
                                    @if (isset($blacklist) && isset($blacklist->dMS) && count($blacklist->dMS) > 0)
                                        @foreach ($blacklist->dMS as $index => $documents)
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="dms_blacklist_attachment">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="blacklist_attachment" data-url="{{ route('removeDmsAttachment') }}"
                                                                data-id="{{ $documents->id }}"></i></a>
                                                            <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                            </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endforeach
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

@include('blacklist.script')
{{-- <script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script> --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script> --}}
{{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.1.0/ckeditor5.css"> --}}

