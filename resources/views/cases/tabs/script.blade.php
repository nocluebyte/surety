<script>
    var datesArr = [];
    $(document).ready(function(){
        initValidation();
        initRepeter();
        $('.jsReasonForSubmission, .jsAudited, .jsConsolidated, .jsCurrencyId, .jsUnderwriter').select2({allowClear:true,placeholder:'Select'});
        if (datesArrList.length > 0) {
            datesArr.push(datesArrList);
            loadDateData();
        }
        var id = '{{ $id ?? '' }}';
    });

    let initValidation = function() {

        jQuery.validator.addClassRules("proposed_cap", {
            max:()=>parseInt($('.action_proposed_overall_cap').val() || $('.proposed_overall_cap').val())
        });

        $('#casesParameterForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                // $('.jsParameterSave').addClass('spinner spinner-white spinner-left');
                // $('.jsParameterSave').prop('disabled', true);
                $('.jsisReload').val('0');
                return checkValidation('parameter');
            }
        });
        $('#casesActionForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                'proposed[proposed_overall_cap]':{
                    min:()=>parseInt($('.action_proposed_individual_cap').val() || $('.proposed_individual_cap').val())    
                }
            },
            messages: {
                'proposed[proposed_overall_cap]':{
                    min:'Overallcap should be greter then or equal to Individualcap.'
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                // $('.jsActionSave').addClass('spinner spinner-white spinner-left');
                // $('.jsActionSave').prop('disabled', true);
                $('.jsisReload').val('0');
                return checkValidation('cases_action_plan');
            }
        });

        $('#casesDecisionForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(form,e) {
                // $('.jsDecisionSave').addClass('spinner spinner-white spinner-left');
                // $('.jsDecisionSave').prop('disabled', true);
                let is_reject = e.originalEvent.submitter.value === 'Rejected' ? false : true;
                $('.jsisReload').val('0');
                return checkValidation('decision',is_reject);
            }
        });

        $('#casesProjectDetailsForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {},
            messages: {},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function(e) {
                return checkValidation('project_details');
            }
        });

        function checkValidation(validationfor,is_reject=undefined){

            let today = moment().format('YYYY-MM-DD');
            let underwriter = $('.JsUnderwriter').val(); 
            let proposed_overall_cap = parseInt($('.proposed_overall_cap').val());
            let action_proposed_overall_cap =  parseInt($('.action_proposed_overall_cap').val());
            let bond_value = parseInt($('.jsBondValue').val());
            let previous_bond_value = parseInt($('.jsPreviousBondValue').val());
            let is_case_amend =  Boolean($('.jsIsCaseAmend').val());
            let total_bond_utilized_cap  = parseInt($('.JsTotalBondUtilizedCap').val());
          
            //bond wise variable
            let bond_wise_row = $('.cases_bond_limit_strategy_row[data-current-case-bond-limit-strategy="true"]');
            bond_wise_row
            let bond_wise_current_cap = parseInt(bond_wise_row.find('.current_cap').val());
            let bond_wise_utilized_cap = parseInt(bond_wise_row.find('.utilized_cap').val());
            let bond_wise_remaining_cap = parseInt(bond_wise_row.find('.remaining_cap').val());
            let bond_wise_valid_till =  moment(bond_wise_row.find('.bond_valid_till').val()).format('YYYY-MM-DD');

            //cases limit stetegy
            let proposed_valid_till = moment($('.proposed_valid_till').val()).format('YYYY-MM-DD');


            //virtual limit when case is ammend
            let virtual_total_bond_utilized_cap = (is_case_amend && bond_value - previous_bond_value === 0) ? total_bond_utilized_cap - previous_bond_value : total_bond_utilized_cap - previous_bond_value;
                
            let total_bond_utilized_cap_with_bond_value = virtual_total_bond_utilized_cap + bond_value;

            let virtual_bond_wise_utilized_cap = (is_case_amend && bond_value - previous_bond_value === 0) ?  bond_wise_utilized_cap - previous_bond_value : bond_wise_utilized_cap - previous_bond_value;


            let bond_utilized_cap_with_bond_value = virtual_bond_wise_utilized_cap + bond_value;            

            let virtual_bond_wise_remaining_cap = bond_utilized_cap_with_bond_value;
            
            // let virtual_bond_wise_remaining_cap = (is_case_amend && bond_value - previous_bond_value === 0) ?  bond_utilized_cap_with_bond_value : bond_utilized_cap_with_bond_value;
            
            switch (validationfor) {
                case 'decision':
                    if (underwriter == '') {
                        $('.decision-error-0').removeClass('d-none');
                        return false;
                    }
                    else if (proposed_valid_till < today && is_reject){
                        $('.decision-error-1').removeClass('d-none');
                        return false;
                    }
                    else if (bond_wise_valid_till < today && is_reject){
                        $('.decision-error-2').removeClass('d-none');
                        return false;
                    }
                    else if (bond_value > proposed_overall_cap && is_reject) {
                        $('.decision-error-3').removeClass('d-none');
                        return false;
                    }  
                    else if(bond_value > virtual_bond_wise_remaining_cap && is_reject){
                        $('.decision-error-4').removeClass('d-none');
                        return false;
                    }
                    else if(proposed_overall_cap < total_bond_utilized_cap_with_bond_value && is_reject){
                        $('.decision-error-5').removeClass('d-none');
                        return false;
                    }
                    else if ((bond_utilized_cap_with_bond_value > virtual_bond_wise_remaining_cap || bond_utilized_cap_with_bond_value > bond_wise_current_cap) && is_reject){
                        $('.decision-error-6').removeClass('d-none');
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                    break;

                    case 'cases_action_plan':
                        
                    if (underwriter == '') {
                        $('.cases-action-plan-error-0').removeClass('d-none');
                        return false;
                    }
                    else if(action_proposed_overall_cap < total_bond_utilized_cap) {
                        $('.cases-action-plan-error-1').removeClass('d-none');
                        return false;
                    }
                    else{
                        return true;
                    }
                    
                    break;

                    case 'parameter':

                    if (underwriter == '') {
                        $('.parmeter-error-0').removeClass('d-none');
                        return false;
                    }
                    else{
                        return true;
                    }

                    break;

                    case 'project_details':

                    if (underwriter == '') {
                        $('.project-details-error-0').removeClass('d-none');
                        return false;
                    }
                    else{
                        return true;
                    }

                    break;

                    default:
                        return false;
                    break;
                
            }

        }

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
                $('.jsDisabled').attr('disabled',false);
                $('.jsReadOnly').attr('readOnly',false);
                $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                $('.jsBtnLoader').prop('disabled', true);
                return true;
	        }
	    });
    };

    let initRepeter = function(){
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

        $('#bondLimitStrategyRepeater').repeater({
            show: function() {

                disableSelectedOptions();
                
                $(this).find('.bond_type').removeAttr('disabled');
                $(this).find('.current_cap').val(0);
                $(this).find('.utilized_cap').val(0);
                $(this).find('.remaining_cap').val(0);
                $(this).find('.bond_utilized_cap_persontage').text(0);
                $(this).find('input[type=hidden]').remove();
                $(this).find('.bond_type').select2({
                        allowClear: true
                });
                $(this).slideDown();
            },
            ready: function(setIndexes) {
                $('.bond_type').select2({allowClear:true});
            },
            isFirstItemUndeletable: false
        });
    }
    
    // let bondlimitBondTypeId = new Set();

    $(document).on('change', '.bond_type', function(e) {
      disableSelectedOptions(); 
    });
    
    function disableSelectedOptions() {
        // Create a Set of selected values for quick lookup
        var selectedValues = new Set();
        
        // Gather selected values from all selects
        $('.bond_type').each(function() {
            var selectedValue = $(this).val();
            if (selectedValue) {
                selectedValues.add(selectedValue);
            }
        });        

        // Disable or enable options only if necessary
        $('.bond_type').each(function() {
            var select = $(this);
            let selectedvalue  = select.val(); 
    
            // Loop through the options in this select
            select.find('option').each(function() {
                var option = $(this);
                var optionValue = option.val();
            
                // Disable option if it's already selected in another select
                if (selectedValues.has(optionValue) && optionValue !== selectedvalue) {
                    if (!option.prop('disabled')) { // Disable if not already disabled
                        option.prop('disabled', true);
                    }
                } else {
                    if (option.prop('disabled')) { // Enable if already disabled
                        option.prop('disabled', false);
                    }
                }
            });
        });
    }



    $(document).on('change', '.jsAdverseNotification', function(e){
        var adverseNotification = $('.jsAdverseNotification:checked').val();
        if(adverseNotification == 'Yes'){
            $('.jsAdverseNotificationDiv').removeClass('invisible');
            $('.jsAdverseNotificationRemark').addClass('required').val('');
        }else{
            $('.jsAdverseNotificationDiv').addClass('invisible');
            $('.jsAdverseNotificationRemark').removeClass('required').val('');
        }
    });
    $(document).on('change', '.jsBeneficiaryAcceptable', function(e){
        var adverseNotification = $('.jsBeneficiaryAcceptable:checked').val();
        if(adverseNotification == 'Yes'){
            $('.jsBeneficiaryAcceptableDiv').addClass('invisible');
            $('.jsBeneficiaryAcceptableRemark').removeClass('required').val('');
        }else{
            $('.jsBeneficiaryAcceptableDiv').removeClass('invisible');
            $('.jsBeneficiaryAcceptableRemark').addClass('required').val('');
        }
    });

    $(document).on('change', '.jsReasonForSubmission', function(e){
        var reasonForSubmission = $('.jsReasonForSubmission').val();

        if(reasonForSubmission == 'Amendment'){
            $('.jsAmendmentTypeDiv').removeClass('d-none');
            $('.jsAmendmentType').addClass('required');
        }else{
            $('.jsAmendmentTypeDiv').addClass('d-none');
            $('.jsAmendmentType').removeClass('required');
        }
    });
    
    $(document).on('change', '.jsProjectAcceptable', function(e){
        var projectAccaptable = $('.jsProjectAcceptable:checked').val();
        if(projectAccaptable == 'No'){
            $('.jsProjectAcceptableDiv').removeClass('d-none');
            $('.jsProjectAcceptableRemark').addClass('required');
        }else{
            $('.jsProjectAcceptableDiv').addClass('d-none');
            $('.jsProjectAcceptableRemark').removeClass('required').val('');
        }
    });

    $(document).on('change', '.jsBondInvocation', function(e){
        var projectAccaptable = $('.jsBondInvocation:checked').val();
        if(projectAccaptable == 'No'){
            $('.jsBondInvocationDiv').addClass('invisible');
            $('.jsBondInvocationRemark').removeClass('required').val('');
        }else{
            $('.jsBondInvocationDiv').removeClass('invisible');
            $('.jsBondInvocationRemark').addClass('required').val('');
        }
    });

    $(document).on('change', '.jsBlacklistedContractor', function(e){
        var projectAccaptable = $('.jsBlacklistedContractor:checked').val();
        if(projectAccaptable == 'No'){
            $('.jsBlacklistedContractorDiv').addClass('invisible');
            $('.jsBlacklistedContractorRemark').removeClass('required').val('');
        }else{
            $('.jsBlacklistedContractorDiv').removeClass('invisible');
            $('.jsBlacklistedContractorRemark').addClass('required').val('');
        }
    });


    function modalTitle(title){
        $(".modal-common-title").text(title);
    }
    $(document).on('click', '.jsActionPlanModal', function() {
        var curTab = $(this).attr('data-tab');
        $('.' + curTab).tab('show');
        return false;
    });

    let analysisEditor;
    ClassicEditor
    .create(document.querySelector('#analysisDescription'), {
        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
    .then(editor => {
        analysisEditor = editor;
    });
    $(document).on('click', '.jsAnalysisButton', function(e){
        document.querySelector('#analysisDescription').value = analysisEditor.getData();
        $(".jsAnalysisError").addClass('d-none');
        $.ajax({
            type: "POST",
            url: "{{route('save-anaysis')}}",
            data: {
                description: document.querySelector('#analysisDescription').value,
                case_id: $('.jsCasesId').val(),
                case_action_plan_id: $('.jsCaseActionPlanId').val(),
                contractor_id:$('.Jscontractor').val()
            }
        }).always(function(respons) {}).done(function(respons) {
            if (respons.success) {
                analysisEditor.setData('');
                $('.analysis-time-line-preview').html(respons.analysis);
                toastr.success(respons.message, "Success");
                // $('.timeline').load(location.href + " .timeline");
            } else {
                toastr.error(respons.message, "Error");
            }
        });
    });
    $(document).on("click", '.jsAnalysisTl,.jsAnalysisTab', function() {
        $(".jsSaveProfitLoss").addClass('d-none');
    });

    $(document).on("click", '.profitLossTab,.balanceSheetTab,.ratiosTab,.popupTab', function() {
        $(".jsSaveProfitLoss").removeClass('d-none');
        $(".jsReadOnlyData").trigger('blur');
    });
    $(document).on('click', '.jsAddDate', function(e){
        var fromDate = $(".jsFormDate").val();
        var toDate = $(".jsToDate").val();
        $('.jsFormDateError').toggleClass('d-none', fromDate !='');
        $('.jsToDateError').toggleClass('d-none', toDate !='');
        if(fromDate !='' && toDate !=''){
            loadDateData();
        }
    });
    function convertToSlug(Text) {
        return Text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    }
    $(".jsSaveProfitLossBtn").on("click", function(){
        var isValid = false;
        var balence_a = 0;
        var balence_b = 0;
        $('.jsBalanceb').each(function() {
            var balancebSlug = $(this).attr('data-slug');
            var balancebYear = $(this).attr('data-year');
            balence_a = $(".total_bs_a_" + balancebYear).val();
            balence_b = $(".total_bs_b_" + balancebYear).val();
        });
        if (balence_b == balence_a) {
            isValid = true;
        }
        if (isValid) {
            $('.jsisReload').val('1');
            var casesactionDataProfitLoss = $('#casesActionForm').serialize();
            if (casesactionDataProfitLoss) {
                $.ajax({
                    type: "POST",
                    url: "{{route('store-cases-action-plan-financials',[$case->id])}}",
                    data: casesactionDataProfitLoss
                }).always(function(respons) {
                }).done(function(respons) {
                    if (respons.success) {
                        toastr.success(respons.message, "Success");
                    }
                }).fail(function({responseJSON:respons}){  
                    toastr.error(respons.message, "Error");
                });
            }
        } else {
            $(".jsBalanceSheet").removeClass('d-none');
            setTimeout(function() {
                $(".jsBalanceSheet").addClass('d-none');;
            }, 5000);
        }
    });
    $(document).on('click', '.jsRemoveDate', function() {
        var fieldName = $(this).data('date-name');
        datesArr[0].splice($.inArray(fieldName, datesArr), 1);
        $('.' + fieldName).remove();
        if (datesArr[0].length < 5) {
            $(".jsAddDate").prop('disabled', false);
        }
    });
    function getFormattedDate(date) {
        var datearr = date.split('-');
        return datearr[2] + '/' + datearr[1] + '/' + datearr[0];
    }
    $(document).on('change', '.jsFormDate', function() {
        var fromDate = new Date($(this).val());
        fromDate.setDate(fromDate.getDate() + 366);
        var maxToDate = fromDate.toISOString().substr(0, 10);
        $(".jsToDate").attr('max', maxToDate);
        $(".jsToDate").attr('min', $(this).val());
    });
    $(document).on('change', '.jsToDate', function() {
        $(".jsFormDate").attr('max', $(this).val());
    });
    $(document).on('keyup', '.losses', function() {
        var losval = $(this).val();
        var losSlug = $(this).attr('data-slug');
        var losYear = $(this).attr('data-year');
        var total = 0;
        var totalNet = 0;
        var total = parseFloat($('.sales_' + losYear).val()) - parseFloat($('.exp_' + losYear).val());
        $(".ebidta_" + losYear).val(total);

        var total_net =
        parseFloat($('.ebidta_' + losYear).val()) -
        parseFloat($('.int_' + losYear).val()) -
        parseFloat($('.dep_' + losYear).val()) +
        parseFloat($('.net_other_' + losYear).val());

        $(".pbt_" + losYear).val(total_net).trigger('input');
        var pat = parseFloat($('.pbt_' + losYear).val()) - parseFloat($('.tax_' + losYear).val());
        $(".pat_" + losYear).val(pat);
        calculateRatios($(this));
    });
    $(document).on('input', '.jsReadOnlyData', function() {
        calculateRatios($(this));
    });
    function calculateRatios(el) {
        var balancebval = el.val();
        var balancebSlug = el.attr('data-slug');
        var balanceaYear = el.attr('data-year');
        if ($.inArray(balancebSlug,['ebidta','sales','exp'])) {
            setTimeout(function() {
                var ebidta = (parseFloat($('.ebidta_' + balanceaYear).val()) / parseFloat($('.sales_' + balanceaYear).val()) * 100);
                $(".ratios_ebidta_" + balanceaYear).val(isinfinity(ebidta).toFixed(2));
            }, 500);
        }

        if ($.inArray(balancebSlug,['pbt','sales'])) {
            setTimeout(function() {
                var bt = (parseFloat($('.pbt_' + balanceaYear).val()) / parseFloat($('.sales_' + balanceaYear).val()) * 100);
                $(".ratios_bt_" + balanceaYear).val(isinfinity(bt).toFixed(2));
            }, 500);
        }

        if ($.inArray(balancebSlug,['ebidta','int'])) {
            setTimeout(function() {
                var icr = parseFloat($('.ebidta_' + balanceaYear).val()) / parseFloat($('.int_' + balanceaYear).val());
                $(".ratios_icr_" + balanceaYear).val(isinfinity(icr).toFixed(2));
            }, 500);
        }

        if ($.inArray(balancebSlug,['sales','tdrs'])) {
            var sales = parseFloat($('.sales_' + balanceaYear).val());
            var tdrs = parseFloat($('.tdrs_' + balanceaYear).val());
            var currindex = datesArr.indexOf(balanceaYear);
            var prevIndex = currindex - 1;
            if (prevIndex > -1) {
                var prevDate = datesArr[prevIndex];
                var prevTdrs = parseFloat($('.tdrs_' + prevDate).val());
            } else {
                var prevTdrs = 0;
            }
            var drs_turnover = 365 / (parseFloat(sales) / ((parseFloat(prevTdrs) + parseFloat(tdrs)) / 2));
            $(".ratios_drs_" + balanceaYear).val(isinfinity(drs_turnover).toFixed(2));
        }

        if ($.inArray(balancebSlug,['exp','tr_crs'])) {
            var exp = parseFloat($('.exp_' + balanceaYear).val());
            var tr_crs = parseFloat($('.tr_crs_' + balanceaYear).val());

            var currindex = datesArr.indexOf(balanceaYear);
            var prevIndex = currindex - 1;
            if (prevIndex > -1) {
                var prevDate = datesArr[prevIndex];
                var prevcrs = parseFloat($('.tr_crs_' + prevDate).val());
            } else {
                var prevcrs = 0;
            }
            var crs_turnover = 365 / (parseFloat(exp) / ((parseFloat(prevcrs) + parseFloat(tr_crs)) / 2));
            $(".ratios_crs_" + balanceaYear).val(isinfinity(crs_turnover).toFixed(2));
        }

        if ($.inArray(balancebSlug,['exp','stock'])) {
            var exp = parseFloat($('.exp_' + balanceaYear).val());
            var stock = parseFloat($('.stock_' + balanceaYear).val());

            var currindex = datesArr.indexOf(balanceaYear);
            var prevIndex = currindex - 1;
            if (prevIndex > -1) {
                var prevDate = datesArr[prevIndex];
                var prevstock = parseFloat($('.stock_' + prevDate).val());
            } else {
                var prevstock = 0;
            }
            var stock_turnover = 365 / (parseFloat(exp) / ((parseFloat(prevstock) + parseFloat(stock)) / 2));
            $(".ratios_stock_turnover_" + balanceaYear).val(isinfinity(stock_turnover).toFixed(2));
        }

        var drs_turnover_val = parseFloat($('.ratios_drs_' + balanceaYear).val());
        var crs_turnover_val = parseFloat($('.ratios_crs_' + balanceaYear).val());
        var stock_turnover_val = parseFloat($('.ratios_stock_turnover_' + balanceaYear).val());
        var credit_cycle = parseFloat(drs_turnover_val) + parseFloat(stock_turnover_val) - parseFloat(crs_turnover_val);
        $(".ratios_credity_cycle_" + balanceaYear).val(isinfinity(credit_cycle).toFixed(2));
    }
    function isinfinity(num){
        if (num == Infinity || num == -Infinity || isNaN(num)) {
            return 0;
        }
        return num;
    }
    $(document).on('blur', '.jsBalancea', function() {
        var balanceaval = $(this).val();
        var balanceaSlug = $(this).attr('data-slug');
        var balanceaYear = $(this).attr('data-year');
        var totalca = 0;
        var totalfa = 0;
        var totalbs = 0;
        var quick = 0;

        var quick = parseFloat($('.cash_' + balanceaYear).val()) + parseFloat($('.tdrs_' + balanceaYear).val());
        $(".quick_" + balanceaYear).val(quick);
        var totalca = parseFloat($('.quick_' + balanceaYear).val()) + parseFloat($('.stock_' + balanceaYear).val()) + parseFloat($('.other_ca_' + balanceaYear).val());
        $(".total_ca_" + balanceaYear).val(totalca).trigger('keyup');
        var totalfa = parseFloat($('.fixed_assets_' + balanceaYear).val()) + parseFloat($('.intangible_' + balanceaYear).val()) + parseFloat($('.other_fa_' + balanceaYear).val());
        $(".total_fa_" + balanceaYear).val(totalfa);
        var totalbs = parseFloat($('.total_ca_' + balanceaYear).val()) + parseFloat($('.total_fa_' + balanceaYear).val());
        $(".total_bs_a_" + balanceaYear).val(totalbs);
        $(".total_bs_b_" + balanceaYear).attr('max', totalbs);
        calculateRatios($(this));
    });
    function loadDateData(){
        var fromDate = $(".jsFormDate").val();
        var toDate = $(".jsToDate").val();
        if(fromDate !='' && toDate !=''){
            var fromDateSlug = convertToSlug(fromDate);
            var toDateSlug = convertToSlug(toDate);
            if ($.isArray(datesArr) && datesArr.length > 0) {
                datesArr[0].push(fromDateSlug + '_' + toDateSlug);
            } else {
                datesArr.push([fromDateSlug + '_' + toDateSlug]);
            }
            var dateFinalArr = [];
            if (datesArr[0].length > 0) {
                $.each(datesArr[0], function(inkey, inval) {
                    var dtArr = inval.split('_');
                    var frmDate = dtArr[0];
                    var toDate = dtArr[1];
                    var dtarr = {
                        'from': frmDate,
                        'to': toDate
                    };
                    dateFinalArr.push(dtarr);
                });
            }
            dateFinalArr.sort(function(a, b) {return new Date(b.from) - new Date(a.from);});
            var finalDateArr = [];
            if (dateFinalArr.length > 0) {
                $.each(dateFinalArr, function(index, dtval) {
                    var dateKey = dtval['from'] + '_' + dtval['to'];
                    finalDateArr.push(dateKey);
                });
            }
        } else {
            var finalDateArr = datesArr[0];
        }
        if (finalDateArr.length == 5) {
            $(".jsAddDate").prop('disabled', true);
        }
        if (finalDateArr.length > 0) {
            $.ajax({
                type: "get",
                url: "{{route('action-plan-data')}}",
                data: {
                    datesArr: finalDateArr,
                    case_id: $('.jsCasesId').val(),
                    case_action_plan_id: $('.jsCaseActionPlanId').val(),
                }
            }).always(function(respons) {
            }).done(function(respons) {
                $('.jsTr').html(respons.profit_loss);
                $('.jsTrratios').html(respons.ratios);
                $('.jsTrBalanceSheet').html(respons.balance_sheet);
                $('.jsDateList').html(respons.dateList);
                $(".jsFormDate").val('');
                $(".jsToDate").val('');

            });
        }
    }
    $(document).on('blur', '.jsBalanceb', function() {
        var balancebval = $(this).val();
        var balancebSlug = $(this).attr('data-slug');
        var balancebYear = $(this).attr('data-year');
        var totalcl = 0;
        var totalltd = 0;
        var networth = 0;
        var totalbbs = 0;

        var totalcl = parseFloat($('.std_' + balancebYear).val()) + parseFloat($('.tr_crs_' + balancebYear).val()) + parseFloat($('.other_cl_' + balancebYear).val());
        $(".total_cl_" + balancebYear).val(totalcl).trigger('keyup');

        var totalltd = parseFloat($('.long_term_' + balancebYear).val()) + parseFloat($('.provision_' + balancebYear).val());
        $(".total_ltd_" + balancebYear).val(totalltd).trigger('keyup');

        var networth = parseFloat($('.equity_' + balancebYear).val()) + parseFloat($('.retained_' + balancebYear).val());
        $(".net_worth_" + balancebYear).val(networth).trigger('keyup');

        var totalbbs = parseFloat($('.total_cl_' + balancebYear).val()) + parseFloat($('.total_ltd_' + balancebYear).val()) + parseFloat($('.net_worth_' + balancebYear).val());
        console.log(totalbbs);
        $(".total_bs_b_" + balancebYear).val(totalbbs);

        calculateanbalanceb($(this));
        calculateRatios($(this));
    });
    function calculateanbalanceb(el) {

        var balancebval = el.val();
        var balancebSlug = el.attr('data-slug');
        var balancebYear = el.attr('data-year');

        if ($.inArray(balancebSlug,['std','net_worth'])) {
            setTimeout(function() {
                var termgearing = (parseFloat($('.std_' + balancebYear).val()) / parseFloat($('.net_worth_' + balancebYear).val()) * 100);
                $(".ratios_term_gearing_" + balancebYear).val(isinfinity(termgearing).toFixed(2));

            }, 500);
        }
        if ($.inArray(balancebSlug,['std','total_ltd','net_worth'])) {
            setTimeout(function() {
                var totalgearing = ((parseFloat($('.std_' + balancebYear).val()) + parseFloat($('.total_ltd_' + balancebYear).val())) / parseFloat($('.net_worth_' + balancebYear).val()) * 100);
                $(".ratios_total_gearing_" + balancebYear).val(isinfinity(totalgearing).toFixed(2));
            }, 500);
        }

        if ($.inArray(balancebSlug,['equity','retained','net_worth','total_bs_b'])) {
            setTimeout(function() {
                var solvability = (parseFloat($('.net_worth_' + balancebYear).val()) / parseFloat($('.total_bs_b_' + balancebYear).val()) * 100);
                $(".ratios_solvability_" + balancebYear).val(isinfinity(solvability).toFixed(2));
            }, 500);
        }
    }
     $(document).on('keyup', '.totalcalc', function() {

        var el = $(this);
        var totalbval = el.val();
        var totalSlug = el.attr('data-slug');
        var totalYear = el.attr('data-year');

        var total1 = parseFloat($(".total_ca_" + totalYear).val()) / parseFloat($(".total_cl_" + totalYear).val());

        var workingcapital = parseFloat($(".total_ca_" + totalYear).val()) - parseFloat($(".total_cl_" + totalYear).val());

        var quickratio = parseFloat($(".quick_" + totalYear).val()) / parseFloat($(".total_cl_" + totalYear).val());

        $(".ratios_c_ratio_" + totalYear).val(isinfinity(total1).toFixed(2));
        $(".ratios_working_capital_" + totalYear).val(isinfinity(workingcapital).toFixed(2));
        $(".ratios_quick_ratio_" + totalYear).val(isinfinity(quickratio).toFixed(2));
    });
     $(document).on('keyup', '.decisionamount', function() {
        var amount1 = $('#decision_amount_1').val();
        var amount2 = $('#decision_amount_2').val();
        var amount3 = $('#decision_amount_3').val();

        if (amount1 != '' || amount2 != '' || amount3 != '') {
            $("#decision_amount_1").removeClass('required');
            //$(".dateField").removeClass('required');  
            if (amount1 == '') {
                $(".date_1").removeClass('required');
                $("#date_1-error").hide();
            } else {
                $(".date_1").addClass('required');
                $("#date_1-error").show();
            }
            var currId = $(this).attr('id');
            var idArr = currId.split('_');
            if ($(this).val() != '' && $(this).val() > 0) {
                $(".date_" + idArr[2]).addClass('required');
            } else {
                $(".date_" + idArr[2]).removeClass('required');
            }
            $("#decision_amount_1-error").hide();
        } else {
            $("#decision_amount_1").addClass('required');
        }
        var total_amount = 0;

        total_amount += (amount1 != '') ? parseFloat(amount1) : 0;
        total_amount += (amount2 != '') ? parseFloat(amount2) : 0;
        total_amount += (amount3 != '') ? parseFloat(amount3) : 0;

        var max_amount = $(".total_amount").attr('max');

        var proposed_group_cap = $(".group_cap_validation").val();
        var total_exposure_validation = $(".total_exposure_validation").val();

        var gorup_total_validation = proposed_group_cap - total_exposure_validation;
        //console.log(gorup_total_validation);


        $(".total_amount").val(total_amount);

        if (total_amount > max_amount || total_amount > gorup_total_validation) {
            // $('.save_button').prop('disabled', true);
        } else {
            $('.save_button').prop('disabled', false);
        }
    });
    $('#transferFormAction').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,select")',
        rules: {},
        messages: {},
        errorPlacement: function(error, element) {
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function(e) {
            $('.jsTrasferSaveBtn, .jsTrasferCloseBtn').addClass('spinner spinner-white spinner-left').prop('disabled', true);
            return true;
        }
    });
    $(".jsTrasferSaveBtn").on("click", function() {
        var casesactionData = $('#casesFormprofileaction').serializeArray();
        var finalData = {};
        $.each(casesactionData, function() {
            finalData[this.name] = this.value;
        });

        $(".jscasesactionData").val(JSON.stringify(finalData));

    });

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

    $('#synopsis-form').validate({
        debug: false,
        ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
        rules: {},
        messages: {},
        errorPlacement: function(error, element) {
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function(e) {
            $('#btn_loader').addClass('spinner spinner-white spinner-left');
            $('#btn_loader').prop('disabled', true);
            return true;
        }
    });

    $(document).on("change", ".uw_view", function() {
        calculateanrating();
    });

    function calculateanrating() {
        var contractorRating = staffRating = 0;
        var staffstrength = $('.staff_strength').val() ?? 0;

        if (staffstrength == '') {
            staffstrength = 0;
        }
        // alert(staffstrength);
        var date_of_incorporation = $('.date_of_incorporation').val();
        var uw_view = $('.uw_view').find('option:selected').val();
        var cases_actions_id = {{Js::from($cases_actions_id ?? 0)}};
        // console.log(cases_actions_id);

        if(staffstrength !='' || date_of_incorporation!='' || uw_view!=''){
            var uwRatingFinancial = $('.uw_view').find('option:selected').attr('data-financial');
            var uwRatingNonFinancial = $('.uw_view').find('option:selected').attr('data-non-financial');
            var countryMidlevel = $('.jscountry').attr('data-midlevel');
            var sectormidlevel = $('.jsSector').attr('data-slug-sector');
            $.ajax({
                type: "GET",
                url: "{{route('calculateRating')}}",
                data: {
                    staffstrength: staffstrength,
                    date_of_incorporation: date_of_incorporation,
                    uw_view: uw_view,
                    countryMidlevel:countryMidlevel,
                    uwRatingFinancial:uwRatingFinancial,
                    uwRatingNonFinancial:uwRatingNonFinancial,
                    sectormidlevel:sectormidlevel,
                    cases_actions_id:cases_actions_id
                }
            }).done(function(respons) {
                // console.log(respons.countryRate);
                if(respons){
                    $(".contractorRate").html(respons.contractorRating);
                    $(".contractor_rating").val(respons.contractorRating);
                    $(".countryRate").html(respons.countryRate);
                    $(".sectorsRate").html(respons.sectorsRate);
                    $(".estRate").html(respons.estRate);
                    $(".employeeRate").html(respons.employeeRate);
                    $(".uwRate").html(respons.uwRate);
                    $(".contractorRatingName").html(respons.contractorRatingName);

                }
            });
        }
    }

    $(document).on('click', '.jsAddDate', function() {
        if (datesArr[0].length > 0) {
            $('.jsSaveProfitLossBtn').prop('disabled',false);
        }
    });

    $(document).on('click', '.jsRemoveDate', function() {
        if (datesArr[0].length == 0) {
            $('.jsSaveProfitLossBtn').prop('disabled',true);
        }
    });
</script>