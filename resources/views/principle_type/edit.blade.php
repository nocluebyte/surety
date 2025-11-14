{!! Form::model($principle_type, [
    'route' => ['principle_type.update', encryptId($principle_type->id)],
    'id' => 'principleTypeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $principle_type->id, ['id' => 'id']) !!}
@include('principle_type.form', [
    'principle_type' => $principle_type,
])
{!! Form::close() !!}
