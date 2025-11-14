<div class="row g-3">
    <div class="col-md-8"></div>
    <div class=" form-group col-md-4 mb-5">
        <label class=" col-form-label text-right">{{ __('principle.cin') }} :<span class="text-danger">*</span></label>
        <div class="col-lg-12">
            @if ($principle)
                {!! Form::text('code', $principle->code ?? null, [
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
    <div class="col-4 form-group">
        {!! Form::label('venture_type', __('principle.venture_type')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('venture_type', 'JV', null, ['class' => 'venture_type']) }}
                <span></span>JV
            </label>
            <label class="radio">
                {{ Form::radio('venture_type', 'SPV', null, ['class' => 'venture_type']) }}
                <span></span>SPV
            </label>
            <label class="radio">
                {{ Form::radio('venture_type', 'Stand Alone', true, ['class' => 'venture_type']) }}
                <span></span>Stand Alone
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::hidden('user_id', $principle->user_id ?? null) !!}
        {!! Form::label(__('principle.registration_no'), __('principle.registration_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        {!! Form::text('registration_no', null, [
            'class' => 'form-control registration_no {{ isset($principle) && isset($principle->venture_type) && $principle->venture_type == "Stand Alone" ? "required" : "" }}',
            'data-rule-AlphabetsAndNumbersV2' => true,
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.company_name'), __('common.company_name')) !!}<i class="text-danger">*</i>
        {{ Form::text('company_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV8' => true]) }}
    </div>
</div>

{{-- <div class="row">
    {!! Form::hidden('user_id', $principle->user_id ?? null) !!}

    <div class="col-4 form-group">
        {!! Form::label(__('common.first_name'), __('common.first_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('first_name', $principle->user->first_name ?? null, [
            'class' => 'form-control required',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label(__('common.middle_name'), __('common.middle_name')) !!}
        {!! Form::text('middle_name', $principle->user->middle_name ?? null, [
            'class' => 'form-control',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label(__('common.last_name'), __('common.last_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('last_name', $principle->user->last_name ?? null, [
            'class' => 'form-control required',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>
</div> --}}

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('common.address'), __('common.address')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('principle.website'), __('principle.website')) !!}
        {!! Form::url('website', null, ['class' => 'form-control']) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.country'), __('common.country')) !!}<i class="text-danger">*</i>
        {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
            'class' => 'form-control required',
            'style' => 'width: 100%;',
            'id' => 'country',
            'data-placeholder' => 'Select country',
            // 'data-ajaxurl' => route('getCountryName'),
            'data-ajaxurl' => route('getCurrencySymbol', ['id' => '__id__']),
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.state'), __('common.state')) !!}<i class="text-danger">*</i>
        {!! Form::select('state_id', ['' => 'Select State'] + $states, null, [
            'class' => 'form-control required',
            'style' => 'width: 100%;',
            'id' => 'state',
            'data-placeholder' => 'Select state',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.city'), __('common.city')) !!}<i class="text-danger">*</i>
        {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.pincode'), __('common.pincode')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
        {{ Form::number('pincode', $principle->pincode ?? null, ['class' => 'form-control jsPinCode pin_code']) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('common.email'), __('common.email')) !!}<i class="text-danger">*</i>

        {{ Form::email('email', $principle->user->email ?? null, [
            'class' => 'form-control email',
            'required',
            'data-rule-remote' => route('common.checkUniqueEmail', [
                'id' => $principle['user_id'] ?? '',
            ]),
            'data-msg-remote' => 'The email has already been taken.',
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.gst_no'), __('common.gst_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>

        {{ Form::text('gst_no', null, [
            'class' => 'form-control gst_no ' . 
                ($jsVentureTypeRequired ? "required" : ""),
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'gst_no',
                'model' => 'principles',
                'id' => $principle['id'] ?? '',
            ]),
            'data-msg-remote' => 'GST No. has already been taken.',
            'data-rule-GstNo' => 'true',
        ]) }}
    </div>

    <div class="col-6 form-group gstAndPanNoFields {{ $isCountryIndia ? '' : 'd-none' }}">
        {!! Form::label(__('common.pan_no'), __('common.pan_no')) !!}<i class="text-danger">*</i>

        {{ Form::text('pan_no', null, [
            'class' => 'form-control pan_no required',
            'data-rule-remote' => route('common.checkUniquePanNumber', [
                'field' => 'principles',
                'id' => $principle['id'] ?? '',
            ]),
            'data-msg-remote' => 'PAN No. has already been taken.',
            'data-rule-PanNo' => true,
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {{ Form::label(__('principle.date_of_incorporation'), __('principle.date_of_incorporation')) }}<i
            class="text-danger">*</i>
        {!! Form::date('date_of_incorporation', null, [
            'class' => 'form-control required selectDate',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            'id' => 'date_of_incorporation',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('principle.principle_type'), __('principle.principle_type')) !!}<i class="text-danger">*</i>
        {!! Form::select(
            'principle_type_id',
            ['' => 'Select Principle Type'] + $principle_types->pluck('name', 'id')->toArray(),
            null,
            [
                'class' => 'form-control required',
                'style' => 'width: 100%;',
                'id' => 'principle_type',
                'data-placeholder' => 'Select Principle Type',
            ],
        ) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('common.phone_no'), __('common.phone_no')) !!}<i class="text-danger">*</i>
        {{ Form::text('mobile', $principle->user->mobile ?? null, [
            'class' => 'form-control number required',
            'data-rule-MobileNo' => true,
            'data-rule-remote' => route('common.checkUniqueMobile', [
                'field' => 'mobile',
                'model' => 'users',
                'role' => 'contractor',
                'id' => $principle['user_id'] ?? '',
            ]),
            'data-msg-remote' => 'Phone No. has already been taken.',
        ]) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('entity_type_id', __('principle.entity_type')) !!}<i class="text-danger">*</i>
        {!! Form::select(
            'entity_type_id',
            ['' => ''] + $entity_types,
            null,
            [
                'class' => 'form-control required jsSelect2ClearAllow',
                'style' => 'width: 100%;',
                'id' => 'entity_type_id',
                'data-placeholder' => 'Select Entity Type',
            ],
        ) !!}
    </div>
</div>

<div class="row">
    {{-- <div class="col-6 form-group">
        {!! Form::label(__('principle.inception_date'), __('principle.inception_date')) !!}<i class="text-danger">*</i>
        {!! Form::date('inception_date', null, [
            'class' => 'form-control required',
            'id' => 'inception_date',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
        ]) !!}
    </div> --}}

    <div class="col-6 form-group">
        {!! Form::label('staff_strength', __('principle.staff_strength')) !!}
        {{ Form::number('staff_strength', null, ['class' => 'form-control', 'data-rule-Numbers' => true,]) }}
    </div>
</div>

{{-- <div class="row">
    <div class="col-4 form-group">
        {!! Form::label(__('principle.is_spv'), __('principle.is_spv')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_spv', 'Yes', null, ['class' => 'form_is_spv', 'id' => 'is_yes_spv_data']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_spv', 'No', true, ['class' => 'form_is_spv', 'id' => 'is_no_spv_data']) }}
                <span></span>No
            </label>
        </div>
    </div>
</div> --}}

<div
    class="row repeater-scrolling-wrapper contractRepeater {{ isset($principle) && $principle->count() > 0 && in_array($principle->venture_type, ['JV', 'SPV']) ? '' : 'd-none' }}">
    <div class="form-group col-lg-12">
        <div id="kt_repeater_contractor">
            <table class="table table-responsive table-separate table-head-custom table-checkable" id="machine"
                data-repeater-list="contractorDetails">
                <p class="duplicateError text-danger d-none"></p>
                <thead>
                    <tr>
                        <th width="5">{{ __('common.no') }}</th>
                        <th class="min-width-300">{{ __('principle.principle') }}<span class="text-danger">*</span></th>
                        <th class="min-width-200">{{ __('principle.pan_no') }}</th>
                        <th class="min-width-100">{{ __('principle.share_holding') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($principle) && count($principle->contractorItem) > 0)
                        @foreach ($principle->contractorItem as $key => $item)
                            <tr data-repeater-item="" class="contractor_data_rows">
                                <td class="list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <td>
                                    {!! Form::select('contractor_id', ['' => 'select'] + $contractors, $item->contractor_id, [
                                        'class' => 'form-control repDuplicate1 contractor_id required',
                                        'style' => 'width: 100%;',
                                        'data-placeholder' => 'Select Contractor',
                                        'data-ajaxurl' => route('getContractorDetail'),
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::text('contractor_pan_no', $item->pan_no, [
                                        'class' => 'form-control contractor_pan_no form-control-solid',
                                        'readonly',
                                        'data-rule-PanNo' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('share_holding', $item->share_holding, [
                                        'class' => 'form-control share_holding number required',
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
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="contractor_data_rows">
                            <td class="list-no">1</td>
                            <td>
                                {!! Form::select('contractor_id', ['' => 'select'] + $contractors, null, [
                                    'class' => 'form-control repDuplicate1 contractor_id',
                                    'style' => 'width: 100%;',
                                    'data-placeholder' => 'Select Contractor',
                                    'data-ajaxurl' => route('getContractorDetail'),
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::text('contractor_pan_no', null, [
                                    'class' => 'form-control contractor_pan_no form-control-solid',
                                    'readonly',
                                    'data-rule-PanNo' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('share_holding', null, [
                                    'class' => 'form-control share_holding number',
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
            </table>
            <div class="col-md-12 col-12">
                <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm"><i
                        class="fa fa-plus-circle"></i> Add</button>
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
                        <th width="510">{{ __('principle.trade_sector') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.from') }}<span class="text-danger">*</span></th>
                        <th>{{ __('principle.till') }}</th>
                        <th>{{ __('principle.main') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($principle) && count($principle->tradeSector) > 0)
                        <span class="text-danger item-dul-error d-none">Duplicate trade sector
                            found.</span>
                        @foreach ($principle->tradeSector as $key => $item)
                            <tr data-repeater-item="" class="trade_sector_row">
                                <td class="trade-list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="trade_item_id" value="{{ $item->id }}">
                                <td>
                                    {!! Form::select('trade_sector', ['' => ''] + $trade_sector, $item->trade_sector_id, [
                                        'class' => 'form-control required trade_sector jsTradeSector',
                                        'data-placeholder' => 'Select Trade Sector',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date('from', $item->from, ['class' => 'form-control from required', 'max' => now()->toDateString()]) !!}
                                </td>
                                <td>
                                    {!! Form::date('till', $item->till, ['class' => 'form-control till minDate', 'max' => '9999-12-31']) !!}
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
                                {!! Form::select('trade_sector', ['' => ''] + $trade_sector, null, [
                                    'class' => 'form-control required trade_sector jsTradeSector',
                                    'data-placeholder' => 'Select Trade Sector',
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::date('from', null, ['class' => 'form-control from required', 'max' => now()->toDateString()]) !!}
                            </td>
                            <td>
                                {!! Form::date('till', null, ['class' => 'form-control till minDate', 'max' => '9999-12-31']) !!}
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
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2">
                                        <i class="flaticon-delete"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12">
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
                        <th width="310">{{ __('principle.contact_person') }}</th>
                        <th>{{ __('common.email') }}</th>
                        <th>{{ __('common.phone_no') }}</th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($principle) && count($principle->contactDetail) > 0)
                        @foreach ($principle->contactDetail as $key => $item)
                            <tr data-repeater-item="" class="contact_detail_row">
                                <td class="contact-list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="contact_item_id" value="{{ $item->id }}">
                                <td>
                                    {!! Form::text('contact_person', $item->contact_person, [
                                        'class' => 'form-control',
                                        'data-rule-AlphabetsV1' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::email('email', $item->email, ['class' => 'form-control email']) !!}
                                </td>
                                <td>
                                    {!! Form::text('phone_no', $item->phone_no, [
                                        'class' => 'form-control number',
                                        'data-rule-MobileNo' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2 contact_detail_delete">
                                        <i class="flaticon-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="contact_detail_row">
                            <td class="contact-list-no">1</td>
                            <td>
                                {!! Form::text('contact_person', null, ['class' => 'form-control', 'data-rule-AlphabetsV1' => true]) !!}
                            </td>
                            <td>
                                {!! Form::email('email', null, ['class' => 'form-control email']) !!}
                            </td>
                            <td>
                                {!! Form::text('phone_no', null, ['class' => 'form-control number', 'data-rule-MobileNo' => true]) !!}
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
            <div class="col-md-12 col-12">
                <button type="button" data-repeater-create=""
                    class="btn btn-outline-primary btn-sm contact_detail_create"><i class="fa fa-plus-circle"></i>
                    Add</button>
            </div>
        </div>
        <div id="load-modal"></div>
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('agency_id', __('principle.agency')) !!}
        {!! Form::select('agency_id', ['' => ''] + $agencies, null, ['class' => 'form-control jsSelect2ClearAllow agency_id', 'data-placeholder' => 'Select Agency', 'data-ajaxurl' => route('getRatingDetails')], $agencyOptions) !!}
    </div>

    <div class="col-3 form-group jsSelectRating">
        {!! Form::label('rating_id', __('principle.rating')) !!}<i class="text-danger jsIsAgency d-none">*</i>
        {!! Form::select('rating_id', ['' => ''] + $agency_rating, null, ['class' => 'form-control jsSelect2ClearAllow rating_id', 'data-placeholder' => 'Select Rating', 'data-ajaxurl' => route('getRatingRemarks')]) !!}
    </div>

    <div class="col-3 form-group">
        {!! Form::label('item_rating_date', __('proposals.rating_date')) !!}<i class="text-danger jsIsAgency d-none">*</i>
        {!! Form::date("item_rating_date",  null, ['class' => 'form-control item_rating_date']) !!}
    </div>

    <div class="col-2">
        <button type="button" 
            class="btn btn-outline-primary btn-sm rating_detail_create mt-9" disabled><i class="fa fa-plus-circle"></i>
            Add</button>
    </div>
</div>

<div class="row jsRatingDetails {{ isset($principle) && count($principle->agencyRatingDetails) > 0 ? '' : 'd-none' }}">
    <div class="form-group col-12">
        <div id="contractorRatingDetailRepeater">
            <table class="table table-separate table-head-custom table-checkable ratingDetailSector" id="machine"
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
                    @if (isset($principle) && count($principle->agencyRatingDetails) > 0)
                        @foreach ($principle->agencyRatingDetails as $key => $item)
                            <tr data-repeater-item="" class="rating_detail_row">
                                <td class="rating-list-no">{{ ++$key }} . </td>
                                <input type="hidden" name="rating_item_id" class="rating_item_id" value="{{ $item->id }}">
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
                                <td>
                                    <a href="javascript:;" data-repeater-delete=""
                                        class="btn btn-sm btn-icon btn-danger mr-2 rating_detail_delete">
                                        <i class="flaticon-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr data-repeater-item="" class="rating_detail_row">
                            <td class="rating-list-no">1</td>
                            <input type="hidden" name="rating_item_id" class="rating_item_id" value="">
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
        <div id="load-modal"></div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-12 form-group">
        {!! Form::label('rating_remarks', __('principle.remarks')) !!}
        {!! Form::textarea("rating_remarks", null, ['class' => 'form-control rating_remarks form-control-solid', 'data-rule-Remarks' => true, 'rows' => 2, 'cols' => 2, 'readonly']) !!}
    </div>
</div> --}}

{{-- <div class="row jsAgencyDetails">
    @if (isset($ratingDetails))
        @foreach ($ratingDetails as $index => $item)

            <div class="col-3 form-group">
                {!! Form::hidden("agency[$index][ard_id]", $item->id ?? null) !!}
                {!! Form::hidden("agency[$index][rating_id]", $item->rating_id ?? '') !!}

                {!! Form::label('agency_rating', __('principle.agency_rating')) !!}
                {!! Form::text("agency[$index][agency_rating]", $item->rating ?? '', ['class' => 'form-control agency_rating form-control-solid', 'readonly']) !!}
            </div>

            <div class="col-9 form-group">
                {!! Form::label('rating_remarks', __('principle.remarks')) !!}
                {!! Form::textarea("agency[$index][rating_remarks]", $item->remarks ?? '', ['class' => 'form-control rating_remarks form-control-solid', 'data-rule-Remarks' => true, 'rows' => 2, 'cols' => 2, 'readonly']) !!}
            </div>
        @endforeach
    @else
        <div class="col-3 form-group">
            {!! Form::hidden('agency[][ard_id]', null) !!}
            {!! Form::hidden('agency[][rating_id]', null) !!}
            {!! Form::label('agency_rating', __('principle.agency_rating')) !!}
            {!! Form::text('agency[][agency_rating]', null, ['class' => 'form-control agency_rating form-control-solid', 'readonly']) !!}
        </div>

        <div class="col-9 form-group">
            {!! Form::label('rating_remarks', __('principle.remarks')) !!}
            {!! Form::textarea('agency[][rating_remarks]', null, ['class' => 'form-control rating_remarks form-control-solid', 'data-rule-Remarks' => true, 'rows' => 2, 'cols' => 2, 'readonly']) !!}
        </div>
    @endif
</div> --}}

<div class="row">
    <div class="col-6 form-group jsDivClass">
        <div class="d-block">
            {!! Form::label('company_details', __('principle.company_details')) !!}
        </div>
        <div class="d-block">
            {!! Form::file('company_details[]', [
                'class' => 'company_details jsDocument',
                'id' => 'company_details',
                // empty($dms_data) ? 'required' : '',
                'multiple',
                'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            ]) !!}

            @php
                $data_company_details = isset($dms_data['company_details']) ? count($dms_data['company_details']) : 0;

                $dsbtcls = $data_company_details == 0 ? 'disabled' : '';
            @endphp
            {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'company_details', 'dmsable_type' => 'Principle']) }}"
                class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="company_details"
                data-delete="jsCompanyDetailsDeleted">

                <span class = "count_company_details" data-temp-company_details="" data-count_company_details = "{{ $data_company_details }}">{{ $data_company_details }}&nbsp;document</span>
            </a> --}}

            <a href="#" data-toggle="modal" data-target="#company_details_modal"
                class="call-modal JsCompanyDetails jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyDetailsDeleted" data-prefix="company_details"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                <span class = "count_company_details" data-count_company_details = "{{ $data_company_details }}">{{ $data_company_details }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="company_details_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Company Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <a class="jsFileRemove"></a>
                            @if (isset($dms_data) && isset($dms_data['company_details']) && count($dms_data['company_details']) > 0)
                                @foreach ($dms_data['company_details'] as $index => $documents)
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="dms_company_details">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="company_details" data-url="{{ route('removeDmsAttachment') }}"
                                                        data-id="{{ $documents->id }}"></i></a>
                                                    <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('company_technical_details', __('principle.company_technical_details')) !!}
        {!! Form::file('company_technical_details[]', [
            'class' => 'company_technical_details jsDocument',
            'id' => 'company_technical_details',
            // empty($dms_data) ? 'required' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}

        @php
            $data_company_technical_details = isset($dms_data['company_technical_details']) ? count($dms_data['company_technical_details']) : 0;

            $dsbtcls = $data_company_technical_details == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'company_technical_details', 'dmsable_type' => 'Principle']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="company_technical_details"
            data-delete="jsCompanyTechnicalDetailsDeleted">
            <span class = "count_company_technical_details" data-temp-company_technical_details="" data-count_company_technical_details = "{{ $data_company_technical_details }}">{{ $data_company_technical_details }}&nbsp;document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#company_technical_details_modal"
            class="call-modal JsCompanyTechnicalDetails jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyTechnicalDetailsDeleted" data-prefix="company_technical_details"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_company_technical_details" data-count_company_technical_details = "{{ $data_company_technical_details }}">{{ $data_company_technical_details }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="company_technical_details_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Company Technical Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($dms_data) && isset($dms_data['company_technical_details']) && count($dms_data['company_technical_details']) > 0)
                            @foreach ($dms_data['company_technical_details'] as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_company_technical_details">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="company_technical_details" data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}"></i></a>
                                                <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('company_presentation', __('principle.company_presentation')) !!}
        {!! Form::file('company_presentation[]', [
            'class' => 'company_presentation jsDocument',
            'id' => 'company_presentation',
            // empty($dms_data) ? 'required' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}

        @php
            $data_company_presentation = isset($dms_data['company_presentation']) ? count($dms_data['company_presentation']) : 0;

            $dsbtcls = $data_company_presentation == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'company_presentation', 'dmsable_type' => 'Principle']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="company_presentation"
            data-delete="jsCompanyPresentationDeleted">
            <span class="navi-icon"><span class="length_company_presentation"
                    data-company_presentation ='{{ $data_company_presentation }}'>{{ $data_company_presentation }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#company_presentation_modal"
            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyPresentationDeleted" data-prefix="company_presentation"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_company_presentation" data-count_company_presentation = "{{ $data_company_presentation }}">{{ $data_company_presentation }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="company_presentation_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Company Presentation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($dms_data) && isset($dms_data['company_presentation']) && count($dms_data['company_presentation']) > 0)
                            @foreach ($dms_data['company_presentation'] as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_company_presentation">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="company_presentation" data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}"></i></a>
                                                <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group">
        {!! Form::label(__('principle.are_you_blacklisted'), __('principle.are_you_blacklisted')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('are_you_blacklisted', 'Yes', null, ['class' => 'are_you_blacklisted']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('are_you_blacklisted', 'No', true, ['class' => 'are_you_blacklisted']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('certificate_of_incorporation', __('principle.certificate_of_incorporation')) !!}<i class="text-danger">*</i>
        {!! Form::file('certificate_of_incorporation[]', [
            'class' => 'certificate_of_incorporation jsDocument',
            'id' => 'certificate_of_incorporation',
            isset($dms_data['certificate_of_incorporation']) && !empty($dms_data['certificate_of_incorporation']) ? '' : 'required',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}

        @php
            $data_certificate_of_incorporation = isset($dms_data) && isset($dms_data['certificate_of_incorporation']) ? count($dms_data['certificate_of_incorporation']) : 0;

            $dsbtcls = $data_certificate_of_incorporation == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'certificate_of_incorporation', 'dmsable_type' => 'Principle']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="certificate_of_incorporation"
            data-delete="jsCertificateofIncorporationDeleted">
            <span class="navi-icon"><span class="length_certificate_of_incorporation"
                    data-certificate_of_incorporation ='{{ $data_certificate_of_incorporation }}'>{{ $data_certificate_of_incorporation }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#certificate_of_incorporation_modal"
            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCertificateofIncorporationDeleted" data-prefix="certificate_of_incorporation"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_certificate_of_incorporation" data-count_certificate_of_incorporation = "{{ $data_certificate_of_incorporation }}">{{ $data_certificate_of_incorporation }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="certificate_of_incorporation_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Certificate of Incorporation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($dms_data) && isset($dms_data['certificate_of_incorporation']) && count($dms_data['certificate_of_incorporation']) > 0)
                            @foreach ($dms_data['certificate_of_incorporation'] as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_certificate_of_incorporation">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_required_attachment_remove" data-prefix="certificate_of_incorporation" data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}"></i></a>
                                                <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('memorandum_and_articles', __('principle.memorandum_and_articles')) !!}<i class="text-danger">*</i>
        {!! Form::file('memorandum_and_articles[]', [
            'class' => 'memorandum_and_articles jsDocument',
            'id' => 'memorandum_and_articles',
            isset($dms_data['memorandum_and_articles']) && !empty($dms_data['memorandum_and_articles']) ? '' : 'required',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}

        @php
            $data_memorandum_and_articles = isset($dms_data) && isset($dms_data['memorandum_and_articles']) ? count($dms_data['memorandum_and_articles']) : 0;

            $dsbtcls = $data_memorandum_and_articles == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'memorandum_and_articles', 'dmsable_type' => 'Principle']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="memorandum_and_articles"
            data-delete="jsMemorandumAndArticlesDeleted">
            <span class="navi-icon"><span class="length_memorandum_and_articles"
                    data-memorandum_and_articles ='{{ $data_memorandum_and_articles }}'>{{ $data_memorandum_and_articles }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#memorandum_and_articles_modal"
            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsMemorandumAndArticlesDeleted" data-prefix="memorandum_and_articles"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_memorandum_and_articles" data-count_memorandum_and_articles = "{{ $data_memorandum_and_articles }}">{{ $data_memorandum_and_articles }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="memorandum_and_articles_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Memorandum and Articles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($dms_data) && isset($dms_data['memorandum_and_articles']) && count($dms_data['memorandum_and_articles']) > 0)
                            @foreach ($dms_data['memorandum_and_articles'] as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_memorandum_and_articles">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_required_attachment_remove" data-prefix="memorandum_and_articles" data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}"></i></a>
                                                <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label('gst_certificate', __('principle.gst_certificate')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        </div>

        <div class="d-block jsDivClass">
            @php
                $isGstCertificateRequired = false;
                if (!isset($principle)) {
                    $isGstCertificateRequired = true;
                } elseif (
                    (isset($principle->venture_type) && $principle->venture_type == 'Stand Alone')
                    && empty($dms_data['gst_certificate'] ?? null)
                ) {
                    $isGstCertificateRequired = true;
                }
            @endphp
            {!! Form::file('gst_certificate[]', [
                'class' => 'gst_certificate jsDocument ' . ($isGstCertificateRequired ? 'required' : ''),
                'id' => 'gst_certificate',
                // isset($dms_data['gst_certificate']) && !empty($dms_data['gst_certificate']) ? '' : 'required',
                'multiple',
                'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            ]) !!}

            @php
                $data_gst_certificate = isset($dms_data) && isset($dms_data['gst_certificate']) ? count($dms_data['gst_certificate']) : 0;
                $dsbtcls = $data_gst_certificate == 0 ? 'disabled' : '';
            @endphp
            {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'gst_certificate', 'dmsable_type' => 'Principle']) }}"
                class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="gst_certificate"
                data-delete="jsGstCertificateDeleted">
                <span class="navi-icon"><span class="length_gst_certificate"
                        data-gst_certificate ='{{ $data_gst_certificate }}'>{{ $data_gst_certificate }}</span>&nbsp;Document</span>
            </a> --}}

            <a href="#" data-toggle="modal" data-target="#gst_certificate_modal"
                class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsGstCertificateDeleted" data-prefix="gst_certificate"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                <span class = "count_gst_certificate" data-count_gst_certificate = "{{ $data_gst_certificate }}">{{ $data_gst_certificate }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="gst_certificate_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Gst Certificate</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <a class="jsFileRemove"></a>
                            @if (isset($dms_data) && isset($dms_data['gst_certificate']) && count($dms_data['gst_certificate']) > 0)
                                @foreach ($dms_data['gst_certificate'] as $index => $documents)
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="dms_gst_certificate">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_required_attachment_remove" data-prefix="gst_certificate" data-url="{{ route('removeDmsAttachment') }}"
                                                        data-id="{{ $documents->id }}"></i></a>
                                                    <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group">
        <div class="d-block">
            {!! Form::label('company_pan_no', __('principle.company_pan_no')) !!}<i class="text-danger jsVentureTypeRequired {{ $jsVentureTypeRequired ? '' : 'd-none' }}">*</i>
        </div>

        <div class="d-block jsDivClass">
            @php
                $isCompanyPanNoRequired = false;
                if (!isset($principle)) {
                    $isCompanyPanNoRequired = true;
                } elseif (
                    (isset($principle->venture_type) && $principle->venture_type == 'Stand Alone')
                    && empty($dms_data['company_pan_no'] ?? null)
                ) {
                    $isCompanyPanNoRequired = true;
                }
            @endphp
            {!! Form::file('company_pan_no[]', [
                'class' => 'company_pan_no jsDocument ' . ($isCompanyPanNoRequired ? 'required' : ''),
                'id' => 'company_pan_no',
                // isset($dms_data['company_pan_no']) && !empty($dms_data['company_pan_no']) ? '' : 'required',
                'multiple',
                'maxfiles' => 5,
                'maxsizetotal' => '52428800',
                'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
                'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
                'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            ]) !!}
            @php
                $data_company_pan_no = isset($dms_data) && isset($dms_data['company_pan_no']) ? count($dms_data['company_pan_no']) : 0;
                $dsbtcls = $data_company_pan_no == 0 ? 'disabled' : '';
            @endphp
            {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
                data-target-modal="#commonModalID"
                data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'company_pan_no', 'dmsable_type' => 'Principle']) }}"
                class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="company_pan_no"
                data-delete="jsCompanyPannoDeleted">
                <span class="navi-icon"><span class="length_company_pan_no"
                        data-company_pan_no ='{{ $data_company_pan_no }}'>{{ $data_company_pan_no }}</span>&nbsp;Document</span>
            </a> --}}

            <a href="#" data-toggle="modal" data-target="#company_pan_no_modal"
                class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsCompanyPannoDeleted" data-prefix="company_pan_no"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                <span class = "count_company_pan_no" data-count_company_pan_no = "{{ $data_company_pan_no }}">{{ $data_company_pan_no }}&nbsp;document</span>
            </a>

            <div class="modal fade" tabindex="-1" id="company_pan_no_modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Company PanNo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <a class="jsFileRemove"></a>
                            @if (isset($dms_data) && isset($dms_data['company_pan_no']) && count($dms_data['company_pan_no']) > 0)
                                @foreach ($dms_data['company_pan_no'] as $index => $documents)
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="dms_company_pan_no">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_required_attachment_remove" data-prefix="company_pan_no" data-url="{{ route('removeDmsAttachment') }}"
                                                        data-id="{{ $documents->id }}"></i></a>
                                                    <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    <div class="col-6 form-group jsDivClass">
        {!! Form::label('last_three_years_itr', __('principle.last_three_years_itr')) !!}
        {!! Form::file('last_three_years_itr[]', [
            'class' => 'last_three_years_itr jsDocument',
            'id' => 'last_three_years_itr',
            // empty($dms_data) ? 'required' : '',
            'multiple',
            'maxfiles' => 5,
            'maxsizetotal' => '52428800',
            'data-msg-maxsizetotal' => 'Total size of all files must not exceed 50 MB.',
            'data-msg-extension' => 'Please upload valid file pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
            'extension' => 'pdf|xlsx|xls|doc|docx|png|jpg|jpeg',
        ]) !!}

        @php
            $data_last_three_years_itr = isset($dms_data) && isset($dms_data['last_three_years_itr']) ? count($dms_data['last_three_years_itr']) : 0;

            $dsbtcls = $data_last_three_years_itr == 0 ? 'disabled' : '';
        @endphp
        {{-- <a href="{{ route('dMSDocument', $principle->id ?? '') }}" data-toggle="modal"
            data-target-modal="#commonModalID"
            data-url="{{ route('dMSDocument', ['id' => $principle->id ?? '', 'attachment_type' => 'last_three_years_itr', 'dmsable_type' => 'Principle']) }}"
            class="call-modal navi-link jsShowDocument {{ $dsbtcls }}" data-prefix="last_three_years_itr"
            data-delete="jsLastThreeYearsItrDeleted">
            <span class="navi-icon"><span class="length_last_three_years_itr"
                    data-last_three_years_itr ='{{ $data_last_three_years_itr }}'>{{ $data_last_three_years_itr }}</span>&nbsp;Document</span>
        </a> --}}

        <a href="#" data-toggle="modal" data-target="#last_three_years_itr_modal"
            class="call-modal jsShowDocument navi-link {{ $dsbtcls }}" data-delete="jsLastThreeYearsItrDeleted" data-prefix="last_three_years_itr"><i class="fa fa-file" aria-hidden="true"></i>&nbsp;
            <span class = "count_last_three_years_itr" data-count_last_three_years_itr = "{{ $data_last_three_years_itr }}">{{ $data_last_three_years_itr }}&nbsp;document</span>
        </a>

        <div class="modal fade" tabindex="-1" id="last_three_years_itr_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Last 3 Years ITR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <a class="jsFileRemove"></a>
                        @if (isset($dms_data) && isset($dms_data['last_three_years_itr']) && count($dms_data['last_three_years_itr']) > 0)
                            @foreach ($dms_data['last_three_years_itr'] as $index => $documents)
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="dms_last_three_years_itr">{!! getdmsFileIcon(e($documents->file_name)) !!}&nbsp;{{ $documents->file_name }} <a type="button" value="Delete"> <i class="flaticon2-cross small dms_attachment_remove" data-prefix="last_three_years_itr" data-url="{{ route('removeDmsAttachment') }}"
                                                    data-id="{{ $documents->id }}"></i></a>
                                                <a href="{{ isset($documents->attachment) ? route('secure-file', encryptId($documents->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
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

    {{-- <div class="col-4 form-group">
        {!! Form::label(__('principle.type_of_entity'), __('principle.type_of_entity')) !!}<i class="text-danger">*</i>
        {!! Form::select('type_of_entity_id', ['' => 'Select Type of Entity'] + $type_of_entity, null, [
            'class' => 'form-control required',
            'style' => 'width:100%;',
            'id' => 'type_of_entity',
            'data-placeholder' => 'Select Type of Entity',
        ]) !!}
    </div> --}}
</div>
