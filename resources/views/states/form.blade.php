@extends('app-modal')
@section('modal-title', !isset($state) ? __('state.add_state') : __('state.edit_state'))
@section('modal-content')
    <div class="form-group">
        {{ Form::label('country', __('country.country')) }}<i class="text-danger">*</i>
        <div class="row">
            <div class="col-md-12">
                {!! Form::select('country_id', ['' => 'Select Country'] + $countries, null, [
                    'class' => 'form-control',
                    'id' => 'country_id',
                    'data-placeholder' => 'Select Country',
                    'required',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('name', __('state.name')) }}<i class="text-danger">*</i>
        {{ Form::text('name', null, [
            'class' => 'form-control',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'states',
                'id' => $state['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) }}
    </div>
    <div class="form-group jsGstCode">
        {{ Form::label('gst_code', __('state.gst_code')) }}<i class="text-danger">*</i>
        {{ Form::number('gst_code', null, ['class' => 'form-control gst_code', 'data-rule-Numbers' => true, 'max' => 999]) }}
    </div>

@section('modal-btn', !isset($state) ? __('common.save') : __('common.update'))
@endsection

@include('states.script')
