@extends('app-modal')
@section('modal-title', !isset($agency_rating) ? __('agency_rating.add_agency_rating') : __('agency_rating.edit_agency_rating'))

@section('modal-content')
    <div class="form-group">
        {!! Form::hidden('id', $agency_rating->id ?? null) !!}

        {!! Form::label('agency_id', __('agency_rating.agency')) !!}<i class="text-danger">*</i>
        {!! Form::select('agency_id', ['' => ''] + $agencies, null, ['class' => 'form-control agency_id required', 'data-placeholder' => 'Select Agency']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('rating', __('agency_rating.rating')) !!}<i class="text-danger">*</i>
        {!! Form::text('rating', null, [
            'class' => 'form-control required',
            'id' => 'rating',
            'data-rule-AlphabetsAndNumbersV7' => true,
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('remarks', __('agency_rating.remarks')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('remarks', null, ['class' => 'form-control required', 'rows' => 2, 'cols' => 2, 'data-rule-Remarks' => true,]) !!}
    </div>

@section('modal-btn', !isset($agency_rating) ? __('common.save') : __('common.update'))
@endsection

@include('agency_rating.script')
