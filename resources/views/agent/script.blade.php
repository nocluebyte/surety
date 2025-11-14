@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#agentForm').validate({
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

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.JsPanNo').removeClass('d-none');
                    $('.pan_no').addClass('required');
                } else {
                    $('.JsPanNo').addClass('d-none');
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

        $('#intermediaryRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.intermediary-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.intermediary-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: true
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
