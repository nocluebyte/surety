@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#bondProgressForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
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

        $(document).ready(function() {
            function updateFieldBasedOnRadio(radioId, fieldClass, requiredClass) {
                if ($(radioId + ':checked').val() == 'Yes') {
                    $(fieldClass).show().attr('aria-hidden', 'false');
                    var is_required = $(radioId).attr('is_required');
                    $(requiredClass).addClass('required').attr('aria-required', 'true');
                } else {
                    $(fieldClass).hide().attr('aria-hidden', 'true');
                    $(requiredClass).val('').removeClass('required').removeAttr('aria-required');
                }
            }

            $('form').on('click', 'input[type="radio"]', function() {
                updateFieldBasedOnRadio('.dispute_initiated','.disputeInitiatedRemarks', '.dispute_initiated_remarks');
            });

            updateFieldBasedOnRadio('.dispute_initiated','.disputeInitiatedRemarks', '.dispute_initiated_remarks');
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        $(".progress_attachment").on("change", function(){
            getAttachmentsCount("progress_attachment");
        });

        $(".physical_completion_attachment").on("change", function(){
            getAttachmentsCount("physical_completion_attachment");
        });
    </script>
@endpush
