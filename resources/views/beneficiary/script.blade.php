@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
            $('.jsTradeSector').select2({
                allowClear: true
            });
        });

        let initValidation = function() {
            jQuery.validator.addClassRules("minDate", {
                min: () => $('.from').val()
            });

            $('#beneficiaryForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                },
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    if ($('.main:checked').length === 0) {
                        errorMessage('Please check at least one main in trade sector')
                        return false;
                    }
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
            });

            $('#tradeSectorRepeater').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function() {
                    $(this).find('.trade-list-no').text($(this).index() + 1 + ' .');
                    $('.trade_sector').select2({
                        allowClear: true,
                    });
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
                                $('.trade-list-no').each(function(index) {
                                    $(this).html(index + 1);
                                });
                            }, 500);
                        }
                    });
                },

                ready: function(setIndexes) {
                    $('.trade_sector').select2({
                        allowClear: true,
                    });
                },
                isFirstItemUndeletable: true

            });
        };

        $(document).on('change', '.from', function() {
            var row = $(this).closest('.trade_sector_row');
            var fromDate = moment(row.find('.from').val()).format('DD/MM/YYYY');
            row.find('.till').attr('data-msg-min', "Please enter a value greater than or equal to " +
                fromDate);
        });

        $('form').on('click', '.beneficiary_type', function() {
            if($('.beneficiary_type:checked').val() == 'Government') {
                $('#ministry_type').addClass('required');
                $('.ministryType').removeClass('d-none');
            } else {
                $('#ministry_type').removeClass('required');
                $('.ministryType').addClass('d-none');
                $('#ministry_type').val(null).trigger("change.select2");
            }
        });

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.gstAndPanNoFields').removeClass('d-none');
                    $('.gst_no').addClass('required');
                    $('.pan_no').addClass('required');
                } else {
                    $('.gstAndPanNoFields').addClass('d-none');
                    $('.gst_no').removeClass('required').val('');
                    $('.pan_no').removeClass('required').val('');
                }
            }
        }

        $('#country').on('select2:select', function() {
            isCountryIndia();
            var countryName = $('#country').find("option:selected").text();
            checkPinCodeValidation('jsPinCode', 'pin_code', countryName);
        });

        $(document).ready(function() {
            isCountryIndia();
        });

        $(document).on("change", ".main", function() {
            $('.main').each(function() {
                $(this).prop("checked", "").removeClass('required');
            });
            $(this).prop("checked", "checked").addClass('required');
        });

        function checkExitTradeSector(_this = '') {
            var tradeSector = _this.val();
            var isExits = false
            $('.trade_sector').each(function(key, value) {
                if (!_this.is($(this))) {
                    if ($(this).val() == tradeSector) {
                        isExits = true;
                    }
                }
            });
            return isExits;
        }

        $(document).on("change", ".trade_sector", function() {
            var _ths = $(this);
            var dataRow = $(this).closest('.trade_sector_row');
            if (checkExitTradeSector(_ths)) {
                $(".item-dul-error").removeClass('d-none')
                dataRow.find(".jsTradeSector").val('').select2({
                    allowClear: true,
                });
            } else {
                $(".item-dul-error").addClass('d-none')
            }
        });

        $(".bond_attachment").on("change", function(){
            getAttachmentsCount("bond_attachment");
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        function errorMessage(err_message) {
            message.fire({
                title: '',
                text: err_message,
                type: 'warning',
                customClass: {
                    confirmButton: 'btn btn-success shadow-sm mr-2',
                },
                buttonsStyling: false,
                showCancelButton: false,
                confirmButtonText: 'OK',
            }).then((result) => {

            });
        }
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
