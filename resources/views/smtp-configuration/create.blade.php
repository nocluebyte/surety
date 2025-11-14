
{!! Form::open(['route' => 'smtp-configuration.store','id' => 'smtpConfigurationForm']) !!}
{!! Form::hidden ('id',0 ,['id' => 'id', 'class' => 'jsId' ])!!}

@include('smtp-configuration.form',[
        'smtp_configuration' => null
    ])

{!! Form::close() !!}