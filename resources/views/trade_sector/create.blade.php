{!! Form::open(['route' => 'trade_sector.store', 'id' => 'tradeSectorForm']) !!}
@include('trade_sector.form', [
    'trade_sector' => null,
])
{!! Form::close() !!}
