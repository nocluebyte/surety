@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#underWriterForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    overall_cap: {
                        required: true,
                        min: function() {
                            return parseInt($('#individual_cap').val());
                        }
                    },

                    group_cap: {
                        required: true,
                        min: function() {
                            return parseInt($('#overall_cap').val());
                        }
                    },
                },
                messages: {
                    overall_cap: {
                        min: "Please enter a value greater than or equal to Individual Cap.",
                    },

                    group_cap: {
                        min: "Please enter a value greater than or equal to Overall Cap.",
                    },
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

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.panNoField').removeClass('d-none');
                    $('.pan_no').addClass('required');
                } else {
                    $('.panNoField').addClass('d-none');
                    $('.pan_no').removeClass('required').val('');
                }
            }
        }

        $('#country').on('select2:select', function() {
            isCountryIndia();
        });

        $(document).ready(function() {
            isCountryIndia();
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        $(document).on('change', '#country', function(){
            getCountryCurrencySymbol($(this));
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
