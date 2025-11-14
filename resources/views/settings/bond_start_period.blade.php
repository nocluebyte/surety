{!! Form::open(['route' => 'settings.store', 'id' => 'bond_start_period', 'enctype' => 'multipart/form-data']) !!}
{{ Form::hidden('group', 'bond_start_period') }}

<div class="row">
    <div class="col-6 form-group">
        {{ Form::hidden('group', 'bond_start_period', ['class' => 'form-control', 'required']) }}
        {!! Form::label('bond_start_period', __('settings.bond_start_period')) !!}<i class="text-danger">*</i>
        {!! Form::number('bond_start_period', $settings['bond_start_period'] ?? null, [
            'class' => 'form-control required',
            'name' => 'bond_start_period',
            'min' => '0',
            'max' => '999',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('initial_fd_validity', __('settings.initial_fd_validity')) !!}<i class="text-danger">*</i>
        {!! Form::number('initial_fd_validity', $settings['initial_fd_validity'] ?? null, [
            'class' => 'form-control required',
            'name' => 'initial_fd_validity',
            'min' => '1',
            'max' => '365',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('extension_period', __('settings.extension_period')) !!}<i class="text-danger">*</i>
        {!! Form::number('extension_period', $settings['extension_period'] ?? null, [
            'class' => 'form-control required',
            'name' => 'extension_period',
            'min' => '1',
            'max' => '999',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('expiring_bond', __('settings.expiring_bond')) !!}<i class="text-danger">*</i>
        {!! Form::number('expiring_bond', $settings['expiring_bond'] ?? null, [
            'class' => 'form-control required',
            'name' => 'expiring_bond',
            'min' => '1',
            'max' => '180',
            'data-msg-min' => 'You are not allow to add days less then 1.',
            'data-msg-max' => 'You are not allow to add days more then 180.',
            'data-rule-Numbers' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
    </div>
</div>

{!! Form::close() !!}
