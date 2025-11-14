@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
            getCkEditor('adverse_information', imageUpload = true);
        });

        var initValidation = function() {
            $('#adverseInformationForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    adverse_information: {
                        check_ck_add_method: true
                    },
                },
                messages: {
                    adverse_information: {
                        check_ck_add_method: "This field is required",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    $('.contractor').prop('disabled', false);
                    return true;
                }
            });
        };

        $('.contractor').select2({
            allowClear: true,
        })

        $.validator.addMethod("check_ck_add_method", function(value, element) {
            return check_ck_editor('adverse_information');
        });

        // function check_ck_editor() {
        //     if (CKEDITOR.instances.adverse_information.getData() == '') {
        //         setTimeout(function() {
        //             $("#adverse_information-error").html('This field is required.');
        //         }, 100);
        //         return false;
        //     } else {
        //         $("#adverse_information-error").empty();
        //         return true;
        //     }
        // }

        // $(".adverse_information_attachment").on("change", function() {
        //     console.log('File selection changed');

        //     var selectedFiles = $(".adverse_information_attachment").get(0).files.length;
        //     var numFiles = $('.delete_group').length;
        //     var autoFetched = numFiles > 0 ? numFiles : 0;
        //     var totalFiles = selectedFiles + autoFetched;

        //     $('.count_adverse_information_attachment')
        //         .text(totalFiles + ' document(s)')
        //         .val(totalFiles)
        //         .attr('data-count_adverse_information_attachment', totalFiles);

        //     console.table({
        //         selectedFiles: selectedFiles,
        //         autoFetched: autoFetched,
        //         totalFiles: totalFiles
        //     });
        // });

        $(".adverse_information_attachment").on("change", function(){
            getAttachmentsCount("adverse_information_attachment");
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });
    </script>
@endpush
