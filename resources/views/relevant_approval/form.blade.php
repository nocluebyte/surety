@extends('app-modal')
@section('modal-title', !isset($relevant_approval) ? __('relevant_approval.add_relevant_approval') :
    __('relevant_approval.edit_relevant_approval'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $relevant_approval->id ?? null) !!}
        {!! Form::label(__('relevant_approval.name'), __('relevant_approval.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'relevant_approvals',
                'id' => $relevant_approval['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($relevant_approval) ? __('common.save') : __('common.update'))
@endsection

@include('relevant_approval.script')
