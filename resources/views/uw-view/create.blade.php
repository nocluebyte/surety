{!! Form::open(['route' => 'uw-view.store', 'id' => 'uwViewForm']) !!}
@include('uw-view.form', [
    'uw-view' => null,
])
{!! Form::close() !!}
