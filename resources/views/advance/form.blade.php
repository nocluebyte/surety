@extends('app-modal')
@section('modal-title',( !isset($advance)) ? __('advance.add_advance') : __('advance.edit_advance') )
@section('modal-content')

@if(isset($employeeID))
{!! Form::hidden ('employee_id', $employeeID) !!}
@endif
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
		    {!! Form::label('employee_id',trans("advance.employee"))!!} <i class="text-danger">*</i>
		    {!! Form::select('employee_id', [''=>'Select'] + $employee,isset($employeeID)?$employeeID:null,['class' => 'form-control employee required','data-placeholder'=>'Select Employee',(!isset($employeeID))?'':'disabled' => true]) !!}
		</div>
	</div>
	
</div>

@php
if(!empty($advance)){
$date = $advance->date;
} else {
$date = \Carbon\Carbon::now();
}
@endphp

<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
		    {!! Form::label('date',trans("common.date"))!!} <i class="text-danger">*</i>
		    {!! Form::date('date', $date, ['class' => 'form-control required', 'max' => '9999-12-31']) !!}
		</div>
		
	</div>
	<div class="col-lg-6">
		<div class="form-group">
		    {!! Form::label('amount',trans("common.amount"))!!} <i class="text-danger">*</i>

		    <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" style=" font-family: sans-serif;">₹</span>
                </div>
                {!! Form::text('amount', null, ['class' => 'form-control required']) !!}
            </div>
		</div>
		
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
	    {!! Form::label('comment',trans("advance.comment"))!!}
	    {!! Form::textarea('comment', null, ['class' => 'form-control','rows'=> 1]) !!}
		</div>
		
		
	</div>
	<div class="col-lg-6">
		<div class="form-group">
		     {!! Form::label('payment_mode',trans("payment.payment_mode"))!!}
             {!! Form::select('payment_mode', [''=>'Select'] + $paymentMode, null, ['class' => 'form-control', 'data-placeholder' => 'Select Payment Mode']) !!}
		</div>
		
		
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="form-group d-none" id="cheque_display">
            <label>{{__('payment.cheque_no')}} <span class="text-danger">*</span></label>
            {!! Form::text('cheque_no', null, ['class' => 'form-control', 'id' => 'cheque_no']) !!}
        </div>
		
	    
	</div>
	<div class="col-lg-6">
		<div class="form-group d-none" id="name_of_cheque_display">
            <label>{{__('payment.date_of_cheque')}} <span class="text-danger">*</span></label>
            {!! Form::date('cheque_date', null, ['class' => 'form-control', 'id' => 'cheque_date']) !!}
        </div>
		
		
	</div>
	
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group d-none" id="bank">
	        <label>{{__('payment.bank')}} <span class="text-danger">*</span></label>
	        {!! Form::select('account_from_id', ['' => 'Select'] + $banks, null, [] + ['class' => 'form-control','id' => 'account_from_id','data-placeholder' => 'Select Bank','style' => 'width:100%']) !!}
	        <!-- <span class="text-danger font-weight-bolder d-none" id="balance">Balance Db : 9,294.62</span> -->
	    </div>
	</div>
</div>



@section('modal-btn',( !isset($advance)) ? __('common.save') : __('common.update') )
@endsection

@include('advance.script')