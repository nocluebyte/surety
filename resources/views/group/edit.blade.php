{{-- Extends layout --}}
@extends($theme)
{{-- Content --}}
@section('content')
@section('title', __('group.group') )

@component('partials._subheader.subheader-v6',
[
'page_title' => __('group.edit_group'),
'back_action'=> url('group'),
'text' => __('common.back'),
'permission' => true,
])
@endcomponent

{!! Form::model($group, ['route' => ['group.update', encryptId($group->id)], 'id' => 'groupForm']) !!}
    @method('PUT')
    {{-- @dd($group) --}}
    {!! Form::hidden('id', $group->id, ['id' => 'id']) !!}
    @include('group.form',[
        'group' => $group
    ])
{!! Form::close() !!}


@endsection
@include('group.script')