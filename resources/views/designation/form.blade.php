@extends('app-modal')
@section('modal-title', !isset($designation) ? __('designation.add_designation') : __('designation.edit_designation'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $designation->id ?? null) !!}
        {!! Form::label(__('designation.name'), __('designation.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'designations',
                'id' => $designation['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($designation) ? __('common.save') : __('common.update'))
@endsection

@include('designation.script')
