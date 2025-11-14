@extends($theme)
@section('content')
@section('title', __('insurance_companies.insurance_companies'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('insurance_companies.add_insurance_companies'),
    'back_action' => route('insurance_companies.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'insurance_companies.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'insuranceCompaniesForm',
        ]) !!}
        @include('insurance_companies.form', [
            'insurance_companies' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
