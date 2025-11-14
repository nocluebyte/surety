@extends('app-modal')
@section('modal-title', !isset($file_source) ? __('file_source.add_file_source') : __('file_source.edit_file_source'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $file_source->id ?? null) !!}
        {!! Form::label(__('file_source.name'), __('file_source.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'file_sources',
                'id' => $file_source['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($file_source) ? __('common.save') : __('common.update'))
@endsection

@include('file_source.script')
