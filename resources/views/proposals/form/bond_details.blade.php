<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('bond_type', __('proposals.bond_type')) !!}<i class="text-danger">*</i>
        {!! Form::select('bond_type', ['' => ''] + $bond_type_id, null, [
            'class' => 'form-control required jsSelect2ClearAllow bond_type',
            'style' => 'width:100%;',
            'data-placeholder' => 'Select Bond Type',
            $disabled,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {{ Form::label('bond_start_date', __('proposals.bond_start_date')) }}<i class="text-danger">*</i>
        {!! Form::date('bond_start_date', null, [
            'class' => 'form-control required bond_start_date jsChangeDate',
            'id' => 'bond_start_date',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {{ Form::label('bond_end_date', __('proposals.bond_end_date')) }}<i class="text-danger">*</i>
        {!! Form::date('bond_end_date', null, [
            'class' => 'form-control required bond_end_date jsChangeDate',
            'max' => '9999-12-31',
            'id' => 'bond_end_date',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('bond_period', __('proposals.bond_period')) !!}<i class="text-danger">*</i>
        {!! Form::number('bond_period', null, ['class' => 'form-control form-control-solid required jsBondPeriod', 'data-rule-Numbers' => true, 'readonly']) !!}
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        {!! Form::label('project_value', __('proposals.project_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {!! Form::text('project_value', null, [
            'class' => 'form-control number pd_project_value required ' . $readonly_cls,
            'data-rule-Numbers' => true,
            $readonly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('contract_value', __('tender.contract_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {{ Form::text('contract_value', null, ['class' => 'form-control contract_value required number contract_value_second', 'data-rule-Numbers' => true]) }}
    </div>

    <div class="col-lg-6 form-group">
        {!! Form::label('bond_value', __('proposals.bond_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
        {!! Form::text('bond_value', null, ['class' => 'form-control tender_bond_value required bond_value_second', 'data-rule-Numbers' => true]) !!}
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        {!! Form::label('bond_triggers', __('proposals.bond_triggers')) !!}<i class="text-danger">*</i>
        {!! Form::text('bond_triggers', null, [
            'class' => 'form-control required ' . $readonly_cls,
            $readonly,
            // 'data-rule-Numbers' => true,
        ]) !!}
    </div>

    <div class="col-lg-6 form-group">
        {!! Form::label('bid_requirement', __('proposals.bid_requirement')) !!}<i class="text-danger">*</i>
        {!! Form::text('bid_requirement', null, ['class' => 'form-control required ' . $readonly_cls, $readonly,]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('main_obligation', __('proposals.main_obligation')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('main_obligation', null, ['class' => 'form-control required ' . $readonly_cls, 'rows' => 2, 'data-rule-Remarks' => true, $readonly,]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('relevant_conditions', __('proposals.relevant_conditions')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('relevant_conditions', null, ['class' => 'form-control required ' . $readonly_cls, 'rows' => 2, 'data-rule-Remarks' => true, $readonly,]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('bond_period_description', __('proposals.bond_period_description_label')) !!}
        {!! Form::textarea('bond_period_description', null, ['class' => 'form-control ' . $readonly_cls, 'rows' => 2, 'data-rule-Remarks' => true, $readonly]) !!}
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        {!! Form::label('bond_required', __('proposals.bond_required_label')) !!}<i class="text-danger">*</i>
        {!! Form::text('bond_required', null, ['class' => 'form-control required ' . $readonly_cls, 'data-rule-Remarks' => true, $readonly,]) !!}
    </div>

    <div class="col-lg-6 form-group jsDivClass">
        <div class="d-block">
            {!! Form::label('bond_wording_file', __('proposals.attach_copy_label')) !!}<i class="text-danger">*</i>
        </div>

        <div class="d-block">
            {!! Form::file('bond_wording_file[]', [
                'class' => 'bond_wording_file form-control jsDocument',
                'id' => 'bond_wording_file',
                empty($dms_data['bond_wording_file']) ? 'required' : '',
                'multiple', 'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                $disabled,
            ]) !!}
        </div>

        @php
            $data_bond_wording_file = isset($dms_data) && isset($dms_data['bond_wording_file']) ? count($dms_data['bond_wording_file']) : 0;

            $dsbtcls = $data_bond_wording_file == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'bond_wording_file', 'dmsable_type' => 'Proposal']) }}"
            class="call-modal JsBondWordingFile navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="bond_wording_file"
            data-delete="jsBondWordingFileDeleted">
            <span class="navi-icon"><span class="length_bond_wording_file"
                    data-bond_wording_file ='{{ $data_bond_wording_file }}'>{{ $data_bond_wording_file }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#bond_wording_file_modal"
            class="call-modal JsBondWordingFileAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBondWordingFileAttachmentDeleted" data-prefix="bond_wording_file"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_bond_wording_file"
                data-bond_wording_file ='{{ $data_bond_wording_file }}'>{{ $data_bond_wording_file }}</span>&nbsp;Document</span> --}}
            <span class = "count_bond_wording_file" data-count_bond_wording_file = "{{ $data_bond_wording_file }}">{{ $data_bond_wording_file }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="bond_wording_file_modal">
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
                        @if (isset($dms_data) && isset($dms_data['bond_wording_file']) && count($dms_data['bond_wording_file']) > 0)
                            @foreach ($dms_data['bond_wording_file'] as $documents)
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
                                                    <i class="delete_group flaticon2-cross small dms_attachment_remove" data-prefix="bond_wording_file"
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
    </div>
</div>

<div class="form-group">
    {!! Form::label('bond_wording', __('proposals.bond_wording')) !!}<i class="text-danger">*</i>
    {!! Form::textarea('bond_wording', null, ['class' => 'form-control required ' . $readonly_cls, 'rows' => 2, 'data-rule-Remarks' => true, $readonly,]) !!}
</div>

<div class="form-group">
    {!! Form::label('bond_collateral', __('proposals.collateral_label')) !!}
    {!! Form::textarea('bond_collateral', null, ['class' => 'form-control ' . $readonly_cls, 'rows' => 2, 'data-rule-Remarks' => true, $readonly,]) !!}
</div>

<div class="form-group">
    {!! Form::label('distribution', __('proposals.joint_venture_description')) !!}
    {!! Form::textarea('distribution', null, [
        'class' => 'form-control jointVentureData_textarea ' . $readonly_cls,
        'rows' => 2,
        'data-rule-Remarks' => true,
        $readonly,
    ]) !!}
</div>