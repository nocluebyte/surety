<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('tender_details_id', __('tender.tender')) !!}<i class="text-danger">*</i>
        {!! Form::select('tender_details_id', ['' => ''] + $tender_details, null, [
            'class' => 'form-control required tender_details_id jsSelect2ClearAllow second_tender',
            'style' => 'width:100%;',
            // 'id' => 'tender_details_id',
            'data-placeholder' => 'Select Tender',
            'data-ajaxurl' => route('getTenderData'),
            $disabled,
            // $typeStandAlone,
        ]) !!}
    </div>

    <div class="col-6 form-group text-right">
        <a type="button" href="{{ route('tender.create') }}" class="btn btn-outline-primary btn-sm mt-7" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('tender_id', __('tender.tender_id')) !!}<i class="text-danger">*</i>
        {{ Form::text('tender_id', null, [
            'class' => 'form-control tender_id required ' . $readonly_cls,
            // 'data-rule-remote' => route('common.checkUniqueField', [
            //     'field' => 'tender_id',
            //     'model' => 'tenders',
            //     'id' => $tender->id ?? '',
            // ]),
            // 'data-msg-remote' => 'Tender ID has already been taken.',
            'data-rule-AlphabetsAndNumbersV5' => true,
            $readonly,
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('tender_header', __('tender.tender_header')) !!}<i class="text-danger">*</i>
        {!! Form::text('tender_header', null, ['class' => 'form-control required tender_header ' . $readonly_cls, 'data-rule-AlphabetsAndNumbersV8' => true, $readonly,]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('tender_description', __('tender.tender_description')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('tender_description', null, ['class' => 'form-control required tender_description ' . $readonly_cls, 'rows' => 2, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('location', __('tender.location')) !!}<i class="text-danger">*</i>
        {{ Form::text('location', null, ['class' => 'form-control location required ' . $readonly_cls, 'data-rule-AlphabetsV1' => true, $readonly,]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('project_type', __('tender.project_type')) !!}
        {!! Form::select('project_type', ['' => ''] + $project_type, null, [
            'class' => 'form-control jsSelect2ClearAllow project_type',
            'style' => 'width:100%;',
            'id' => 'project_type',
            'data-placeholder' => 'Select Project Type',
            $disabled,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('tender_beneficiary_id', __('tender.beneficiary')) !!}<i class="text-danger">*</i>
        {!! Form::select('tender_beneficiary_id', ['' => ''] + $beneficiaries, null, [
            'class' => 'form-control  jsSelect2ClearAllow tender_beneficiary_id',
            'style' => 'width: 100%;',
            'data-placeholder' => 'Select Beneficiary',
            'disabled',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('tender_contract_value', __('tender.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {{ Form::text('tender_contract_value', null, ['class' => 'form-control contract_value required number contract_value_first', 'data-rule-Numbers' => true]) }}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('period_of_contract', __('tender.period_of_contract')) !!}<i class="text-danger">*</i>
        {{ Form::number('period_of_contract', null, ['class' => 'period_of_contract form-control required ' . $readonly_cls, 'data-rule-Numbers' => true, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('bond_value', __('tender.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {{ Form::text('tender_bond_value', null, ['class' => 'tender_bond_value form-control required number bond_value_third', 'data-rule-Numbers' => true]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('tender.bond_type_id'), __('tender.bond_type')) !!}<i class="text-danger">*</i>
        {!! Form::select('bond_type_id', ['' => ''] + $bond_type_id, null, [
            'class' => 'form-control required jsSelect2ClearAllow bond_type_id',
            'style' => 'width:100%;',
            'id' => 'bond_type_id',
            'data-placeholder' => 'Select Bond Type',
            $disabled,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('type_of_contracting', __('tender.type_of_contracting')) !!}<i class="text-danger">*</i>
        {!! Form::select('type_of_contracting', ['' => ''] + $type_of_contracting, null, [
            'class' => 'type_of_contracting form-control jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'data-placeholder' => 'Select Type of Contracting',
            $disabled,
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {{ Form::label('rfp_date', __('tender.rfp_date')) }}<i class="text-danger">*</i>
        {!! Form::date('rfp_date', null, [
            'class' => 'form-control required rfp_date ' . $readonly_cls,
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            $readonly,
        ]) !!}
    </div>
    {{-- @dd($dms_data) --}}
    <div class="col-4 form-group jsDivClass">
        {!! Form::label('rfp_attachment', __('tender.rfp_attachment')) !!}<i class="text-danger">*</i>
        {!! Form::file('rfp_attachment[]', [
            'class' => 'rfp_attachment jsDocument form-control',
            'id' => 'rfp_attachment',
            empty($dms_data['rfp_attachment']) ? '' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            $disabled,
        ]) !!}
        @php
            $data_rfp_attachment = isset($dms_data) && isset($dms_data['rfp_attachment']) ? count($dms_data['rfp_attachment']) : 0;

            $dsbtcls = $data_rfp_attachment == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal" data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'rfp_attachment', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsRfpAttachment navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="rfp_attachment"
                data-delete="jsRfpAttachmentDeleted">
                {{-- <span class="navi-icon"><span class="length_rfp_attachment"
                        data-rfp_attachment ='{{ $data_rfp_attachment }}'>{{ $data_rfp_attachment }}</span>&nbsp;Document</span> --}}
                <span class = "count_rfp_attachment" data-count_rfp_attachment = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#rfp_attachment_modal"
            class="call-modal JsRfpAttachment jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsRfpAttachmentDeleted" data-prefix="rfp_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_rfp_attachment"
                data-rfp_attachment ='{{ $data_rfp_attachment }}'>{{ $data_rfp_attachment }}</span>&nbsp;Document</span> --}}
                <span class = "count_rfp_attachment" data-count_rfp_attachment = "{{ $data_rfp_attachment }}">{{ $data_rfp_attachment }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="rfp_attachment_modal">
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
                            @if (isset($dms_data) && isset($dms_data['rfp_attachment']) && count($dms_data['rfp_attachment']) > 0)
                                @foreach ($dms_data['rfp_attachment'] as $documents)
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
                            @else
                                {{-- <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}"> --}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('project_description', __('tender.project_description_label')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('project_description', null, ['class' => 'project_description form-control required ' . $readonly_cls, 'rows' => 2, $readonly,]) }}
    </div>
</div>

