@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#projectDetailsForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    project_end_date: {
                        min: () => $(".project_start_date").val(),
                    },
                },
                messages: {
                    project_end_date: {
                        min: () => "Please enter a value greater than or equal to " + moment($(".project_start_date").val()).format('DD/MM/YYYY'),
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
        }

        // $(document).on('change', '.jsPeriod', function() {
        //     var startDate = $('.project_start_date').val();
        //     $('.project_end_date').attr('min', startDate).attr('data-msg-min',
        //         'Please enter a Date greater than or equal to ' + moment(startDate).format('DD/MM/YYYY'));

        //     var endDate = $('.project_end_date').val();
        //     $('.project_start_date').attr('max', endDate).attr('data-msg-max',
        //         'Please enter a Date less than or equal to ' + moment(endDate).format('DD/MM/YYYY'));

        //     if (startDate != '' && endDate != '') {
        //         $('.jsProjectPeriod').val(daysCalculate(startDate, endDate));
        //     }
        // });

        $(".project_start_date, .project_end_date").change(function() {
            const startDate = $('.project_start_date').val();
            const endDate = $('.project_end_date').val();

            if (!startDate || !endDate) {
                $('.jsProjectPeriod').val('');
                return;
            }

            $('.jsProjectPeriod').val(dateDifferenceInDays(startDate, endDate));
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        $(document).on('change', '.beneficiary_id', function(){
            var beneficiary_id = $(this).val();
            var ajaxUrl = $(this).attr('data-ajaxUrl');

            if(beneficiary_id > 0){
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'beneficiary_id' : beneficiary_id,
                    },
                    success: function(response) {
                        console.log(response);
                        
                        if (response) {
                            $('.currency_symbol').text(' (' + response + ')');
                        } else {
                            $('.currency_symbol').text('');

                        }
                    },
                    error: function() {
                        $('.currency_symbol').text('');
                    }
                });
            }
        });
    </script>
@endpush
