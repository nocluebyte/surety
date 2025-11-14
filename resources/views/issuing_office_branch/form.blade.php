<div class="card card-custom gutter-b">
    <div class="card-body">
        <form class="form">
            <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('branch_name', __('issuing_office_branch.branch_name')) !!}<i class="text-danger">*</i>
                    {!! Form::text('branch_name', null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsAndNumbersV3' => true,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label('branch_code', __('issuing_office_branch.branch_code')) !!}<i class="text-danger">*</i>
                    {!! Form::text('branch_code', null, [
                        'class' => 'form-control required',
                        'data-rule-AlphabetsAndNumbersV2' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'branch_code',
                            'model' => 'issuing_office_branches',
                            'id' => $issuingOfficeBranch['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'Branch Code has already been taken.',
                    ]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('address', __('common.address')) !!}<i class="text-danger">*</i>
                    {{ Form::textarea('address', null, ['class' => 'form-control required', 'rows' => 2, 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('country', __('common.country')) !!}<i class="text-danger">*</i>
                    {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
                        'class' => 'form-control required jsSelect2 jsSelect2ClearAllow',
                        'style' => 'width: 100%;',
                        'id' => 'country',
                        'data-placeholder' => 'Select country',
                    ]) !!}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('state', __('common.state')) !!}<i class="text-danger">*</i>
                    {!! Form::select('state_id', ['' => 'Select State'] + $states, null, [
                        'class' => 'form-control required jsSelect2 jsSelect2ClearAllow',
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
                <div class="col-6 form-group">
                    {!! Form::label('oo_cbo_bo_kbo', __('issuing_office_branch.oo_cbo_bo_kbo')) !!}<i class="text-danger">*</i>
                    {{ Form::number('oo_cbo_bo_kbo', null, [
                        'class' => 'form-control required',
                        'data-rule-Numbers' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'oo_cbo_bo_kbo',
                            'model' => 'issuing_office_branches',
                            'id' => $issuingOfficeBranch['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'OO/CBO/BO/KBO No. has already been taken.',
                    ]) }}
                </div>

                <div class="col-6 form-group JsGstNo {{ $isCountryIndia ? '' : 'd-none' }}">
                    {!! Form::label('gst_no', __('common.gst_no')) !!}<i class="text-danger">*</i>
                    {{ Form::text('gst_no', null, [
                        'class' => 'form-control required gst_no',
                        'data-rule-GstNo' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'gst_no',
                            'model' => 'issuing_office_branches',
                            'id' => $issuingOfficeBranch['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'GST No. has already been taken.',
                    ]) }}
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-6 form-group">
                    {!! Form::label('sac_code', __('issuing_office_branch.sac_code')) !!}<i class="text-danger">*</i>
                    {{ Form::number('sac_code', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) }}
                </div>
            </div> --}}

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('bank', __('issuing_office_branch.bank')) !!}<i class="text-danger">*</i>
                    {{ Form::text('bank', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('bank_branch', __('issuing_office_branch.bank_branch')) !!}<i class="text-danger">*</i>
                    {{ Form::text('bank_branch', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV3' => true]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('account_no', __('issuing_office_branch.account_no')) !!}<i class="text-danger">*</i>
                    {{ Form::text('account_no', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV6' => true]) }}
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                    {!! Form::label('ifsc', __('issuing_office_branch.ifsc')) !!}<i class="text-danger">*</i>
                    {{ Form::text('ifsc', null, ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV1' => true]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('micr', __('issuing_office_branch.micr')) !!}<i class="text-danger">*</i>
                    {{ Form::number('micr', null, [
                        'class' => 'form-control required',
                        'data-rule-Numbers' => true,
                        'data-rule-remote' => route('common.checkUniqueField', [
                            'field' => 'micr',
                            'model' => 'issuing_office_branches',
                            'id' => $issuingOfficeBranch['id'] ?? '',
                        ]),
                        'data-msg-remote' => 'MICR No. has already been taken.',
                    ]) }}
                </div>

                <div class="col-4 form-group">
                    {!! Form::label('mode', __('issuing_office_branch.mode')) !!}<i class="text-danger">*</i>
                    {{ Form::select('mode', ['' => ''] + $mode, null, ['class' => 'form-control required jsSelect2ClearAllow', 'data-placeholder' => 'Select Mode']) }}
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
    @include('issuing_office_branch.script')
@endsection
