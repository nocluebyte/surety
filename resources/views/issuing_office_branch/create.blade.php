@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('issuing_office_branch.add_issuing_office_branch'),
    'back_action' => route('issuing-office-branch.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'issuing-office-branch.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'issuingOfficeBranchForm',
        ]) !!}
        @include('issuing_office_branch.form', [
            'issuing_office_branch' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
