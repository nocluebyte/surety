@extends('app-modal')
@section('modal-title', !isset($work_type) ? __('work_type.add_work_type') : __('work_type.edit_work_type'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $work_type->id ?? null) !!}
        {!! Form::label('name', __('work_type.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'work_types',
                'id' => $work_type['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($work_type) ? __('common.save') : __('common.update'))
@endsection

@include('work_type.script')
