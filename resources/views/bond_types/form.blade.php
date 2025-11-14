@extends('app-modal')
@section('modal-title', !isset($bond_types) ? __('bond_types.add_bond_types') : __('bond_types.add_bond_types'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $bond_types->id ?? null) !!}
        {!! Form::label(__('bond_types.name'), __('bond_types.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'bond_types',
                'id' => $bond_types['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>
    <div class="form-group">
        {!! Form::label(__('bond_types.prefix'), __('bond_types.prefix')) !!}<i class="text-danger">*</i>
        {!! Form::text('prefix', null, [
            'class' => 'form-control required',
            isset($bond_types) && $bond_types['prefix'] !== NULL ? 'readonly' : '',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'prefix',
                'model' => 'bond_types',
                'id' => $bond_types['id'] ?? '',
            ]),
            'data-msg-remote' => 'The prefix has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($bond_types) ? __('common.save') : __('common.update'))
@endsection

@include('bond_types.script')
