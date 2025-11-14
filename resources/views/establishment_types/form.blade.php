@extends('app-modal')
@section('modal-title', !isset($establishment_types) ? __('establishment_types.add_establishment_types') :
    __('establishment_types.edit_establishment_types'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $establishment_types->id ?? null) !!}
        {!! Form::label(__('establishment_types.name'), __('establishment_types.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'establishment_types',
                'id' => $establishment_types['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($establishment_types) ? __('common.save') : __('common.update'))
@endsection

@include('establishment_types.script')
