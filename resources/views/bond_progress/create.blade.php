@extends($theme)
@section('content')
@section('title', $title)
@component('partials._subheader.subheader-v6',[
'page_title' => $title,
'back_action'=> $backAction,
'text' => __('common.back'),
'permission' => $current_user->hasAnyAccess(['users.superadmin', 'proposals.bond_progress']),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::open([
            'route' => ['bond-progress.store'],
            'role' => 'form',
            'enctype' => 'multipart/form-data',
            'id' => 'bondProgressForm',
        ]) !!}
        {!! Form::hidden('type', $type ?? null) !!}
        {!! Form::hidden('back_action_id', $back_action_id ?? null) !!}
        @include('bond_progress.form', [
            'bond_progress' => null,
        ])
        {!! Form::close() !!}
    </div>
</div>
@endsection