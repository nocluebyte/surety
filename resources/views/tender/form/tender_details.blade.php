<div class="row g-3">
    <div class="col-md-8"></div>
    <div class=" form-group col-4 mb-5">
        <label class=" col-form-label text-right">{{ __('tender.tin') }} <span class="text-danger">*</span></label>
        <div class="col-lg-12">
            @if ($tender)
                {!! Form::text('code', $tender->code ?? null, [
                    'class' => 'form-control form-control-solid required',
                    'readonly' => '',
                ]) !!}
            @else
                {!! Form::text('code', $seriesNumber, ['class' => 'form-control form-control-solid required', 'readonly' => '']) !!}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('project_details_id', __('tender.project_details')) !!}<i class="text-danger">*</i>
        {!! Form::select('project_details_id', ['' => ''] + $project_details, $tender->project_details ?? null, [
            'class' => 'project_details_id form-control jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'data-placeholder' => 'Select Project Details',
            'data-ajaxurl' => route('getProjectDetailsData'),
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('tender_id', __('tender.tender_id')) !!}<i class="text-danger">*</i>
        {{ Form::text('tender_id', null, [
            'class' => 'form-control required',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'tender_id',
                'model' => 'tenders',
                'id' => $tender->id ?? '',
            ]),
            'data-msg-remote' => 'Tender ID has already been taken.',
            'data-rule-AlphabetsAndNumbersV5' => true,
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('tender_header', __('tender.tender_header')) !!}<i class="text-danger">*</i>
        {!! Form::text('tender_header', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV8' => true]) !!}
    </div>

    {{-- <div class="col-6 form-group">
                {!! Form::label('tender_reference_no', __('tender.tender_reference_no')) !!}<i class="text-danger">*</i>
                {!! Form::text('tender_reference_no', null, [
                    'class' => 'form-control required',
                    'data-rule-remote' => route('common.checkUniqueField', [
                        'field' => 'tender_reference_no',
                        'model' => 'tenders',
                        'id' => $tender->id ?? '',
                    ]),
                    'data-msg-remote' => 'Tender Reference No. has already been taken.',
                    'data-rule-AlphabetsAndNumbersV5' => true,
                ]) !!}
            </div> --}}
    {{-- <div class="col-4 form-group">
                {!! Form::label(__('common.phone_no'), __('common.phone_no')) !!}<i class="text-danger">*</i>
                {{ Form::text('phone_no', null, ['class' => 'form-control number required', 'data-rule-MobileNo' => true, 'maxLength' => 10]) }}
            </div> --}}
</div>

{{-- <div class="row">
            <div class="col-4 form-group">
                {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
                {!! Form::text('first_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
                {!! Form::text('middle_name', null, ['class' => 'form-control', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
                {!! Form::text('last_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-6 form-group">
                {!! Form::label(__('common.address'), __('common.address')) !!}<i class="text-danger">*</i>
                {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) }}
            </div>

            <div class="col-6 form-group">
                {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

                {{ Form::text('email', null, [
                    'class' => 'form-control email',
                    'required',
                    'data-rule-remote' => route('common.checkUniqueField', [
                        'field' => 'email',
                        'model' => 'tenders',
                        'id' => $tender->id ?? '',
                    ]),
                    'data-msg-remote' => 'The email has already been taken.',
                ]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
                {!! Form::select('country_id', ['' => ''] + $countries, null, [
                    'class' => 'form-control required',
                    'style' => 'width: 100%;',
                    'id' => 'country',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
                {!! Form::select('state_id', ['' => ''] + $states, null, [
                    'class' => 'form-control required',
                    'style' => 'width: 100%;',
                    'id' => 'state',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
                {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) }}
            </div>
        </div> --}}

{{-- <div class="row">
                <div class="col-6 form-group panNoField {{ $isCountryIndia ? '' : 'd-none' }}">
                {!! Form::label(__('common.pan_no'), __('common.pan_no')) !!}<i class="text-danger">*</i>

                {{ Form::text('pan_no', null, [
                    'class' => 'form-control pan_no required',
                    'data-rule-remote' => route('common.checkUniquePanNumber', [
                        'field' => 'tenders',
                        'id' => $tender->id ?? '',
                    ]),
                    'data-msg-remote' => 'PAN No. has already been taken.',
                    'data-rule-PanNo' => true,
                ]) }}
            </div> 
        </div> --}}

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('tender_description', __('tender.tender_description')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('tender_description', null, ['class' => 'form-control required', 'rows' => 2]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('location', __('tender.location')) !!}<i class="text-danger">*</i>
        {{ Form::text('location', null, ['class' => 'form-control location required', 'data-rule-AlphabetsV1' => true]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('project_type', __('tender.project_type')) !!}
        {!! Form::select('project_type', ['' => ''] + $project_type, null, [
            'class' => 'form-control jsSelect2ClearAllow',
            'style' => 'width:100%;',
            'id' => 'project_type',
            'data-placeholder' => 'Select Project Type',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('beneficiary_id', __('tender.beneficiary')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_id', ['' => ''] + $beneficiary_id, null, [
            'class' => 'form-control required jsSelect2ClearAllow',
            'style' => 'width:100%;',
            'id' => 'beneficiary_id',
            'disabled',
            'data-placeholder' => 'Select Beneficiary',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('contract_value', __('tender.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {{ Form::text('contract_value', null, ['class' => 'form-control contract_value required number', 'data-rule-Numbers' => true]) }}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('period_of_contract', __('tender.period_of_contract')) !!}<i class="text-danger">*</i>
        {{ Form::number('period_of_contract', null, ['class' => 'period_of_contract form-control required', 'data-rule-Numbers' => true]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('tender.bond_value'), __('tender.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {{ Form::text('bond_value', null, ['class' => 'bond_value form-control required number', 'data-rule-Numbers' => true]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('tender.bond_type_id'), __('tender.bond_type')) !!}<i class="text-danger">*</i>
        {!! Form::select('bond_type_id', ['' => ''] + $bond_type_id, null, [
            'class' => 'form-control required jsSelect2ClearAllow',
            'style' => 'width:100%;',
            'id' => 'bond_type_id',
            'data-placeholder' => 'Select Bond Type',
        ]) !!}
    </div>
</div>

{{-- <div class="row">
            <div class="col-4 form-group">
                {{ Form::label(__('tender.bond_start_date'), __('tender.bond_start_date')) }}<i
                    class="text-danger">*</i>
                {!! Form::date('bond_start_date', null, [
                    'class' => 'bond_start_date form-control required bond_date',
                    'min' => '1000-01-01',
                    'max' => '9999-12-31',
                    'id' => 'bond_start_date',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {{ Form::label(__('tender.bond_end_date'), __('tender.bond_end_date')) }}<i
                    class="text-danger">*</i>
                {!! Form::date('bond_end_date', null, [
                    'class' => 'bond_end_date form-control required bond_date',
                    'min' => '1000-01-01',
                    'max' => '9999-12-31',
                    'id' => 'bond_end_date',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label(__('tender.period_of_bond'), __('tender.period_of_bond')) !!}<i class="text-danger">*</i>
                {{ Form::text('period_of_bond', null, ['class' => 'form-control form-control-solid required', 'id' => 'period_of_bond', 'readonly']) }}
            </div>
        </div> --}}

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('type_of_contracting', __('tender.type_of_contracting')) !!}<i class="text-danger">*</i>
        {!! Form::select('type_of_contracting', ['' => ''] + $type_of_contracting, null, [
            'class' => 'type_of_contracting form-control jsSelect2ClearAllow',
            'style' => 'width: 100%;',
            'required',
            'data-placeholder' => 'Select Type of Contracting',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {{ Form::label('rfp_date', __('tender.rfp_date')) }}<i class="text-danger">*</i>
        {!! Form::date('rfp_date', null, [
            'class' => 'form-control required rfp_date',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
        ]) !!}
    </div>
    {{-- @dd($dms_data) --}}
    <div class="col-4 form-group jsDivClass">
        {!! Form::label('rfp_attachment', __('tender.rfp_attachment')) !!}<i class="text-danger">*</i>
        {!! Form::file('rfp_attachment[]', [
            'class' => 'rfp_attachment jsDocument',
            'id' => 'rfp_attachment',
            empty($dms_data) ? 'required' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}
        @php
            $data_rfp_attachment = isset($dms_data) ? count($dms_data) : 0;

            $dsbtcls = $data_rfp_attachment == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $tender->id ?? '') }}" data-toggle="modal" data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $tender->id ?? '', 'attachment_type' => 'rfp_attachment', 'dmsable_type' => 'Tender']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="rfp_attachment"
            data-delete="jsRfpAttachmentDeleted">
            <span class="navi-icon"><span class="length_rfp_attachment"
                    data-rfp_attachment ='{{ $data_rfp_attachment }}'>{{ $data_rfp_attachment }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#rfp_attachment_modal"
        class="call-modal JsRfpAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsRfpAttachmentDeleted" data-prefix="rfp_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_rfp_attachment" data-count_rfp_attachment = "{{ $data_rfp_attachment }}">{{ $data_rfp_attachment }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="rfp_attachment_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">RFP Attachment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($tender) && isset($dms_data) && count($dms_data) > 0)
                            @foreach ($dms_data as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_rfp_attachment">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="rfp_attachment" data-url="{{ route('removeDmsAttachment') }}"
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
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('project_description', __('tender.project_description_label')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('project_description', null, ['class' => 'project_description form-control required', 'rows' => 2]) }}
    </div>
</div>

<div id="load-modal"></div>
