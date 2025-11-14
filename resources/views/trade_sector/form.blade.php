@extends('app-modal')
@section('modal-title', !isset($trade_sector) ? __('trade_sector.add_trade_sector') :
    __('trade_sector.edit_trade_sector'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $trade_sector->id ?? null) !!}
        {!! Form::label(__('trade_sector.name'), __('trade_sector.name')) !!}<i class="text-danger">*</i>
        {!! Form::text('name', null, [
            'class' => 'form-control required',
            'id' => 'Name',
            'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'name',
                'model' => 'trade_sectors',
                'id' => $trade_sector['id'] ?? '',
            ]),
            'data-msg-remote' => 'The name has already been taken.',
            'data-rule-AlphabetsV1' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label(__('trade_sector.mid_level'), __('trade_sector.mid_level')) !!}<i class="text-danger">*</i>
        {!! Form::select('mid_level', ['' => 'Select Mid Level'] + $mid_level, null, [
            'class' => 'form-control',
            'data-placeholder' => 'Select Mid Level',
            'class' => 'mid_level',
            'style' => 'width: 100%;',
            'id' => 'Mid Level',
            'required',
        ]) !!}
    </div>

@section('modal-btn', !isset($trade_sector) ? __('common.save') : __('common.update'))
@endsection

@include('trade_sector.script')
