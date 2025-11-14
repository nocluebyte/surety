@extends($theme)
@section('content')
@section('title', __('underwriter.underwriter'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('underwriter.add_underwriter'),
    'back_action' => route('underwriter.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'underwriter.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'underWriterForm',
        ]) !!}
        @include('underwriter.form', [
            'underwriter' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
