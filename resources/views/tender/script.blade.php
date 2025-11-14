@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#tenderForm').validate({
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
                    $('select[name="pd_beneficiary"]').prop('disabled', false);
                    $('select[name="beneficiary_id"]').prop('disabled', false);
                    $('select[name="pd_type_of_project"]').prop('disabled', false);
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
            });
        };

        $("#bond_start_date, #bond_end_date").change(function() {
            const dateDifferenceInDays = (dateInitial, dateFinal) => {
                const initialDate = new Date(dateInitial);
                const finalDate = new Date(dateFinal);

                if (isNaN(initialDate.getTime()) || isNaN(finalDate.getTime())) {
                    return '';
                }
                return (finalDate - initialDate) / 86_400_000;
            };

            const startDate = $('#bond_start_date').val();
            const endDate = $('#bond_end_date').val();

            if (!startDate || !endDate) {
                $('#period_of_bond').val('');
                return;
            }

            $('#period_of_bond').val(dateDifferenceInDays(startDate, endDate));
        });

        $('.bond_date').on('change', function() {
            var startDate = $('#bond_start_date').val();
            $('#bond_end_date').attr('min',
                startDate);
        });

        // let isCountryIndia = () => {
        //     let country = $('#country').find("option:selected").text();
        //     let countryId = $('#country').val();

        //     if (countryId.length > 0) {
        //         if (country.toLowerCase() == 'india') {
        //             $('.panNoField').removeClass('d-none');
        //             $('.pan_no').addClass('required');
        //         } else {
        //             $('.panNoField').addClass('d-none');
        //             $('.pan_no').removeClass('required').val('');
        //         }
        //     }
        // }

        // $('#country').on('select2:select', function() {
        //     isCountryIndia();
        // });

        // $(document).ready(function() {
        //     isCountryIndia();
        // });

        $(document).on('change', '.project_details_id', function() {
            let project_details = $(this).val();

            if (project_details.length === 0) {
                projectDetailsFields.forEach(field => {
                    $("." + field).val("");
                    $("." + field).prop('readonly', false).removeClass(
                        'form-control-solid');
                });

                $('select[name="pd_beneficiary"]').val('').trigger('change.select2');
                $('select[name="pd_beneficiary"]').prop('disabled', false);

                $('select[name="pd_type_of_project"]').val('').trigger('change.select2');
                $('select[name="pd_type_of_project"]').prop('disabled', false);

                $('.currency_symbol').empty();
            }

            if (project_details > 0) {
                let ajaxUrl = $(this).attr('data-ajaxurl');

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'project_details_id': project_details,
                    },
                }).always(function() {

                }).done(function(response) {
                    if (response) {
                        projectDetailsFields.forEach(field => {
                            $("." + field).val(response[field]);
                            $("." + field).prop('readonly', true).addClass('form-control-solid');
                        });

                        $('select[name="pd_beneficiary"]').val(response.pd_beneficiary).trigger(
                            'change');
                        $('select[name="pd_beneficiary"]').prop('disabled', true).addClass(
                            'form-control-solid');

                        $('select[name="beneficiary_id"]').val(response.pd_beneficiary).trigger(
                            'change');
                        $('select[name="beneficiary_id"]').prop('disabled', true).addClass(
                            'form-control-solid');

                        $('select[name="pd_type_of_project"]').val(response.pd_type_of_project).trigger(
                            'change');
                        $('select[name="pd_type_of_project"]').prop('disabled', true).addClass('form-control-solid');

                        $('.currency_symbol').text(' (' + response.currency_symbol + ')');

                    } else {
                        projectDetailsFields.forEach(field => {
                            $("." + field).val("");
                            $("." + field).prop('readonly', false).removeClass(
                                'form-control-solid');
                        });

                        $('select[name="pd_beneficiary"]').empty();
                        $('select[name="pd_beneficiary"]').prop('disabled', false);

                        $('select[name="pd_type_of_project"]').empty();
                        $('select[name="pd_type_of_project"]').prop('disabled', false);

                        $('#rfp_attachment_link').hide();
                    }
                });
            }
        });

        const projectDetailsFields = [
            'pd_project_name',
            'pd_project_description',
            'pd_project_value',
            'pd_project_start_date',
            'pd_project_end_date',
            'pd_period_of_project',
        ];

        $(".rfp_attachment").on("change", function(){
            getAttachmentsCount("rfp_attachment");
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
