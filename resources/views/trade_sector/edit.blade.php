{!! Form::model($trade_sector, [
    'route' => ['trade_sector.update', encryptId($trade_sector->id)],
    'id' => 'tradeSectorForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $trade_sector->id, ['id' => 'id']) !!}
@include('trade_sector.form', [
    'trade_sector' => $trade_sector,
])
{!! Form::close() !!}
