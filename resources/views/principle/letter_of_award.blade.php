<div class="row">
    <div class="col-lg-12">
        <div class="float-right">
            @if($current_user->hasAnyAccess('users.superadmin', 'principle.add_letter_of_award'))
                <button class="btn btn-primary JsAddItem" type="button" data-addContractorId={{ encryptId($principle->id) }} data-toggle="modal" data-original-title="test"
                    data-target="#loaModal">Add</button>
            @endif
        </div>
    </div>

    <div class="col-lg-12 overflow-auto" style="height: 370px;">
        <table class="table table-responsive table-separate table-head-custom table-checkable">
            <thead>
                <tr>
                    <th>{{ __('common.no') }}</th>
                    <th class="min-width-300">{{ __('letter_of_award.beneficiary') }}</th>
                    <th class="min-width-300">{{ __('letter_of_award.project_details') }}</th>
                    <th class="min-width-150">{{ __('letter_of_award.tender_id') }}</th>
                    <th class="min-width-300">{{ __('letter_of_award.tender_header') }}</th>
                    <th class="min-width-200">{{ __('letter_of_award.ref_no_loa') }}</th>
                    <th class="min-width-100">{{ __('letter_of_award.loa_attachment') }}</th>
                    <th class="min-width-100">{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($letterOfAward as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->getBeneficiary->company_name ?? '' }}</td>
                        <td>{{ $item->getProjectDetails->project_name ?? '' }}</td>
                        <td>{{ $item->getTender->code ?? '' }}</td>
                        <td>{{ $item->getTender->tender_header ?? '' }}</td>
                        <td>{{ $item->ref_no_loa ?? '' }}</td>
                        <td><a href="#" data-toggle="modal" data-target="#loaDocuments{{ $item->id }}"
                                class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>

                            <div class="modal fade" tabindex="-1" id="loaDocuments{{ $item->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">LOA Documents</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                                @foreach ($item->dMS as $documents)
                                                    <div class="mb-3">
                                                        <a href="{{ isset($documents->attachment) && !empty($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : asset('/default.jpg') }}"
                                                            target="_blanck" download>
                                                            {!! getdmsFileIcon(e($documents->file_name)) !!}
                                                        </a>
                                                        {{ $documents->file_name }}
                                                    </div>
                                                @endforeach
                                                {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                                        target="_blanck">
                                                                                        {{ $dms_data->file_name }}
                                                                                    </a> --}}
                                            @else
                                                <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($current_user->hasAnyAccess('users.superadmin', 'principle.edit_letter_of_award'))
                                <a href="" data-target="#dmAmendmentModal{{ $item->id }}" data-toggle="modal"><i
                                        class="fas fa-edit cursor-pointer btn-sm JsItem" data-contractorId={{ encryptId($principle->id) }} data-itemId={{ encryptId($item->id) }} data-beneficiaryId={{ encryptId($item->beneficiary_id) }} data-projectDetailsId={{ encryptId($item->project_details_id) }} data-tenderId={{ encryptId($item->tender_id) }} title="Edit"></i>
                                </a>
                            @else
                                -
                            @endif
                            <div class="modal fade bd-example-modal-lg" id="dmAmendmentModal{{ $item->id }}" data-backdrop="static" aria-labelledby="staticBackdrop" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        {!! Form::model($item, [
                                            'route' => ['letter-of-award.update', encryptId($item->id)],
                                            'enctype' => 'multipart/form-data',
                                            'id' => 'loaEditTabForm',
                                        ]) !!}
                                        @method('PUT')
                                        {!! Form::hidden('contractor_id', $principle->id ?? null) !!}
                                        {{-- {!! Form::hidden('item_id', $item->id, ['class' => 'JsletterOfAwardItem']) !!} --}}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="loaModalLabel">
                                                {{ !isset($letterOfAward) ? __('letter_of_award.add_letter_of_award') : __('letter_of_award.edit_letter_of_award') }}
                                            </h5>
                                            {!! Form::button('<i aria-hidden="true" class="ki ki-close"></i>', [
                                                'class' => 'close',
                                                'data-dismiss' => 'modal',
                                                'aria-label' => 'Close',
                                            ]) !!}
                                        </div>
                                        {{-- @dd($item->contractor_id) --}}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                {!! Form::label('beneficiary_id', __('letter_of_award.beneficiary')) !!}<span class="text-danger">*</span>
                                                {!! Form::select(
                                                    'beneficiary_id',
                                                    ['' => ''] + $beneficiaries,
                                                    $item->beneficiary_id,
                                                    [
                                                    'class' => 'form-control beneficiary_id jsSelect2ClearAllow',
                                                    'data-placeholder' => 'Select Beneficiary',
                                                    'required' => true,
                                                    'id' => 'beneficiary' . $item->id,
                                                ],
                                                ) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('project_details_id', __('letter_of_award.project_details')) !!}<span class="text-danger">*</span>
                                                {!! Form::select(
                                                    'project_details_id',
                                                    ['' => ''] + $project_details,
                                                    $item->project_details_id,
                                                    [
                                                    'class' => 'form-control project_details_id jsSelect2ClearAllow',
                                                    'data-placeholder' => 'Select Project Details',
                                                    'required' => true,
                                                    'id' => 'project_details' . $item->id,
                                                ],
                                                ) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('tender_id', __('letter_of_award.tender')) !!}<span class="text-danger">*</span>
                                                {!! Form::select(
                                                    'tender_id',
                                                    ['' => ''] + $tenders,
                                                    $item->tender_id,
                                                    [
                                                    'class' => 'form-control tender_id jsSelect2ClearAllow',
                                                    'data-placeholder' => 'Select Tender',
                                                    'required' => true,
                                                    'id' => 'tender' . $item->id,
                                                ],
                                                ) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('ref_no_loa', __('letter_of_award.ref_no_loa')) !!}<span class="text-danger">*</span>
                                                {!! Form::text('ref_no_loa', $item->ref_no_loa ?? null, [
                                                    'class' => 'form-control ref_no_loa',
                                                    'required' => true,
                                                    'data-rule-AlphabetsAndNumbersV3' => true,
                                                ]) !!}
                                            </div>
                                            <div class="form-group">
                                                <div class="d-block">
                                                    {!! Form::label('loa_attachment', __('letter_of_award.loa_attachment')) !!}<span class="text-danger">*</span>
                                                </div>
        
                                                <div class="d-block jsDivClass">
                                                    {!! Form::file('loa_attachment[]', [
                                                        'class' => 'loa_attachment jsDocument',
                                                        empty($item->dMS) ? 'required' : '',
                                                        'id' => 'loa_attachment',
                                                        'multiple',
                                                        'maxfiles' => 5,
                                                        'maxsizetotal' => '52428800',
                                                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                                                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                                                    ]) !!}
        
                                                    @php
                                                        $data_loa_attachment = isset($item->dMS) ? count($item->dMS) : 0;
                                                        $dsbtcls = $data_loa_attachment == 0 ? 'disabled' : '';
                                                    @endphp
                                                    {{-- <a href="{{ route('dMSDocument', $item->id ?? '') }}" data-toggle="modal"
                                                        data-target-modal="#commonModalID"
                                                        data-url="{{ route('dMSDocument', ['id' => $item->id ?? '', 'attachment_type' => 'loa_attachment', 'dmsable_type' => 'LetterOfAward']) }}"
                                                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}"
                                                        data-prefix="loa_attachment" data-delete="jsLoaAttachmentDeleted">
                                                        <span class="navi-icon"><span class="length_loa_attachment"
                                                                data-loa_attachment ='{{ $data_loa_attachment }}'>{{ $data_loa_attachment }}</span>&nbsp;Document</span>
                                                    </a> --}}

                                                    <a href="#" data-toggle="modal" data-target="#loa_attachment_modal_{{ $item->id }}"
                                                    class="call-modal JsLoaAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsLoaAttachmentDeleted" data-prefix="loa_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                                        <span class = "count_loa_attachment" data-count_loa_attachment = "{{ $data_loa_attachment }}">{{ $data_loa_attachment }}&nbsp;document</span>
                                                    </a>
                                                </div>
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

                            <div class="modal fade" data-backdrop="static" tabindex="-1" aria-labelledby="staticBackdrop" id="loa_attachment_modal_{{ $item->id }}">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">LOA Attachment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <a class="jsFileRemove"></a>
                                            @if (isset($item) && isset($item->dMS) && count($item->dMS) > 0)
                                                @foreach ($item->dMS as $index => $documents)
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <span class="dms_loa_attachment">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="loa_attachment" data-url="{{ route('removeDmsAttachment') }}"
                                                                        data-id="{{ $documents->id }}"></i></a>
                                                                    <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No data available in table</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="loaModal" data-backdrop="static" aria-labelledby="staticBackdrop" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                'route' => 'letter-of-award.store',
                'id' => 'loaTabForm',
                'enctype' => 'multipart/form-data',
                'method' => 'POST',
            ]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="loaModalLabel">
                    {{ __('letter_of_award.add_letter_of_award') }}
                </h5>
                {!! Form::button('<i aria-hidden="true" class="ki ki-close"></i>', [
                    'class' => 'close',
                    'data-dismiss' => 'modal',
                    'aria-label' => 'Close',
                ]) !!}
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::hidden('contractor_id', $principle->id ?? null) !!}
                    {!! Form::label('beneficiary_id', __('letter_of_award.beneficiary')) !!}<span class="text-danger">*</span>
                    {!! Form::select('beneficiary_id', ['' => ''] + $beneficiaries, null, [
                        'class' => 'form-control beneficiary_id jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Beneficiary',
                        'id' => 'beneficiary_id',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('project_details_id', __('letter_of_award.project_details')) !!}<span class="text-danger">*</span>
                    {!! Form::select('project_details_id', ['' => ''] + $project_details, null, [
                        'class' => 'form-control project_details_id jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Project Details',
                        'id' => 'project_details_id',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('tender_id', __('letter_of_award.tender')) !!}<span class="text-danger">*</span>
                    {!! Form::select('tender_id', ['' => ''] + $tenders, null, [
                        'class' => 'form-control tender_id jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Tender',
                        'id' => 'tender_id',
                        'required' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('ref_no_loa', __('letter_of_award.ref_no_loa')) !!}<span class="text-danger">*</span>
                    {!! Form::text('ref_no_loa', null, [
                        'class' => 'form-control ref_no_loa',
                        'required' => true,
                        'data-rule-AlphabetsAndNumbersV3' => true,
                    ]) !!}
                </div>
                <div class="form-group">
                    <div class="d-block">
                        {!! Form::label('loa_attachment', __('letter_of_award.loa_attachment')) !!}<span class="text-danger">*</span>
                    </div>

                    <div class="d-block jsDivClass">
                        {!! Form::file('loa_attachment[]',
                        [
                            'class' => 'add_loa_attachment jsDocument',
                            'id' => 'add_loa_attachment',
                            // empty($dms_data) ? 'required' : '',
                            'multiple', 'maxfiles' => 5,
                            'maxsizetotal' => '52428800',
                            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                            ]) !!}

                        @php
                            $data_add_loa_attachment = 0;
                            $dsbtcls = $data_add_loa_attachment == 0 ? 'disabled' : '';
                        @endphp

                        <a href="#" data-toggle="modal" data-target="#loa_attachment_modal"
                    class="call-modal JsAddLoaAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsAddLoaAttachmentDeleted" data-prefix="add_loa_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                            <span class = "count_add_loa_attachment" data-count_add_loa_attachment = "{{ $data_add_loa_attachment }}">{{ $data_add_loa_attachment }}&nbsp;document</span>
                        </a>
                    </div>
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
<div class="modal fade" tabindex="-1" id="loa_attachment_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">LOA Attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                </button>
            </div>

            <div class="modal-body">
                <a class="jsFileRemove"></a>
            </div>
        </div>
    </div>
</div>
@include('principle.letter_of_award_script')
