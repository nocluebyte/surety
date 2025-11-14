@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        jQuery.validator.addMethod("filesize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than 2 MB');

        let initValidation = function() {
            $('#employeeForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    photo: {
                        extension: "png|jpg|jpeg",
                        filesize: 2 * 1024 * 1024,
                    },
                },
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

        $('#country').select2({
            placeholder: 'Select Country',
            allowClear: true,
        });
        $('#state').select2({
            placeholder: 'Select State',
            allowClear: true,
        });
        $('#designation_id').select2({
            placeholder: 'Select Designation',
            allowClear: true,
        });

        $(".photo").on("change", function(){
            getAttachmentsCount("photo");
        });

        $(document).on('select2:select', '#country', function() {
            var countryName = $('#country').find("option:selected").text();
            checkPinCodeValidation('jsPinCode', 'post_code', countryName);
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
