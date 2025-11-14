@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
            getCkEditor('terms_conditions', imageUpload = false);
            getCkEditor('issue_bond_note', imageUpload = false);
            getCkEditor('issue_bond_footer', imageUpload = false);
            getCkEditor('issue_bond_declaration', imageUpload = false);
            getCkEditor('print_disclosure', imageUpload = false);
        });

        var initValidation = function() {
            $('#company_form').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    // if (CKEDITOR.instances.terms_conditions.getData() == '') {
                    //     $("#terms_conditions-error").removeClass('d-none').html('This field is required.');
                    //     return false;
                    // } else {
                    //     $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    //     $('#btn_loader').prop('disabled', true);
                    //     return true;
                    // }
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                }
            });

            $('#session_form').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {

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

            $('#bond_start_period').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    name: {
                        required: true,
                    },
                },
                messages: {

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
            $('#print').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {},
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    var formValid = true;
                    $('.jsPrintDescription').each(function(index,row){
                        var description = $(this).attr('name');
                        var parentRow = $(this).closest('.jsPrintRow');
                        // if(CKEDITOR.instances[description].getData() == ''){
                        //     formValid =false;
                        //     $(".jsPrintDescriptionError",parentRow).html('This field is required.');
                        // }else{
                        //     $(".jsPrintDescriptionError",parentRow).html('');
                        // }

                        if (editorInstancesOne[description].getData().trim() === '') {
                            formValid = false;
                            $(".jsPrintDescriptionError", parentRow).html('This field is required.');
                        } else {
                            $(".jsPrintDescriptionError", parentRow).html('');
                        }
                    });
                    if (!formValid) {
                        return false;
                    }else{
                        $('.jsPrintSaveBtn').addClass('spinner spinner-white spinner-left');
                        $('.jsPrintSaveBtn').prop('disabled', true);
                        return true;
                    }
                }
            });

            $('#issue_bond_print').validate({
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
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                        $('#btn_loader').prop('disabled', true);
                        return true;
                }
            });

            var editorInstanceRepeater;
            $('#printRepeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'foo'
                },
                show: function() {
                    var rowIndex = $(this).index();
                    $(this).find('.jsPrintNo').text(rowIndex + 1 + ' .');
                    var rName = $(this).find('.jsPrintDescription').attr('name');
                    ClassicEditor
                        .create(document.querySelector('textarea[name="' + rName + '"]'), {
                            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                        })
                        .then(editor => {
                            editorInstanceRepeater = editor;
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
                                $('.jsPrintNo').each(function(index) {$(this).html(index + 1);});
                            }, 500);
                        }
                    });
                },
                ready: function(setIndexes) {
                    $('.jsPrintDescription').each(function(index) {
                        var description = $(this).attr('name');
                        ClassicEditor
                            .create(document.querySelector('textarea[name="' + description + '"]'), {
                                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                            })
                            .then(editor => {
                                editorInstanceRepeater = editor;
                            });
                    });
                },
                isFirstItemUndeletable: true
            });
        };

        let isCountryIndia = () => {
            let country = $('#country').find("option:selected").text();
            let countryId = $('#country').val();

            if (countryId.length > 0) {
                if (country.toLowerCase() == 'india') {
                    $('.gstAndPanNoFields').removeClass('d-none');
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

        $('#country').select2();
        $('#state').select2();
        $('#default_bill_print').select2();

        $('.inward_width_height').on('click', function() {

            var inwardVal = $('.inward_width_height:checked').val();
            if (inwardVal == 100) {
                var width = $(this).val();
                var height = 76;

                $(".inward_width").val(width);
                $(".inward_height").val(height);

            } else {
                var width = $(this).val();
                var height = 50;

                $(".inward_width").val(width);
                $(".inward_height").val(height);
            }
        });

        $('.production_width_height').on('click', function() {

            var productionVal = $('.production_width_height:checked').val();
            if (productionVal == 100) {
                var width = $(this).val();
                var height = 76;

                $(".production_width").val(width);
                $(".production_height").val(height);

            } else {
                var width = $(this).val();
                var height = 50;

                $(".production_width").val(width);
                $(".production_height").val(height);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const bondStartPeriodInput = document.querySelector('input[name="bond_start_period"]');

            bondStartPeriodInput.addEventListener('input', function(event) {
                const value = parseInt(event.target.value, 10);
                const min = parseInt(event.target.getAttribute('min'), 10);
                const max = parseInt(event.target.getAttribute('max'), 10);

                // Block input outside the min and max range
                if (value < min || value > max) {
                    event.target.setCustomValidity('Value must be between 1 and 365');
                } else {
                    event.target.setCustomValidity('');
                }
            });
        });
    </script>

    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
