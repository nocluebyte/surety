{!! Form::model($agency_rating, [
    'route' => ['agency-rating.update', encryptId($agency_rating->id)],
    'id' => 'agencyRatingForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $agency_rating->id, ['id' => 'id']) !!}
@include('agency_rating.form', [
    'agency_rating' => $agency_rating,
])
{!! Form::close() !!}
