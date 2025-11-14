
{!! Form::open(['route' => 'tenure.store','id' => 'tenureForm']) !!}
@include('tenure.form',[
                    'tenures' => null
                ])
{!! Form::close() !!}