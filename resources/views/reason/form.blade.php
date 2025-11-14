@extends('app-modal')
@section('modal-title', !isset($reason) ? __('reason.add_reason') : __('reason.edit_reason'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $reason->id ?? null) !!}
        {!! Form::label('reason', __('reason.reason')) !!}<i class="text-danger">*</i>
        {!! Form::text('reason', null, [
            'class' => 'form-control required',
            'id' => 'reason',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'reason',
                'model' => 'reasons',
                'id' => $reason['id'] ?? '',
            ]),
            'data-msg-remote' => 'The reason has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('reason.description')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('description', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($reason) ? __('common.save') : __('common.update'))
@endsection

@include('reason.script')
