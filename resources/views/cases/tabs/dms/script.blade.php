<script>
    $(document).ready(function(){
        dmsTabForm();
        select2Init();
    });

    let dmsTabForm = function() {
            $('#dmsTabForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    attachment: {
                        extension: "doc|png|jpg|jpeg|webp|pdf|docx|xlsx|txt|xml",
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

        let select2Init = function(){
            $('.document_type,.file_source').select2({
              allowClear:true,
              placeholder:'Select',
              dropdownParent:'#dmsModal'
          });
        }
</script>