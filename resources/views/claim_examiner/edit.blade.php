@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('claim_examiner.edit_claim_examiner'),
    'back_action' => route('claim-examiner.show', encryptId($claim_examiner->id)),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($claim_examiner, [
            'route' => ['claim-examiner.update', encryptId($claim_examiner->id)],
            'id' => 'claimExaminerForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $claim_examiner->id, ['id' => 'id']) !!}
        @include('claim_examiner.form', [
            'claim_examiner' => $claim_examiner,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
