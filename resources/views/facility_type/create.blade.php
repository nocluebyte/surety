{!! Form::open(['route' => 'facility_type.store', 'id' => 'facilityTypeForm']) !!}
@include('facility_type.form', [
    'facility_type' => null,
])
{!! Form::close() !!}
