{!! Form::open(['route' => 'settings.store', 'id' => 'settingForm']) !!}
{{ Form::hidden('group', 'invoice', ['class' => 'form-control', 'required']) }}


<div class="row">
    <div class="form-group col-lg-4">
        {{ Form::label('default_bill_print', __('settings.bill_print')) }}<i class="text-danger">*</i>
        {!! Form::select(
            'default_bill_print',
            ['original' => 'Original', 'duplicate' => 'Duplicate', 'triplicate' => 'Triplicate'],
            $settings['default_bill_print'] ?? '',
            [
                'class' => 'form-control',
                'style' => 'width: 100%;',
                'id' => 'default_bill_print',
                'data-placeholder' => 'Select Bill Print',
                'required',
            ],
        ) !!}

    </div>

    <div class="form-group col-lg-4">
        
    </div>
</div>

<div class="form-group col-12">
    {{Form::label('term_condition', __('settings.term_condition'))}}<i class="text-danger">*</i>
    {{ Form::textarea('terms_and_condition', $settings['terms_and_condition'] ?? '', ['class' => 'form-control', 'rows' => 4, 'id' => 'message_body', 'required']) }}
</div>
<div class="row">
    <div class="col-12 text-right">
        <a href="" class="mr-2">{{ __('common.cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
    </div>
</div>
{!! Form::close() !!}
<script src="//cdn.ckeditor.com/4.5.6/standard/ckeditor.js"></script>
@push('scripts')
    <script>
        // CKEDITOR.replace( 'message_body' );
    </script>
@endpush
