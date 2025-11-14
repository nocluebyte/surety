{!! Form::model($facility_type, [
    'route' => ['facility_type.update', encryptId($facility_type->id)],
    'id' => 'facilityTypeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $facility_type->id, ['id' => 'id']) !!}
@include('facility_type.form', [
    'facility_type' => $facility_type,
])
{!! Form::close() !!}
