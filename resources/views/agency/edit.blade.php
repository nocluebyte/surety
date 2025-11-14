{!! Form::model($agency, [
    'route' => ['agency.update', encryptId($agency->id)],
    'id' => 'agencyForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $agency->id, ['id' => 'id']) !!}
@include('agency.form', [
    'agency' => $agency,
])
{!! Form::close() !!}
