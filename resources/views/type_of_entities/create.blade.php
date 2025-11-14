{!! Form::open(['route' => 'type_of_entities.store', 'id' => 'typeOfEntitiesForm']) !!}
@include('type_of_entities.form', [
    'type_of_entities' => null,
])
{!! Form::close() !!}
