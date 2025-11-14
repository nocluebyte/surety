@extends($theme)
@section('content')
@section('title', __('proposals.proposals'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('proposals.add_proposals'),
    'back_action' => route('proposals.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'proposals.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'proposalsForm',
        ]) !!}
        @include('proposals.form', [
            'proposals' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
@include('proposals.scripts.autosave_create_script')
