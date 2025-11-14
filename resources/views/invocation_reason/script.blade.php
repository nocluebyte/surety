<script>
    $(document).ready(function(){
        initValidation();
    });

    var initValidation = function(){
        $('#invocationReasonForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules:{},
            message:{},
            errorClass:'text-danger',
            errorPlacement:function(error, element){
                error.appendTo(element.parent());
            },
            submitHandlser:function(e){
                $('#btn_loader').addClass('spinner spinner-white spinner-left');
                $('#btn_loader').prop('disabled', true);
                return true;
            }
        });
    }
</script>