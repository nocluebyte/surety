{!! Form::model($dms, ['route' => ['dms.update', encryptId($dms->id)],'id' => 'dmsForm']) !!}
@method('PUT')
{!! Form::hidden('id', $dms->id, ['id' => 'id']) !!}
@include('dms.contractor.form', ['dms' => $dms])
{!! Form::close() !!}
