@extends('app-modal')
@section('modal-title', !isset($country) ? __('currency.add_currency') : __('currency.edit_currency'))
@section('modal-content')
    <div class="form-group">
        {{ Form::label('country', __('country.country')) }}<i class="text-danger">*</i>
        {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
            'class' => 'form-control jsCountry',
            'id' => 'country_id',
            'data-placeholder' => 'Select Country',
            'required',
        ]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('short_name', __('currency.short_name')) }}<i class="text-danger">*</i>
        {{ Form::text('short_name', null, ['class' => 'form-control required upperCase' , 'maxlength' => '5', 'data-rule-AlphabetsV1' => true]) }}
    </div>
    <div class="form-group">
        {{ Form::label('symbol', __('currency.symbol')) }}<i class="text-danger">*</i>
        {{ Form::text('symbol', null, ['class' => 'form-control required upperCase', 'maxlength' => '5', 'data-rule-AlphabetsV4' => true]) }}
    </div>
@section('modal-btn', !isset($country) ? __('common.save') : __('common.update'))
@endsection
@include('currency.script')
