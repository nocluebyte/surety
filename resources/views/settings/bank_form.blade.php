{!! Form::open(['route' => 'settings.store', 'id' => 'settingForm']) !!}
{{ Form::hidden('group', 'bank_details', ['class' => 'form-control', 'required']) }}

<div class="row">
    <div class="form-group col-lg-4">
        {{ Form::label('account_number', __('settings.account_number')) }}<i class="text-danger">*</i>
        {{ Form::text('account_number', $settings['account_number'] ?? '', ['class' => 'form-control', 'required']) }}
    </div>

    <div class="form-group col-lg-4">
        {{ Form::label('ifsc_code', __('settings.ifsc_code')) }}<i class="text-danger">*</i>
        {{ Form::text('ifsc_code', $settings['ifsc_code'] ?? '', ['class' => 'form-control', 'required']) }}
    </div>

    <div class="form-group col-lg-4">
        {{ Form::label('bank_name', __('settings.bank_name')) }}<i class="text-danger">*</i>
        {{ Form::text('bank_name', $settings['bank_name'] ?? '', ['class' => 'form-control', 'required']) }}
    </div>
</div>


<div class="row">
        <div class="form-group col-lg-4">
            {{ Form::label('swift_code', __('settings.swift_code')) }}
            {{ Form::text('swift_code', $settings['swift_code'] ?? '', ['class' => 'form-control']) }}
        </div>
</div>

<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
    </div>
</div>
{!! Form::close() !!}

