<script type="text/javascript">
    $(document).ready(function () {
        $('.jsPassword').val('<?php echo $smtp_configuration->password ?? ''; ?>');
        $('.jsFromName').val($('.jsUsername').val());
        initValidation();
    });

    var initValidation = function () {

        
        
        $('#smtpConfigurationForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                username: {required: true,},
                password: {required: true,},
            },
            messages: {
                /*name: {
                    required: "The name field is required.",
                },*/
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('#btn_loader').addClass('spinner spinner-white spinner-left');
                $('#btn_loader').prop('disabled',true);
                return true;
            }
        });
    };

    $(document).on('input', '.jsUsername', function(){
        $('.jsFromName').val($(this).val());
    });
</script>