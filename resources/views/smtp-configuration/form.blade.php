@extends('app-modal')
@section('modal-size', 'modal-lg')
@section('modal-title', !isset($smtp_configuration) ? __('smtp_configuration.add_smtp_configuration') :
    __('smtp_configuration.edit_smtp_configuration'))
@section('modal-content')

    @php
        $module_names = [
            'sales_invoice' => 'Sales Invoice',
            'forgot_password' => 'Forgot Password',
            'lead_source' => 'Lead Source',
        ];

        $driver_names = [
            'smtp' => 'SMTP',
        ];
        $host_name = env('MAIL_HOST', 'smtp.zoho.com');
        $driver = 'smtp';
        $port = '465';
        $encryption = 'SSL';
    @endphp

    <div class="row">
        <div class="form-group col-6">
            {{ Form::label(__('smtp_configuration.from_email'), __('smtp_configuration.from_email')) }}<i
                class="text-danger">*</i>
            {{ Form::email('username', null, ['class' => 'form-control jsUsername']) }}
        </div>

        <div class="form-group col-6">
            {{ Form::label(__('smtp_configuration.password'), __('smtp_configuration.password')) }}<i
                class="text-danger">*</i>
            {{ Form::password('password', ['class' => 'form-control jsPassword']) }}

        </div>
    </div>

    <div class="row">
        <div class="form-group col-12 mb-0">
            {{ Form::label(__('smtp_configuration.host_name'), __('smtp_configuration.outgoing_server')) }} :
            {{ $host_name }}
            <input type="hidden" name="host_name" id="host_name" value="{{ $host_name }}">
        </div>

        <div class="form-group col-12 mb-0">
            {{ Form::label(__('smtp_configuration.driver'), __('smtp_configuration.protocol')) }} :
            {{ strtoupper($driver) }}
            <input type="hidden" name="driver" id="driver" value="{{ $driver }}">
            <input type="hidden" class="jsFromName" name="from_name" id="from_name" value="">
        </div>
        <div class="form-group col-12 mb-0">
            {{ Form::label(__('smtp_configuration.port'), __('smtp_configuration.port')) }} : {{ $port }}
            <input type="hidden" name="port" id="port" value="{{ $port }}">
        </div>
        <div class="form-group col-12 mb-0">
            {{ Form::label(__('smtp_configuration.encryption'), __('smtp_configuration.security_type')) }} :
            {{ $encryption }}
            <input type="hidden" name="encryption" id="encryption" value="{{ $encryption }}">
        </div>

    </div>


@section('modal-btn', !isset($smtp_configuration) ? __('common.save') : __('common.update'))
@endsection

@include('smtp-configuration.script')
