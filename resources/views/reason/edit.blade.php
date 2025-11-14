{!! Form::model($reason, [
    'route' => ['reason.update', encryptId($reason->id)],
    'id' => 'reasonForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $reason->id, ['id' => 'id']) !!}
@include('reason.form', [
    'reason' => $reason,
])
{!! Form::close() !!}
