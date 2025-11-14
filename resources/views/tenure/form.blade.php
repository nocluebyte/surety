@extends('app-modal')
@section('modal-title', !isset($tenures) ? __('tenure.add_tenure') : __('tenure.edit_tenure'))
@section('modal-content')
    <div class="form-group">
        {{ Form::label('name', __('tenure.name')) }}<i class="text-danger">*</i>
        {{ Form::text('name', null, [
            'class' => 'form-control',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'tenures',
                'id' => $tenures['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            //'data-rule-AlphabetsAndNumbersV1' => true,
        ]) }}
    </div>
@section('modal-btn', !isset($tenures) ? __('common.save') : __('common.update'))
@endsection

@include('tenure.script')
