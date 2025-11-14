{!! Form::open(['route' => 'cases.sendcaseDmsMail','role' => 'form','id' => 'sendMailDmsInsert'])!!}
    @csrf
    @include('cases.modal.dms.dms_mail.form')
{!!Form::close()!!}