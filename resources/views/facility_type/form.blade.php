@extends('app-modal')
@section('modal-title', !isset($facility_type) ? __('facility_type.add_facility_type') :
    __('facility_type.edit_facility_type'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $facility_type->id ?? null) !!}
        {!! Form::label(__('facility_type.name'), __('facility_type.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'facility_types',
                'id' => $facility_type['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($facility_type) ? __('common.save') : __('common.update'))
@endsection

@include('facility_type.script')
