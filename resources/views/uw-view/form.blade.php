@extends('app-modal')
@section('modal-title', !isset($uwView) ? __('uw-view.add_uwView') : __('uw-view.edit_uwView'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $uwView->id ?? null) !!}
        {!! Form::label('name', __('common.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'uw-view',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'uw_views',
                'id' => $uwView['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>
@section('modal-btn', !isset($uwView) ? __('common.save') : __('common.update'))
@endsection

@include('uw-view.script')
