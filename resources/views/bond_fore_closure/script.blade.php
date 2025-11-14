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
            $('#bondForeClosureForm').validate({
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
                showOrHideForeClosureFields('is_refund', 'jsShowRefundRemarks', 'refund_remarks');
                showOrHideForeClosureFields('is_original_bond_received', 'jsShowOriginalBondReceived', 'original_bond_received_attachment');
                showOrHideForeClosureFields('is_confirming_foreclosure', 'jsShowConfirmingForeclosure', 'confirming_foreclosure_attachment');
                showOrHideForeClosureFields('is_any_other_proof', 'jsShowAnyOtherProof', 'any_other_proof_attachment');
            });
        };

        function showOrHideForeClosureFields(radioField, fieldClass, requiredClass){
            if($('.' + radioField + ':checked').val() == 'Yes'){
                $('.' + fieldClass).removeClass('d-none');
                $('.' + requiredClass).addClass('required');
            } else {
                $('.' + fieldClass).addClass('d-none');
                $('.' + requiredClass).removeClass('required');
            }
        }

        $(".proof_of_foreclosure").on("change", function(){
            getAttachmentsCount("proof_of_foreclosure");
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
