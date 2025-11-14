@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#issuingOfficeBranchForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
            });
        };

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.JsGstNo').removeClass('d-none');
                    $('.gst_no').addClass('required');
                } else {
                    $('.JsGstNo').addClass('d-none');
                    $('.gst_no').removeClass('required').val('');
                }
            }
        }

        $('#country').on('select2:select', function() {
            isCountryIndia();
        });

        $(document).ready(function() {
            isCountryIndia();
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
