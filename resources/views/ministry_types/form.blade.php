@extends('app-modal')
@section('modal-title', !isset($ministry_types) ? __('ministry_types.add_ministry_types') :
    __('ministry_types.edit_ministry_types'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $ministry_types->id ?? null) !!}
        {!! Form::label(__('ministry_types.name'), __('ministry_types.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'ministry_types',
                'id' => $ministry_types['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($ministry_types) ? __('common.save') : __('common.update'))
@endsection

@include('ministry_types.script')
