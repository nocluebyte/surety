{!! Form::model($currency, ['route' => ['currency.update', encryptId($currency->id)],'id' => 'currencyForm']) !!}
@method('PUT')
{!! Form::hidden ('id', $currency->id ,['id' => 'id' ])!!}
@include('currency.form',['currency' => $currency])
{!! Form::close() !!}

