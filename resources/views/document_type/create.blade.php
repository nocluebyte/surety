{!! Form::open(['route' => 'document_type.store', 'id' => 'documentTypeForm']) !!}
@include('document_type.form', [
    'document_type' => null,
])
{!! Form::close() !!}
