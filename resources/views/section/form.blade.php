@extends('app-modal')
@section('modal-title',( !isset($section)) ? __('section.add_section') : __('section.edit_section') )
@section('modal-content')

<div class="form-group">
    {!! Form::label('name',trans("section.name"))!!} <i class="text-danger">*</i>
    {!! Form::text('name', null, ['class' => 'form-control required']) !!}
</div>

<div class="form-group">
    {!! Form::label('maximum_amount',trans("section.maximum_amount"))!!} <i class="text-danger">*</i>
    {!! Form::text('maximum_amount', null, ['class' => 'form-control required number']) !!}
</div>

@section('modal-btn',( !isset($section)) ? __('common.save') : __('common.update') )
@endsection

@include('section.script')