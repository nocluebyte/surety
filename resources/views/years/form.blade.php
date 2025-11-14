@extends('app-modal')
@section('modal-title', !isset($year) ? __('year.add_year') : __('year.edit_year'))
@section('modal-content')

    <div class="form-group">
        {{ Form::label('yearname', __('year.year')) }}<i class="text-danger">*</i>
        {{ Form::text('yearname', null, [
            'class' => 'form-control',
            'required',
            'pattern' => '^[0-9]{4}-[0-9]{2}$',
            'data-msg-pattern' => 'Invalid format (eg. 2024-25)',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'yearname',
                'model' => 'years',
                'id' => $year->id ?? '',
            ]),
            'data-msg-remote' => 'Year name has already been taken.',
        ]) }}
    </div>
    <div class="form-group">
        {{ Form::label('is_default', __('year.is_default')) }}<i class="text-danger">*</i>
        {!! Form::select('is_default', ['' => 'Select'] + ['Yes' => 'Yes', 'No' => 'No'], null, [
            'class' => 'form-control',
            'id' => 'is_default',
            'style' => 'width: 100%',
            'data-placeholder' => 'Select',
            'required',
        ]) !!}
    </div>
    <div class="form-group">
        {{ Form::label('is_displayed', __('year.is_displayed')) }}<i class="text-danger">*</i>
        {!! Form::select('is_displayed', ['' => 'Select'] + ['Yes' => 'Yes', 'No' => 'No'], null, [
            'class' => 'form-control',
            'id' => 'is_displayed',
            'style' => 'width: 100%',
            'data-placeholder' => 'Select',
            'required',
        ]) !!}
    </div>
    <div class="row">
        <div class="form-group col-6">
            {{ Form::label('from_date', __('year.from_date')) }}<i class="text-danger">*</i>
            {!! Form::date('from_date', null, [
                'class' => 'form-control required',
                'min' => '1000-01-01',
                'max' => '9999-12-31',
                'id' => 'from_date',
            ]) !!}
        </div>
        <div class="form-group col-6">
            {{ Form::label('to_date', __('year.to_date')) }}<i class="text-danger">*</i>
            {!! Form::date('to_date', null, [
                'class' => 'form-control required',
                'min' => '1000-01-01',
                'max' => '9999-12-31',
                'id' => 'to_date',
            ]) !!}
        </div>
    </div>

@section('modal-btn', !isset($year) ? __('common.save') : __('common.update'))
@endsection

@include('years.script')
