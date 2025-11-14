@extends('app-modal')
@section('modal-title', __('smtp_configuration.view_smtp_configuration') )
@section('modal-content')

@php
$module_names = array (
'sales_invoice'=>'Sales Invoice',
'forgot_password'=>'Forgot Password',
);
@endphp
<div class="form-group">
    {{Form::label(__('smtp_configuration.module_name'), __('smtp_configuration.module_name'))}}
    <p>{{$module_names[$smtp_configuration->module_name]}}</p>
    
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.host_name'), __('smtp_configuration.host_name'))}}<i class="text-danger">*</i>
    {{Form::text('host_name', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.username'), __('smtp_configuration.username'))}}<i class="text-danger">*</i>
    {{Form::text('username', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.password'), __('smtp_configuration.password'))}}<i class="text-danger">*</i>

    {{Form::password('password',['class' => 'form-control jsPassword']);}}

</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.from_email'), __('smtp_configuration.from_email'))}}<i class="text-danger">*</i>
    {{Form::text('from_name', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.port'), __('smtp_configuration.port'))}} <i class="text-danger">*</i>
    {{Form::text('port', null,['class' => 'form-control']);}}
</div>


<div class="form-group">
    {{Form::label(__('smtp_configuration.driver'), __('smtp_configuration.driver'))}}<i class="text-danger">*</i>

    {{Form::text('driver', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.encryption'), __('smtp_configuration.encryption'))}}<i class="text-danger">*</i>

    {{Form::text('encryption', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.subject'), __('smtp_configuration.subject'))}}<i class="text-danger">*</i>

    {{Form::text('subject', null,['class' => 'form-control']);}}
</div>

<div class="form-group">
    {{Form::label(__('smtp_configuration.message_body'), __('smtp_configuration.message_body'))}}<i class="text-danger">*</i>

    {{Form::textarea('message_body', null,['class' => 'form-control', 'rows' => 5]);}}
</div>

@section('modal-btn',( !isset($smtp_configuration)) ? __('common.save') : __('common.update') )
@endsection

@include('smtp-configuration.script')




