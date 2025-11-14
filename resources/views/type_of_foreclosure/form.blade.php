@extends('app-modal')
@section('modal-title', !isset($type_of_foreclosure) ? __('type_of_foreclosure.add_type_of_foreclosure') :
    __('type_of_foreclosure.edit_type_of_foreclosure'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $type_of_foreclosure->id ?? null) !!}
        {!! Form::label('name', __('common.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'type_of_foreclosures',
                'id' => $type_of_foreclosure['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-Remarks' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($type_of_foreclosure) ? __('common.save') : __('common.update'))
@endsection

@include('type_of_foreclosure.script')
