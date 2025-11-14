<div class="card card-custom gutter-b">

    <div class="card-body">
        <form class="form">
            <div class="row g-3">
                <div class="col-md-8"></div>
                <div class=" form-group col-4 mb-5">
                    <label class=" col-form-label text-right">{{ __('beneficiary.bin') }} <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-12">
                        @if ($beneficiary)
                            {!! Form::text('code', $beneficiary->code ?? null, [
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
                {!! Form::hidden('user_id', $beneficiary->user_id ?? null) !!}

                {{-- <div class="col-4 form-group">
                    {!! Form::label('company_code', __('beneficiary.company_code')) !!}<i class="text-danger">*</i>
                    {!! Form::text('company_code', null, [
                        'class' => 'form-control required',
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'company_code',
                            'model' => 'beneficiaries',
                            'id' => $beneficiary['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'Company Code has already been taken.',
                        'data-rule-AlphabetsAndNumbersV2' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('reference_code', __('beneficiary.reference_code')) !!}<i class="text-danger">*</i>
                    {!! Form::text('reference_code', null, [
                        'class' => 'form-control required',
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'reference_code',
                            'model' => 'beneficiaries',
                            'id' => $beneficiary['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'Reference Code has already been taken.',
                        'data-rule-AlphabetsAndNumbersV2' => true,
                    ]) !!}
                </div> --}}

                <div class="col-6 form-group">
                    {!! Form::label('registration_no', __('beneficiary.registration_no')) !!}<i class="text-danger">*</i>
                    {!! Form::text('registration_no', null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsAndNumbersV2' => true,
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('company_name', __('common.company_name')) !!}<i class="text-danger">*</i>
                    {{ Form::text('company_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV8' => true,]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('email', __('common.email')) !!}<i class="text-danger">*</i>

                    {{ Form::text('email', $beneficiary->user->email ?? null, [
                        'class' => 'form-control email',
                        'required',
                        'data-rule-remote' => route('common.checkUniqueEmail', [
                            'id' => $beneficiary['user_id'] ?? '',
                        ]),
                        'data-msg-remote' => 'The email has already been taken.',
                    ]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('phone_no', __('common.phone_no')) !!}
                    {{ Form::text('mobile', $beneficiary->user->mobile ?? null, ['class' => 'form-control number', 'data-rule-MobileNo' => true, 'data-rule-remote' => route('common.checkUniqueMobile', [
                        'field' => 'mobile',
                        'model' => 'users',
                        'role' => 'beneficiary',
                        'id' => $beneficiary['user_id'] ?? '',
                    ]),
                    'data-msg-remote' => 'Phone No. has already been taken.',]) }}
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('address', __('common.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'address form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true,]) }}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('website', __('beneficiary.website')) !!}
                    {!! Form::url('website', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('country', __('common.country')) !!}<i class="text-danger">*</i>
                    {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'country',
                        'data-placeholder' => 'Select country',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('state', __('common.state')) !!}<i class="text-danger">*</i>
                    {!! Form::select('state_id', ['' => 'Select State'] + $states, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'state',
                        'data-placeholder' => 'Select state',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('city', __('common.city')) !!}<i class="text-danger">*</i>
                    {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true,]) }}
                </div>
            </div>
            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('pincode', __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
                    {{ Form::text('pincode', $principle->pincode ?? null, ['class' => 'form-control jsPinCode pin_code',]) }}
                </div>
                <div class="col-4 form-group gstAndPanNoFields {{ $isCountryIndia ? '' : 'd-none' }}">
                    {!! Form::label('gst_no', __('common.gst_no')) !!}<i class="text-danger">*</i>

                    {{ Form::text('gst_no', null, [
                        'class' => 'form-control gst_no',
                        'required',
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'gst_no',
                            'model' => 'beneficiaries',
                            'id' => $beneficiary['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'GST No. has already been taken.',
                        'data-rule-GstNo' => true,
                    ]) }}
                </div>

                <div class="col-4 form-group gstAndPanNoFields {{ $isCountryIndia ? '' : 'd-none' }}">
                    {!! Form::label('pan_no', __('common.pan_no')) !!}<i class="text-danger">*</i>

                    {{ Form::text('pan_no', null, [
                        'class' => 'form-control pan_no required',
                        'data-rule-remote' => route('common.checkUniquePanNumber', [
                            'field' => 'beneficiaries',
                            'id' => $beneficiary['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'PAN No. has already been taken.',
                        'data-rule-PanNo' => true,
                    ]) }}
                </div>
            </div>
            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('beneficiary_type', __('beneficiary.beneficiary_type')) !!}<i class="text-danger">*</i>

                    <div class="radio-inline">
                        <label class="radio">
                            {{ Form::radio('beneficiary_type', 'Government', true, ['class' => 'form-check-input required beneficiary_type', 'id' => '']) }}
                            <span></span>Government
                        </label>
                        <label class="radio">
                            {{ Form::radio('beneficiary_type', 'Non-Government', '', ['class' => 'form-check-input required beneficiary_type', 'id' => '']) }}
                            <span></span>Non-Government
                        </label>
                    </div>
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('establishment_type_id', __('beneficiary.establishment_type')) !!}<i class="text-danger">*</i>
                    {!! Form::select('establishment_type_id', ['' => 'Select Establishment Type'] + $establishment_type, null, [
                        'class' => 'form-control jsSelect2ClearAllow required',
                        'style' => 'width:100%;',
                        'id' => 'establishment_type',
                        'data-placeholder' => 'Select Establishment Type',
                    ]) !!}
                </div>

                <div class="col-4 form-group ministryType {{ isset($beneficiary) && $beneficiary->beneficiary_type == 'Non-Government' ? 'd-none' : ''}}">
                    {!! Form::label('ministry_type_id', __('beneficiary.ministry_type')) !!}<i class="text-danger">*</i>
                    {!! Form::select(
                        'ministry_type_id',
                        ['' => ''] + $ministry_type_id,
                        null,
                        [
                            'class' => 'form-control jsSelect2ClearAllow',
                            'style' => 'width:100%;',
                            'id' => 'ministry_type',
                            'data-placeholder' => 'Select Ministry Type',
                        ],
                    ) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-5 form-group">
                    {!! Form::label('bond_wording', __('beneficiary.bond_wording')) !!}
                    {{ Form::textarea('bond_wording', null, ['class' => 'form-control', 'rows' => 2,  'data-rule-AlphabetsAndNumbersV3' => true,]) }}
                </div>

                <div class="col-3 form-group jsDivClass">
                    {!! Form::label('bond_attachment', __('beneficiary.bond_attachment')) !!}
                    {!! Form::file('bond_attachment[]',
                    [
                        'class' => 'bond_attachment jsDocument',
                        'id' => 'bond_attachment',
                        // empty($dms_data) ? 'required' : '',
                        'multiple', 'maxfiles' => 5,
                        'maxsizetotal' => '52428800',
                        'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                        'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                        ]) !!}
                    {{-- @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data))
                        <span> <a href="{{ asset($dms_data->attachment) }}"
                                target="_blank">{{ $dms_data->file_name ?? '' }}</a></span>
                    @endif --}}
                    @php
                        $data_bond_attachment = isset($dms_data) ? count($dms_data) : 0;

                        $dsbtcls = $data_bond_attachment == 0 ? 'disabled' : '';
                    @endphp
                    {{-- <a href="{{ route('dMSDocument', $beneficiary->id ?? '') }}" data-toggle="modal"
                        data-target-modal="#commonModalID"
                        data-url="{{ route('dMSDocument', ['id' => $beneficiary->id ?? '', 'attachment_type' => 'bond_attachment', 'dmsable_type' => 'Beneficiary']) }}"
                        class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="bond_attachment"
                        data-delete="jsBondAttachmentDeleted">
                        <span class="navi-icon"><span class="length_bond_attachment"
                                data-bond_attachment ='{{ $data_bond_attachment }}'>{{ $data_bond_attachment }}</span>&nbsp;Document</span>
                    </a> --}}

                    <a href="#" data-toggle="modal" data-target="#bond_attachment_modal"
                    class="call-modal JsBondAttachment jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsBondAttachmentDeleted" data-prefix="bond_attachment"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                        <span class = "count_bond_attachment" data-count_bond_attachment = "{{ $data_bond_attachment }}">{{ $data_bond_attachment }}&nbsp;document</span>
                    </a>

                    <div class="modal fade" tabindex="-1" id="bond_attachment_modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bond Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <a class="jsFileRemove"></a>
                                    @if (isset($beneficiary) && isset($dms_data) && count($dms_data) > 0)
                                        @foreach ($dms_data as $index => $documents)
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <span class="dms_bond_attachment">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="bond_attachment" data-url="{{ route('removeDmsAttachment') }}"
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

            <div class="row">
                <div class="form-group col-12">
                    <div id="tradeSectorRepeater">
                        <table class="table table-separate table-head-custom table-checkable tradeSector" id="machine"
                            data-repeater-list="tradeSector">
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
                                <span class="text-danger item-dul-error d-none">Duplicate trade sector is select.</span> 
                                @if (isset($beneficiaryTradeSector) && $beneficiaryTradeSector->count() > 0)
                                    @foreach ($beneficiaryTradeSector as $key => $item)
                                        <tr data-repeater-item="" class="trade_sector_row">
                                            <td class="trade-list-no">{{ ++$key }} . </td>
                                            <input type="hidden" name="trade_item_id" value="{{ $item->id }}">
                                            <td>
                                                {!! Form::select('trade_sector_id', ['' => ''] + $trade_sector_id, $item->trade_sector_id, [
                                                    'class' => 'form-control required trade_sector jsTradeSector',
                                                    'data-placeholder' => 'Select Trade Sector',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::date('from', $item->from, ['class' => 'form-control required from', 'max' => now()->toDateString()]) !!}
                                            </td>
                                            <td>
                                                {!! Form::date('till', $item->till, ['class' => 'form-control till minDate']) !!}
                                            </td>
                                            <td class="pl-5 pt-6">
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        {{ Form::radio('is_main', 'Yes', $item->is_main == 'Yes' ? true : false, ['class' => 'form-check-input main', 'id' => 'main']) }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;" data-repeater-delete=""
                                                    class="btn btn-sm btn-icon btn-danger mr-2 trade_sector_delete">
                                                    <i class="flaticon-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr data-repeater-item="" class="trade_sector_row">
                                        <td class="trade-list-no">1</td>
                                        <td>
                                            {!! Form::select('trade_sector_id', ['' => ''] + $trade_sector_id ?? '', null, [
                                                'class' => 'form-control required trade_sector jsTradeSector',
                                                'data-placeholder' => 'Select Trade Sector',
                                            ]) !!}
                                        </td>
                                        <td>
                                            {!! Form::date('from', null, ['class' => 'form-control required from' ,'max' => now()->toDateString()]) !!}
                                        </td>
                                        <td>
                                            {!! Form::date('till', null, ['class' => 'form-control till minDate']) !!}
                                        </td>
                                        <td class="pl-5 pt-6">
                                            <div class="radio-inline">
                                                <label class="radio">
                                                    {{ Form::radio('is_main', 'Yes', true, ['class' => 'form-check-input main', 'id' => 'main']) }}
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
                        <div class="col-md-12 col-12">
                            <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm trade_sector_create"><i class="fa fa-plus-circle"></i> Add</button>
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

@section('scripts')
    @include('beneficiary.script')
@endsection
