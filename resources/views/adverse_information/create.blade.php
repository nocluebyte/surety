{{-- {!! Form::open(['route' => 'adverse-information.store', 'id' => 'adverseInformationForm', 'enctype' => 'multipart/form-data',]) !!}
@include('adverse_information.form', [
    'adverse_information' => null,
])
{!! Form::close() !!} --}}

@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('adverse_information.add_adverse_information'),
    'back_action' => route('adverse-information.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'adverse-information.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'adverseInformationForm',
        ]) !!}
        @include('adverse_information.form', [
            'adverse_information' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
