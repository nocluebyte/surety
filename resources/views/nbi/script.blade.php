<script type="text/javascript">
	$(document).ready(function(e){
		initValidation();
        getCkEditor('bond_wording', imageUpload = false);
        $('.jsHsnCodeId').select2();
        $(".jsBondPeriodEndDate").trigger('change');

	});
	let initValidation = function() {
        $('#nbiForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                bond_wording: {
                    check_ck_add_method: true
                },
            },
            messages: {},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                // if (CKEDITOR.instances.bond_wording.getData() == '') {
                //     $("#bond_wording-error").removeClass('d-none').html('This field is required.');
                //     return false;
                // } else {
                //     $('.jsReadOnly').attr('readOnly',false);
                //     $('.jsDisabledField').attr('disabled',false);
                //     $("#bond_wording-error").addClass('d-none').empty();
                //     $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                //     $('.jsBtnLoader').prop('disabled', true);
                //     return true;
                // }
                $('.jsReadOnly').attr('readOnly',false);
                $('.jsDisabledField').attr('disabled',false);
                // $("#bond_wording-error").addClass('d-none').empty();
                $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                $('.jsBtnLoader').prop('disabled', true);
                return true;
            }
        });
    };
    $('.jsBondPeriodStartDate').on('change', function() {
        var startDate = $(this).val();
        $('.jsBondPeriodEndDate').attr('min', startDate).attr('data-msg-min', 'Please enter a Date greater than or equal to ' + moment(startDate).format('DD/MM/YYYY'));
        var endDate = $('.jsBondPeriodEndDate').val();
        if(startDate != '' && endDate !=''){
            $('.jsBondPeriodDays').val(daysCalculate(startDate, endDate));
        }
    });
    $('.jsBondPeriodEndDate').on('change', function() {
        var endDate = $(this).val();
        $('.jsBondPeriodStartDate').attr('max', endDate).attr('data-msg-max', 'Please enter a Date less than or equal to ' + moment(endDate).format('DD/MM/YYYY'));
        var startDate = $('.jsBondPeriodStartDate').val();
        if(startDate != '' && endDate !=''){
            $('.jsBondPeriodDays').val(daysCalculate(startDate, endDate));
        }

        var initialFdDate = moment(endDate).add({{ $initial_fd_validity }}, 'day').format('YYYY-MM-DD');
        $('.jsInitialFDValidity').val(initialFdDate);
    });
    $(document).on("change", '.jsHsnCodeId', function(event) {
       gstCalculation();
    });
    $(document).on("input", '.jsNetPremium', function(event) {
        gstCalculation();
    });
    $(document).on("input", '.jsStampDutyCharges', function(event) {
        var grossPremium = parseFloat($('.jsGrossPremium').val());
        var stampDutyCharges = parseFloat($('.jsStampDutyCharges').val());
        $('.jsTotalPremiumIncludingStampDuty').val('');
        var totalPremiumIncludingStampDuty = 0;
        if(grossPremium > 0){
            totalPremiumIncludingStampDuty = totalPremiumIncludingStampDuty + parseFloat(grossPremium);
        }
        if(stampDutyCharges > 0){
            totalPremiumIncludingStampDuty = totalPremiumIncludingStampDuty + parseFloat(stampDutyCharges);
        }
        $('.jsTotalPremiumIncludingStampDuty').val(numberFormatPrecision(totalPremiumIncludingStampDuty, 0));
    });
    // $.validator.addMethod("check_ck_add_method", function(value, element) {
    //     return check_ck_editor();
    // });

    $.validator.addMethod("check_ck_add_method", function(value, element) {
        return check_ck_editor('bond_wording');
    });

    // function check_ck_editor() {
    //     if (CKEDITOR.instances.bond_wording.getData() == '') {
    //         setTimeout(function() {
    //             $("#bond_wording-error").html('This field is required.');
    //         }, 100);
    //         return false;
    //     } else {
    //         $("#bond_wording-error").empty();
    //         return true;
    //     }
    // }
    function gstCalculation(){
        var netPremium = parseFloat($('.jsNetPremium').val());
        var igst = $('option:selected', $('.jsHsnCodeId')).attr('igst') ?? 0;
        var cgst = $('option:selected', $('.jsHsnCodeId')).attr('cgst') ?? 0;
        var sgst = $('option:selected', $('.jsHsnCodeId')).attr('sgst');
        $('.jsGstAmount').val('');
        console.log('netPremium == '+netPremium);
        console.log('igst == '+igst);
        if(netPremium >= 0 && igst >= 0){
            var gstAmount = parseFloat((netPremium * igst) / 100);
            $('.jsCgst').val(cgst);
            $('.jsCgstAmount').val(parseFloat((netPremium * cgst) / 100));
            $('.jsSgst').val(sgst);
            $('.jsSgstAmount').val(parseFloat((netPremium * sgst) / 100));
            $('.jsIgst').val(igst);
            $('.jsGstAmount').val(numberWithRound(gstAmount));
            $('.jsGrossPremium').val(numberFormatPrecision(netPremium + gstAmount, 0));
        }
        $('.jsStampDutyCharges').trigger('input');
    }
    $(document).on('input', '.jsBondValue, .jsRate, .jsBondPeriodDays', function(){
        netPremiumCal();
    });
    function netPremiumCal(){
        var bondVal = $('.jsBondValue').val();
        var rate = $('.jsRate').val();
        var bondPeriodDays = $('.jsBondPeriodDays').val();
        var netPremium = 0;
        if(bondVal >= 0 && rate > 0 && bondPeriodDays > 0){
            netPremium = ((bondVal * rate * bondPeriodDays) / 365) / 100;
        }
        $('.jsNetPremium').val(numberWithRound(netPremium)).trigger('input');
    }

    $(document).on('input', '.jsCashMargin', function() {
        var bondValue = $('.jsBondValue').val();
        var cashMargin = $(this).val();

        var cashMarginAmt = (bondValue * cashMargin) / 100;
        $('.jsCashMarginAmount').val(numberFormatPrecision(cashMarginAmt, 0)).trigger('input');
    })
</script>