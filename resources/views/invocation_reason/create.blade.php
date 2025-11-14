{!!Form::open(['route'=>'invocation-reason.store','id'=>'invocationReasonForm'])!!}
    @method('post')
    @include('invocation_reason.form')
{!!Form::close()!!}