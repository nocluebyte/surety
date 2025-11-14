@extends($theme)
@section('content')
@section('title', $title)
@component('partials._subheader.subheader-v6',[
'page_title' => $title,
'back_action'=> $backAction,
'text' => __('common.back'),
'permission' => $current_user->hasAnyAccess(['users.superadmin', 'proposals.bond_cancellation']),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => 'bondCancellationStore',
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'bondCancellationForm',
        ]) !!}
        {!! Form::hidden('proposal_id', $proposal->id ?? null) !!}
        {!! Form::hidden('type', $type ?? null) !!}
        {!! Form::hidden('back_action_id', $back_action_id ?? null) !!}
        @include('bond_cancellation.form', [
            'bond_cancellation' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>
@endsection