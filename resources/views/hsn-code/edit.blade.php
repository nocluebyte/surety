{!! Form::model($hsnCode, [
    'route' => ['hsn-code.update', encryptId($hsnCode->id)],
    'id' => 'hsnCodeForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $hsnCode->id, ['id' => 'id']) !!}
@include('hsn-code.form', [
    'hsn-code' => $hsnCode,
])
{!! Form::close() !!}
