@extends('app-modal')
@section('modal-title', !isset($document_type) ? __('document_type.add_document_type') :
    __('document_type.edit_document_type'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $document_type->id ?? null) !!}
        {!! Form::label(__('document_type.name'), __('document_type.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'document_types',
                'id' => $document_type['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('document_type.type'), __('document_type.type')) !!}<i class="text-danger">*</i>
        {!! Form::select('type', ['' => 'Select Type'] + $type, null, [
            'class' => 'form-control',
            'data-placeholder' => 'Select Type',
            'class' => 'type',
            'style' => 'width: 100%;',
            'id' => 'Type',
            'required',
        ]) !!}
    </div>

@section('modal-btn', !isset($document_type) ? __('common.save') : __('common.update'))
@endsection

@include('document_type.script')
