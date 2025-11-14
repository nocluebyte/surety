@extends('app-modal')
@section('modal-title', $title)
@section('modal-size','modal-xl')
@section('modal-content')

<input type="hidden" name="id" value="{{$user->id}}">
<div class="modal-body">
    <div class="mb-3">
        <label class="col-form-label" for="recipient-name">Email:</label><i class="text-danger">*</i><br>
        {!! Form::text('email', $user->email, ['class' => 'form-control required']) !!}
    </div>
    <div class="mb-3">
        <label class="col-form-label" for="recipient-name">Subject:</label><i class="text-danger">*</i><br>
        {!! Form::text('subject', $subject, ['class' => 'form-control required']) !!}
    </div>
    <div class="mb-3">
        <div class="form-group ">
            {{Form::label(__('mail_template.message_body'), __('mail_template.message_body'))}}<i class="text-danger">*</i>
            {{Form::textarea('message', $message_body ,['class' => 'form-control', 'rows' => 5, 'id'=>'message_body']);}}
        </div>
    </div>
</div>

@section('modal-btn',  __('common.save'))
@endsection
@section('script')
<script>
    $(document).ready(function() {
        initValidation();
        getCkEditor('message_body', imageUpload = true);
    });

    var initValidation = function() {
        $('#sendMailDmsInsert').validate({
            debug: false,
            ignore: [],
            rules: {
                message: {
                    check_ck_add_method: true,
                }
                // description: {
                //     required: function() {
                //         CKEDITOR.instances.cktext.updateElement();
                //     },
                // }
            },
            messages: {
                message: {
                    check_ck_add_method: "This field is required",
                },
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

    $.validator.addMethod("check_ck_add_method", function(value, element) {
        return check_ck_editor('message_body');
    });
</script>
@endsection
