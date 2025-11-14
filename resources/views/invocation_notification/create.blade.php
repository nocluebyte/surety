@extends($theme)
@section('content')
@section('title', __('invocation_notification.invocation_notification'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('invocation_notification.add_invocation_notification'),
    'back_action' => $back_action ?? route('invocation-notification.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'invocation-notification.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'bondInvocationNotificationForm',
        ]) !!}
        @include('invocation_notification.form', [
            'invocation_notification' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
