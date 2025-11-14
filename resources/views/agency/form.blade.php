@extends('app-modal')
@section('modal-title', !isset($agency) ? __('agency.add_agency') : __('agency.edit_agency'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $agency->id ?? null) !!}
        {!! Form::label('agency_name', __('agency.agency_name')) !!}<i class="text-danger">*</i>
        {!! Form::text('agency_name', null, [
            'class' => 'form-control required',
            'id' => 'agency_name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'agency_name',
                'model' => 'agencies',
                'id' => $agency['id'] ?? '',
            ]),
            'data-msg-remote' => 'The Agency Name has already been taken.',
            'data-rule-AlphabetsAndNumbersV2' => true,
        ]) !!}
    </div>

@section('modal-btn', !isset($agency) ? __('common.save') : __('common.update'))
@endsection

@include('agency.script')
