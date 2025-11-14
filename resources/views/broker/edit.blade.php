@extends($theme)
@section('content')
@section('title', __('broker.broker'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('broker.edit_broker'),
    'back_action' => route('broker.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($broker, [
            'route' => ['broker.update', encryptId($broker->id)],
            'id' => 'brokerForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $broker->id, ['id' => 'id']) !!}
        @include('broker.form', [
            'broker' => $broker,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
