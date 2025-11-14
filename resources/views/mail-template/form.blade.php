@extends('app-modal')
@section('modal-size', 'modal-xl')
@section('modal-title', !isset($mail_template) ? __('mail_template.add_mail_template') :
    __('mail_template.edit_mail_template'))
@section('modal-content')

    <div class="row">
        <div class="form-group col-6">
            {{ Form::label(__('mail_template.module_name'), __('mail_template.module_name')) }}<i class="text-danger">*</i>

            {!! Form::select('module_name', ['' => 'Select'] + $module_names, null, [
                'class' => 'form-control jsModuleName',
                'id' => 'module_name',
                'data-placeholder' => 'Select Module Name',
                'required',
            ]) !!}
        </div>

        <div class="form-group col-6">
            {{ Form::label(__('mail_template.from_email'), __('mail_template.from_email')) }}<i class="text-danger">*</i>

            {!! Form::select('smtp_id', ['' => 'Select'] + $smtp_data, null, [
                'class' => 'form-control',
                'id' => 'smtp_id',
                'data-placeholder' => 'Select Email',
                'required',
            ]) !!}
        </div>
    </div>

    <div class="row jsLeadDiv">
        {{-- <div class="form-group col-6">
        {{Form::label(__('mail_template.lead_source'), __('mail_template.lead_source'))}}<i class="text-danger">*</i>

        {!! Form::select('lead_source_id', [''=>'Select'] + $lead_source_data, null, ['class' => 'form-control','id'=>'lead_source_id','data-placeholder'=>'Select Lead Sourcee','required', 'data-url'=>route('get_lead_source')]) !!}
    </div> --}}

        {{-- <div class="form-group col-6">
        {{Form::label(__('mail_template.time'), __('mail_template.time'))}}<i class="text-danger">*</i>

        {!! Form::time('send_time', null, ['class' => 'form-control', 'id'=>"send_time"]) !!}
    </div> --}}
    </div>


    <div class="row">
        <div class="form-group col-12">
            {{ Form::label(__('mail_template.subject'), __('mail_template.subject')) }}<i class="text-danger">*</i>

            {{ Form::text('subject', null, ['class' => 'form-control', 'data-rule-AlphabetsV1' => true]) }}
        </div>

    </div>

    <div class="row">

        <div class="form-group col-12">
            {{ Form::label(__('mail_template.message_body'), __('mail_template.message_body')) }}<i
                class="text-danger">*</i>
            {{ Form::textarea('message_body', null, ['class' => 'form-control', 'rows' => 5, 'id' => 'message_body']) }}
        </div>
    </div>

    <div class="row">

        <div class="form-group col-12 mb-0">
            {{ Form::label(__('mail_template.attachment'), __('mail_template.attachment')) }}
        </div>
        <div class="form-group col-12 mb-3">
            {{ Form::file('attachment', null, [
                'class' => 'form-control',
                'id' => 'attachment',
            ]) }}
        </div>

        @if (!empty($mail_template))
            <div class="form-group col-12 mb-0">
                {{ $mail_template->attachment }}
            </div>
        @endif
    </div>

@section('modal-btn', !isset($mail_template) ? __('common.save') : __('common.update'))
@endsection

@include('mail-template.script')

