{!! Form::model($document_type, [
    'route' => ['document_type.update', encryptId($document_type->id)],
    'id' => 'documentTypeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $document_type->id, ['id' => 'id']) !!}
@include('document_type.form', [
    'document_type' => $document_type,
])
{!! Form::close() !!}
