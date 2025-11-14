{!! Form::model($financing_sources, [
    'route' => ['financing_sources.update', encryptId($financing_sources->id)],
    'id' => 'financingSourcesForm',
]) !!}
@method('PUT')
{!! Form::hidden('id', $financing_sources->id, ['id' => 'id']) !!}
@include('financing_sources.form', [
    'financing_sources' => $financing_sources,
])
{!! Form::close() !!}
