@extends('app-modal')
@section('modal-title', !isset($additional_bond) ? __('additional_bond.add_additional_bond') : __('additional_bond.edit_additional_bond'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $additional_bond->id ?? null) !!}
        {!! Form::label('name', __('additional_bond.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'additional_bonds',
                'id' => $additional_bond['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV3' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($additional_bond) ? __('common.save') : __('common.update'))
@endsection

@include('additional_bond.script')
