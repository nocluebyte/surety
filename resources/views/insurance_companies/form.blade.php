<div class="card card-custom gutter-b">

    <div class="card-body">
        <form class="form">
            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.company_name'), __('insurance_companies.company_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('company_name', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) !!}
                </div>
                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.email'), __('insurance_companies.email')) !!}<i class="text-danger">*</i>

                    {{ Form::text('email', null, [
                        'class' => 'form-control email',
                        'required',
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'email',
                            'model' => 'insurance_companies',
                            'id' => $insurance_companies['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'The email has already been taken.',
                    ]) }}
                </div>
                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.phone_no'), __('insurance_companies.phone_no')) !!}<i class="text-danger">*</i>
                    {{ Form::text('phone_no', null, ['class' => 'form-control number', 'required', 'data-rule-MobileNo' => true]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label(__('insurance_companies.address'), __('insurance_companies.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('insurance_companies.post_code'), __('insurance_companies.post_code')) !!}<i class="text-danger jsRemoveAsterisk">*</i>
                    {{ Form::text('post_code', null, ['class' => 'form-control jsPinCode post_code',]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.country'), __('insurance_companies.country')) !!}<i class="text-danger">*</i>
                    {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
                        'class' => 'form-control required jsSelect2 jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'country',
                        'data-placeholder' => 'Select country',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.state'), __('insurance_companies.state')) !!}<i class="text-danger">*</i>
                    {!! Form::select('state_id', ['' => 'Select State'] + $states, null, [
                        'class' => 'form-control required jsSelect2 jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'state',
                        'data-placeholder' => 'Select state',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label(__('insurance_companies.city'), __('insurance_companies.city')) !!}<i class="text-danger">*</i>
                    {{ Form::text('city', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
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
    @include('insurance_companies.script')
@endsection
