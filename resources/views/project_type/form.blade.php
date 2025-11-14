@extends('app-modal')
@section('modal-title', !isset($project_type) ? __('project_type.add_project_type') :
    __('project_type.edit_project_type'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $project_type->id ?? null) !!}
        {!! Form::label(__('project_type.name'), __('project_type.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'project_types',
                'id' => $project_type['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($project_type) ? __('common.save') : __('common.update'))
@endsection

@include('project_type.script')
