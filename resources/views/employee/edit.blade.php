@extends($theme)
@section('content')
@section('title', $title)

@component('partials._subheader.subheader-v6', [
    'page_title' => __('employee.edit_employee'),
    'back_action' => route('employee.index'),
    'text' => __('common.back'),
])
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        {!! Form::model($employee, [
            'route' => ['employee.update', encryptId($employee->id)],
            'id' => 'employeeForm',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @method('PUT')
        {!! Form::hidden('id', $employee->id, ['id' => 'id']) !!}
        @include('employee.form', [
            'employee' => $employee,
        ])
        {!! Form::close() !!}
    </div>
</div>

@endsection
