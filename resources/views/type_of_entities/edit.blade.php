{!! Form::model($type_of_entities, [
    'route' => ['type_of_entities.update', encryptId($type_of_entities->id)],
    'id' => 'typeOfEntitiesForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $type_of_entities->id, ['id' => 'id']) !!}
@include('type_of_entities.form', [
    'type_of_entities' => $type_of_entities,
])
{!! Form::close() !!}
