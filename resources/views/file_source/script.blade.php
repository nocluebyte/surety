<script type="text/javascript">
    $(document).ready(function() {
        initValidation();
    });

    var initValidation = function() {
        $('#fileSourceForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                // name: {
                //     required: true,
                // },
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
