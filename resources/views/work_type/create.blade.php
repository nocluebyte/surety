{!! Form::open(['route' => 'work-type.store', 'id' => 'workTypeForm']) !!}
@include('work_type.form', [
    'work_type' => null,
])
{!! Form::close() !!}
