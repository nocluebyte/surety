{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', $title)
@component('partials._subheader.subheader-v6',[
'page_title' => $title,
'back_action'=> url('proposals',[encryptId($proposal->id)]),
'text' => __('common.back'),
'permission' => $current_user->hasAnyAccess(['users.superadmin','nbi.add']),
])
@endcomponent
{!! Form::open(['route' => 'nbi.store','id' => 'nbiForm','enctype' => 'multipart/form-data']) !!}
@include('nbi.form',['nbi' => null])
{!! Form::close() !!}
@endsection