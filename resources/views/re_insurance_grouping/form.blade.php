@extends('app-modal')
@section('modal-title', !isset($re_insurance_grouping) ? __('re_insurance_grouping.add_re_insurance_group') :
    __('re_insurance_grouping.edit_re_insurance_group'))
@section('modal-content')

    <div class="form-group">
        {{ Form::label('re_insurance_grouping', __('re_insurance_grouping.name')) }}<i class="text-danger">*</i>
        {{ Form::text('name', null, ['class' => 'form-control required', 'data-rule-AlphabetsV1' => true]) }}
    </div>
@section('modal-btn', !isset($re_insurance_grouping) ? __('common.save') : __('common.update'))
@endsection

@include('re_insurance_grouping.script')
