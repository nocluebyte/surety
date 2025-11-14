@push('scripts')

<script type="text/javascript">
    var prodVariantIds = [];
    $(document).ready(function() {
        initValidation(); 
    });  

    var initValidation = function() {
        $('#searchForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")', 
               
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
    
</script>
@endpush