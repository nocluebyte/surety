@extends($theme)
@section('content')
@section('title', __('invocation_claims.invocation_claims'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('invocation_claims.invocation_claims'),
    'back_action' => $back_action ?? route('invocation-claims.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'invocation-claims.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'bondInvocationClaimsForm',
        ]) !!}
        @include('invocation_claims.form', [
            'invocation_claims' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
