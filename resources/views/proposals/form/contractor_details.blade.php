<div class="row g-3">
    <div class="col-md-8"></div>
    <div class="form-group col-4 mb-5">
        <div class="col-lg-12">
            @if ($proposals)
                {!! Form::text('series_number', $proposals->code . '/V' . $proposals->version ?? null, [
                    'class' => 'form-control form-control-solid required',
                    'readonly' => '',
                ]) !!}
            @else
                {!! Form::text('series_number', $seriesNumber, ['class' => 'form-control form-control-solid required', 'readonly' => '']) !!}
            @endif
        </div>
    </div>
</div>
{!! Form::hidden('auto_proposal_id', $proposals->id ?? '', ['class' => 'auto_proposal_id']) !!}

<div class="row">
    {{-- @dd($disabled, $readonly, $readonly_cls) --}}
    <div class="col-4 form-group">
        {!! Form::label('contractor_type', __('proposals.contractor_type')) !!}<i class="text-danger">*</i>
        {!! Form::select('contract_type', ['' => ''] + $contractor_types, null, [
            'class' => 'form-control contractor_type required jsDisabled jsSelect2ClearAllow',
            'data-placeholder' => 'Select Contractor Type',
            'id' => 'contract_type',
            'style' => 'width: 100%;',
            $disabled,
        ]) !!}
    </div>

    {{-- <div class="col-4 form-group tenderDetail {{ isset($proposals) ? $proposals->contract_type == 'Stand Alone' ? 'd-none' : '' : 'd-none' }}">
        {!! Form::label('tender_details_id', __('tender.tender')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_tender_id', ['' => ''] + $tender_details, $proposals->tender_details_id ?? null, [
            'class' => 'form-control required tender_details_id jsSelect2ClearAllow first_tender',
            'style' => 'width:100%;',
            // 'id' => 'tender_details_id',
            'data-placeholder' => 'Select Tender',
            'data-ajaxurl' => route('getTenderData'),
            $disabled,
        ]) !!}
    </div>

    <div class="col-4 form-group tenderDetail {{ isset($proposals) ? $proposals->contract_type == 'Stand Alone' ? 'd-none' : '' : 'd-none' }}">
        {!! Form::label('tender_bond_value', __('tender.bond_value')) !!}<i class="text-danger">*</i>
        {{ Form::text('tender_bond_value', null, ['class' => 'tender_bond_value form-control required number bond_value_first', 'data-rule-Numbers' => true]) }}
    </div> --}}
</div>

<div class="row standaloneCls {{ isset($proposals) && $proposals->contract_type == 'Stand Alone' ? '' : 'd-none' }}">
    <div class="col-7 form-group">
        {{-- {!! Form::label('full_name_contractor', __('proposals.full_name_contractor')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_id', ['' => ''] + $jv_contractors, null, [
            'class' => 'form-control contractor_id jsDisabled',
            'style' => 'width:100%;',
            'id' => 'contractor_id',
            'data-ajaxurl' => route('getContractorData'),
            'data-placeholder' => 'Select Contractor',
            $disabled,
        ]) !!} --}}
        {!! Form::label('full_name_contractor', __('proposals.full_name_contractor')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_id', ['' => ''] + $stand_alone_contractors, null, [
            'class' => 'form-control contractor_id jsDisabled jsClearContractorType',
            'style' => 'width:100%;',
            'id' => 'contractor_id',
            'data-ajaxurl' => route('getContractorData'),
            'data-placeholder' => 'Select Contractor',
            $disabled,
        ]) !!}
    </div>
    <div class="col-3 form-group">
        {!! Form::label('pan_no', __('common.pan_no')) !!}

        {{ Form::text('pan_no', null, [
            'class' => 'form-control form-control-solid stand_alone_pan_no jsClearContractorType',
            'data-rule-PanNo' => true,
            'readonly',
        ]) }}
    </div>
    <div class="col-2 form-group">
        <a type="button" href="{{ route('principle.create') }}" class="btn btn-outline-primary btn-sm mt-8" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div>
{{-- <div class="row jvCls {{ isset($proposals) && $proposals->contract_type == 'JV' ? '' : 'd-none' }}">
    <div class="col-6 form-group">
        {{ Form::label('contractor', __('proposals.contractor')) }}
        {!! Form::select(
            'jv_contractor',
            ['' => ''] + $jv_contractors,
            null,
            [
                'class' => 'form-control jv_contractor',
                'id' => 'jv_contractor',
                'data-placeholder' => 'Select Contractor',
                'data-ajaxurl' => route('getContractorData'),
                $disabled,
            ],
            $jvConOptions,
        ) !!}
    </div>
    <div class="col-4">
        <label>&nbsp;</label><br>
        <button class="btn btn-primary contAdd" type="button">Add</button>
    </div>
</div> --}}
<div class="row spvCls {{ isset($proposals) && $proposals->contract_type == 'SPV' ? '' : 'd-none' }}">
    <div class="col-7 form-group">
        {{ Form::label('contractor', __('proposals.contractor')) }}<i class="text-danger">*</i>
        {!! Form::select(
            'spv_contractor',
            ['' => ''] + $spv_contractors,
            $proposals->contractor_id ?? null,
            [
                'class' => 'form-control spv_contractor jsClearContractorType',
                'id' => 'spv_contractor',
                'data-placeholder' => 'Select Contractor',
                'data-ajaxurl' => route('getContractorData'),
                $disabled,
            ],
            $spvConOptions,
        ) !!}
    </div>
    <div class="col-3">
        <label>&nbsp;</label><br>
        <button class="btn btn-primary contAdd" type="button">Add</button>
    </div>
    <div class="col-2 form-group">
        <a type="button" href="{{ route('principle.create') }}" class="btn btn-outline-primary btn-sm mt-8" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div>

{{-- <div class="row spvCls {{ isset($proposals) && $proposals->contract_type == 'SPV' ? '' : 'd-none' }}">
    <div class="col-6 form-group">
        {{ Form::label('contractor', __('proposals.contractor')) }}
        {!! Form::select(
            'spv_contractor',
            ['' => ''] + $spv_contractors,
            null,
            [
                'class' => 'form-control spv_contractor',
                'id' => 'spv_contractor',
                'data-placeholder' => 'Select Contractor',
                'data-ajaxurl' => route('getContractorData'),
                $disabled,
            ],
            $spvOptArr,
        ) !!}
    </div>
    <div class="col-4">
        <label>&nbsp;</label><br>
        <button class="btn btn-primary contAdd" type="button">Add</button>
    </div>
    <div class="col-2 form-group">
        <a type="button" href="{{ route('principle.create') }}" class="btn btn-outline-primary btn-sm mt-7" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div> --}}
<div class="row jvCls {{ isset($proposals) && $proposals->contract_type == 'JV' ? '' : 'd-none' }}">
    <div class="col-7 form-group">
        {{ Form::label('contractor', __('proposals.contractor')) }}<i class="text-danger">*</i>
        {!! Form::select(
            'jv_contractor',
            ['' => ''] + $jv_contractors,
            $proposals->contractor_id ?? null,
            [
                'class' => 'form-control jv_contractor jsClearContractorType',
                'id' => 'jv_contractor',
                'data-placeholder' => 'Select Contractor',
                'data-ajaxurl' => route('getContractorData'),
                $disabled,
            ],
            $jvOptArr,
        ) !!}
    </div>
    <div class="col-3">
        <label>&nbsp;</label><br>
        <button class="btn btn-primary contAdd" type="button">Add</button>
    </div>
    <div class="col-2 form-group">
        <a type="button" href="{{ route('principle.create') }}" class="btn btn-outline-primary btn-sm mt-8" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div>

<div class="row showAdverseInformation d-none">
    <div class="col-12 form-group stand_alone_adverse_information">
    </div>
