<div class="card card-custom gutter-b">

    <div class="card-body">
        <form class="form">
            <div class="row">
                {!! Form::hidden('user_id', $underwriter->user_id ?? null) !!}
                <div class="col-4 form-group">
                    {!! Form::label('first_name', __('common.first_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('first_name', $underwriter->user->first_name ?? null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('middle_name', __('common.middle_name')) !!}
                    {!! Form::text('middle_name', $underwriter->user->middle_name ?? null, [
                        'class' => 'form-control',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('last_name', __('common.last_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('last_name', $underwriter->user->last_name ?? null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsV1' => true,
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('company_name', __('common.company_name')) !!}<i class="text-danger">*</i>
                    {{ Form::text('company_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('email', __('common.email')) !!}<i class="text-danger">*</i>

                    {{ Form::email('email', $underwriter->user->email ?? null, [
                        'class' => 'form-control required email',
                        'data-rule-remote' => route('common.checkUniqueEmail', [
                            'id' => $underwriter['user_id'] ?? '',
                        ]),
                        'data-msg-remote' => 'The email has already been taken.',
                    ]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('type', __('common.type')) !!}<i class="text-danger">*</i>

                    {!! Form::select('type', ['' => ''] + $type, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'data-placeholder' => 'Select Underwriter Type',
                        'style' => 'width: 100%;',
                        'id' => 'Type',
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('country', __('common.country')) !!}<i class="text-danger">*</i>
                    {!! Form::select('country_id', ['' => ''] + $countries, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'country',
                        'data-placeholder' => 'Select country',
                        // 'data-ajaxurl' => route('getCurrencySymbol'),
                        'data-ajaxurl' => route('getCurrencySymbol', ['id' => '__id__']),
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('state', __('common.state')) !!}<i class="text-danger">*</i>
                    {!! Form::select('state_id', ['' => ''] + $states, null, [
                        'class' => 'form-control required jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'state',
                        'data-placeholder' => 'Select state',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('city', __('common.city')) !!}<i class="text-danger">*</i>
                    {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('phone_no', __('common.phone_no')) !!}<i class="text-danger">*</i>
                    {{ Form::number('mobile', $underwriter->user->mobile ?? null, ['class' => 'form-control required', 'data-rule-MobileNo' => true, 'data-rule-remote' => route('common.checkUniqueField', [
                        'field' => 'mobile',
                        'model' => 'users',
                        'id' => $underwriter->user_id ?? '',
                    ]),
                    'data-msg-remote' => 'The Phone No. has already been taken.',]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('address', __('common.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>

                <div class="col-4 form-group panNoField {{ $isCountryIndia ? '' : 'd-none' }}">
                    {!! Form::label('pan_no', __('common.pan_no')) !!}<i class="text-danger">*</i>

                    {{ Form::text('pan_no', null, [
                        'class' => 'form-control pan_no',
                        'data-rule-remote' => route('common.checkUniquePanNumber', [
                            'field' => 'underwriters',
                            'id' => $underwriter['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'PAN No. has already been taken.',
                        'data-rule-PanNo' => true,
                    ]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('max_approved_limit', __('underwriter.max_approved_limit')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                    {!! Form::number('max_approved_limit', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('individual_cap', __('underwriter.individual_cap')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                    {!! Form::number('individual_cap', null, [
                        'class' => 'form-control required',
                        'id' => 'individual_cap',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('overall_cap', __('underwriter.overall_cap')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                    {!! Form::number('overall_cap', null, [
                        'class' => 'form-control required',
                        'id' => 'overall_cap',
                        'data-rule-Numbers' => true,
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('group_cap', __('underwriter.group_cap')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>
                    {!! Form::number('group_cap', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) !!}
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
</div>

@section('scripts')
    @include('underwriter.script')
@endsection
