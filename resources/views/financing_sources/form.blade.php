@extends('app-modal')
@section('modal-title', !isset($financing_sources) ? __('financing_sources.add_financing_sources') :
    __('financing_sources.edit_financing_sources'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $financing_sources->id ?? null) !!}
        {!! Form::label(__('financing_sources.name'), __('financing_sources.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'financing_sources',
                'id' => $financing_sources['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($financing_sources) ? __('common.save') : __('common.update'))
@endsection

@include('financing_sources.script')
