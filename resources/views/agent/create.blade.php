@extends($theme)
@section('content')
@section('title', __('agent.agent'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('agent.add_agent'),
    'back_action' => route('agent.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'agent.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'agentForm',
        ]) !!}
        @include('agent.form', [
            'agent' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
