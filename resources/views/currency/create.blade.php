{!! Form::open(['route' => 'currency.store','id' => 'currencyForm']) !!}
@include('currency.form',['currency' => null])
{!! Form::close() !!}