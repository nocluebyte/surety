@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
            getCkEditor('reason', imageUpload = true);
        });

        var initValidation = function() {
            $('#blacklistForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    reason: {
                        check_ck_add_method: true
                    },
                },
                messages: {
                    reason: {
                        check_ck_add_method: "This field is required",
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    $('.contractor').attr('disabled', false);
                    return true;
                }
            });
        };

        // $(".blacklist_attachment").on("change", function() {
        //     console.log('File selection changed');

        //     var selectedFiles = $(".blacklist_attachment").get(0).files.length;
        //     var numFiles = $('.delete_group').length;
        //     var autoFetched = numFiles > 0 ? numFiles : 0;
        //     var totalFiles = selectedFiles + autoFetched;

        //     $('.count_blacklist_attachment')
        //         .text(totalFiles + ' document(s)')
        //         .val(totalFiles)
        //         .attr('data-count_blacklist_attachment', totalFiles);

        //     console.table({
        //         selectedFiles: selectedFiles,
        //         autoFetched: autoFetched,
        //         totalFiles: totalFiles
        //     });
        // });

        $(".blacklist_attachment").on("change", function(){
            getAttachmentsCount("blacklist_attachment");
        });

        // $(".delete_group").on("click", function(){
        //     var filePrefix = $(this).attr('data-prefix');
        //     if(filePrefix == 'blacklist_attachment'){
        //         remainingFiles = $(".blacklist_attachment").get(0).files.length - 1;
        //         $('.count_blacklist_attachment').text(remainingFiles + ' document');
        //     }
        // });


        // $(".blacklist_attachment").on("change", function(){
        //     console.log('222');
        //     // console.log($('.delete_group').attr('data-clicked'));
        //     var selectedFiles = $(".blacklist_attachment").get(0).files.length;
        //     // var numFiles = $(".count_blacklist_attachment").attr('data-count_blacklist_attachment');
        //     var numFiles = $('.delete_group').length;
        //     console.log(numFiles);
        //     var abc = $(".count_blacklist_attachment").val();
        //     var autoFetched = numFiles.length == 0 ? 0 : parseInt(numFiles);
        //     var totalFiles = 0;
        //     if(numFiles > 0 && selectedFiles > 0){
        //         console.log('555');
        //         if(parseInt($(".count_blacklist_attachment").attr('data-count_blacklist_attachment')) > 0){
        //             totalFiles = parseInt($(".count_blacklist_attachment").attr('data-count_blacklist_attachment')) + selectedFiles;
        //         } else {
        //             totalFiles = selectedFiles;
        //         }
        //     } else if (numFiles > 0){
        //         console.log('444');
        //         totalFiles = numFiles;
        //     }
        //     else {
        //         console.log('666');
        //         totalFiles = selectedFiles + autoFetched;
        //     }
        //     // totalFiles = selectedFiles + autoFetched;

        //     console.table(selectedFiles, autoFetched, totalFiles);
        //     $('.count_blacklist_attachment').text(totalFiles + ' document').val(totalFiles).attr('data-count_blacklist_attachment', totalFiles);
        // });

        // $(".delete_group").on("click", function(){
        //     var filePrefix = $(this).attr('data-prefix');
        //     remainingFiles = $(".blacklist_attachment").get(0).files.length - 1;
        //     $('.count_blacklist_attachment').text(remainingFiles + ' document');
        // });

        $('.contractor').select2({
            allowClear: true,
        })

        $.validator.addMethod("check_ck_add_method", function(value, element) {
            return check_ck_editor('reason');
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        // let editorInstance;
        // ClassicEditor
        //     .create(document.querySelector('#reason'), {
        //         removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        //     })
        //     .then(editor => {
        //         editorInstance = editor;
        //     })
        //     .catch(error => {
        //         // console.error(error);
        //     });

        // function check_ck_editor() {
        //     if (editorInstance) {
        //         document.querySelector('#reason').value = editorInstance.getData();

        //         if (editorInstance.getData().trim() === '') {
        //             setTimeout(function() {
        //                 $("#reason-error").html('This field is required.');
        //             }, 100);
        //             return false;
        //         } else {
        //             $("#reason-error").empty();
        //             return true;
        //         }
        //     }
        //     return false;
        // }

    </script>
@endpush
