<script type="text/javascript">
    $(document).ready(function() {
        initValidation();
    });

    var initValidation = function() {
        $('#stateForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                name: {
                    required: true,
                },
                gst_code: {
                    required: true,
                },
                input_type: {
                    required: true,
                },
            },
            messages: {
                /*name: {
                    required: "The name field is required.",
                },*/
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

        $('#country_id').select2({
            allowClear: true
        });
    };

    let isCountryIndia = () => {
        let country = $('#country_id').find("option:selected").text();
        let countryId = $('#country_id').val();

        if (countryId.length > 0) {
            if (country.toLowerCase() == 'india') {
                $('.jsGstCode').removeClass('d-none');
            } else {
                $('.jsGstCode').addClass('d-none');
                $('.gst_code').removeClass('required').val('');
            }
        }
    }

    $('#country_id').on('select2:select', function() {
        isCountryIndia();
    });

    $(document).ready(function() {
        isCountryIndia();
    });
</script>
