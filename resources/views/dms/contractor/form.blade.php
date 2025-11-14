@extends('app-modal')
@section('modal-title', !isset($dms) ? __('dms.add_dms') : __('dms.edit_dms'))
@section('modal-content')
    {!! Form::hidden('type', $type ?? null) !!}
    @if(isset($type) && $type == 'documents')
        <div class="form-group">
            {!! Form::label('file_name', __('dms.file_name')) !!}<span class="text-danger">*</span>
            {!! Form::text('file_name',$dms->file_name,['class'=>'form-control required']) !!}
        </div>
    @else
        <div class="form-group">
            {!! Form::label('final_submission', __('dms.final_submission')) !!}<span class="text-danger">*</span>
            <div class="radio-inline pt-4">
                <label class="radio radio-rounded">
                    {{ Form::radio('final_submission', 'Yes', '', ['class'=>'form-check-input required', 'id' => 'final_submission_yes']) }}
                    <span></span>{{__("dms.yes")}}
                </label>
                <label class="radio radio-rounded">
                    {{ Form::radio('final_submission', 'No', '', ['class'=>'form-check-input required', 'id' => 'final_submission_no']) }}
                    <span></span>{{__('dms.no')}}
                </label>
            </div>
            <label id="final_submission-error" class="error text-danger" for="final_submission"></label>
        </div>
        <div class="form-group">
            {{ Form::label('dmsamend_id', __('dms.contractor')) }}<span class="text-danger">*</span>
            {!! Form::select('dmsamend_id', ['' => ''] + $contractor, $contractor_id ?? null, [
                'class' => 'form-control jsContractor required',
                'data-placeholder' => 'Select Contractor','disabled'=>($contractor_id) ? true : false
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('document_type', __('dms.document_type')) !!}<span class="text-danger">*</span>
            {!! Form::select('document_type_id', ['' => ''] + $document_type, null, [
                'class' => 'form-control jsDocumentType',
                'data-placeholder' => 'Select Document Type',
                'required' => true,
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('file_source', __('dms.file_source')) !!}<span class="text-danger">*</span>
            {!! Form::select('file_source_id', [''=>''] + $file_source, null, [
                'class' => 'form-control jsFileSource',
                'data-placeholder' => 'Select File Source',
                'required' => true,
            ]) !!}
        </div>
        <div class="form-group">
            @if($dms)
                {!! Form::label('file_name', __('dms.file_name')) !!}<span class="text-danger">*</span>
                {!! Form::text('file_name',$dms->file_name,['class'=>'form-control required']) !!}
            @else
                {!! Form::label('attachment', __('dms.attachments')) !!}<span class="text-danger">*</span>

                {!! Form::file('attachment[]',
                    [
                        'class' => 'dms_attachment jsDocument',
                        'id' => 'dms_attachment',
                        'required' => ($dms && $dms->attachment) ? false : true,
                        'multiple', 'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                    ])
                !!}

                @php
                    $data_dms_attachment = isset($dms_data) ? count($dms_data) : 0;
                    $dsbtcls = $data_dms_attachment == 0 ? 'disabled' : '';
                @endphp

                {{-- <a href="#" data-toggle="modal" data-target="#dms_attachment_modal"
                class="call-modal JsDmsAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsDmsAttachmentDeleted" data-prefix="dms_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp; --}}
                    <span class = "count_dms_attachment" data-count_dms_attachment = "{{ $data_dms_attachment }}">{{ $data_dms_attachment }}&nbsp;document</span>
                {{-- </a> --}}

                {{-- <div class="modal fade" tabindex="-1" id="dms_attachment_modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Dms Attachment</h5>
                            </div>

                            <div class="modal-body">
                                <a class="jsFileRemove"></a>
                                @if (isset($dms) && count($dms) > 0)
                                    @foreach ($dms as $index => $documents)
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="dms_dms_attachment">{!! getdmsFileIcon($documents->file_name) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="dms_attachment" data-url="{{ route('removeDmsAttachment') }}"
                                                            data-id="{{ $documents->id }}"></i></a>
                                                        <a href="{{ asset($documents->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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
                        <div class="text-right">
                            <button type="button" class="btn btn-light-primary font-weight-bold" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div> --}}
            @endif
        </div>
    @endif
@section('modal-btn', !isset($dms) ? __('common.save') : __('common.update'))
@endsection
@include('dms.script')
