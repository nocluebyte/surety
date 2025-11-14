{!! Form::open(['route' => 'settings.store', 'id' => 'issue_bond_print', 'enctype' => 'multipart/form-data']) !!}
{{ Form::hidden('group', 'issue_bond_print') }}
{{-- @php
    $print_description = isset($settings['print_description']) ? json_decode($settings['print_description']) : [];
@endphp --}}
<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('issue_bond_note', __('settings.issue_bond_note')) !!}<i class="text-danger">*</i>
        {!! Form::textArea('issue_bond_note', $settings['issue_bond_note'] ?? null, ['class' => 'form-control issue_bond_note','id' => 'issue_bond_note'])!!}
    </div>

    <div class="col-12 form-group">
        {!! Form::label('issue_bond_footer', __('settings.issue_bond_footer')) !!}<i class="text-danger">*</i>
        {!! Form::textArea('issue_bond_footer', $settings['issue_bond_footer'] ?? null, [
            'class' => 'form-control',
        ]) !!}
    </div>

    <div class="col-12 form-group">
        {!! Form::label('issue_bond_declaration', __('settings.issue_bond_declaration')) !!}<i class="text-danger">*</i>
        {!! Form::textArea('issue_bond_declaration', $settings['issue_bond_declaration'] ?? null, [
            'class' => 'form-control',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary jsPrintSaveBtn">{{ __('common.save') }}</button>
    </div>
</div>

{!! Form::close() !!}
