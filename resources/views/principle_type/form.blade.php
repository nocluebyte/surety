@extends('app-modal')
@section('modal-title', !isset($principle_type) ? __('principle_type.add_principle_type') :
    __('principle_type.edit_principle_type'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $principle_type->id ?? null) !!}
        {!! Form::label(__('principle_type.name'), __('principle_type.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'principle_types',
                'id' => $principle_type['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($principle_type) ? __('common.save') : __('common.update'))
@endsection

@include('principle_type.script')
