{!! Form::open(['route' => 'file_source.store', 'id' => 'fileSourceForm']) !!}
@include('file_source.form', [
    'file_source' => null,
])
{!! Form::close() !!}
