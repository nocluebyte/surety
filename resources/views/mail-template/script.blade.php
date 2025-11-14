<script type="text/javascript">
    $(document).ready(function() {
        $('#module_name, #smtp_id').select2({
            allowClear: true
        });
        $('.jsModuleName').change();
        initValidation();
        getCkEditor('message_body', imageUpload = true);
    });

    var initValidation = function() {

        $('#mailTemplateForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select,time")',
            rules: {
                module_name: {
                    required: true,
                },
                smtp_id: {
                    required: true,
                },
                subject: {
                    required: true,
                },
                message_body: {
                    check_ck_add_method: true
                },

                attachment: {
                    extension: "xls|xlsx|doc|docx|pdf",
                    filesize: 10 * 1024 * 1024,
                },
            },
            messages: {
                message_body: {
                    check_ck_add_method: "This field is required",
                },

                attachment: {
                    extension: "Please enter a value with a valid extension xls | xlsx | doc | docx | pdf",
                    filesize: "The attachment must not be greater than 10 MB.",
                },
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
    };

    $.validator.addMethod("check_ck_add_method", function(value, element) {
        return check_ck_editor('message_body');
    });

    // $('#lead_source_id').select2({
    //     //theme: 'bootstrap4',
    //     ajax: {
    //         url: function () {
    //             return $(this).data('url');
    //         },
    //         data: function (params) {
    //             return {
    //                 // id: 1,
    //                 search: params.term,
    //             };
    //         },
    //         dataType: 'json',
    //         processResults: function (data) {
    //             return {
    //                 results: data.map(function (item) {
    //                     return {
    //                         id: item.id,
    //                         text: item.name,
    //                         otherfield: item,
    //                     };
    //                 }),
    //             }
    //         },
    //         //cache: true,
    //         delay: 250
    //     },
    //     allowClear: true
    // });

    // $('.jsModuleName').on('change', function(){
    //     $('.jsLeadDiv').toggleClass('d-none', ($(this).val() != 'lead_source'));
    //     $('#lead_source_id').attr('required', ($(this).val() == 'lead_source'));
    //     $('#send_time').attr('required', ($(this).val() == 'lead_source'));
    // });
</script>
