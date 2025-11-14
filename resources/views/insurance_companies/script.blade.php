@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#insuranceCompaniesForm').validate({
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

        $(document).on('select2:select', '#country', function() {
            var countryName = $('#country').find("option:selected").text();
            checkPinCodeValidation('jsPinCode', 'post_code', countryName);
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
