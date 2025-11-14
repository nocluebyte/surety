<script type="text/javascript">
	$(document).ready(function() {
	    initValidation();
        var id = '{{ $id }}';
	});
	let initValidation = function() {
	    $('#tenderEvaluationForm').validate({
	        debug: false,
	        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
	        rules: {},
	        messages: {

	        },
	        errorPlacement: function(error, element) {
	            error.appendTo(element.parent()).addClass('text-danger');
	        },
	        submitHandler: function(e) {
                if (CKEDITOR.instances.remarks.getData() == '') {
                    $("#remarks-error").removeClass('d-none').html('This field is required.');
                    return false;
                }else{
    	        	$('.jsDisabled').attr('disabled',false);
    	        	$('.jsReadOnly').attr('readOnly',false);
    	            $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
    	            $('.jsBtnLoader').prop('disabled', true);
    	            return true;
                }
	        }
	    });
	    $('#locationsRepeater').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                $(this).find('.jsListNo').text($(this).index() + 1 + ' .');
                $('.jsStateId').select2({allowClear:true});
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
                            $('.jsListNo').each(function(index) {$(this).html(index + 1);});
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {
                $('.jsStateId').select2({allowClear:true});
            },
            isFirstItemUndeletable: true
        });
	};
	$('.jsBondStartDate').on('change', function() {
        var startDate = $(this).val();
        $('.jsBondEndDate').attr('min', startDate);
        var endDate = $('.jsBondEndDate').val();
        if(startDate != '' && endDate !=''){
            $('.jsPeriodOfBond').val(daysCalculate(startDate, endDate));
        }
    });
    $('.jsBondEndDate').on('change', function() {
        var endDate = $(this).val();
        $('.jsBondStartDate').attr('max', endDate);
        var startDate = $('.jsBondStartDate').val();
        if(startDate != '' && endDate !=''){
            $('.jsPeriodOfBond').val(daysCalculate(startDate, endDate));
        }
    });
    $('.jsWorkType').change(function(e){
    	var workType = $(this).val();
    	if($.inArray("-1", workType) != -1){
    		$('.jsOtherWorkTypeDiv').removeClass('d-none');
    		$('.jsOtherWorkType').addClass('required');
    	}else{
    		$('.jsOtherWorkTypeDiv').addClass('d-none');
    		$('.jsOtherWorkType').removeClass('required');
    	}
    });
</script>