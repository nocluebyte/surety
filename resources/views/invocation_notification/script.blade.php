@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
            getCkEditor('remark', imageUpload = true);
        });

        function updateTabValidation() {
            $('.tab-content.tab-validate .tab-pane').each(function() {
                var id = $(this).attr('id');
                if ($(this).find('input.error, textarea.error, select.error').length) {
                    $('.nav-tabs li a[href="#' + id + '"]').addClass('border border-danger');
                } else {
                    $('.nav-tabs li a[href="#' + id + '"]').removeClass('border border-danger');
                }
            });
        }

        jQuery.validator.addMethod("filesize", function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than 2 MB');

        var initValidation = function() {
           // var contractArr = [];            
            var id = $('#id').val();            

            $('#bondInvocationNotificationForm').validate({
                debug: false,
                ignore: '.select2-search__field, .jv_pan_no, .spv_pan_no, :hidden:not("textarea,.files,select,input")',                
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function() {
                    $('.jsReadOnly').attr('readonly',false);
                    $('.jsDisabled').attr('disabled',false);
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                },
                invalidHandler: function() {
                    setTimeout(updateTabValidation, 0);
                },
            });

            $('#invocationPayoutForm').validate({
                debug: false,
                ignore: '.select2-search__field, :hidden:not("textarea,.files,select,input")',                
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');

                },
            });

            $('#claimExaminerForm').validate({
                debug: false,
                ignore: '.select2-search__field, :hidden:not("textarea,.files,select,input")',                
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');

                },
            });

            $('#analysisForm').validate({
                debug: false,
                ignore: '.select2-search__field, :hidden:not("textarea,.files,select,input")',
                rules: {
                    remark: {
                        check_ck_add_method: true
                    },
                },
                messages: {
                    remark: {
                        check_ck_add_method: "This field is required",
                    },
                },             
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');

                },
            });
            $.validator.addMethod("check_ck_add_method", function(value, element) {
                return check_ck_editor('remark');
            });

            $('#dmsTabForm').validate({
                debug: false,
                ignore: '.select2-search__field, :hidden:not("textarea,.files,select,input")',             
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');

                },
            });            

        };

        $('.closed_reason').select2({
            allowClear:true
        });        

        $(document).on('change', '.bond_type', function() {
            var bond_type = $(this).val();
            $(".proposal_id option").remove();
            var s = $(".proposal_id");
            if(bond_type > 0) {
                addLoadSpiner(s);
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'bond_type': bond_type,
                    },
                }).always(function() {

                }).done(function(response) {
                   hideLoadSpinner(s); 
                   if(response){
                        var options = '';
                        var selected = '';
                        $.each(response,function(index,val){
                                options += '<option '+selected+' value = '+val.id+' data-bond_value='+val.bond_value+' data-version='+val.version+'>'+val.code+'/V'+ val.version+'</option>';
                        });
                        $('.proposal_id').html("<option value = ''>Select Type</option>").append(options);
                        $('.proposal_id').select2({ allowClear:true});
                   }                  
                });
            } else {
                $(".proposal_id option").remove();
            }
        });

        $(document).on('change', '.proposal_id', function() {
            var proposal_id = $(this).find(':selected').val();
            if(proposal_id){
                var bond_value = $(this).find(':selected').data('bond_value'); 
                var version = $(this).find(':selected').data('version'); 
                $(".invocation_amount").val(bond_value);                           
                $(".version").val(version);                           
            } else {
                $(".version").val('');                           
                $(".invocation_amount").val('');
            }
        });

        $(document).on('change', '.JsSource', function(e) {
            var source = $(this).val();
            $(".JsUserId option").remove();
            if (source != '' && source != 'direct') {
                $('.jsSourceNameDiv').removeClass('d-none');
                $.ajax({
                    url: '{{ route('get-soure') }}',
                    data: {
                        source: source,
                    }
                }).done(function(response) {
                    var data = [{
                        'id': '',
                        'text': '',
                        'html': ''
                    }];
                    $.each(response, function(index, value) {
                        var obj = {
                            'id': index,
                            'text': value,
                            'html': value,
                        };
                        data.push(obj);
                    });
                    $('.JsUserId').select2({
                        data: data,
                        escapeMarkup: function(m) {
                            return m;
                        }
                    });
                });
            } else {
                $('.jsSourceNameDiv').addClass('d-none');
            }
        });

        const bondDetails = [
            'contractor',
            'beneficiary',
            'project_name',
            'tender',
            'bond_type',
            'bond_value',
            'bond_start_date',
            'bond_end_date',
            'bond_conditionality',
            'contractor_id',
            'beneficiary_id',
            'tender_id',
            'project_details_id',
            'bond_type_id',
            'bond_number',
            'proposal_id',
        ];
        
        $(document).on('change', '.bond_policies_issue_id', function(){
            var bond_policies_issue_id = $(this).val();
            bondDetails.forEach(item => {
                $("." + item).val('');
            });
            if(bond_policies_issue_id > 0) {
                // addLoadSpiner(s);
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'bond_policies_issue_id': bond_policies_issue_id,
                    },
                }).always(function() {

                }).done(function(response) {
                    if(response){
                        bondDetails.forEach(item => {
                            $("." + item).val(response[item]);
                        });
                        $('.currency_symbol').text(' (' + response.currency_symbol + ')');
                        
                        if(response['bond_number'] == null){
                            var url = "{{ route('proposals.show', '__encryptedID__') }}".replace('__encryptedID__', response['encryptedID']);
                            $('.add_bond_number').removeClass('d-none').attr('href', decodeURIComponent(url));

                            $('.is_bond_number').text('Add Bond Number in Bond Issued Tab first.').addClass('text-danger');
                        } else {
                            $('.is_bond_number').text('');
                            $('.add_bond_number').addClass('d-none');
                        }
                    }
                });
            }
        });

        $(".notice_attachment").on("change", function(){
            getAttachmentsCount("notice_attachment");
        });

        $(".invocation_notification_attachment").on("change", function(){
            getAttachmentsCount("invocation_notification_attachment");
        });

        $(".contract_agreement").on("change", function(){
            getAttachmentsCount("contract_agreement");
        });

        $(".beneficiary_communication_attachment").on("change", function(){
            getAttachmentsCount("beneficiary_communication_attachment");
        });

        $(".legal_documents").on("change", function(){
            getAttachmentsCount("legal_documents");
        });

        $(".any_other_documents").on("change", function(){
            getAttachmentsCount("any_other_documents");
        });

        $(document).on('change', '.claim_examiner_id', function() {            
            var claim_examiner_id = $(this).val();
            
            if(claim_examiner_id){
                let ajaxUrl = $(this).attr('data-ajaxUrl');

                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'claim_examiner_id' : claim_examiner_id,
                    },
                }).always(function() {

                }).done(function(response) {
                    if(response == 2){
                      $('.JsApprovedLimit').text('The Maximun Approved Limit of Claim Examiner should be greater than or equal to Invocation Amount.');
                      $('.JsAssignClaimExaminer').attr('disabled', true);
                      $('.claim_examiner_id').val(null).trigger('change');
                    } else if(response == 1){
                        $('.JsApprovedLimit').text('This Claim Examiner is already assigned to this Invocation Notification.');
                        $('.JsAssignClaimExaminer').attr('disabled', true);
                        $('.claim_examiner_id').val(null).trigger('change');
                    } else {
                      $('.JsApprovedLimit').text('');
                      $('.JsAssignClaimExaminer').attr('disabled', false);
                    }
                });
            }
        });

        $(document).on('keyup', '.disallowed_amount, .claimed_amount', function() {
            let total_approved_bond_value = $('.claimed_amount').val() - $('.disallowed_amount').val();
            $('.total_approved_bond_value').val(total_approved_bond_value);
        });

        // $('#payout').click(function(e){
        //     e.preventDefault();
            
        //     let element = $(this);
        //     let url = element.data('url');
            
        //     message.fire({
        //     title: "Submit your Github username",
        //     input: "number",
        //     inputAttributes: {
        //         autocapitalize: "off"
        //     },
        //     showCancelButton: true,
        //     confirmButtonText: "Payout",
        //     showLoaderOnConfirm: true,
        //     preConfirm: () =>
            
        //         $.ajax({
        //             url:url,
        //             method:'POST',
        //         }),  
              
        //     allowOutsideClick: () => !Swal.isLoading()
        //     }).then((result) => {
        //         if (result.value) {
        //             message.fire({
        //                 title: result.value.success
        //             });
        //         }
        //     });
            
            
        // });
    </script>
@endpush
