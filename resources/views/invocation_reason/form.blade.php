@extends('app-modal')

@section('modal-title',$title)

@section('modal-content')

<div class="form-group">
    {!!Form::label(__('invocation_reason_master.reason'),__('invocation_reason_master.reason'))!!} <i class="text-danger">*</i>
    {!!Form::text('reason',$invocation_reason->reason ?? null,[
        'class'=>'form-control required',
        'data-rule-remote' => route('common.checkUniqueField', [
                'field' => 'reason',
                'model' => 'invocation_reasons',
                'id' => $invocation_reason['id'] ?? '',
            ]),
        'data-msg-remote' => 'The name has already been taken.',
        'data-rule-Remarks'=>true
    ])!!}
</div>
<div class="form-group">
    {!!Form::label(__('invocation_reason_master.description'),__('invocation_reason_master.description'))!!} <i class="text-danger">*</i>
    {!!Form::textarea('description',$invocation_reason->description ?? null,['class'=>'form-control required','rows'=>2,'data-rule-Remarks'=>true])!!}
</div>

@endsection

@section('modal-btn',!isset($invocation_reason) ? __('common.save') : __('common.update'))

@section('script')
    @include('invocation_reason.script')
@endsection