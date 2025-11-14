@extends('app-modal')
@section('modal-title', !isset($country) ? __('country.add_country') : __('country.edit_country'))
@section('modal-content')

    <div class="form-group">
        {{ Form::label('name', __('country.name')) }}<i class="text-danger">*</i>
        {{ Form::text('name', null, [
            'class' => 'form-control',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'countries',
                'id' => $country['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('phone_code', __('country.phone_code')) }}<i class="text-danger">*</i>
        {{ Form::number('phone_code', null, ['class' => 'form-control', 'data-rule-Numbers' => true, 'max' => 999]) }}
    </div>

    <div class="form-group">
        {{ Form::label('code', __('country.code')) }}<i class="text-danger">*</i>
        {{ Form::text('code', null, ['class' => 'text-uppercase form-control', 'data-rule-Numbers' => true, 'max' => 999]) }}
    </div>

    <div class="form-group">
        {{ Form::label('mid_level', __('country.mid_level')) }}<i class="text-danger">*</i>
        {{ Form::select('mid_level', ['' => ''] + $mid_level, null, ['class' => 'form-control required mid_level', 'data-placeholder' => 'Select Mid Level']) }}
    </div>

@section('modal-btn', !isset($country) ? __('common.save') : __('common.update'))
@endsection

@include('countries.script')
