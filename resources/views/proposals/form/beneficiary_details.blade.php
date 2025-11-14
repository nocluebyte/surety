<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('beneficiary_id', __('tender.beneficiary')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_id', ['' => ''] + $beneficiaries, null, [
            'class' => 'form-control beneficiary_id jsSelect2ClearAllow required',
            'style' => 'width:100%;',
            'data-placeholder' => 'Select Beneficiary',
            'data-ajaxurl' => route('getBeneficiaryData'),
            $disabled,
            // $typeStandAlone,
        ]) !!}
    </div>

    <div class="col-6 form-group text-right">
        <a type="button" href="{{ route('beneficiary.create') }}" class="btn btn-outline-primary btn-sm mt-7" target="_blank">
            <i class="fa fa-plus-circle" style="padding: 0%;"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('beneficiary_registration_no', __('beneficiary.registration_no')) !!}<i class="text-danger">*</i>
        {!! Form::text('beneficiary_registration_no', null, [
            'class' => 'form-control beneficiary_registration_no required ' . $readonly_cls,
            'data-rule-AlphabetsAndNumbersV2' => true,
            $readonly,
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('beneficiary_company_name', __('common.company_name')) !!}<i class="text-danger">*</i>
        {{ Form::text('beneficiary_company_name', null, ['class' => 'form-control required beneficiary_company_name ' . $readonly_cls, 'data-rule-AlphabetsAndNumbersV8' => true, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('beneficiary_email', __('common.email')) !!}
        {{ Form::email('beneficiary_email', null, [
            'class' => 'form-control email beneficiary_email ' . $readonly_cls,
            $readonly,
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('beneficiary_phone_no', __('common.phone_no')) !!}
        {{ Form::text('beneficiary_phone_no', null, ['class' => 'form-control number  beneficiary_phone_no ' . $readonly_cls, 'data-rule-MobileNo' => true, $readonly]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('beneficiary_address', __('common.address')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('beneficiary_address', null, ['class' => 'beneficiary_address form-control required ' . $readonly_cls, 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true, $readonly]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('beneficiary_website', __('beneficiary.website')) !!}
        {!! Form::url('beneficiary_website', null, ['class' => 'form-control beneficiary_website ' . $readonly_cls, $readonly]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('country', __('common.country')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_country_id', ['' => ''] + $countries, null, [
            'class' => 'form-control beneficiary_country_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'beneficiary_country_id',
            'data-placeholder' => 'Select country',
            $disabled,
            'data-ajaxurl' => route('getCurrencySymbol', ['id' => '__id__']),
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('state', __('common.state')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_state_id', ['' => ''] + $states, null, [
            'class' => 'form-control beneficiary_state_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'beneficiary_state_id',
            'data-placeholder' => 'Select state',
            $disabled,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('beneficiary_city', __('common.city')) !!}<i class="text-danger">*</i>
        {{ Form::text('beneficiary_city', null, ['class' => 'form-control required beneficiary_city ' . $readonly_cls, 'data-rule-AlphabetsV1' => true, $readonly,]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('beneficiary_pincode', __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
        {{ Form::text('beneficiary_pincode', $principle->pincode ?? null, ['class' => 'form-control jsPinCodeBeneficiary beneficiary_pincode ' . $readonly_cls, $readonly,]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group beneficiaryGstAndPanNoFields {{ $isBeneCountryIndia ? '' : 'd-none' }}">
        {!! Form::label('beneficiary_gst_no', __('common.gst_no')) !!}<i class="text-danger">*</i>
        {{ Form::text('beneficiary_gst_no', null, [
            'class' => 'form-control beneficiary_gst_no ' . $readonly_cls,
            $readonly,
        ]) }}
    </div>

    <div class="col-6 form-group beneficiaryGstAndPanNoFields {{ $isBeneCountryIndia ? '' : 'd-none' }}">
        {!! Form::label('beneficiary_pan_no', __('common.pan_no')) !!}<i class="text-danger">*</i>
        {{ Form::text('beneficiary_pan_no', null, [
            'class' => 'form-control beneficiary_pan_no ' . $readonly_cls,
            $readonly,
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('same_as_above', __('proposals.same_as_above')) !!}

        <div class="checkbox-inline pt-1">
            <label class="checkbox checkbox-square">
                {!! Form::checkbox('beneficiary_same_as_above', 'Yes', null, [
                    'class' => 'beneficiary_same_as_above',
                    $disabled,
                ]) !!}
                <span></span>
                {!! Form::label('same_as_above', null, ['class' => 'mt-2 beneficiary_same_as_above']) !!}
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('beneficiary_bond_address', __('proposals.bond_address')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('beneficiary_bond_address', null, [
            'class' => 'form-control beneficiary_bond_address JsNotJvSpv required ' . $readonly_cls,
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
        {!! Form::select('beneficiary_bond_country_id', ['' => ''] + $countries, null, [
            'class' => 'form-control beneficiary_bond_country_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'beneficiary_bond_country_id',
            'data-placeholder' => 'Select country',
            // 'data-ajaxurl' => route('getCountryName'),
            $disabled,
            // 'disabled',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_bond_state_id', ['' => ''] + $states, null, [
            'class' => 'form-control beneficiary_bond_state_id jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'id' => 'beneficiary_bond_state_id',
            'data-placeholder' => 'Select state',
            $disabled,
            // 'disabled',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
        {{ Form::text('beneficiary_bond_city', null, [
            'class' => 'form-control required beneficiary_bond_city ' . $readonly_cls, 
            'data-rule-AlphabetsV1' => true, 
            $readonly, 
            // 'readonly',
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.pincode'), __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
        {{ Form::text('beneficiary_bond_pincode', $principle->pincode ?? null, [
            'class' => 'form-control jsPinCodeBeneficiaryBond required beneficiary_bond_pincode ' . $readonly_cls, 
            // 'data-rule-PinCode' => true, 
            $readonly, 
            // 'readonly'
            ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group beneficiaryBondGstNo {{ $isAddBeneCountryIndia ? '' : 'd-none' }}">
        {!! Form::label(__('common.gst_no'), __('common.gst_no')) !!}<i class="text-danger">*</i>

        {{ Form::text('beneficiary_bond_gst_no', null, [
            'class' => 'form-control beneficiary_bond_gst_no ' . $readonly_cls,
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
    <div class="col-4 form-group">
        {!! Form::label('beneficiary_type', __('beneficiary.beneficiary_type')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('beneficiary_type', 'Government', true, ['class' => 'form-check-input beneficiary_type', 'id' => '', $disabled,]) }}
                <span></span>Government
            </label>
            <label class="radio">
                {{ Form::radio('beneficiary_type', 'Non-Government', '', ['class' => 'form-check-input beneficiary_type', 'id' => '', $disabled,]) }}
                <span></span>Non-Government
            </label>
        </div>
    </div>

    <div class="col-4 form-group">
        {!! Form::label('establishment_type_id', __('beneficiary.establishment_type')) !!}<i class="text-danger">*</i>
        {!! Form::select('establishment_type_id', ['' => 'Select Establishment Type'] + $establishment_type, null, [
            'class' => 'form-control jsSelect2ClearAllow required establishment_type_id',
            'style' => 'width:100%;',
            'id' => 'establishment_type',
            'data-placeholder' => 'Select Establishment Type',
            $disabled,
        ]) !!}
    </div>

    <div class="col-4 form-group ministryType {{ isset($beneficiary) && $beneficiary->beneficiary_type == 'Non-Government' ? 'd-none' : ''}}">
        {!! Form::label('ministry_type_id', __('beneficiary.ministry_type')) !!}<i class="text-danger">*</i>
        {!! Form::select(
            'ministry_type_id',
            ['' => ''] + $ministry_type_id,
            null,
            [
                'class' => 'form-control jsSelect2ClearAllow ministry_type',
                'style' => 'width:100%;',
                'id' => 'ministry_type',
                'data-placeholder' => 'Select Ministry Type',
                $disabled,
            ],
        ) !!}
    </div>
</div>

<div class="row">
    <div class="col-8 form-group">
        {!! Form::label('beneficiary_bond_wording', __('beneficiary.bond_wording')) !!}
        {{ Form::textarea('beneficiary_bond_wording', null, ['class' => 'form-control beneficiary_bond_wording ' . $readonly_cls, 'rows' => 2,  'data-rule-AlphabetsAndNumbersV3' => true, $readonly,]) }}
    </div>

    <div class="col-4 form-group jsDivClass">
        {!! Form::label('bond_attachment', __('beneficiary.bond_attachment')) !!}
        {!! Form::file('bond_attachment[]',
        [
        'class' => 'bond_attachment jsDocument form-control',
        'id' => 'bond_attachment',
        // empty($dms_data) ? '' : '',
        'multiple', 'maxfiles' => 5,
        'maxsizetotal' => '52428800',
        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        $disabled,
        ]) !!}

        @php
            $data_bond_attachment = isset($dms_data) && isset($dms_data['bond_attachment']) ? count($dms_data['bond_attachment']) : 0;

            $dsbtcls = $data_bond_attachment == 0 ? 'disabled' : '';
        @endphp

        @if(!isset($proposals->id))
            <a href="{{ route('dMSDocument', $proposals->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $proposals->id ?? '', 'attachment_type' => 'bond_attachment', 'dmsable_type' => 'Proposal']) }}"
                class="call-modal JsBondAttachment navi-link jsShowProposalDocument {{ $dsbtcls }}" data-prefix="bond_attachment"
                data-delete="jsBondAttachmentDeleted">
                {{-- <span class="navi-icon"><span class="length_bond_attachment"
                        data-bond_attachment ='{{ $data_bond_attachment }}'>{{ $data_bond_attachment }}</span>&nbsp;Document</span> --}}
                <span class = "count_bond_attachment" data-count_bond_attachment = ""></span>
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#bond_attachment_modal"
            class="call-modal JsBondAttachment jsShowProposalDocument navi-link {{ $dsbtcls }}" data-delete="jsBondAttachmentDeleted" data-prefix="bond_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            {{-- <span class="navi-icon"><span class="length_bond_attachment"
                data-bond_attachment ='{{ $data_bond_attachment }}'>{{ $data_bond_attachment }}</span>&nbsp;Document</span> --}}
                <span class = "count_bond_attachment" data-count_bond_attachment = "{{ $data_bond_attachment }}">{{ $data_bond_attachment }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="bond_attachment_modal">
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
                            @if (isset($dms_data) && isset($dms_data['bond_attachment']) && count($dms_data['bond_attachment']) > 0)
                                @foreach ($dms_data['bond_attachment'] as $documents)
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
    <div class="form-group col-12">
        <div id="beneficiaryTradeSectorRepeater">
            <table class="table table-separate table-head-custom table-checkable JsBeneficiaryTradeSector beneficiary_trade_sector_repeater" id="machine"
                data-repeater-list="beneficiaryTradeSector">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th width="510">{{ __('beneficiary.trade_sector') }}<span class="text-danger">*</span></th>
                        <th>{{ __('beneficiary.from') }}<span class="text-danger">*</span></th>
                        <th>{{ __('beneficiary.till') }}</th>
                        <th>{{ __('beneficiary.main') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($proposals->proposalBeneficiaryTradeSector) --}}
                    <span class="text-danger item-dul-error d-none">Duplicate trade sector is select.</span> 
                    @if (isset($proposals->proposalBeneficiaryTradeSector) && $proposals->proposalBeneficiaryTradeSector->count() > 0)
                    {{-- @dd($proposals->proposalBeneficiaryTradeSector) --}}
                        @foreach ($proposals->proposalBeneficiaryTradeSector as $key => $item)
                            <tr data-repeater-item="" class="trade_sector_row beneficiary_trade_sector_row">
                                <td class="trade-list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="beneficiary_trade_item_id" value="{{ $item->id }}" class="beneficiaryTradeSectorId">
                                {!! Form::hidden("pbt_item_id", $item->contractor_fetch_reference_id ?? '') !!}
                                <td>
                                    {!! Form::select('beneficiary_trade_sector_id', ['' => ''] + $trade_sector_id, $item->trade_sector_id, [
                                        'class' => 'form-control  trade_sector jsTradeSector beneficiary_trade_sector_id',
                                        'data-placeholder' => 'Select Trade Sector',
                                        $disabled,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date('beneficiary_from', $item->from, ['class' => 'form-control beneficiary_from from ' . $readonly_cls, 'max' => now()->toDateString(), $readonly,]) !!}
                                </td>
                                <td>
                                    {!! Form::date('beneficiary_till', $item->till, ['class' => 'form-control till beneficiary_till beneficiaryMinDate minDate ' . $readonly_cls, $readonly,]) !!}
                                </td>
                                {{-- @dd($item->is_main) --}}
                                <td class="pl-5 pt-6">
                                    <div class="radio-inline">
                                        <label class="radio">
                                            {{ Form::radio('beneficiary_is_main', 'Yes', $item->is_main == 'Yes' ? true : false, ['class' => 'form-check-input beneficiary_is_main', $disabled,]) }}
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
                        <tr data-repeater-item="" class="trade_sector_row beneficiary_trade_sector_row">
                            <td class="trade-list-no">1</td>
                            <td>
                                <input type="hidden" name="beneficiary_trade_item_id" value="" class="beneficiaryTradeSectorId">
                                {!! Form::select('beneficiary_trade_sector_id', ['' => ''] + $trade_sector_id ?? '', null, [
                                    'class' => 'form-control required trade_sector jsTradeSector beneficiary_trade_sector_id',
                                    'data-placeholder' => 'Select Trade Sector',
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::date('beneficiary_from', null, ['class' => 'form-control required from beneficiary_from' ,'max' => now()->toDateString()]) !!}
                            </td>
                            <td>
                                {!! Form::date('beneficiary_till', null, ['class' => 'form-control till minDate beneficiary_till beneficiaryMinDate']) !!}
                            </td>
                            <td class="pl-5 pt-6">
                                <div class="radio-inline">
                                    <label class="radio">
                                        {{ Form::radio('beneficiary_is_main', 'Yes', true, ['class' => 'form-check-input beneficiary_is_main']) }}
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="trade_sector_delete">
                                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12 {{isset($is_amendment) && $is_amendment == 'yes' ? 'd-none' : ''}}">
                <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm trade_sector_create"><i class="fa fa-plus-circle"></i> Add</button>
            </div>
        </div>
    </div>
</div>