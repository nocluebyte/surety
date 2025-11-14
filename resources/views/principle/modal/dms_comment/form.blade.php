@extends('app-modal')
@section('modal-title', $title)
@section('modal-size','modal-l')
@section('modal-content')

<input type="hidden" name="dms_id" value="{{$dms_attachment->id}}">
<div class="modal-body">
    <div class="mb-3">
        <div class="form-group ">
            {{Form::label(__('cases.comment'), __('cases.comment'))}}<i class="text-danger">*</i>
            {{Form::textarea('comment',null,['class' => 'form-control required', 'rows' => 2, 'data-rule-Remarks' => true,]);}}
        </div>
    </div>
</div>

@section('modal-btn',  __('common.save'))
@endsection
@section('script')
<script>
    $(document).ready(function(){
        dmsCommentForm();
    });
    var dmsCommentForm = function() {
        $('#dmsCommentForm').validate({
            debug: false,
            ignore: [],
            rules: {
            
            },
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
@endsection
