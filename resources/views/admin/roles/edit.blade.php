{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')
@section('title', __('roles.title'))
@component('partials._subheader.subheader-v6', [
    'page_title' => __('roles.title'),
    'back_action' => url('roles'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($role, [
            'route' => ['roles.update', encryptId($role->id)],
            'id' => 'roleForm',
            'class' => 'form-horizontal',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $role->id, ['id' => 'id']) !!}
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>{{ __('roles.form.name') }} :<span class="text-danger">*</span></label>
                        {!! Form::text('name', $role->name, [
                            'class' => 'form-control form-control-solid required',
                            'id' => 'name',
                            'readonly',
                        ]) !!}
                        {{-- <input type="text" class="form-control" placeholder=""> --}}
                    </div>

                    <div class="form-group col-lg-6">
                        <label>{{ __('roles.form.slug') }} :<span class="text-danger">*</span></label>
                        {!! Form::text('slug', $role->slug, [
                            'class' => 'form-control form-control-solid required',
                            'id' => 'slug',
                            'readonly',
                        ]) !!}
                        {{--  <input type="text" class="form-control form-control-solid" readonly="" placeholder=""> --}}
                    </div>
                </div>
            </div>
        </div>
        <h2>{{ __('roles.form.permissions') }}</h2>
        <div class="row">
            <div class="col-8">
                @include('admin.roles.permission_form')
            </div>
            <div class="col-4">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        @if (count($groupPermissions) > 0 && count($all_permission) > 0)
                            @foreach ($all_permission as $area => $permissions)
                                @if (!empty($groupPermissions))
                                    @php
                                        $count = 0;
                                        $html = '';
                                    @endphp
                                    @foreach ($permissions as $permission)
                                        @if (array_key_exists($permission['permission'], $groupPermissions) == true)
                                            @php
                                                $count++;
                                                $html .=
                                                    '<li>' .
                                                    ucfirst(str_replace('_', ' ', $permission['label'])) .
                                                    '</li>';
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if ($count > 0)
                                        <h6>{{ ucwords(str_replace(['_', '-'], [' ', ' '], $area)) }}</h6>
                                        <ul>{!! $html !!}</ul>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer pb-5 pt-5">
            <div class="row">
                <div class="col-12 text-right">
                    {!! link_to(URL::full(), 'Cancel', ['class' => 'btn btn-light-primary font-weight-bold']) !!}
                    {!! Form::submit('Save', ['name' => 'save', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@endsection
@section('styles')
<style type="text/css">
    .card.card-style {
        border: 1px solid rgba(0, 0, 0, 0.121569);
        border-color: burlywood;
    }
</style>
@endsection

@section('scripts')
@include('admin.roles.script')
@endsection
