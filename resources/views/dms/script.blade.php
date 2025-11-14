<script type="text/javascript">
    $(document).ready(function () {
        $('.jsContractor, .jsDocumentType, .jsFileSource').select2({allowClear:true});
        initValidation();
    });
    var initValidation = function () {
        $('#dmsForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                attachment: {
                    required: true,
                    extension: "docx|png|doc|pdf|jpeg|jpg|xlsx|xls|jpg|svg|webp"
                }
            },
            messages: {
                attachment: {
                    required: "The name field is required.",
                },
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('.jsContractor').prop("disabled", false);
                $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                $('.jsBtnLoader').prop('disabled',true);
                return true;
            }
        });
    };

    $(".dms_attachment").on("change", function(){
        getAttachmentsCount("dms_attachment");
    });
</script>
