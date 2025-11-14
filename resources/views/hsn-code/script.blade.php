<script type="text/javascript">
    $(document).ready(function() {
        initValidation();
    });

    var initValidation = function() {
        $('#hsnCodeForm').validate({
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

    $(document).on('change', '#gst',function(){
        let gstVal = $('#gst option:selected').val();
        let gVal = gstVal / 2;

        $('.JsCgst, .JsSgst').val(gVal);
        $('.JsIgst').val(gstVal);
    });

    $('#gst').select2({
        allowClear: true,
    });
</script>
