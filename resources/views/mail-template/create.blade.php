
{!! Form::open(['route' => 'mail-template.store','id' => 'mailTemplateForm','files'=>'true']) !!}
{!! Form::hidden ('id',0 ,['id' => 'id', 'class' => 'jsId' ])!!}

@include('mail-template.form',[
        'mail_template' => null
    ])

{!! Form::close() !!}