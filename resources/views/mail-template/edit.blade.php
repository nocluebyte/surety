
{!! Form::model($mail_template, ['route' => ['mail-template.update', encryptId($mail_template->id)],'id' => 'mailTemplateForm','files'=>'true']) !!}
@method('PUT')
{!! Form::hidden ('id', $mail_template->id ,['id' => 'id', 'class' => 'jsId' ])!!}
@include('mail-template.form',[
        'mail_template' => $mail_template,
    ])

{!! Form::close() !!}

