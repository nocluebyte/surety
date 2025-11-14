@extends('app-modal')
@section('modal-title', !isset($rejection_reason) ? __('rejection_reason.add_rejection_reason') : __('rejection_reason.edit_rejection_reason'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $rejection_reason->id ?? null) !!}
        {!! Form::label('reason', __('rejection_reason.reason')) !!}<i class="text-danger">*</i>
        {!! Form::text('reason', null, [
            'class' => 'form-control required',
            'id' => 'reason',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'reason',
                'model' => 'rejection_reasons',
                'id' => $rejection_reason['id'] ?? '',
            ]),
            'data-msg-remote' => 'The reason has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('rejection_reason.description')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('description', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($rejection_reason) ? __('common.save') : __('common.update'))
@endsection

@include('rejection_reason.script')
