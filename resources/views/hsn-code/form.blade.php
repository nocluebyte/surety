@extends('app-modal')
@section('modal-size', 'modal-lg')
@section('modal-title', !isset($hsnCode) ? __('hsn_code.add_hsncode') : __('hsn_code.edit_hsncode'))
@section('modal-content')

    <div class="row">
        <div class="col-6 form-group">
            {!! Form::label('hsn_code', __('hsn_code.hsn_code')) !!}<i class="text-danger">*</i>
            {!! Form::number('hsn_code', null, ['class' => 'form-control required', 'data-rule-Pincode' => true]) !!}
        </div>

        <div class="col-6 form-group">
            {!! Form::label('gst', __('hsn_code.gst')) !!}<i class="text-danger">*</i>
            {!! Form::select('gst', ['' => ''] + $gst_slab, null, [
                'class' => 'form-control gst required',
                'id' => 'gst',
                'data-placeholder' => 'Select GST Slab',
            ]) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12">
            {!! Form::label('is_service', __('hsn_code.is_service')) !!}<i class="text-danger">*</i>
            <div class="radio-inline">
                <label class="radio">
                    {{ Form::radio('is_service', 'Goods', true, ['class' => 'form-check-input', 'id' => 'goods']) }}
                    <span></span>{{ __('hsn_code.goods') }}
                </label>
                <label class="radio">
                    {{ Form::radio('is_service', 'Services', '', ['class' => 'form-check-input', 'id' => 'services']) }}
                    <span></span>{{ __('hsn_code.services') }}
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-4">
            {!! Form::label('cgst', __('hsn_code.cgst')) !!}<i class="text-danger">*</i>
            {!! Form::text('cgst', null, ['class' => 'form-control JsCgst form-control-solid', 'readonly']) !!}
        </div>
        <div class="form-group col-4">
            {!! Form::label('sgst', __('hsn_code.sgst')) !!}<i class="text-danger">*</i>
            {!! Form::text('sgst', null, ['class' => 'form-control JsSgst form-control-solid', 'readonly']) !!}
        </div>
        <div class="form-group col-4">
            {!! Form::label('igst', __('hsn_code.igst')) !!}<i class="text-danger">*</i>
            {!! Form::text('igst', null, ['class' => 'form-control JsIgst form-control-solid', 'readonly']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            {!! Form::label('description', __('hsn_code.description')) !!}
            {!! Form::textarea('description', null, [
                'class' => 'form-control',
                'rows' => 2,
                'data-rule-AlphabetsAndNumbersV3' => true,
            ]) !!}
        </div>
    </div>

@section('modal-btn', !isset($entity) ? __('common.save') : __('common.update'))
@endsection

@include('hsn-code.script')
