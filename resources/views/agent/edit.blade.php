@extends($theme)
@section('content')
@section('title', __('agent.agent'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('agent.edit_agent'),
    'back_action' => route('agent.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($agent, [
            'route' => ['agent.update', encryptId($agent->id)],
            'id' => 'agentForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $agent->id, ['id' => 'id']) !!}
        @include('agent.form', [
            'agent' => $agent,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
