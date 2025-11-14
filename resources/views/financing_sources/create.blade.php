{!! Form::open(['route' => 'financing_sources.store', 'id' => 'financingSourcesForm']) !!}
@include('financing_sources.form', [
    'financing_sources' => null,
])
{!! Form::close() !!}
