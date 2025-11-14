{!!Form::open(['route'=>['invocation-reason.update',encryptId($invocation_reason->id)],'id'=>'invocationReasonForm'])!!}
    @method('put')
    {!!Form::hidden('id',$invocation_reason->id)!!}
    @include('invocation_reason.form')
{!!Form::close()!!}