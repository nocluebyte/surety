@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => $title,
    'back_action'=> route('proposals.show',[$proposal->id]),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        {!! Form::model($nbi, ['route' => ['nbi.update', $nbi->id],'id' => 'nbiForm','enctype' => 'multipart/form-data']) !!}
        @method('PUT')
        {!! Form::hidden('id', $nbi->id, ['id' => 'id']) !!}
        @include('nbi.form',['nbi' => $nbi])
        {!! Form::close() !!}
    </div>
</div>

@endsection
