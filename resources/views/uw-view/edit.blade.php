{!! Form::model($uwView, [
    'route' => ['uw-view.update', $uwView->id],
    'id' => 'uwViewForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $uwView->id, ['id' => 'id']) !!}
@include('uw-view.form', [
    'uw-view' => $uwView,
])
{!! Form::close() !!}
