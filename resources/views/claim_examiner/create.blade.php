@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('claim_examiner.add_claim_examiner'),
    'back_action' => route('claim-examiner.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'claim-examiner.store',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'claimExaminerForm',
        ]) !!}
        @include('claim_examiner.form', [
            'claim_examiner' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
