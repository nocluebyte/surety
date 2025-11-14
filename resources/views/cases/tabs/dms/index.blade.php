<div class="row">
    <div class="col-lg-12">
        <div class="float-right">
            @if ($current_user->id === $case->underwriterUserId)
                <button class="btn btn-primary" type="button" data-toggle="modal" data-original-title="test"
                data-target="#dmsModal">Add Document</button>
            @endif   
        </div>
    </div>

    <div class="col-lg-12 overflow-auto" style="height: 170px;">
        <table class="table table-separate table-head-custom table-checkable">
            <thead>
                <tr>
                    <th>{{ __('common.no') }}</th>
                    <th>{{ __('dms.document_specific_type') }}</th>
                    <th>{{ __('cases.document_type') }}</th>
                    <th>{{ __('cases.by') }}</th>
                    <th>{{ __('cases.file_source') }}</th>
                    <th>{{ __('cases.download') }}</th>
                    <th>{{ __('cases.final_submission') }}</th>
                    <th>{{ __('cases.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dms_attachments as $dms_key => $dms_attachment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dms_attachment->document_specific_type ?? '' }}</td>
                        <td>{{ $dms_attachment->documentType->name ?? '' }}</td>
                        <td>{{ $dms_attachment->createdBy->full_name ?? '' }}</td>
                        <td>{{ $dms_attachment->fileSource->name ?? '' }}</td>
                        <td><a data-toggle="modal" data-target-modal="#commonModalID"
                                data-url="{{ route('cases.dmsattachmentdownload', $dms_attachment->id) }}"
                                class="btn call-modal  font-weight-bold px-2 px-lg-5 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path
                                            d="M14,16 L12,16 L12,12.5 C12,11.6715729 11.3284271,11 10.5,11 C9.67157288,11 9,11.6715729 9,12.5 L9,17.5 C9,19.4329966 10.5670034,21 12.5,21 C14.4329966,21 16,19.4329966 16,17.5 L16,7.5 C16,5.56700338 14.4329966,4 12.5,4 L12,4 C10.3431458,4 9,5.34314575 9,7 L7,7 C7,4.23857625 9.23857625,2 12,2 L12.5,2 C15.5375661,2 18,4.46243388 18,7.5 L18,17.5 C18,20.5375661 15.5375661,23 12.5,23 C9.46243388,23 7,20.5375661 7,17.5 L7,12.5 C7,10.5670034 8.56700338,9 10.5,9 C12.4329966,9 14,10.5670034 14,12.5 L14,16 Z"
                                            fill="#000000" fill-rule="nonzero"
                                            transform="translate(12.500000, 12.500000) rotate(-315.000000) translate(-12.500000, -12.500000) ">
                                        </path>
                                    </g>
                                </svg>
                            </a></td>
                        <td>{{ $dms_attachment->final_submission ?? 'No' }}</td>
                        <td>
                            <div class="dropdown dropdown-inline text-center" title="" data-placement="left"
                                data-original-title="Quick actions">
                                <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="ki ki-bold-more-hor"></i>
                                </a>
                                <div class="dropdown-menu m-0 dropdown-menu-right position-absolute will-change-transform top-0 left-0"
                                    x-placement="top-end" style="transform: translate3d(-101px, -157px, 0px);">
                                    <ul class="navi navi-hover ">
                                        <li class="navi-item">
                                            <a type="button" data-toggle="modal" data-original-title="test"
                                                data-target="#dmAmendmentModal{{ $dms_attachment->id }}"
                                                class="call-modal navi-link">
                                                <span class="navi-icon"><i class="fas fa-edit"></i></span>
                                                <span class="navi-text">{{ __('cases.amendment') }}</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" data-toggle="modal" data-target-modal="#commonModalID"
                                                data-url="{{ route('cases.dmsAttachmentcomment.get', $dms_attachment->id) }}"
                                                class="call-modal navi-link">

                                                <span class="navi-icon"><i class="fas fa-edit"></i></span><span
                                                    class="navi-text">Comment</span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" data-toggle="modal" data-target-modal="#dms_attachment_modal"
                                                data-url="{{ route('cases.dmsAttachmentCommentLog', $dms_attachment->id) }}"
                                                class="call-modal navi-link">
                                                <span class="navi-icon"><i class="fa fa-eye"></i></span>&nbsp;<span
                                                    class="navi-text">View Comment</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade bd-example-modal-lg" id="dmAmendmentModal{{ $dms_attachment->id }}"
                        tabindex="-1" role="dialog" aria-labelledby="dmAmendmentModal{{ $dms_attachment->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {!! Form::model($dms_attachment, [
                                    'route' => ['dms-update', $dms_attachment->id],
                                    'id' => 'amendmentForm_' . $dms_attachment->id,
                                ]) !!}
                                @method('PUT')
                                <input type="hidden" name="cases_id" value="{{ $case->id ?? '' }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('dms.amendment') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        {!! Form::label('final_submission', __('cases.final_submission')) !!}<span class="text-danger">*</span>
                                        <div class="radio-inline pt-4">
                                            <label class="radio radio-rounded">
                                                {{ Form::radio('final_submission', 'Yes', $dms_attachment->final_submission == 'Yes' ? true : '', ['class' => 'form-check-input required', 'id' => 'final_submission_yes']) }}
                                                <span></span>{{ __('cases.yes') }}
                                            </label>
                                            <label class="radio radio-rounded">
                                                {{ Form::radio('final_submission', 'No', $dms_attachment->final_submission == 'No' ? true : '', ['class' => 'form-check-input required', 'id' => 'final_submission_no']) }}
                                                <span></span>{{ __('cases.no') }}
                                            </label>
                                        </div>
                                        <label id="final_submission-error" class="error text-danger"
                                            for="final_submission"></label>
                                    </div>
                                    {{-- <div class="form-group">
                                        {{ Form::label('dmsamend_id', __('dms.contractor')) }}
                                        {!! Form::select('dmsamend_id', ['' => 'Select'] + $contractors, $dms_attachment->dmsamend_id ?? '', [
                                            'class' => 'form-control jsContractor jsSelect2ClearAllow',
                                            'data-placeholder' => 'Select Contractor',
                                            'id' => 'dmsamend_id' . $dms_key,
                                        ]) !!}
                                    </div> --}}
                                    <div class="form-group">
                                        {{ Form::label('document_type_id', __('cases.document_type')) }}
                                        {{ Form::select('document_type_id', ['' => 'Select'] + $document_type, $dms_attachment->document_type_id ?? '', ['class' => 'form-select jsSelect2ClearAllow required', 'data-placeholder' => 'Select Document Type', 'id' => 'document_type_amend' . $dms_key]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('file_source_id', __('cases.file_source')) }}
                                        {{ Form::select('file_source_id', ['' => 'Select'] + $file_source, $dms_attachment->file_source_id ?? '', ['class' => 'form-select jsSelect2ClearAllow required', 'data-placeholder' => 'Select File Source', 'id' => 'file_source_amend' . $dms_key]) }}

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary jsBtnLoader" type="button"
                                        data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary jsBtnLoader"
                                        type="submit">{{ __('common.save') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No data available in table</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="dmsModal" tabindex="-1" role="dialog" aria-labelledby="dmsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'cases.dmsattachment',
                'id' => 'dmsTabForm',
                'enctype' => 'multipart/form-data',
                'method' => 'POST',
            ]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="dmsModalLabel">ADD Document</h5>
                {!! Form::button('<i aria-hidden="true" class="ki ki-close"></i>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                {!! Form::hidden('id', $case->id) !!}
                <div class="form-group">
                    {!! Form::label('final_submission', __('cases.final_submission')) !!}<span class="text-danger">*</span>
                    <div class="radio-inline pt-4">
                        <label class="radio radio-rounded">
                            {{ Form::radio('final_submission', 'Yes', '', ['class' => 'form-check-input required', 'id' => 'final_submission_yes']) }}
                            <span></span>{{ __('cases.yes') }}
                        </label>
                        <label class="radio radio-rounded">
                            {{ Form::radio('final_submission', 'No', '', ['class' => 'form-check-input required', 'id' => 'final_submission_no']) }}
                            <span></span>{{ __('cases.no') }}
                        </label>
                    </div>
                    <label id="final_submission-error" class="error text-danger" for="final_submission"></label>
                </div>
                <div class="form-group">
                    {!! Form::label('document_specific_type', __('dms.document_specific_type')) !!}<span class="text-danger">*</span>
                    <div class="radio-inline pt-4">
                        <label class="radio radio-rounded">
                            {{ Form::radio('document_specific_type', 'Contractor', '', ['class'=>'form-check-input required', 'id' => 'document_specific_type_yes']) }}
                            <span></span>{{__("dms.contractor")}}
                        </label>
                        <label class="radio radio-rounded">
                            {{ Form::radio('document_specific_type', 'Project', '', ['class'=>'form-check-input required', 'id' => 'document_specific_type_no']) }}
                            <span></span>{{__('dms.project')}}
                        </label>
                    </div>
                    <label id="document_specific_type-error" class="error text-danger" for="document_specific_type"></label>
                </div>
                <div class="form-group">
                    {!! Form::label('document_type', __('cases.document_type')) !!}<span class="text-danger">*</span>
                    {!! Form::select('document_type_id', ['' => ''] + $document_type, null, [
                        'class' => 'form-control document_type',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('file_source', __('cases.file_source')) !!}<span class="text-danger">*</span>
                    {!! Form::select('file_source_id', ['' => ''] + $file_source, null, [
                        'class' => 'form-control file_source',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('attachment', __('cases.attachment')) !!}<span class="text-danger">*</span>
                    {!! Form::file('attachment[]', [
                        'class' => 'form-control', 
                        'required' => true, 
                        'multiple' => true,
                        'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('Close', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                {!! Form::submit('Save', ['class' => 'btn btn-primary jsBtnLoader']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
