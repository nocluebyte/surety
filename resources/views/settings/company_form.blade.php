{!! Form::open( ['route' => 'settings.store' ,'id' => 'company_form', 'enctype' => 'multipart/form-data']) !!}
{{ Form::hidden('group', 'company') }}

<!--begin::Accordion-->

    <div class="row">
        <div class="form-group col-lg-4">
        {{Form::hidden('group','company',['class' => 'form-control' ,'required']);}}

            {{Form::label('project_title', __('settings.project_title'))}}<i class="text-danger">*</i>
            {{Form::text('project_title', $settings['project_title'] ?? '',['class' => 'form-control','required', 'data-rule-AlphabetsV1' => true,]);}}
        </div>

        <div class="form-group col-lg-4">
            {{Form::label('company_name', __('settings.company_name'))}}<i class="text-danger">*</i>
            {{Form::text('company_name', $settings['company_name'] ?? '',['class' => 'form-control','required', 'data-rule-AlphabetsV1' => true,]);}}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-4">
            {{Form::label('subtitle', __('settings.subtitle'))}}<i class="text-danger">*</i>
            {{Form::text('subtitle', $settings['subtitle'] ?? '',['class' => 'form-control required','data-rule-AlphabetsV2'=>true]);}}
        </div>
        <div class="form-group col-lg-4">
            {{Form::label('copyright_name', __('settings.copyright_name'))}}<i class="text-danger">*</i>
            {{Form::text('copyright_name', $settings['copyright_name'] ?? '',['class' => 'form-control required','data-rule-Remarks'=>true]);}}
        </div>
    </div>
    <div class="form-group">
        {{Form::label('tag_line', __('settings.tag_line'))}}
        {{Form::text('tag_line', $settings['tag_line'] ?? '',['class' => 'form-control', 'data-rule-AlphabetsV1' => true,]);}}
    </div>

    <div class="form-group">
        {{Form::label('company_address', __('settings.company_address'))}}<i class="text-danger">*</i>
        {{Form::textarea('company_address', $settings['company_address'] ?? '',['class' => 'form-control','rows' => 2 , 'id' => 'exampleTextarea' ,'required', 'data-rule-AlphabetsAndNumbersV3' => true,]);}}
    </div>

    <div class="row">
        <div class="form-group col-lg-4">
            {{Form::label('country', __('settings.country'))}}<i class="text-danger">*</i>
            {!! Form::select('country_id', [''=>'Select Country']+$countries, $settings['country'] ?? null, ['class' => 'form-control','style' => 'width: 100%;', 'id' => 'country' ,'data-placeholder' => 'Select country','required' ]) !!}
        </div>

        <div class="form-group col-lg-4">
            {{Form::label('state', __('settings.state'))}}<i class="text-danger">*</i>
            {!! Form::select('state_id', [''=>'Select State']+$states, $settings['state'] ?? null, ['class' => 'form-control','style' => 'width: 100%;', 'id' => 'state' ,'data-placeholder' => 'Select state' ,'required']) !!}
        </div>

        <div class="form-group col-lg-4">
            {{Form::label('city', __('settings.city'))}}<i class="text-danger">*</i>
            {{Form::text('city', $settings['city'] ?? '',['class' => 'form-control','required', 'data-rule-AlphabetsV1' => true,]);}}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-4">
            {{Form::label('pincode', __('settings.pincode'))}}<i class="text-danger jsRemoveAsterisk">*</i>
            {{Form::text('pincode', $settings['pincode'] ?? '',['class' => 'form-control jsPinCode pin_code']);}}
        </div>

        <div class="form-group col-lg-4 gstAndPanNoFields">
            {{Form::label('.pan_no', __('settings.pan_no'))}}<i class="text-danger">*</i>
            {{Form::text('pan_no', $settings['pan_no'] ?? '',['class' => 'form-control pan_no','required', 'data-rule-PanNo' => true,]);}}
        </div>
        <div class="form-group col-lg-4 gstAndPanNoFields">
            {{Form::label('gst_no', __('settings.gst_no'))}}<i class="text-danger">*</i>
            {{Form::text('gst_no', $settings['gst_no'] ?? '',['class' => 'form-control gst_no','required', 'data-rule-GstNo' => true,]);}}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-6">
            {{Form::label('mobile', __('settings.company_mobile'))}}<i class="text-danger">*</i>
            {{Form::text('mobile', $settings['mobile'] ?? '',['class' => 'form-control number required', 'data-rule-MobileNo' => true,]);}}
        </div>

        <div class="form-group col-lg-6">
            {{Form::label('email', __('settings.email'))}}<i class="text-danger">*</i>
            {{Form::text('email', $settings['email'] ?? '',['class' => 'form-control email','required']);}}
        </div>
    </div>

    <div class="row">
        <div class="col-6 form-group">
            {!! Form::label('cin_no', __('settings.cin_no')) !!}<i class="text-danger">*</i>
            {{ Form::text('cin_no', $settings['cin_no'] ?? '', ['class' => 'form-control required', 'data-rule-AlphabetsAndNumbersV2' => true]) }}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-4">
            {{Form::label('iec_no', __('settings.iec_no'))}}
            {{Form::text('iec_no', $settings['iec_no'] ?? '',['class' => 'form-control', 'data-rule-AlphabetsAndNumbersV2' => true,]);}}
        </div>
        <div class="form-group col-lg-4">
            {{Form::label('msme_no', __('settings.msme_no'))}}
            {{Form::text('msme_no', $settings['msme_no'] ?? '',['class' => 'form-control', 'data-rule-AlphabetsAndNumbersV2' => true,]);}}
        </div>
        <div class="form-group col-lg-4">
            {{Form::label('msme_type', __('settings.msme_type'))}}
            {{Form::select('msme_type', ['' => ''] + $msme_types, $settings['msme_type'] ?? null, ['class' => 'form-control jsSelect2ClearAllow', 'data-placeholder' => 'Select MSME Type'])}}
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                {{Form::label('terms_conditions', __('settings.terms_conditions'))}}
                {!! Form::textArea('terms_conditions', $settings['terms_conditions'] ?? null, ['class' => 'form-control'])!!}
                <label id="terms_conditions-error" class="text-danger" for="terms_conditions-error"></label>
            </div>
        </div>
    </div>

    <div class="row">    
        <div class="col-lg-4">
            <div class="form-group">
                {!! Form::label('logo', __('settings.logo')) !!}
                {!! Form::file('logo', ['id' => 'logo', 'accept' => 'image/png, image/jpg, image/jpeg']) !!}
            </div>
            <br>
            <div class="form-group">
                <img alt="Logo"
                    src="{{ (isset($settings['logo']) && !empty($settings['logo'])) ? asset($settings['logo']) : asset('default.jpg') }}"
                    class="h-75 align-self-end" id="logo_preview"
                    name="logo_preview" style="height: 30%;width: 30%;">
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                {!! Form::label('favicon', __('settings.favicon')) !!}
                {!! Form::file('favicon', ['id' => 'favicon', 'accept' => 'image/png, image/jpg, image/jpeg']) !!}
            </div>
            <br>
            <div class="form-group">
                <img alt="Favicon"
                    src="{{ (isset($settings['favicon']) && !empty($settings['favicon'])) ? asset($settings['favicon']) : asset('default.jpg') }}"
                    class="h-75 align-self-end" id="flaticon_preview"
                    name="flaticon_preview" style="height: 30%;width: 30%;">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-right">
            <a href="" class="mr-2">{{__('common.cancel')}}</a>
            <button type="submit" class="btn btn-primary">{{__('common.save')}}</button>
        </div>
    </div>


{!! Form::close() !!}