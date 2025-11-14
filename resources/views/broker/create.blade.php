@extends($theme)
@section('content')
@section('title', __('broker.broker'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('broker.add_broker'),
    'back_action' => route('broker.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'broker.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'brokerForm',
        ]) !!}
        @include('broker.form', [
            'broker' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
