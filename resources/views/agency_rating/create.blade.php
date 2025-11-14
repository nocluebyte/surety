{!! Form::open(['route' => 'agency-rating.store', 'id' => 'agencyRatingForm']) !!}
@include('agency_rating.form', [
    'agency_rating' => null,
])
{!! Form::close() !!}
