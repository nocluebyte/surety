
{!! Form::model($smtp_configuration, ['route' => ['smtp-configuration.update', encryptId($smtp_configuration->id)],'id' => 'smtpConfigurationForm']) !!}
@method('PUT')
{!! Form::hidden ('id', $smtp_configuration->id ,['id' => 'id', 'class' => 'jsId' ])!!}
@include('smtp-configuration.form',[
        'smtp_configuration' => $smtp_configuration
    ])

{!! Form::close() !!}

