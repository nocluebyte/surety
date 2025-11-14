{!! Form::open(['route' => 'settings.store', 'id' => 'print', 'enctype' => 'multipart/form-data']) !!}
{{ Form::hidden('group', 'print') }}
@php
$print_logo = $settings['print_logo'] ?? '';
$print_description = (isset($settings['print_description'])) ? json_decode($settings['print_description']) : [];
@endphp
<div class="row">
    <div class="col-lg-6 form-group">
        {!! Form::label('print_logo', __('settings.logo')) !!}<i class="text-danger">*</i>
        {!! Form::file('print_logo', ['id' => 'print_logo','class' => 'form-control jsDisabled', 'data-rule-extension'=>'jpg|jpeg|png', 'data-msg-extension'=>'please upload valid file jpg|jpeg|png','data-rule-filesize'=>'20971520', 'data-msg-filesize'=>'File size must be less than or equal to 20 MB','required'=>($print_logo) ? false : true]) !!}
        @if($print_logo)
            <a href="{{ isset($print_logo) && !empty($print_logo) ? route('secure-file', encryptId($print_logo)) : asset('/default.jpg') }}" target="__blank">{{ basename($print_logo) }}</a>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        {!! Form::label('print_company_address_title', __('settings.company_address_title')) !!}<i class="text-danger">*</i>
        {!! Form::text('print_company_address_title', $settings['print_company_address_title'] ?? null, ['class' => 'form-control required','data-rule-AlphabetsV3'=>true])!!}
    </div>
    <div class="col-lg-6 form-group">
        {!! Form::label('print_company_address', __('settings.company_address')) !!}<i class="text-danger">*</i>
        {!! Form::text('print_company_address', $settings['print_company_address'] ?? null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV4'=>true])!!}
    </div>
    <div class="col-lg-6 form-group">
        {!! Form::label('print_email_id', __('settings.email_id')) !!}<i class="text-danger">*</i>
        {!! Form::email('print_email_id', $settings['print_email_id'] ?? null, ['class' => 'form-control required'])!!}
    </div>
    <div class="col-lg-6 form-group">
        {!! Form::label('print_title', __('settings.print_title')) !!}<i class="text-danger">*</i>
        {!! Form::text('print_title', $settings['print_title'] ?? null, ['class' => 'form-control required','data-rule-AlphabetsV3'=>true])!!}
    </div>
    <div class="col-lg-12 form-group">
        {!! Form::label('print_disclosure', __('settings.disclosure')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('print_disclosure', $settings['print_disclosure'] ?? null, ['class' => 'form-control required'])!!}
    </div>
    {{-- <div class="col-lg-6 form-group">
        {!! Form::label('print_documentation', __('settings.documentation')) !!}<i class="text-danger">*</i>
        {!! Form::text('print_documentation', $settings['print_documentation'] ?? null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV2'=>true])!!}
    </div> --}}
</div>
<div class="row">
    <div class="col-12">
        <div id="printRepeater">
            <table class="table table-separate table-head-custom table-checkable tradeSector" id="prints" data-repeater-list="prints">
                <thead>
                    <tr>
                        <th>{{ __('common.no') }}</th>
                        <th width="16%">{{ __('settings.title') }}<span class="text-danger">*</span></th>
                        <th>{{ __('settings.description') }}<span class="text-danger">*</span></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($print_description) && count($print_description) > 0)
                        @foreach($print_description as $pd_key => $pd_row)
                            <tr data-repeater-item="" class="jsPrintRow">
                                <td class="jsPrintNo">{{ $loop->index+1 }}</td>
                                <td>
                                    {!! Form::text('print_title', $pd_row->print_title ?? null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV2'=>true])!!}
                                </td>
                                <td>
                                    {!! Form::textArea('print_description', $pd_row->print_description ?? null, ['class' => 'form-control jsPrintDescription'])!!}
                                    <label class="text-danger jsPrintDescriptionError"></label>
                                </td>
                                <td>
                                    <div class="jsLocationDelete">
                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr data-repeater-item="" class="jsPrintRow">
                        <td class="jsPrintNo">1</td>
                        <td>
                            {!! Form::text('print_title', null, ['class' => 'form-control required','data-rule-AlphabetsAndNumbersV2'=>true])!!}
                        </td>
                        <td>
                            {!! Form::textArea('print_description', $settings['print_description'] ?? null, ['class' => 'form-control jsPrintDescription'])!!}
                            <label class="text-danger jsPrintDescriptionError"></label>
                        </td>
                        <td>
                            <div class="jsLocationDelete">
                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2"> <i class="flaticon-delete"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="col-md-12 col-12">
                <button type="button" data-repeater-create="" class="btn btn-outline-primary btn-sm jsPrintAdd">
                    <i class="fa fa-plus-circle"></i>{{ __('common.add') }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary jsPrintSaveBtn">{{ __('common.save') }}</button>
    </div>
</div>

{!! Form::close() !!}
