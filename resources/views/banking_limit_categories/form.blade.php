@extends('app-modal')
@section('modal-title', !isset($banking_limit_categories) ? __('banking_limit_categories.add_banking_limit_categories')
    : __('banking_limit_categories.edit_banking_limit_categories'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $banking_limit_categories->id ?? null) !!}
        {!! Form::label('name', __('banking_limit_categories.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'banking_limit_categories',
                'id' => $banking_limit_categories['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('type', __('banking_limit_categories.type')) !!}<i class="text-danger">*</i>
        {!! Form::select('type', ['' => ''] + $type, null, [
            'class' => 'form-control type',
            'data-placeholder' => 'Select Type',
            'style' => 'width: 100%;',
            'id' => 'Type',
            'required',
        ]) !!}
    </div>

@section('modal-btn', !isset($banking_limit_categories) ? __('common.save') : __('common.update'))
@endsection

@include('banking_limit_categories.script')
