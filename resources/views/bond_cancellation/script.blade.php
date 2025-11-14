@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        const disabledFields = [
            'contractor_id',
            'beneficiary_id',
            'project_details_id',
            'tender_id',
            'bond_type_id',
            'bond_conditionality',
        ];

        var initValidation = function() {
            $('#bondCancellationForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    disabledFields.forEach(item => {
                        $('.' + item).prop('disabled', false);
                    });
                    return true;
                }
            });

            $(document).on('change', 'input[type="radio"]', function(){
                showOrHideBondCancellationFields('is_refund', 'jsShowRefundRemarks', 'refund_remarks');
                showOrHideBondCancellationFields('is_original_bond_received', 'jsShowOriginalBondReceived', 'original_bond_received_attachment');
                showOrHideBondCancellationFields('is_confirming_foreclosure', 'jsShowConfirmingForeclosure', 'confirming_foreclosure_attachment');
                showOrHideBondCancellationFields('is_any_other_proof', 'jsShowAnyOtherProof', 'any_other_proof_attachment');
            });

            $(document).on('change', '.bond_cancellation_type', function(){
                if($('.bond_cancellation_type:checked').val() == 'pre_project'){
                    $('.jsPreProjectRemarksShow').removeClass('d-none');
                    $('.pre_project_remarks').addClass('required');
                    $('.jsMidProjectRemarksShow, .jsAnyOtherTypeRemarksShow').addClass('d-none');
                    $('.mid_project_remarks, .any_other_type_remarks').removeClass('required');
                } else if($('.bond_cancellation_type:checked').val() == 'mid_project'){
                    $('.jsMidProjectRemarksShow').removeClass('d-none');
                    $('.mid_project_remarks').addClass('required');
                    $('.jsPreProjectRemarksShow, .jsAnyOtherTypeRemarksShow').addClass('d-none');
                    $('.pre_project_remarks, .any_other_type_remarks').removeClass('required');
                } else if($('.bond_cancellation_type:checked').val() == 'any_other_type'){
                    $('.jsAnyOtherTypeRemarksShow').removeClass('d-none');
                    $('.any_other_type_remarks').addClass('required');
                    $('.jsPreProjectRemarksShow, .jsMidProjectRemarksShow').addClass('d-none');
                    $('.pre_project_remarks, .mid_project_remarks').removeClass('required');
                }
            });
        };

        function showOrHideBondCancellationFields(radioField, fieldClass, requiredClass){
            if($('.' + radioField + ':checked').val() == 'Yes'){
                $('.' + fieldClass).removeClass('d-none');
                $('.' + requiredClass).addClass('required');
            } else {
                $('.' + fieldClass).addClass('d-none');
                $('.' + requiredClass).removeClass('required');
            }
        }

        $(".bond_cancellation_attachment").on("change", function(){
            getAttachmentsCount("bond_cancellation_attachment");
        });
        $(".original_bond_received_attachment").on("change", function(){
            getAttachmentsCount("original_bond_received_attachment");
        });
        $(".confirming_foreclosure_attachment").on("change", function(){
            getAttachmentsCount("confirming_foreclosure_attachment");
        });
        $(".any_other_proof_attachment").on("change", function(){
            getAttachmentsCount("any_other_proof_attachment");
        });
    </script>
@endpush
