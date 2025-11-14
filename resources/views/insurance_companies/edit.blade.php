@extends($theme)
@section('content')
@section('title', __('insurance_companies.insurance_companies'))

@component('partials._subheader.subheader-v6', [
    'page_title' => __('insurance_companies.edit_insurance_companies'),
    'back_action' => route('insurance_companies.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($insurance_companies, [
            'route' => ['insurance_companies.update', encryptId($insurance_companies->id)],
            'id' => 'insuranceCompaniesForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $insurance_companies->id, ['id' => 'id']) !!}
        @include('insurance_companies.form', [
            'insurance_companies' => $insurance_companies,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
