@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        var initValidation = function() {
            $('#bondPoliciesIssueForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select,input")',
                rules: {},
                messages: {
                    bond_period_end_date: {
                        min: () => "Please enter a value greater than or equal to " + moment($(
                            "#bond_period_start_date").val()).format('DD/MM/YYYY'),
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function() {
                    $('.jsReadOnly').attr('readOnly',false);
                    $('.jsDisabledField').attr('disabled',false);
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                },
            });
            $('#bondIssueChecklistForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select,input")',
                rules: {},
                messages: {

                },
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function() {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                },
            });
        };

        var beneficiaries_address = @json($beneficiary_address ?? []);
        var beneficiaries_phone_no = @json($beneficiary_phone_no ?? []);

        $(document).ready(function() {
            $('#beneficiary_id').change(function() {
                var beneficiaryId = $(this).val();

                if (beneficiaryId && beneficiaries_address[beneficiaryId] && beneficiaries_phone_no[
                        beneficiaryId]) {
                    var selectedBeneficiary_address = beneficiaries_address[beneficiaryId];
                    var selectedBeneficiary_phone_no = beneficiaries_phone_no[beneficiaryId];

                    $('textarea[name="beneficiary_address"]').val(selectedBeneficiary_address);
                    $('input[name="beneficiary_phone_no"]').val(selectedBeneficiary_phone_no);
                } else {
                    $('textarea[name="beneficiary_address"]').val('');
                    $('input[name="beneficiary_phone_no"]').val('');
                }
            });

            $('#beneficiary_id').select2();

            $("#bond_period_start_date, #bond_period_end_date").change(function() {
                const dateDifferenceInDays = (dateInitial, dateFinal) => {
                    const initialDate = new Date(dateInitial);
                    const finalDate = new Date(dateFinal);

                    if (isNaN(initialDate.getTime()) || isNaN(finalDate.getTime())) {
                        return '';
                    }
                    return (finalDate - initialDate) / 86_400_000;
                };

                const startDate = $('#bond_period_start_date').val();
                const endDate = $('#bond_period_end_date').val();

                if (!startDate || !endDate) {
                    $('#bond_period').val('');
                    return;
                }

                $('#bond_period').val(dateDifferenceInDays(startDate, endDate));
            });

            $('.minDate').on('change', function() {
                var startDate = $('#bond_period_start_date').val();
                $('#bond_period_end_date').attr('min',
                    startDate).attr('data-msg-min', 'Please enter a value greater than or equal to ' + startDate);

                var startDateObj = new Date(startDate);
                startDateObj.setDate(startDateObj.getDate() + 60);

                var endDate = startDateObj.toISOString().split('T')[0];
                $('#bond_period_end_date').attr('max', endDate).attr('data-msg-max', 'Please enter a value less than or equal to ' + endDate);
            });

            $(document).on('change','.executed_deed_indemnity',function(){
                var execVal = $('.executed_deed_indemnity:checked').val();
                if(execVal == 'Yes'){
                    $(".deedAttach").removeClass('d-none');
                    $(".deed_attach_document").addClass('required');
                    $(".deedRemark").addClass('d-none');
                    $(".deed_remarks").removeClass('required');
                    $(".deed_remarks").val('');
                } else {
                    $(".deedAttach").addClass('d-none');
                     $(".deed_attach_document").removeClass('required');
                    $(".deed_attach_document").val('');
                    $(".deedRemark").removeClass('d-none');
                    $(".deed_remarks").addClass('required');
                }
            })

            $(document).on('change','.executed_board_resolution',function(){
                var boardVal = $('.executed_board_resolution:checked').val();
                if(boardVal == 'Yes'){
                    $(".boardAttach").removeClass('d-none');
                    $(".board_attach_document").addClass('required');
                    $(".boardRemark").addClass('d-none');
                    $(".board_remarks").removeClass('required');
                    $(".board_remarks").val('');
                } else {
                    $(".boardAttach").addClass('d-none');
                     $(".board_attach_document").removeClass('required');
                    $(".board_attach_document").val('');
                    $(".boardRemark").removeClass('d-none');
                    $(".board_remarks").addClass('required');
                }
            })

            $(document).on('change','.broker_mandate',function(){
                var brokerVal = $('.broker_mandate:checked').val();
                if(brokerVal == 'Broker'){
                    $(".brokerAttach").removeClass('d-none');
                    $(".broker_attach_document").addClass('required');
                    $(".agentAttach").addClass('d-none');
                    $(".agent_attach_document").removeClass('required');
                    $(".agent_attach_document").val('');
                } else if(brokerVal == 'Agent'){
                    $(".agentAttach").removeClass('d-none');
                    $(".agent_attach_document").addClass('required');
                    $(".brokerAttach").addClass('d-none');
                    $(".broker_attach_document").removeClass('required');
                    $(".broker_attach_document").val('');
                } else {
                    $(".brokerAttach").addClass('d-none');
                    $(".broker_attach_document").removeClass('required');
                    $(".agentAttach").addClass('d-none');
                    $(".agent_attach_document").removeClass('required');
                    $(".agent_attach_document, .broker_attach_document").val('');
                }
            })

            $(document).on('change','.collateral_available',function(){
                var colVal = $('.collateral_available:checked').val();
                if(colVal == 'Yes'){
                    $(".collateralRemark").removeClass('d-none');
                    $(".collateralAvailableRemark").addClass('d-none');
                    $(".collateral_remarks").removeClass('required');                   
                    $(".fd_amount").addClass('required');                   
                    $(".fd_issuing_bank_name").addClass('required');                   
                    $(".fd_issuing_branch_name").addClass('required');                   
                    $(".fd_receipt_number").addClass('required');                   
                    $(".bank_address").addClass('required');                   
                    $(".collateral_attach_document").addClass('required');                   
                    $(".collateral_remarks").val('');
                } else {
                    $(".collateralRemark").addClass('d-none');
                    $(".collateralAvailableRemark").removeClass('d-none');
                    $(".collateral_remarks").addClass('required');  
                    $(".fd_amount").removeClass('required');                   
                    $(".fd_issuing_bank_name").removeClass('required');                   
                    $(".fd_issuing_branch_name").removeClass('required');                   
                    $(".fd_receipt_number").removeClass('required');                   
                    $(".bank_address").removeClass('required');                   
                    $(".collateral_attach_document").removeClass('required');                  
                    $(".fd_amount").val('');
                    $(".fd_issuing_bank_name").val('');
                    $(".fd_issuing_branch_name").val('');
                    $(".fd_receipt_number").val('');
                    $(".bank_address").val('');
                    
                }
            })
        });

        $(document).on('change','.intermediary_detail',function(){
                var type = $('.intermediary_detail:checked').val();
                var url = {{Js::from(route('getTeamMemberByType'))}};
                
                   $.ajax({
                        url:url,
                        data:{
                            type:type
                        }
                    }).done(function(response){

                        if(response){
                            var tOptions = '';
                            var tData = [{
                                'id': '',
                                'text': '',
                                'html': '',
                            }];
                            $.each(response, function(id,name) {

                                var obj = {
                                    'id': id,
                                    'text': name,
                                    'html': name,
                                };
                                tData.push(obj);
                            });
                            $(".intermediaryDetailId").select2({
                                data: tData,
                                templateResult: selectTemplate,
                                escapeMarkup: function(m) {
                                    return m;
                                },
                            });
                    }

                    });
                 

                if(['Broker','Agent'].includes(type)){
                   $('.intermediaryParentDetailSection').removeClass('d-none');
                   $('.intermediaryChildDetailSection').val(null);
                   $('.intermediaryDetailId').addClass('required');
                }
                else {
                   $('.intermediaryParentDetailSection').addClass('d-none');
                   $('.intermediaryChildDetailSection').val(null);
                   $('.intermediaryDetailId').removeClass('required');
                }

                $('.intermediaryDetailId').empty();
        });

         $(document).on('change','.intermediaryDetailId',function(){

             var intermediary_detail_id = $(this).val();
             var intermediary_detail_type = $('.intermediary_detail:checked').val();
             var url = {{Js::from(route('getDetailByTeamMember'))}};

               $.ajax({
                        url:url,
                        data:{
                            intermediary_detail_id:intermediary_detail_id,
                            intermediary_detail_type:intermediary_detail_type
                        }
                    }).done(function(response){
                        $('#intermediary_detail_code').val(response.code);
                        $('#intermediary_detail_name').val(response.name);
                        $('#intermediary_detail_email').val(response.email);
                        $('#intermediary_detail_mobile').val(response.mobile);
                        $('#intermediary_detail_address').val(response.address);
                });
        });

        

        $(".deed_attach_document").on("change", function(){
            getAttachmentsCount("deed_attach_document");
        });

        $(".board_attach_document").on("change", function(){
            getAttachmentsCount("board_attach_document");
        });

        $(".broker_attach_document").on("change", function(){
            getAttachmentsCount("broker_attach_document");
        });

        $(".agent_attach_document").on("change", function(){
            getAttachmentsCount("agent_attach_document");
        });

        $(".collateral_attach_document").on("change", function(){
            getAttachmentsCount("collateral_attach_document");
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });
    </script>
@endpush
