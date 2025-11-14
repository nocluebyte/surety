<script type="text/javascript">
    $(document).ready(function () {
        initValidation();
    });

    var initValidation = function () {
        $('#advanceForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
            },
            messages: {
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('#btn_loader').addClass('spinner spinner-white spinner-left');
                $('#btn_loader').prop('disabled',true);
                return true;
            }
        });

        $(document).on('change','#payment_mode',function(){
            var returnVal = $(this).val();
            if (returnVal == 'Cash') {
                $("#bank").addClass('d-none')
                // $("#utr_no_display").addClass('d-none')
                $("#cheque_display").addClass('d-none')
                $("#name_of_cheque_display").addClass('d-none')
                $("#cheque_no").removeClass('required');
                $("#account_from_id").removeClass('required');
                $("#cheque_date").removeClass('required');
            } else if (returnVal === "Cheque") {
                $("#cheque_display").removeClass('d-none')
                $("#name_of_cheque_display").removeClass('d-none')
                // $("#utr_no_display").addClass('d-none')
                $("#bank").removeClass('d-none')
                $("#cheque_no").addClass('required');
                $("#account_from_id").addClass('required');
                $("#cheque_date").addClass('required');
            } else {
                // $("#utr_no_display").removeClass('d-none')
                $("#cheque_display").removeClass('d-none')
                $("#name_of_cheque_display").addClass('d-none')
                $("#bank").removeClass('d-none')
                $("#cheque_no").addClass('required');
                $("#account_from_id").addClass('required');
                $("#cheque_date").removeClass('required');
            }      
        });
       
       
        $('#payment_mode').select2({allowClear:true});
        $('#account_from_id').select2({allowClear:true});

        $('.employee').select2({allowClear:true});

        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('max', today);
    };
</script>