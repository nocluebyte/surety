<script type="text/javascript">
    jQuery(document).ready(function () {
        initValidation();
        jQuery("#name").on('keyup', function () {
            var Text = jQuery(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            jQuery("#slug").val(Text);
        });
    });

    var initValidation = function () {
        jQuery('#roleForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                name: {
                    required: true,
                },
                slug: {
                    required: true,
                },
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
                jQuery('#btn_loader').addClass('spinner spinner-white spinner-left');
                jQuery('#btn_loader').prop('disabled',true);
                return true;
            }
        });
    };
</script>