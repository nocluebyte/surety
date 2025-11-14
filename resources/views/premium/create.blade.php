@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('premium.add_premium'),
    'back_action' => route('premium.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'premium.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'premiumForm',
        ]) !!}
        @include('premium.form', [
            'premium' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
