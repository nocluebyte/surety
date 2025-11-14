<div class="card card-custom gutter-b">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8"></div>
            <div class=" form-group col-4 mb-5">
                <label class=" col-form-label text-right">{{ __('project_details.pin') }} <span
                        class="text-danger">*</span></label>
                <div class="col-lg-12">
                    @if ($project_details)
                        {!! Form::text('code', $project_details->code ?? null, [
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
                {!! Form::label('beneficiary_id', __('project_details.beneficiary')) !!}<i class="text-danger">*</i>
                {!! Form::select('beneficiary_id', ['' => ''] + $beneficiaries, null, [
                    'class' => 'form-control required beneficiary_id jsSelect2ClearAllow',
                    'style' => 'width: 100%;',
                    'data-placeholder' => 'Select Beneficiary',
                    'data-ajaxUrl' => route('getProjectDetailCurrencySymbol'),
                ]) !!}
            </div>

            <div class="col-6 form-group">
                {!! Form::label('project_name', __('project_details.project_name')) !!}<i class="text-danger">*</i>
                {!! Form::text('project_name', null, [
                    'class' => 'form-control required',
                    'data-rule-AlphabetsAndNumbersV8' => true,
                ]) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-12 form-group">
                {!! Form::label('project_description', __('project_details.project_description')) !!}<i class="text-danger">*</i>
                {{ Form::textarea('project_description', null, ['class' => 'project_description form-control required', 'rows' => 2, 'data-rule-Remarks' => true]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-6 form-group">
                {!! Form::label('project_value', __('project_details.project_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>

                {{ Form::number('project_value', null, ['class' => 'form-control required', 'data-rule-Numbers' => true]) }}
            </div>

            <div class="col-6 form-group">
                {!! Form::label('type_of_project', __('project_details.type_of_project')) !!}<i class="text-danger">*</i>
                {!! Form::select('type_of_project', ['' => ''] + $type_of_project, null, [
                    'class' => 'form-control required type_of_project jsSelect2ClearAllow',
                    'style' => 'width: 100%;',
                    'data-placeholder' => 'Select Type of Project',
                ]) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-4 form-group">
                {!! Form::label('project_start_date', __('project_details.project_start_date')) !!}<i class="text-danger">*</i>
                {!! Form::date('project_start_date', null, [
                    'class' => 'form-control project_start_date jsPeriod required',
                    'min' => '1000-01-01',
                    'max' => '9999-12-31',
                    'data-msg-min' => 'Please enter a Date greater than or equal to 01/01/1000',
                    'data-msg-max' => 'Please enter a Date less than or equal to 31/12/9999',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label('project_end_date', __('project_details.project_end_date')) !!}<i class="text-danger">*</i>
                {!! Form::date('project_end_date', null, [
                    'class' => 'form-control project_end_date jsPeriod required',
                    'min' => '1000-01-01',
                    'max' => '9999-12-31',
                    'data-msg-min' => 'Please enter a Date greater than or equal to 01/01/1000',
                    'data-msg-max' => 'Please enter a Date less than or equal to 31/12/9999',
                ]) !!}
            </div>

            <div class="col-4 form-group">
                {!! Form::label('period_of_project', __('project_details.period_of_project')) !!}<i class="text-danger">*</i>
                {!! Form::number('period_of_project', null, [
                    'class' => 'form-control form-control-solid jsProjectPeriod required',
                    'data-rule-Numbers' => true,
                    'readonly',
                ]) !!}
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
    </div>
</div>

@section('scripts')
    @include('project_details.script')
@endsection