</div>
@if(isset($proposals->contractor->contractorAdverseInformation) && count($proposals->contractor->contractorAdverseInformation) > 0 && $proposals->contract_type == 'Stand Alone')
    {{ Form::label('adverse_information', __('proposals.adverse_information'), ['class' => 'text-danger']) }} 
    <ol class="adverse_information_ids">
        @foreach($proposals->contractor->contractorAdverseInformation as $adverse_item)
            @if($adverse_item)
                <li>
                    <a href="#" data-toggle="modal" data-target="#adverseInformation_{{ $adverse_item->id }}" class="call-modal navi-link">{{ $adverse_item->code }}</a>
                </li>
            @endif

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformation_{{ $adverse_item->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('adverse_information.adverse_information') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('common.code') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {{ $adverse_item->code ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('adverse_information.attachment') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        <a href="#" data-toggle="modal"
                                        data-target="#adverseInformationDocuments_{{ $adverse_item->id }}"
                                        class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('adverse_information.adverse_information') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {!! $adverse_item->adverse_information ?? '' !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformationDocuments_{{ $adverse_item->id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adverse Information Documents</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (isset($adverse_item->dMS) && count($adverse_item->dMS) > 0)
                                @foreach ($adverse_item->dMS as $docs)
                                    <div class="mb-3">
                                        <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                            target="_blanck">
                                            {!! getdmsFileIcon(e($docs->file_name)) !!}
                                        </a>
                                        {{ $docs->file_name ?? '' }}
                                    </div>
                                @endforeach
                            @else
                                <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </ol>
@endif

<div class="row showBlacklistInformation d-none">
    <div class="col-12 form-group stand_alone_blacklist_information">
    </div>
</div>
@if(isset($proposals->contractor->contractorBlacklistInformation) && count($proposals->contractor->contractorBlacklistInformation) > 0 && $proposals->contract_type == 'Stand Alone')
    {{ Form::label('blacklist_information', __('proposals.blacklist_information'), ['class' => 'text-danger']) }} 
    <ol class="blacklist_information_ids">
        @foreach($proposals->contractor->contractorBlacklistInformation as $item)
            @if($item)
                <li>
                    <a href="#" data-toggle="modal" data-target="#blacklistInformation_{{ $item->id }}" class="call-modal navi-link">{{ $item->code }}</a>
                </li>
            @endif

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformation_{{ $item->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('blacklist.blacklist_information') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <table>
                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('common.code') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {{ $item->code ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('blacklist.attachment') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        <a href="#" data-toggle="modal"
                                        data-target="#blacklistInformationDocuments_{{ $item->id }}"
                                        class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td class="text-light-grey" width="20%">
                                        {{ __('blacklist.reason') }}
                                    </td>
                                    <td width="10%">:</td>
                                    <td class="text-black" width="50%">
                                        {!! $item->reason ?? '' !!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformationDocuments_{{ $item->id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Blacklist Information Documents</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (isset($item->dMS) && count($item->dMS) > 0)
                                @foreach ($item->dMS as $docs)
                                    <div class="mb-3">
                                        <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                            target="_blanck">
                                            {!! getdmsFileIcon(e($docs->file_name)) !!}
                                        </a>
                                        {{ $docs->file_name ?? '' }}
                                    </div>
                                @endforeach
                            @else
                                <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </ol>
@endif

{{-- <div
    class="row jvClsData {{ isset($proposals) && $proposals->contract_type == 'JV' && isset($proposal_contractors) && $proposal_contractors->count() ? '' : 'd-none' }}">
    <div id="jv_repeater_contractor">
        <table class="table table-separate table-head-custom table-checkable" id="machine"
            data-repeater-list="jvContractorDetails">
            <p class="duplicateError text-danger d-none"></p>
            <thead>
                <tr>
                    <th width="5">{{ __('common.no') }}</th>
                    <th width="350">{{ __('proposals.contractor') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('common.pan_no') }}</th>
                    <th width="150">{{ __('proposals.oc') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('proposals.spare_capacity') }}<span class="text-danger">*</span></th>
                    <th width="15"></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($proposal_contractors) && $proposal_contractors->count() > 0)
                    @foreach ($proposal_contractors as $key => $item)
                        <tr data-repeater-item="" class="jv_contractor_rows">
                            <td class="list-no">{{ $loop->index + 1 }}</td>
                            <td>
                                <input type="hidden" name="jv_item_id" value="{{ $item->id }}">
                                {!! Form::text('', $item->contractor->company_name ?? null, [
                                    'class' => 'form-control jv_contractor_name form-control-solid',
                                    'readonly',
                                ]) !!}
                                {!! Form::hidden('jv_contractor_id', $item->proposal_contractor_id, [
                                    'class' => 'form-control contractCls jv_contractor_id',
                                ]) !!}

                                <div class="col-6 float-left w-150px">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('jv_share_holding',  $item->share_holding, ['class' => 'form-control jv_share_holding number','min' => '1','max' => '100','step' => '1']) !!} 
                                </div>
                                <div class="col-6 float-left">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.jv_exposure') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('jv_exposure', ($proposals->contract_type == 'JV') ? $item->jv_spv_exposure : null, [
                                        'class' => 'form-control jv_exposure contractCls number form-control-solid',  
                                        'readonly'                                  
                                    ]) !!}
                                </div>
                            </td>
                            <td>
                                {!! Form::text('jv_pan_no', $item->pan_no, [
                                    'class' => 'form-control jv_pan_no contractCls form-control-solid',
                                    'readonly',
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('jv_assign_exposure', $item->assign_exposure, [
                                    'class' => 'form-control contractCls jv_assign_exposure assign_exposure number',
                                    'min' => '1',
                                    'max' => '100',
                                    'step' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('jv_overall_cap', $item->overall_cap, [
                                    'class' => 'form-control jv_overall_cap contractCls number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('jv_consumed', $item->consumed, [
                                    'class' => 'form-control contractCls jv_consumed form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('jv_spare_capacity', $item->spare_capacity, [
                                    'class' => 'form-control contractCls jv_spare_capacity number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('jv_remaining_cap', $item->remaining_cap, [
                                    'class' => 'form-control contractCls jv_remaining_cap number form-control-solid',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td class="pt-28">
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr data-repeater-item="" class="jv_contractor_rows">
                        <td class="list-no">1</td>
                        <td>
                            {!! Form::text('', null, ['class' => 'form-control jv_contractor_name form-control-solid', 'readonly']) !!}
                            {!! Form::hidden('jv_contractor_id', null, ['class' => 'form-control contractCls jv_contractor_id']) !!}
                            <div class="col-6 float-left w-150px">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                </div>
                               {!! Form::number('jv_share_holding',  null, ['class' => 'form-control jv_share_holding number','min' => '1','max' => '100','step' => '1']) !!} 
                            </div>
                            <div class="col-6 float-left">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.jv_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('jv_exposure', null, [
                                    'class' => 'form-control jv_exposure contractCls number form-control-solid',  
                                    'readonly'                                  
                                ]) !!}
                            </div>
                        </td>
                        <td>
                            {!! Form::text('jv_pan_no', null, [
                                'class' => 'form-control jv_pan_no contractCls form-control-solid',
                                'readonly',
                            ]) !!}
                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::number('jv_assign_exposure', null, [
                                'class' => 'form-control contractCls jv_assign_exposure assign_exposure number',
                                'min' => '1',
                                'max' => '100',
                                'step' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('jv_overall_cap', null, [
                                'class' => 'form-control jv_overall_cap contractCls number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('jv_consumed', null, [
                                'class' => 'form-control contractCls jv_consumed form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('jv_spare_capacity', null, [
                                'class' => 'form-control contractCls jv_spare_capacity number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('jv_remaining_cap', null, [
                                'class' => 'form-control contractCls jv_remaining_cap number form-control-solid',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td class="pt-28">
                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                                <i class="flaticon-delete"></i></a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-12 col-12 d-none">
            <button type="button" data-repeater-create="" class="btn btn-outline-primary jvRepeaterAdd btn-sm"><i
                    class="fa fa-plus-circle"></i> Add</button>
        </div>
    </div>
</div> --}}
<div
    class="row spvClsData {{ isset($proposals) && $proposals->contract_type == 'SPV' && isset($proposal_contractors) && $proposal_contractors->count() ? '' : 'd-none' }}">
    <div id="spv_repeater_contractor">
        <table class="table table-separate table-head-custom table-checkable JsspvContractorRepeater" id="machine"
            data-repeater-list="spvContractorDetails">
            <p class="duplicateError text-danger d-none"></p>
            <thead>
                <tr>
                    <th width="5">{{ __('common.no') }}</th>
                    <th width="350">{{ __('proposals.contractor') }}<span class="text-danger">*</span></th>
                    <th width="250">{{ __('common.pan_no') }}</th>
                    {{-- <th width="150">{{ __('proposals.oc') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('proposals.spare_capacity') }}<span class="text-danger">*</span></th> --}}
                    <th width="50">{{ __('proposals.share_holding') }}</th>
                    <th width="15"></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($proposal_contractors) && $proposal_contractors->count() > 0)
                    @foreach ($proposal_contractors as $key => $item)
                        <tr data-repeater-item="" class="spv_contractor_rows">
                            <td class="list-no">{{ $loop->index + 1 }}</td>
                            <td>
                                <input type="hidden" name="spv_item_id" value="{{ $item->id }}" class="spVItemId">
                                {!! Form::text('spv_contractor_name', $item->contractor->company_name ?? null, [
                                    'class' => 'form-control spv_contractor_name',
                                    // 'readonly',
                                ]) !!}
                                {!! Form::hidden('spv_contractor_id', $item->proposal_contractor_id, [
                                    'class' => 'form-control contractCls spv_contractor_id',
                                ]) !!}

                                {{-- <div class="col-6 float-left w-150px">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('spv_share_holding',  $item->share_holding, ['class' => 'form-control spv_share_holding number ' . $readonly_cls,'min' => '1','max' => '100','step' => '1', $readonly]) !!} 
                                </div> --}}
                                {{-- <div class="col-6 float-left">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.spv_exposure') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('spv_exposure', ($proposals->contract_type == 'SPV') ? $item->jv_spv_exposure : null, [
                                        'class' => 'form-control spv_exposure contractCls number form-control-solid',  
                                        'readonly'                                  
                                    ]) !!}
                                </div> --}}
                                <div data-index-adverse-info-spv class="spv_adverse_information">
                                    @php
                                        $adverseInfo = $item->contractor->contractorAdverseInformation ?? [];
                                    @endphp
                                    @if(isset($adverseInfo) && count($adverseInfo) > 0)
                                        {{ Form::label('adverse_information', __('proposals.adverse_information'), ['class' => 'text-danger']) }} 
                                        <ol class="adverse_information_ids">
                                            @foreach($adverseInfo as $adverse_item)
                                                @if($adverse_item)
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#adverseInformation_{{ $adverse_item->id }}" class="call-modal navi-link">{{ $adverse_item->code }}</a>
                                                    </li>
                                                @endif

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformation_{{ $adverse_item->id }}">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('adverse_information.adverse_information') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('common.code') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {{ $adverse_item->code ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('adverse_information.attachment') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            <a href="#" data-toggle="modal"
                                                                            data-target="#adverseInformationDocuments_{{ $adverse_item->id }}"
                                                                            class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('adverse_information.adverse_information') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {!! $adverse_item->adverse_information ?? '' !!}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformationDocuments_{{ $adverse_item->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Adverse Information Documents</h5>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (isset($adverse_item->dMS) && count($adverse_item->dMS) > 0)
                                                                    @foreach ($adverse_item->dMS as $docs)
                                                                        <div class="mb-3">
                                                                            <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                                                                target="_blanck">
                                                                                {!! getdmsFileIcon(e($docs->file_name)) !!}
                                                                            </a>
                                                                            {{ $docs->file_name ?? '' }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                                <div data-index-blacklist-info-spv class="spv_blacklist_information">
                                    @php
                                        $blacklistInfo = $item->contractor->contractorBlacklistInformation ?? [];
                                    @endphp
                                    @if(isset($blacklistInfo) && count($blacklistInfo) > 0)
                                        {{ Form::label('blacklist_information', __('proposals.blacklist_information'), ['class' => 'text-danger']) }} 
                                        <ol class="blacklist_information_ids">
                                            @foreach($blacklistInfo as $blacklist_item)
                                                @if($blacklist_item)
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#blacklistInformation_{{ $blacklist_item->id }}" class="call-modal navi-link">{{ $blacklist_item->code }}</a>
                                                    </li>
                                                @endif

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformation_{{ $blacklist_item->id }}">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('blacklist.blacklist_information') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('common.code') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {{ $blacklist_item->code ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('blacklist.attachment') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            <a href="#" data-toggle="modal"
                                                                            data-target="#blacklistInformationDocuments_{{ $blacklist_item->id }}"
                                                                            class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('blacklist.reason') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {!! $blacklist_item->reason ?? '' !!}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformationDocuments_{{ $blacklist_item->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Blacklist Information Documents</h5>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (isset($blacklist_item->dMS) && count($blacklist_item->dMS) > 0)
                                                                    @foreach ($blacklist_item->dMS as $docs)
                                                                        <div class="mb-3">
                                                                            <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                                                                target="_blanck">
                                                                                {!! getdmsFileIcon(e($docs->file_name)) !!}
                                                                            </a>
                                                                            {{ $docs->file_name ?? '' }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            </td>
                            <td>
                                {!! Form::text('spv_pan_no', $item->pan_no, [
                                    'class' => 'form-control spv_pan_no contractCls',
                                    // 'readonly',
                                ]) !!}

                                {{-- <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('spv_assign_exposure', $item->assign_exposure, [
                                    'class' => 'form-control contractCls spv_assign_exposure assign_exposure number ' . $readonly_cls,
                                    'min' => '1',
                                    'max' => '100',
                                    'step' => '1',
                                    'data-rule-Numbers' => true,
                                    $readonly,
                                ]) !!} --}}
                            </td>
                            <td>
                                {!! Form::number('spv_share_holding',  $item->share_holding, ['class' => 'form-control spv_share_holding number','min' => '1','max' => '100', 'data-rule-PercentageV1' => true,]) !!} 
                            </td>
                            {{-- <td> --}}
                                {{-- {!! Form::number('spv_overall_cap', $item->overall_cap, [
                                    'class' => 'form-control spv_overall_cap overall_cap contractCls number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!} --}}

                                {{-- <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('spv_consumed', $item->consumed, [
                                    'class' => 'form-control contractCls spv_consumed form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!} --}}
                            {{-- </td> --}}
                            {{-- <td> --}}
                                {{-- {!! Form::number('spv_spare_capacity', $item->spare_capacity, [
                                    'class' => 'form-control contractCls spare_capacity spv_spare_capacity number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('spv_remaining_cap', $item->remaining_cap, [
                                    'class' => 'form-control contractCls spv_remaining_cap number form-control-solid',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!} --}}
                            {{-- </td> --}}
                            {{-- <td>
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2">
                                    <i class="flaticon-delete"></i></a>
                            </td> --}}
                        </tr>
                    @endforeach
                @else
                    <tr data-repeater-item="" class="spv_contractor_rows">
                        <td class="list-no">1</td>
                        <td>
                            <input type="hidden" name="spv_item_id" value="" class="spVItemId">
                            {!! Form::text('spv_contractor_name', null, ['class' => 'form-control spv_contractor_name form-control-solid', 'readonly']) !!}
                            {!! Form::hidden('spv_contractor_id', null, ['class' => 'form-control contractCls spv_contractor_id']) !!}
                            {{-- <div class="col-6 float-left w-150px">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                </div>
                            {!! Form::number('spv_share_holding',  null, ['class' => 'form-control spv_share_holding number','min' => '1','max' => '100','step' => '1']) !!}  --}}
                            {{-- </div> --}}
                            {{-- <div class="col-6 float-left">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.spv_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('spv_exposure', null, [
                                    'class' => 'form-control spv_exposure contractCls number form-control-solid',  
                                    'readonly'                                  
                                ]) !!}
                            </div> --}}

                            <div data-index-adverse-info-spv class="spv_adverse_information">
                            </div>
                            <div data-index-blacklist-info-spv class="spv_blacklist_information">
                            </div>
                        </td>
                        <td>
                            {!! Form::text('spv_pan_no', null, [
                                'class' => 'form-control spv_pan_no contractCls form-control-solid',
                                'readonly',
                            ]) !!}
                            {{-- <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::number('spv_assign_exposure', null, [
                                'class' => 'form-control contractCls spv_assign_exposure assign_exposure number',
                                'min' => '1',
                                'max' => '100',
                                'step' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!} --}}
                        </td>
                        <td>
                            {!! Form::number('spv_share_holding',  null, ['class' => 'form-control spv_share_holding form-control-solid number','min' => '1','max' => '100', 'readonly', 'data-rule-PercentageV1' => true,]) !!} 
                        </td>
                        {{-- <td> --}}
                            {{-- {!! Form::number('spv_overall_cap', null, [
                                'class' => 'form-control spv_overall_cap overall_cap contractCls number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('spv_consumed', null, [
                                'class' => 'form-control contractCls spv_consumed form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!} --}}
                        {{-- </td> --}}
                        {{-- <td> --}}
                            {{-- {!! Form::number('spv_spare_capacity', null, [
                                'class' => 'form-control contractCls spare_capacity spv_spare_capacity number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('spv_remaining_cap', null, [
                                'class' => 'form-control contractCls spv_remaining_cap number form-control-solid',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!} --}}
                        {{-- </td> --}}
                        {{-- <td>
                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                                <i class="flaticon-delete"></i></a>
                        </td> --}}

                        {{-- <td colspan="12">
                            <table>
                                <tr>
                                    <td class="showSpvAdverseInformation d-none">
                                        <div class="spv_adverse_information">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td> --}}
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-12 col-12 d-none">
            {!! Form::hidden('spv_count', null, ['class' => 'form-control spv_count spv_count']) !!}
            <button type="button" data-repeater-create="" class="btn btn-outline-primary spvRepeaterAdd btn-sm"><i
                    class="fa fa-plus-circle"></i> Add</button>
        </div>
    </div>
</div>

{{-- <div
    class="row spvClsData {{ isset($proposals) && $proposals->contract_type == 'SPV' && isset($proposal_contractors) && $proposal_contractors->count() ? '' : 'd-none' }}">
    <div id="spv_repeater_contractor">
        <table class="table table-separate table-head-custom table-checkable"
            data-repeater-list="spvContractorDetails">
            <p class="duplicateError text-danger d-none"></p>
            <thead>
                <tr>
                    <th width="5">{{ __('common.no') }}</th>
                    <th width="350">{{ __('proposals.contractor') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('common.pan_no') }}</th>
                    <th width="150">{{ __('proposals.oc') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('proposals.spare_capacity') }}<span class="text-danger">*</span></th>
                    <th width="15"></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($proposal_contractors) && $proposal_contractors->count() > 0)
                    @foreach ($proposal_contractors as $key => $item)
                        <tr data-repeater-item="" class="spv_contractor_rows">
                            <td class="list-no">{{ $loop->index + 1 }}</td>
                            <td>
                                <input type="hidden" name="spv_item_id" value="{{ $item->id }}">
                                {!! Form::text('spv_contractor_name', $item->contractor->company_name ?? null, [
                                    'class' => 'form-control spv_contractor_name form-control-solid',
                                    'readonly',
                                ]) !!}
                                {!! Form::hidden('spv_contractor_id', $item->proposal_contractor_id, [
                                    'class' => 'form-control contractCls spv_contractor_id',
                                ]) !!}

                                <div class="col-6 float-left w-150px">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                    </div>
                                {!! Form::number('spv_share_holding',  $item->share_holding, ['class' => 'form-control spv_share_holding number','min' => '1','max' => '100','step' => '1']) !!} 
                                </div>
                                <div class="col-6 float-left">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.spv_exposure') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('spv_exposure',  ($proposals->contract_type == 'SPV') ? $item->jv_spv_exposure : null, [
                                        'class' => 'form-control spv_exposure contractCls number form-control-solid',  
                                        'readonly'                                  
                                    ]) !!}
                                </div> 
                            </td>
                            <td>
                                {!! Form::text('spv_pan_no', $item->pan_no, [
                                    'class' => 'form-control spv_pan_no contractCls form-control-solid',
                                    'readonly',
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('spv_assign_exposure', $item->assign_exposure, [
                                    'class' => 'form-control contractCls spv_assign_exposure assign_exposure number',
                                    'min' => '1',
                                    'max' => '100',
                                    'step' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('spv_overall_cap', $item->overall_cap, [
                                    'class' => 'form-control contractCls spv_overall_cap number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('spv_consumed', $item->consumed, [
                                    'class' => 'form-control contractCls spv_consumed form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('spv_spare_capacity', $item->spare_capacity, [
                                    'class' => 'form-control contractCls spv_spare_capacity number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('spv_remaining_cap', $item->remaining_cap, [
                                    'class' => 'form-control contractCls spv_remaining_cap form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr data-repeater-item="" class="spv_contractor_rows">
                        <td class="list-no">1</td>
                        <td>
                            {!! Form::text('spv_contractor_name', null, [
                                'class' => 'form-control spv_contractor_name form-control-solid',
                                'readonly',
                            ]) !!}
                            {!! Form::hidden('spv_contractor_id', null, ['class' => 'form-control contractCls spv_contractor_id']) !!}

                            <div class="col-6 float-left w-150px">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                </div>
                               {!! Form::number('spv_share_holding',  null, ['class' => 'form-control spv_share_holding number','min' => '1','max' => '100','step' => '1']) !!} 
                            </div>
                            <div class="col-6 float-left">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.spv_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('spv_exposure', null, [
                                    'class' => 'form-control spv_exposure contractCls number form-control-solid',  
                                    'readonly'                                  
                                ]) !!}
                            </div>                           
                        </td>
                        <td>
                            {!! Form::text('spv_pan_no', null, [
                                'class' => 'form-control spv_pan_no contractCls form-control-solid',
                                'readonly',
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::number('spv_assign_exposure', null, [
                                'class' => 'form-control contractCls spv_assign_exposure assign_exposure number',
                                'min' => '1',
                                'max' => '100',
                                'step' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('spv_overall_cap', null, [
                                'class' => 'form-control contractCls spv_overall_cap number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('spv_consumed', null, [
                                'class' => 'form-control contractCls spv_consumed form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('spv_spare_capacity', null, [
                                'class' => 'form-control contractCls spv_spare_capacity number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('spv_remaining_cap', null, [
                                'class' => 'form-control contractCls spv_remaining_cap form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-12 col-12 d-none">
            {!! Form::hidden('spv_count', null, ['class' => 'form-control spv_count spv_count']) !!}
            <button type="button" data-repeater-create="" class="btn btn-outline-primary spvRepeaterAdd btn-sm"><i
                    class="fa fa-plus-circle"></i>Add</button>
        </div>
    </div>
</div> --}}
<div
    class="row jvClsData {{ isset($proposals) && $proposals->contract_type == 'JV' && isset($proposal_contractors) && $proposal_contractors->count() ? '' : 'd-none' }}">
    <div id="jv_repeater_contractor">
        <table class="table table-separate table-head-custom table-checkable JsjvContractorRepeater"
            data-repeater-list="jvContractorDetails">
            <p class="duplicateError text-danger d-none"></p>
            <thead>
                <tr>
                    <th width="5">{{ __('common.no') }}</th>
                    <th width="350">{{ __('proposals.contractor') }}<span class="text-danger">*</span></th>
                    <th width="250">{{ __('common.pan_no') }}</th>
                    <th width="50">{{ __('proposals.share_holding') }}</th>
                    {{-- <th width="150">{{ __('proposals.oc') }}<span class="text-danger">*</span></th>
                    <th width="150">{{ __('proposals.spare_capacity') }}<span class="text-danger">*</span></th> --}}
                    <th width="15"></th>
                </tr>
            </thead>
            <tbody>
                @if (isset($proposal_contractors) && $proposal_contractors->count() > 0)
                    @foreach ($proposal_contractors as $key => $item)
                        <tr data-repeater-item="" class="jv_contractor_rows">
                            <td class="list-no">{{ $loop->index + 1 }}</td>
                            <td>
                                <input type="hidden" name="jv_item_id" value="{{ $item->id }}" class="jVItemId">
                                {!! Form::text('jv_contractor_name', $item->contractor->company_name ?? null, [
                                    'class' => 'form-control jv_contractor_name',
                                ]) !!}
                                {!! Form::hidden('jv_contractor_id', $item->proposal_contractor_id, [
                                    'class' => 'form-control contractCls jv_contractor_id',
                                ]) !!}

                                {{-- <div class="col-6 float-left w-150px">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                    </div>
                                {!! Form::number('jv_share_holding',  $item->share_holding, ['class' => 'form-control jv_share_holding number ' . $readonly_cls,'min' => '1','max' => '100','step' => '1', $readonly]) !!} 
                                </div>
                                <div class="col-6 float-left">
                                    <div class="mt-5" style="font-weight: 600;color: #000;">
                                        {{ __('proposals.jv_exposure') }}<span class="text-danger">*</span>
                                    </div>
                                    {!! Form::number('jv_exposure',  ($proposals->contract_type == 'JV') ? $item->jv_spv_exposure : null, [
                                        'class' => 'form-control jv_exposure contractCls number form-control-solid',  
                                        'readonly'                                  
                                    ]) !!}
                                </div> --}}
                                <div>
                                    {{-- @dd($item->contractor->contractorAdverseInformation) --}}
                                    @php
                                        $adverseInfo = $item->contractor->contractorAdverseInformation ?? [];
                                        $blacklistInfo = $item->contractor->contractorBlacklistInformation ?? [];
                                    @endphp
                                    @if(isset($adverseInfo) && count($adverseInfo) > 0)
                                        {{ Form::label('adverse_information', __('proposals.adverse_information'), ['class' => 'text-danger']) }} 
                                        <ol class="adverse_information_ids">
                                            @foreach($adverseInfo as $adverse_item)
                                                @if($adverse_item)
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#adverseInformation_{{ $adverse_item->id }}" class="call-modal navi-link">{{ $adverse_item->code }}</a>
                                                    </li>
                                                @endif

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformation_{{ $adverse_item->id }}">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('adverse_information.adverse_information') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('common.code') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {{ $adverse_item->code ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('adverse_information.attachment') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            <a href="#" data-toggle="modal"
                                                                            data-target="#adverseInformationDocuments_{{ $adverse_item->id }}"
                                                                            class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('adverse_information.adverse_information') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {!! $adverse_item->adverse_information ?? '' !!}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="adverseInformationDocuments_{{ $adverse_item->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Adverse Information Documents</h5>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (isset($adverse_item->dMS) && count($adverse_item->dMS) > 0)
                                                                    @foreach ($adverse_item->dMS as $docs)
                                                                        <div class="mb-3">
                                                                            <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                                                                target="_blanck">
                                                                                {!! getdmsFileIcon(e($docs->file_name)) !!}
                                                                            </a>
                                                                            {{ $docs->file_name ?? '' }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ol>
                                    @endif

                                    @if(isset($blacklistInfo) && count($blacklistInfo) > 0)
                                        {{ Form::label('blacklist_information', __('proposals.blacklist_information'), ['class' => 'text-danger']) }} 
                                        <ol class="blacklist_information_ids">
                                            @foreach($blacklistInfo as $blacklist_item)
                                                @if($blacklist_item)
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#blacklistInformation_{{ $blacklist_item->id }}" class="call-modal navi-link">{{ $blacklist_item->code }}</a>
                                                    </li>
                                                @endif

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformation_{{ $blacklist_item->id }}">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('blacklist.blacklist_information') }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('common.code') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {{ $blacklist_item->code ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('blacklist.attachment') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            <a href="#" data-toggle="modal"
                                                                            data-target="#blacklistInformationDocuments_{{ $blacklist_item->id }}"
                                                                            class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td class="text-light-grey" width="20%">
                                                                            {{ __('blacklist.reason') }}
                                                                        </td>
                                                                        <td width="10%">:</td>
                                                                        <td class="text-black" width="50%">
                                                                            {!! $blacklist_item->reason ?? '' !!}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" data-backdrop="static" tabindex="-1" id="blacklistInformationDocuments_{{ $blacklist_item->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Blacklist Information Documents</h5>

                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if (isset($blacklist_item->dMS) && count($blacklist_item->dMS) > 0)
                                                                    @foreach ($blacklist_item->dMS as $docs)
                                                                        <div class="mb-3">
                                                                            <a href="{{ isset($docs->attachment) && !empty($docs->attachment) ? route('secure-file', encryptId($docs->attachment)) : asset('/default.jpg') }}"
                                                                                target="_blanck">
                                                                                {!! getdmsFileIcon(e($docs->file_name)) !!}
                                                                            </a>
                                                                            {{ $docs->file_name ?? '' }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                                
                            </td>
                            <td>
                                {!! Form::text('jv_pan_no', $item->pan_no, [
                                    'class' => 'form-control jv_pan_no contractCls',
                                ]) !!}

                                {{-- <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('jv_assign_exposure', $item->assign_exposure, [
                                    'class' => 'form-control contractCls jv_assign_exposure assign_exposure number ' . $readonly_cls,
                                    'min' => '1',
                                    'max' => '100',
                                    'step' => '1',
                                    'data-rule-Numbers' => true,
                                    $readonly,
                                ]) !!} --}}
                            </td>
                            <td>
                                {!! Form::number('jv_share_holding',  $item->share_holding, ['class' => 'form-control jv_share_holding number','min' => '1','max' => '100', 'data-rule-PercentageV1' => true,]) !!} 
                            </td>
                            {{-- <td>
                                {!! Form::number('jv_overall_cap', $item->overall_cap, [
                                    'class' => 'form-control contractCls overall_cap jv_overall_cap number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('jv_consumed', $item->consumed, [
                                    'class' => 'form-control contractCls jv_consumed form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('jv_spare_capacity', $item->spare_capacity, [
                                    'class' => 'form-control contractCls spare_capacity jv_spare_capacity number form-control-solid',
                                    'data-rule-Numbers' => true,
                                ]) !!}

                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::text('jv_remaining_cap', $item->remaining_cap, [
                                    'class' => 'form-control contractCls jv_remaining_cap form-control-solid number',
                                    'readonly',
                                    'min' => '1',
                                    'data-rule-Numbers' => true,
                                ]) !!}
                            </td> --}}
                        </tr>
                    @endforeach
                @else
                    <tr data-repeater-item="" data-jv-index class="jv_contractor_rows">
                        <td class="list-no">1</td>
                        <td>
                            <input type="hidden" name="jv_item_id" value="" class="jVItemId">
                            {!! Form::text('jv_contractor_name', null, [
                                'class' => 'form-control jv_contractor_name form-control-solid',
                                'readonly',
                            ]) !!}
                            {!! Form::hidden('jv_contractor_id', null, ['class' => 'form-control contractCls jv_contractor_id']) !!}

                            {{-- <div class="col-6 float-left w-150px">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.share_holding') }}<span class="text-danger">*</span>
                                </div>
                            {!! Form::number('jv_share_holding',  null, ['class' => 'form-control jv_share_holding number','min' => '1','max' => '100','step' => '1']) !!} 
                            </div>
                            <div class="col-6 float-left">
                                <div class="mt-5" style="font-weight: 600;color: #000;">
                                    {{ __('proposals.jv_exposure') }}<span class="text-danger">*</span>
                                </div>
                                {!! Form::number('jv_exposure', null, [
                                    'class' => 'form-control jv_exposure contractCls number form-control-solid',  
                                    'readonly'                                  
                                ]) !!}
                            </div>       --}}
                            <div data-index-adverse-info class="jv_adverse_information">
                            </div>
                            <div data-index-blacklist-info class="jv_blacklist_information">
                            </div>
                        </td>
                        <td>
                            {!! Form::text('jv_pan_no', null, [
                                'class' => 'form-control jv_pan_no contractCls form-control-solid',
                                'readonly',
                            ]) !!}

                            {{-- <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.assign_exposure') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::number('jv_assign_exposure', null, [
                                'class' => 'form-control contractCls jv_assign_exposure assign_exposure number',
                                'min' => '1',
                                'max' => '100',
                                'step' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!} --}}
                        </td>
                        <td>
                            {!! Form::number('jv_share_holding',  null, ['class' => 'form-control jv_share_holding number form-control-solid','min' => '1','max' => '100', 'readonly', 'data-rule-PercentageV1' => true,]) !!} 
                        </td>
                        {{-- <td>
                            {!! Form::number('jv_overall_cap', null, [
                                'class' => 'form-control contractCls overall_cap jv_overall_cap number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.consumed') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('jv_consumed', null, [
                                'class' => 'form-control contractCls jv_consumed form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('jv_spare_capacity', null, [
                                'class' => 'form-control contractCls spare_capacity jv_spare_capacity number form-control-solid',
                                'data-rule-Numbers' => true,
                            ]) !!}

                            <div class="mt-5" style="font-weight: 600;color: #000;">
                                {{ __('proposals.remaining_cap') }}<span class="text-danger">*</span>
                            </div>
                            {!! Form::text('jv_remaining_cap', null, [
                                'class' => 'form-control contractCls jv_remaining_cap form-control-solid number',
                                'readonly',
                                'min' => '1',
                                'data-rule-Numbers' => true,
                            ]) !!}
                        </td> --}}

                        {{-- <td colspan="12">
                            <table>
                                <tr>
                                    <td class="showJvAdverseInformation d-none">
                                        <div data-index-adverse-info class="jv_adverse_information">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td> --}}
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="col-md-12 col-12 d-none">
            {!! Form::hidden('jv_count', null, ['class' => 'form-control jv_count jv_count']) !!}
            <button type="button" data-repeater-create="" class="btn btn-outline-primary jvRepeaterAdd btn-sm"><i
                    class="fa fa-plus-circle"></i>Add</button>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-4 form-group">
        {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('first_name', null, [
            'class' => 'form-control  first_name JsNotJvSpv',
            'id' => 'first_name',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>
    <div class="col-4 form-group">
        {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
        {!! Form::text('middle_name', null, [
            'class' => 'form-control middle_name JsNotJvSpv',
            'id' => 'middle_name',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('last_name', null, [
            'class' => 'form-control  last_name JsNotJvSpv',
            'id' => 'last_name',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>
</div> --}}

<div class="row">
    {{-- <div class="col-6 form-group">
        {!! Form::label(__('common.full_name'), __('common.full_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('full_name', null, [
            'class' => 'form-control  JsNotJvSpv',
            'id' => 'full_name',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div> --}}

    <div class="col-6 form-group">
        {!! Form::label(__('proposals.parent_group'), __('proposals.parent_group')) !!}<i class="text-danger">*</i>
        {!! Form::text('parent_group', null, [
            'class' => 'form-control form-control-solid required jsClearContractorType parent_group_name ' . $readonly_cls,
            'id' => 'parent_group',
            // $readonly,
            'data-rule-AlphabetsAndNumbersV8' => true,
            'readonly',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('principle.registration_no'), __('principle.registration_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        {!! Form::text('registration_no', null, [
            'class' => 'form-control jsClearContractorType registration_no {{ isset($proposals) && isset($proposals->contract_type) && $proposals->contract_type == "Stand Alone" ? "required" : "" }} '.$readonly_cls,
            'data-rule-AlphabetsAndNumbersV2' => true,
            $readonly,
            'readonly',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.company_name'), __('common.company_name')) !!}<i class="text-danger">*</i>
        {{ Form::text('contractor_company_name', null, ['class' => 'form-control jsClearContractorType required contractor_company_name ' . $readonly_cls, 'data-rule-AlphabetsAndNumbersV8' => true, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.register_address'), __('proposals.register_address')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('register_address', null, [
            'class' => 'form-control jsClearContractorType register_address JsNotJvSpv required ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('principle.website'), __('principle.website')) !!}
        {!! Form::url('contractor_website', null, ['class' => 'form-control contractor_website ' . $readonly_cls, $readonly,]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_country_id', ['' => ''] + $countries, null, [
            'class' => 'form-control contractor_country_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'contractor_country_id',
            'data-placeholder' => 'Select country',
            // 'data-ajaxurl' => route('getCountryName'),
            $disabled,
            'data-ajaxurl' => route('getCurrencySymbol', ['id' => '__id__']),
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_state_id', ['' => ''] + $states, null, [
            'class' => 'form-control contractor_state_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'contractor_state_id',
            'data-placeholder' => 'Select state',
            $disabled,
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
        {{ Form::text('contractor_city', null, ['class' => 'form-control required contractor_city ' . $readonly_cls, 'data-rule-AlphabetsV1' => true, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.pincode'), __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
        {{ Form::text('contractor_pincode', $principle->pincode ?? null, ['class' => 'form-control required jsClearContractorType jsPinCodeContractor contractor_pincode ' . $readonly_cls, $readonly,]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

        {{ Form::email('contractor_email', $principle->user->email ?? null, [
            'class' => 'form-control jsClearContractorType contractor_email required ' . $readonly_cls,
            'data-rule-remote' => route('common.checkUniqueEmail', [
                'id' => $principle['user_id'] ?? '',
            ]),
            'data-msg-remote' => 'The email has already been taken.',
            $readonly,
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.gst_no'), __('common.gst_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>

        {{ Form::text('contractor_gst_no', null, [
            'class' => 'form-control jsClearContractorType contractor_gst_no ' . 
                (isset($proposals) && isset($proposals->contract_type) && $proposals->contract_type == "Stand Alone" ? "required" : "") .' '.$readonly_cls,
            '',
            // 'data-rule-remote' => route('common.checkUniqueField', [
            //     'field' => 'contractor_gst_no',
            //     'model' => 'principles',
            //     'id' => $principle['id'] ?? '',
            // ]),
            // 'data-msg-remote' => 'GST No. has already been taken.',
            'data-rule-GstNo' => true,
            $readonly,
        ]) }}
    </div>

    <div class="col-6 form-group contractorGstAndPanNoFields {{ $isContractorCountryIndia ? '' : 'd-none' }}">
        {!! Form::label(__('common.pan_no'), __('common.pan_no')) !!}<i class="text-danger">*</i>

        {{ Form::text('contractor_pan_no', null, [
            'class' => 'form-control jsClearContractorType contractor_pan_no ' . $readonly_cls,
            // 'data-rule-remote' => route('common.checkUniquePanNumber', [
            //     'field' => 'principles',
            //     'id' => $principle['id'] ?? '',
            // ]),
            // 'data-msg-remote' => 'PAN No. has already been taken.',
            'data-rule-PanNo' => true,
            $readonly,
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('same_as_above', __('proposals.same_as_above')) !!}

        <div class="checkbox-inline pt-1">
            <label class="checkbox checkbox-square">
                {!! Form::checkbox('contractor_same_as_above', 'Yes', null, [
                    'class' => 'contractor_same_as_above',
                    $disabled,
                ]) !!}
                <span></span>
                {!! Form::label('same_as_above', null, ['class' => 'mt-2 contractor_same_as_above']) !!}
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('contractor_bond_address', __('proposals.bond_address')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('contractor_bond_address', null, [
            'class' => 'form-control contractor_bond_address JsNotJvSpv required ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
            // 'readonly',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_bond_country_id', ['' => ''] + $countries, null, [
            'class' => 'form-control contractor_bond_country_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'contractor_bond_country_id',
            'data-placeholder' => 'Select country',
            // 'data-ajaxurl' => route('getCountryName'),
            $disabled,
            // 'disabled',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
        {!! Form::select('contractor_bond_state_id', ['' => ''] + $states, null, [
            'class' => 'form-control contractor_bond_state_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'contractor_bond_state_id',
            'data-placeholder' => 'Select state',
            $disabled,
            // 'disabled',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
        {{ Form::text('contractor_bond_city', null, [
            'class' => 'form-control required contractor_bond_city ' . $readonly_cls,
            'data-rule-AlphabetsV1' => true,
            $readonly,
            // 'readonly'
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.pincode'), __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
        {{ Form::text('contractor_bond_pincode', $principle->pincode ?? null, [
            'class' => 'form-control required jsPinCodeContractorBond contractor_bond_pincode ' . $readonly_cls, 
            // 'data-rule-PinCode' => true, 
            $readonly, 
            // 'readonly',
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.gst_no'), __('common.gst_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>

        {{ Form::text('contractor_bond_gst_no', null, [
            'class' => 'form-control contractor_bond_gst_no ' . 
                (isset($proposals) && isset($proposals->contract_type) && $proposals->contract_type == "Stand Alone" ? "required" : "") .' '.$readonly_cls,
            '',
            // 'data-rule-remote' => route('common.checkUniqueField', [
            //     'field' => 'contractor_gst_no',
            //     'model' => 'principles',
            //     'id' => $principle['id'] ?? '',
            // ]),
            // 'data-msg-remote' => 'GST No. has already been taken.',
            'data-rule-GstNo' => true,
            $readonly,
            // 'readonly',
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {{ Form::label(__('proposals.date_of_incorporation'), __('proposals.date_of_incorporation')) }}<i
            class="text-danger">*</i>
        {!! Form::date('date_of_incorporation', null, [
            'class' => 'form-control jsClearContractorType required date_of_incorporation ' . $readonly_cls,
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            $readonly,
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('principle.principle_type'), __('principle.principle_type')) !!}<i class="text-danger">*</i>
        {!! Form::select(
            'principle_type_id',
            ['' => 'Select Principle Type'] + $principle_types->pluck('name', 'id')->toArray(),
            null,
            [
                'class' => 'form-control jsClearContractorType required jsSelect2ClearAllow principle_type_id',
                'style' => 'width: 100%;',
                'id' => 'principle_type',
                'data-placeholder' => 'Select Principle Type',
                $disabled,
            ],
        ) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.phone_no'), __('common.phone_no')) !!}<i class="text-danger">*</i>
        {{ Form::text('contractor_mobile', $principle->user->mobile ?? null, [
            'class' => 'form-control jsClearContractorType number contractor_mobile required ' . $readonly_cls,
            'data-rule-MobileNo' => true,
            $readonly,
            // 'data-rule-remote' => route('common.checkUniqueMobile', [
            //     'field' => 'contractor_mobile',
            //     'model' => 'users',
            //     'role' => 'contractor',
            //     'id' => $principle['user_id'] ?? '',
            // ]),
            // 'data-msg-remote' => 'Phone No. has already been taken.',
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('contractor_entity_type_id', __('principle.entity_type')) !!}<i class="text-danger">*</i>
        {!! Form::select(
            'contractor_entity_type_id',
            ['' => ''] + $entity_types,
            null,
            [
                'class' => 'form-control contractor_entity_type_id required jsSelect2ClearAllow',
                'style' => 'width: 100%;',
                'id' => 'contractor_entity_type_id',
                'data-placeholder' => 'Select Entity Type',
                $disabled,
            ],
        ) !!}
    </div>
</div>

<div class="row">
    {{-- <div class="col-6 form-group">
        {!! Form::label('contractor_inception_date', __('principle.inception_date')) !!}<i class="text-danger">*</i>
        {!! Form::date('contractor_inception_date', null, [
            'class' => 'form-control contractor_inception_date required ' . $readonly_cls,
            'id' => 'contractor_inception_date',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            $readonly,
        ]) !!}
    </div> --}}

    <div class="col-6 form-group">
        {!! Form::label('contractor_staff_strength', __('principle.staff_strength')) !!}
        {{ Form::number('contractor_staff_strength', null, ['class' => 'contractor_staff_strength form-control ' . $readonly_cls, 'data-rule-Numbers' => true, $readonly,]) }}
    </div>
</div>
    {{-- <div class="col-4 form-group">
        {{ Form::label(__('principle.date_of_incorporation'), __('principle.date_of_incorporation')) }}<i
            class="text-danger">*</i>
        {!! Form::date('date_of_incorporation', null, [
            'class' => 'form-control  selectDate',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            'id' => 'date_of_incorporation',
        ]) !!}
    </div> --}}

    {{-- <div class="col-4 form-group">
        {!! Form::label(__('principle.inception_date'), __('principle.inception_date')) !!}<i class="text-danger">*</i>
        {!! Form::date('inception_date', null, [
            'class' => 'form-control  selectDate',
            'id' => 'inception_date',
            'max' => '9999-12-31',
        ]) !!}
    </div> --}}

{{-- <div class="row jsShowIsJV {{ isset($proposals->is_jv) && $proposals->is_jv == 'Yes' ? '' : 'd-none' }}">
    <div class="col-4 form-group">
        {!! Form::label(__('principle.is_jv'), __('principle.is_jv')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_jv', 'Yes', true, ['class' => 'form_is_jv', 'id' => 'is_yes_jv_data', 'disabled']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_jv', 'No', null, ['class' => 'form_is_jv', 'id' => 'is_no_jv_data', 'disabled']) }}
                <span></span>No
            </label>
        </div>
    </div>
</div> --}}

{{-- <div
    class="row repeater-scrolling-wrapper contractRepeater {{ isset($proposals->is_jv) && $proposals->is_jv == 'Yes' ? '' : 'd-none' }}">
    <div class="form-group col-lg-12">
        <div id="kt_repeater_contractor">
            <table class="table table-separate table-head-custom table-checkable contractorDetails" id="machine"
                data-repeater-list="contractorDetails">
                <p class="duplicateError text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.principle') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.pan_no') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.share_holding') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($proposals) && count($proposals->contractorItem) > 0)
                        @foreach ($proposals->contractorItem as $key => $item)
                            <tr data-repeater-item="" class="contractor_data_rows">
                                <td class="list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="contractor_item_id" value="{{ $item->id }}" class="contractorItemId">
                                <td>
                                    {!! Form::select('contractor_id', ['' => 'select'] + $contractors, $item->contractor_id, [
                                        'class' => 'form-control jsClearContractorType form-control-solid repDuplicate1 JvSpvContractorId jsSelect2ClearAllow',
                                        'style' => 'width: 100%;',
                                        'data-placeholder' => 'Select Contractor',
                                        'data-ajaxurl' => route('getContractorDetail'),
                                        'disabled',
                                        $disabled,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::text('contractor_pan_no', $item->pan_no, [
                                        'class' => 'form-control jsClearContractorType contractor_pan_no form-control-solid',
                                        'readonly',
                                        'data-rule-PanNo' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('share_holding', $item->share_holding, [
                                        'class' => 'form-control jsClearContractorType form-control-solid share_holding number ',
                                        'data-rule-maxShareHolding' => true,
                                        'data-rule-PercentageV1' => true,
                                        'readonly',
                                    ]) !!}
                                </td>
                                @if(!$disabled)
                                    <td>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="contractor_data_rows">
                            <td class="list-no">1</td>
                            <td>
                                <input type="hidden" name="contractor_item_id" value="" class="contractorItemId">
                                {!! Form::select('contractor_id', ['' => 'select'] + $contractors, null, [
                                    'class' => 'form-control jsClearContractorType repDuplicate1 JvSpvContractorId',
                                    'style' => 'width: 100%;',
                                    'data-placeholder' => 'Select Contractor',
                                    'data-ajaxurl' => route('getContractorDetail'),
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::text('contractor_pan_no', null, [
                                    'class' => 'form-control jsClearContractorType contractor_pan_no form-control-solid',
                                    'readonly',
                                    'data-rule-PanNo' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('share_holding', null, [
                                    'class' => 'form-control jsClearContractorType share_holding number',
                                    'data-rule-maxShareHolding' => true,
                                    'data-rule-PercentageV1' => true,
                                ]) !!}
                            </td>
                            <td>
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table> --}}
            {{-- <div class="col-md-12 col-12">
                <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-plus-circle"></i> Add</button>
            </div> --}}
        {{-- </div>
    </div>
</div> --}}

<div class="row">
    <div class="form-group col-12">
        <div id="tradeSectorRepeater">
            <table class="table table-separate table-head-custom table-checkable tradeSector" id="machine"
                data-repeater-list="tradeSector">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.trade_sector') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.from') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.till') }}</th>
                        <th>{{ __('principle.main') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($proposals) && count($proposals->tradeSector) > 0)
                        <span class="text-danger item-dul-error d-none">Duplicate trade sector
                            found.</span>
                        @foreach ($proposals->tradeSector as $key => $item)
                            <tr data-repeater-item="" class="contractor_trade_sector_row">
                                <td class="trade-list-no">{{ ++$key }} . </td>
                                <td>
                                    <input type="hidden" name="contractor_trade_item_id" value="{{ $item->id }}" class="contractorTradeSectorId">
                                    {!! Form::hidden("pct_item_id", $item->contractor_fetch_reference_id ?? '') !!}
                                    {!! Form::select('contractor_trade_sector', ['' => ''] + $trade_sector, $item->trade_sector_id, [
                                        'class' => 'form-control jsClearContractorType contractor_trade_sector jsTradeSector',
                                        'data-placeholder' => 'Select Trade Sector',
                                        $disabled,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date('contractor_from', $item->from, ['class' => 'form-control jsClearContractorType from ' . $readonly_cls, 'max' => now()->toDateString(), $readonly]) !!}
                                </td>
                                <td>
                                    {!! Form::date('contractor_till', $item->till, ['class' => 'form-control jsClearContractorType till minDate ' . $readonly_cls, 'max' => '9999-12-31', $readonly]) !!}
                                </td>
                                <td class="pl-5 pt-6">
                                    <div class="radio-inline">
                                        <label class="radio">
                                            {{ Form::radio('contractor_is_main', 'Yes', $item->is_main == 'Yes' ? true : false, ['class' => 'form-check-input contractor_is_main', $disabled]) }}
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                                {{-- @if(!$disabled)
                                    <td>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2 trade_sector_delete">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                @endif --}}
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="contractor_trade_sector_row">
                            <td class="trade-list-no">1</td>
                            <td>
                                <input type="hidden" name="contractor_trade_item_id" value="" class="contractorTradeSectorId">
                                {!! Form::select('contractor_trade_sector', ['' => ''] + $trade_sector, null, [
                                    'class' => 'form-control jsClearContractorType contractor_trade_sector jsTradeSector required',
                                    'data-placeholder' => 'Select Trade Sector',
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::date('contractor_from', null, ['class' => 'form-control from jsClearContractorType required', 'max' => now()->toDateString()]) !!}
                            </td>
                            <td>
                                {!! Form::date('contractor_till', null, ['class' => 'form-control till jsClearContractorType minDate', 'max' => '9999-12-31']) !!}
                            </td>
                            <td class="pl-5 pt-6">
                                <div class="radio-inline">
                                    <label class="radio">
                                        {{ Form::radio('contractor_is_main', 'Yes', true, ['class' => 'form-check-input contractor_is_main']) }}
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="trade_sector_delete">
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2">
                                        <i class="flaticon-delete"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12 {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
                <button type="button" data-repeater-create=""
                    class="btn btn-outline-primary btn-sm trade_sector_create"><i class="fa fa-plus-circle"></i>
                    Add</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-12">
        <div id="contactDetailRepeater">
            <table class="table table-separate table-head-custom table-checkable contactDetailSector" id="machine"
                data-repeater-list="contactDetail">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('principle.contact_person') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.phone_no') }}</th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($proposals) && count($proposals->contactDetail) > 0)
                        @foreach ($proposals->contactDetail as $key => $item)
                            <tr data-repeater-item="" class="contact_detail_row">
                                <td class="contact-list-no">{{ ++$key }} . </td>

                                <td>
                                    <input type="hidden" name="contact_item_id" value="{{ $item->id }}" class="contactDetailId contact_item_id">
                                    {!! Form::hidden("proposal_contact_item_id", $item->contractor_fetch_reference_id ?? '') !!}
                                    {!! Form::text('contact_person', $item->contact_person, [
                                        'class' => 'jsClearContractorType form-control ' . $readonly_cls,
                                        'data-rule-AlphabetsV1' => true,
                                        $readonly,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::email('email', $item->email, ['class' => 'jsClearContractorType form-control email ' . $readonly_cls, $readonly]) !!}
                                </td>
                                <td>
                                    {!! Form::text('phone_no', $item->phone_no, [
                                        'class' => 'form-control jsClearContractorType number ' . $readonly_cls,
                                        'data-rule-MobileNo' => true,
                                        $readonly,
                                    ]) !!}
                                </td>
                                {{-- @if(!$disabled)
                                    <td>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2 contact_detail_delete">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                @endif --}}
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="contact_detail_row">
                            <td class="contact-list-no">1</td>
                            <td>
                                <input type="hidden" name="contact_item_id" value="" class="contactDetailId contact_item_id">
                                {!! Form::text('contact_person', null, ['class' => 'form-control jsClearContractorType', 'data-rule-AlphabetsV1' => true]) !!}
                            </td>
                            <td>
                                {!! Form::email('email', null, ['class' => 'form-control jsClearContractorType email']) !!}
                            </td>
                            <td>
                                {!! Form::text('phone_no', null, ['class' => 'form-control jsClearContractorType number', 'data-rule-MobileNo' => true]) !!}
                            </td>
                            <td>
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2 contact_detail_delete">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12 {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
                <button type="button" data-repeater-create=""
                    class="btn btn-outline-primary btn-sm contact_detail_create"><i class="fa fa-plus-circle"></i>
                    Add</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        <span class="text-danger item-dul-error d-none">Duplicate Agency found.</span>
        {!! Form::label('agency_id', __('principle.agency')) !!}
        {!! Form::select('agency_id', ['' => ''] + $agencies, null, ['class' => 'form-control jsSelect2ClearAllow agency_id', 'data-placeholder' => 'Select Agency', 'data-ajaxurl' => route('getProposalRatingDetails'), $disabled], $agencyOptions) !!}
    </div>

    <div class="col-3 form-group jsSelectRating invisible">
        {!! Form::label('rating_id', __('principle.rating')) !!}<i class="text-danger jsIsAgency">*</i>
        {!! Form::select('rating_id', ['' => ''] + $agency_rating, null, ['class' => 'form-control jsSelect2ClearAllow rating_id', 'data-placeholder' => 'Select Rating', 'data-ajaxurl' => route('getProposalRatingRemarks'), $disabled]) !!}
    </div>

    <div class="col-3 form-group">
        {!! Form::label('item_rating_date', __('proposals.rating_date')) !!}<i class="text-danger jsIsAgency">*</i>
        {!! Form::date("item_rating_date",  null, ['class' => 'form-control item_rating_date ' . $readonly_cls, $readonly]) !!}
    </div>

    <div class="col-2">
        <button type="button" 
            class="btn btn-outline-primary btn-sm rating_detail_create mt-9" disabled><i class="fa fa-plus-circle"></i>
            Add</button>
    </div>
</div>

<div class="row jsAgencyDetails">
    <div class="form-group col-12">
        <div id="ratingDetailRepeater">
            <table class="table table-separate table-head-custom table-checkable ratingDetails" id="machine"
                data-repeater-list="ratingDetail">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th style="width: 5%">{{ __('common.no') }}</th>
                        <th style="width: 20%">{{ __('principle.agency_name') }}</th>
                        <th style="width: 15%">{{ __('principle.rating') }}</th>
                        <th style="width: 40%">{{ __('principle.remarks') }}</th>
                        <th style="width: 15%">{{ __('proposals.rating_date') }}</th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($ratingDetails) && count($ratingDetails) > 0)
                        @foreach ($ratingDetails as $key => $item)
                            <tr data-repeater-item="" class="rating_detail_row">
                                <td class="rating-list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="rating_item_id" class="rating_item_id" value="{{ $item->id }}" class="contractorRatingDetailId">
                                <td>
                                    {!! Form::hidden('item_agency_id', $item->agency_id ?? '', ['class' => 'form-control item_agency_id',]) !!}
                                    {!! Form::hidden('item_rating_id', $item->rating_id ?? '', ['class' => 'form-control item_rating_id',]) !!}
                                    {!! Form::text('agency_name', $item->agencyName->agency_name ?? '', [
                                        'class' => 'form-control agency_name form-control-solid',
                                        'readonly',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::text('rating', $item->rating ?? '', [
                                        'class' => 'form-control rating form-control-solid',
                                        'readonly',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::textarea("rating_remarks", $item->remarks ?? '', ['class' => 'form-control rating_remarks form-control-solid', 'data-rule-Remarks' => true, 'rows' => 2, 'cols' => 2, 'readonly']) !!}
                                </td>
                                <td>
                                    {!! Form::date("rating_date", $item->rating_date ?? '', ['class' => 'form-control rating_date form-control-solid', 'readonly']) !!}
                                </td>
                                {{-- @if(!$disabled)
                                    <td>
                                        <a href="javascript:;" data-repeater-delete=""
                                            class="btn btn-sm btn-icon btn-danger mr-2 rating_detail_delete">
                                            <i class="flaticon-delete"></i></a>
                                    </td>
                                @endif --}}
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="rating_detail_row">
                            <td class="rating-list-no">1</td>
                            <input type="hidden" name="rating_item_id" class="rating_item_id" value="" class="contractorRatingDetailId">
                            <td>
                                {!! Form::hidden('item_agency_id', null, ['class' => 'form-control item_agency_id',]) !!}
                                {!! Form::hidden('item_rating_id', null, ['class' => 'form-control item_rating_id',]) !!}
                                {!! Form::text('agency_name', null, [
                                    'class' => 'form-control agency_name form-control-solid',
                                    'readonly',
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::text('rating', null, [
                                    'class' => 'form-control rating form-control-solid',
                                    'readonly',
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::textarea("rating_remarks", null, ['class' => 'form-control rating_remarks form-control-solid', 'data-rule-Remarks' => true, 'rows' => 2, 'cols' => 2, 'readonly']) !!}
                            </td>
                            <td>
                                {!! Form::date("rating_date", null, ['class' => 'form-control rating_date form-control-solid', 'readonly']) !!}
                            </td>
                            <td>
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm btn-icon btn-danger mr-2 rating_detail_delete">
                                    <i class="flaticon-delete"></i></a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12 d-none">
                <button type="button" data-repeater-create=""
                    class="btn btn-outline-primary btn-sm add_rating_detail"><i class="fa fa-plus-circle"></i>
                    Add</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- @dd($dms_data) --}}
    <div class="col-6 form-group jsDivClass">
        <div class="d-block">
            {!! Form::label('company_details', __('principle.company_details')) !!}
        </div>

        <div class="d-block">
            {!! Form::file('company_details[]', [
                'class' => 'company_details jsDocument form-control',
                'id' => 'company_details',
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
                $data_company_details = isset($dms_data) && isset($dms_data['company_details']) ? count($dms_data['company_details']) : 0;
                $dsbtcls = $data_company_details == 0 ? 'disabled' : '';
            @endphp
            @if(!isset($proposals->id))
                <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                    data-target-modal="#commonModalID"
                    data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'company_details', 'dmsable_type' => 'Proposal']) }}"
                    class="call-modal JsCompanyDetails navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="company_details"
                    data-delete="jsCompanyDetailsDeleted">
                    {{-- <span class="navi-icon"><span class="length_company_details"
                            data-company_details ='{{ $data_company_details }}'>{{ $data_company_details }}</span>&nbsp;Document</span> --}}
                        <span class = "count_company_details" data-count_company_details = ""></span>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#company_details_modal"
                class="call-modal JsCompanyDetails jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyDetailsDeleted" data-prefix="company_details"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                {{-- <span class="navi-icon"><span class="length_company_details"
                    data-company_details ='{{ $data_company_details }}'>{{ $data_company_details }}</span>&nbsp;Document</span> --}}
                        <span class = "count_company_details" data-count_company_details = "{{ $data_company_details }}">{{ $data_company_details }}&nbsp;document</span>
                </a>

                <div class="modal fade" tabindex="-1" id="company_details_modal">
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
                                @if (isset($dms_data) && isset($dms_data['company_details']) && count($dms_data['company_details']) > 0)
                                    @foreach ($dms_data['company_details'] as $documents)
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
                                    <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('company_technical_details', __('principle.company_technical_details')) !!}
        {!! Form::file('company_technical_details[]', [
            'class' => 'company_technical_details jsDocument form-control',
            'id' => 'company_technical_details',
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
            $data_company_technical_details = isset($dms_data) && isset($dms_data['company_technical_details']) ? count($dms_data['company_technical_details']) : 0;

            $dsbtcls = $data_company_technical_details == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsCompanyTechnicalDetails navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="company_technical_details"
                data-delete="jsCompanyTechnicalDetailsDeleted">
                {{-- <span class="navi-icon"><span class="length_company_technical_details"
                        data-company_technical_details ='{{ $data_company_technical_details }}'>{{ $data_company_technical_details }}</span>&nbsp;Document</span> --}}
                <span class = "count_company_technical_details" data-count_company_technical_details = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#company_technical_details_modal"
            class="call-modal JsCompanyTechnicalDetails jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyTechnicalDetailsDeleted" data-prefix="company_technical_details"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_company_technical_details"
                data-company_technical_details ='{{ $data_company_technical_details }}'>{{ $data_company_technical_details }}</span>&nbsp;Document</span> --}}
                <span class = "count_company_technical_details" data-count_company_technical_details = "{{ $data_company_technical_details }}">{{ $data_company_technical_details }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="company_technical_details_modal">
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
                            @if (isset($dms_data) && isset($dms_data['company_technical_details']) && count($dms_data['company_technical_details']) > 0)
                                @foreach ($dms_data['company_technical_details'] as $documents)
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('company_presentation', __('principle.company_presentation')) !!}
        {!! Form::file('company_presentation[]', [
            'class' => 'company_presentation jsDocument form-control',
            'id' => 'company_presentation',
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
            $data_company_presentation = isset($dms_data) && isset($dms_data['company_presentation']) ? count($dms_data['company_presentation']) : 0;

            $dsbtcls = $data_company_presentation == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsCompanyPresentation navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="company_presentation"
                data-delete="jsCompanyPresentationDeleted">
                {{-- <span class="navi-icon"><span class="length_company_presentation"
                        data-company_presentation ='{{ $data_company_presentation }}'>{{ $data_company_presentation }}</span>&nbsp;Document</span> --}}
                <span class = "count_company_presentation" data-count_company_presentation = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#company_presentation_modal"
            class="call-modal JsCompanyPresentation jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyPresentationDeleted" data-prefix="company_presentation"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_company_presentation"
                data-company_presentation ='{{ $data_company_presentation }}'>{{ $data_company_presentation }}</span>&nbsp;Document</span> --}}
                <span class = "count_company_presentation" data-count_company_presentation = "{{ $data_company_presentation }}">{{ $data_company_presentation }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="company_presentation_modal">
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
                            @if (isset($dms_data) && isset($dms_data['company_presentation']) && count($dms_data['company_presentation']) > 0)
                                @foreach ($dms_data['company_presentation'] as $documents)
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

    <div class="col-6 form-group">
        {!! Form::label(__('principle.are_you_blacklisted'), __('principle.are_you_blacklisted')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('are_you_blacklisted', 'Yes', null, ['class' => 'are_you_blacklisted', $disabled]) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('are_you_blacklisted', 'No', true, ['class' => 'are_you_blacklisted', $disabled]) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('certificate_of_incorporation', __('principle.certificate_of_incorporation')) !!}<i class="text-danger">*</i>
        {!! Form::file('certificate_of_incorporation[]', [
            'class' => 'certificate_of_incorporation jsDocument form-control',
            'id' => 'certificate_of_incorporation',
            // isset($dms_data) && !empty($dms_data['certificate_of_incorporation']) ? '' : 'required',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            $disabled,
        ]) !!}

        @php
            $data_certificate_of_incorporation = isset($dms_data) && isset($dms_data['certificate_of_incorporation']) ? count($dms_data['certificate_of_incorporation']) : 0;

            $dsbtcls = $data_certificate_of_incorporation == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsCertificateofIncorporation navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="certificate_of_incorporation"
                data-delete="jsCertificateofIncorporationDeleted">
                {{-- <span class="navi-icon"><span class="length_certificate_of_incorporation"
                        data-certificate_of_incorporation ='{{ $data_certificate_of_incorporation }}'>{{ $data_certificate_of_incorporation }}</span>&nbsp;Document</span> --}}
                <span class = "count_certificate_of_incorporation" data-count_certificate_of_incorporation = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#certificate_of_incorporation_modal"
            class="call-modal JsCertificateofIncorporation jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsCertificateofIncorporationDeleted" data-prefix="certificate_of_incorporation"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_certificate_of_incorporation"
                data-certificate_of_incorporation ='{{ $data_certificate_of_incorporation }}'>{{ $data_certificate_of_incorporation }}</span>&nbsp;Document</span> --}}
                <span class = "count_certificate_of_incorporation" data-count_certificate_of_incorporation = "{{ $data_certificate_of_incorporation }}">{{ $data_certificate_of_incorporation }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="certificate_of_incorporation_modal">
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
                            @if (isset($dms_data) && isset($dms_data['certificate_of_incorporation']) && count($dms_data['certificate_of_incorporation']) > 0)
                                @foreach ($dms_data['certificate_of_incorporation'] as $documents)
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('memorandum_and_articles', __('principle.memorandum_and_articles')) !!}<i class="text-danger">*</i>
        {!! Form::file('memorandum_and_articles[]', [
            'class' => 'memorandum_and_articles jsDocument form-control',
            'id' => 'memorandum_and_articles',
            // isset($dms_data) && !empty($dms_data['memorandum_and_articles']) ? '' : 'required',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            $disabled,
        ]) !!}

        @php
            $data_memorandum_and_articles = isset($dms_data) && isset($dms_data['memorandum_and_articles']) ? count($dms_data['memorandum_and_articles']) : 0;

            $dsbtcls = $data_memorandum_and_articles == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsMemorandumAndArticles navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="memorandum_and_articles"
                data-delete="jsMemorandumAndArticlesDeleted">
                {{-- <span class="navi-icon"><span class="length_memorandum_and_articles"
                        data-memorandum_and_articles ='{{ $data_memorandum_and_articles }}'>{{ $data_memorandum_and_articles }}</span>&nbsp;Document</span> --}}
                <span class = "count_memorandum_and_articles" data-count_memorandum_and_articles = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#memorandum_and_articles_modal"
            class="call-modal JsMemorandumAndArticles jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsMemorandumAndArticlesDeleted" data-prefix="memorandum_and_articles"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_memorandum_and_articles"
                data-memorandum_and_articles ='{{ $data_memorandum_and_articles }}'>{{ $data_memorandum_and_articles }}</span>&nbsp;Document</span> --}}
                <span class = "count_memorandum_and_articles" data-count_memorandum_and_articles = "{{ $data_memorandum_and_articles }}">{{ $data_memorandum_and_articles }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="memorandum_and_articles_modal">
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
                            @if (isset($dms_data) && isset($dms_data['memorandum_and_articles']) && count($dms_data['memorandum_and_articles']) > 0)
                                @foreach ($dms_data['memorandum_and_articles'] as $documents)
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

    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label('gst_certificate', __('principle.gst_certificate')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        </div>

        <div class="d-block jsDivClass">
            {!! Form::file('gst_certificate[]', [
                'class' => 'gst_certificate jsDocument form-control',
                'id' => 'gst_certificate',
                // isset($dms_data) && !empty($dms_data['gst_certificate']) ? '' : 'required',
                'multiple',
                'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                $disabled,
            ]) !!}

            @php
                $data_gst_certificate = isset($dms_data) && isset($dms_data['gst_certificate']) ? count($dms_data['gst_certificate']) : 0;
                $dsbtcls = $data_gst_certificate == 0 ? 'disabled' : '';
            @endphp

            @if(!isset($proposals->id))
                <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                    data-target-modal="#commonModalID"
                    data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Proposal']) }}"
                    class="call-modal JsGstCertificate navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="gst_certificate"
                    data-delete="jsGstCertificateDeleted">
                    {{-- <span class="navi-icon"><span class="length_gst_certificate"
                            data-gst_certificate ='{{ $data_gst_certificate }}'>{{ $data_gst_certificate }}</span>&nbsp;Document</span> --}}
                    <span class = "count_gst_certificate" data-count_gst_certificate = ""></span>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#gst_certificate_modal"
                class="call-modal JsGstCertificate jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsGstCertificateDeleted" data-prefix="gst_certificate"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                {{-- <span class="navi-icon"><span class="length_gst_certificate"
                    data-gst_certificate ='{{ $data_gst_certificate }}'>{{ $data_gst_certificate }}</span>&nbsp;Document</span> --}}
                    <span class = "count_gst_certificate" data-count_gst_certificate = "{{ $data_gst_certificate }}">{{ $data_gst_certificate }}&nbsp;document</span>
                </a>

                <div class="modal fade" tabindex="-1" id="gst_certificate_modal">
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
                                @if (isset($dms_data) && isset($dms_data['gst_certificate']) && count($dms_data['gst_certificate']) > 0)
                                    @foreach ($dms_data['gst_certificate'] as $documents)
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

    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label('company_pan_no', __('principle.company_pan_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        </div>

        <div class="d-block jsDivClass">
            {!! Form::file('company_pan_no[]', [
                'class' => 'company_pan_no jsDocument form-control',
                'id' => 'company_pan_no',
                // isset($dms_data) && !empty($dms_data['company_pan_no']) ? '' : 'required',
                'multiple',
                'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                $disabled,
            ]) !!}
            @php
                $data_company_pan_no = isset($dms_data) && isset($dms_data['company_pan_no']) ? count($dms_data['company_pan_no']) : 0;
                $dsbtcls = $data_company_pan_no == 0 ? 'disabled' : '';
            @endphp

            @if(!isset($proposals->id))
                <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                    data-target-modal="#commonModalID"
                    data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Proposal']) }}"
                    class="call-modal JsCompanyPanNo navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="company_pan_no"
                    data-delete="jsCompanyPannoDeleted">
                    {{-- <span class="navi-icon"><span class="length_company_pan_no"
                            data-company_pan_no ='{{ $data_company_pan_no }}'>{{ $data_company_pan_no }}</span>&nbsp;Document</span> --}}
                    <span class = "count_company_pan_no" data-count_company_pan_no = ""></span>
                </a>
            @else
                <a href="#" data-toggle="modal" data-target="#company_pan_no_modal"
                class="call-modal JsCompanyPanNo jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyPannoDeleted" data-prefix="company_pan_no"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                {{-- <span class="navi-icon"><span class="length_company_pan_no"
                    data-company_pan_no ='{{ $data_company_pan_no }}'>{{ $data_company_pan_no }}</span>&nbsp;Document</span> --}}
                    <span class = "count_company_pan_no" data-count_company_pan_no = "{{ $data_company_pan_no }}">{{ $data_company_pan_no }}&nbsp;document</span>
                </a>

                <div class="modal fade" tabindex="-1" id="company_pan_no_modal">
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
                                @if (isset($dms_data) && isset($dms_data['company_pan_no']) && count($dms_data['company_pan_no']) > 0)
                                    @foreach ($dms_data['company_pan_no'] as $documents)
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('last_three_years_itr', __('principle.last_three_years_itr')) !!}
        {!! Form::file('last_three_years_itr[]', [
            'class' => 'last_three_years_itr jsDocument form-control',
            'id' => 'last_three_years_itr',
            empty($dms_data) ? '' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            $disabled,
        ]) !!}

        @php
            $data_last_three_years_itr = isset($dms_data) && isset($dms_data['last_three_years_itr']) ? count($dms_data['last_three_years_itr']) : 0;

            $dsbtcls = $data_last_three_years_itr == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsLastThreeYearsItr navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="last_three_years_itr"
                data-delete="jsLastThreeYearsItrDeleted">
                {{-- <span class="navi-icon"><span class="length_last_three_years_itr"
                        data-last_three_years_itr ='{{ $data_last_three_years_itr }}'>{{ $data_last_three_years_itr }}</span>&nbsp;Document</span> --}}
                <span class = "count_last_three_years_itr" data-count_last_three_years_itr = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#last_three_years_itr_modal"
            class="call-modal JsLastThreeYearsItr jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsLastThreeYearsItrDeleted" data-prefix="last_three_years_itr"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_last_three_years_itr"
                data-last_three_years_itr ='{{ $data_last_three_years_itr }}'>{{ $data_last_three_years_itr }}</span>&nbsp;Document</span> --}}
                <span class = "count_last_three_years_itr" data-count_last_three_years_itr = "{{ $data_last_three_years_itr }}">{{ $data_last_three_years_itr }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="last_three_years_itr_modal">
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
                            @if (isset($dms_data) && isset($dms_data['last_three_years_itr']) && count($dms_data['last_three_years_itr']) > 0)
                                @foreach ($dms_data['last_three_years_itr'] as $documents)
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

    {{-- <div class="col-4 form-group">
        {!! Form::label(__('principle.type_of_entity'), __('principle.type_of_entity')) !!}<i class="text-danger">*</i>
        {!! Form::select('type_of_entity_id', ['' => 'Select Type of Entity'] + $type_of_entity, null, [
            'class' => 'form-control ',
            'style' => 'width:100%;',
            'id' => 'type_of_entity',
            'data-placeholder' => 'Select Type of Entity',
        ]) !!}
    </div> --}}
</div>