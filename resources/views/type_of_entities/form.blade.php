@extends('app-modal')
@section('modal-title', !isset($type_of_entities) ? __('type_of_entities.add_type_of_entities') :
    __('type_of_entities.edit_type_of_entities'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $type_of_entities->id ?? null) !!}
        {!! Form::label(__('type_of_entities.name'), __('type_of_entities.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'type_of_entities',
                'id' => $type_of_entities['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($type_of_entities) ? __('common.save') : __('common.update'))
@endsection

@include('type_of_entities.script')
