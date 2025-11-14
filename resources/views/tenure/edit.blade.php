{!! Form::model($tenure, ['route' => ['tenure.update', $tenure->id], 'id' => 'tenureForm']) !!}
    @method('PUT')
    {!! Form::hidden('id', $tenure->id, ['id' => 'id']) !!}
    @include('tenure.form',[
        'tenures' => $tenure
    ])
{!! Form::close() !!}
