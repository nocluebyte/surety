@extends($theme)
@section('content')
@section('title', __('principle.principle'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('principle.add_principle'),
    'back_action' => route('principle.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'principle.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'principleForm',
        ]) !!}
        @include('principle.form', [
            'principle' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
