{!! Form::model($designation, [
    'route' => ['designation.update', encryptId($designation->id)],
    'id' => 'designationForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $designation->id, ['id' => 'id']) !!}
@include('designation.form', [
    'designation' => $designation,
])
{!! Form::close() !!}
