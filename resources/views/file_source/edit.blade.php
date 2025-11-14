{!! Form::model($file_source, [
    'route' => ['file_source.update', encryptId($file_source->id)],
    'id' => 'fileSourceForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $file_source->id, ['id' => 'id']) !!}
@include('file_source.form', [
    'file_source' => $file_source,
])
{!! Form::close() !!}
