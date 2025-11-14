@extends('app-modal')
@section('modal-title', __('rejection_reason.rejection_reason'))
@method('POST')
@section('modal-content')
    <div class="form-group">
        {{ Form::label('rejection_reason', __('rejection_reason.reason')) }}<i class="text-danger">*</i>
        {{ Form::select('rejection_reason', ['' => ''] + $rejection_reason + ['Other' => 'Other'], null, ['class' => 'form-control required rejection_reason', 'style' => 'width:100%;', 'data-placeholder' => 'Select Rejection Reason', 'data-ajaxurl' => route('getRejectionReasonData')]) }}
    </div>

    <div class="form-group">
        {!! Form::label('description', __('rejection_reason.description')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('description', $rejection_reason->description ?? null, [
            'class' => 'form-control required description',
            'rows' => 4,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>

@section('modal-btn', __('common.save'))

@endsection

<script>
    $('.rejection_reason').select2({
        allowClear: true,
    });

    $('.rejection_reason').on('change', function() {
        let rejection_reason = $(this).val();

        if (rejection_reason.length === 0) {
            $(".description").val("");
        }

        if (rejection_reason > 0) {
            let ajaxUrl = $(this).attr('data-ajaxurl');

            $.ajax({
                type: "GET",
                url: ajaxUrl,
                data: {
                    'rejection_reason': rejection_reason,
                },
            }).always(function() {

            }).done(function(response) {
                if (response) {
                    $(".description").val(response.description).addClass('required');

                } else {
                    $(".description").val('');
                }
            })
        }
    });

    $(document).ready(function() {
        initValidation();
    });

    var initValidation = function() {
        $('#proposalRejection').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {

            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                $('#btn_loader').addClass('spinner spinner-white spinner-left');
                $('#btn_loader').prop('disabled', true);
                return true;
            }
        });
    };
</script>
