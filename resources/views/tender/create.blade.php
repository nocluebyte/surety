@extends($theme)
@section('content')
@section('title', __('tender.tender'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('tender.add_tender'),
    'back_action' => route('tender.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'tender.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'tenderForm',
        ]) !!}

        @include('tender.form', [
            'tender' => null,
        ])

        {!! Form::close() !!}
    </div>
</div>

@endsection