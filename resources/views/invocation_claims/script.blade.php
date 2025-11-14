@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
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

            $('#bondInvocationClaimsForm').validate({
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
        };

        $('.closed_reason').select2({
            allowClear:true
        });        

        $(document).on('change', '.bond_type', function() {
            var bond_type = $(this).val();
            $(".bond_id option").remove();
            var s = $(".bond_id");
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
                                options += '<option '+selected+' value = '+val.id+' data-bond_value='+val.bond_value+'>'+val.code+'</option>';
                        });
                        $('.bond_id').html("<option value = ''>Select Type</option>").append(options);
                        $('.bond_id').select2({ allowClear:true});
                   }                  
                });
            } else {
                $(".bond_id option").remove();
            }
        });

        $(document).on('change', '.bond_id', function() {
            var bond_id = $(this).find(':selected').val();
            if(bond_id){
                var bond_value = $(this).find(':selected').data('bond_value'); 
                $(".invocation_amount").val(bond_value);                           
            } else {
                $(".invocation_amount").val('');
            }
        });

        function updateFieldBasedOnRadio(radioId, fieldClass, requiredClass) {
            if ($(radioId).is(':checked')) {
                $(fieldClass).show().attr('aria-hidden', 'false');
                $(requiredClass).addClass('required').attr('aria-required', 'true');

                if ($(requiredClass).data('id') == "Yes" && $(requiredClass).attr('data-document-uploaded') ==
                    'false') {
                    $(requiredClass).removeClass('required').removeAttr('aria-required');
                }
                if ($(requiredClass).data('id') == "No" && $(requiredClass).attr('data-document-uploaded') ==
                    'false') {
                    $(requiredClass).removeClass('required').removeAttr('aria-required');
                }
            } else {
                $(fieldClass).hide().attr('aria-hidden', 'true');
                $(requiredClass).val('').removeClass('required').removeAttr('aria-required');
            }
        }

        $('form').on('change', '.chkRadio', function() {
            updateFieldBasedOnRadio('#claim_form','.claimAttachment','.claim_form_attachment');
            updateFieldBasedOnRadio('#invocation_notice','.noticeAttachment','.invocation_notice_attachment');
            updateFieldBasedOnRadio('#contract_copy','.contractCopyAttachment','.contract_copy_attachment');
            updateFieldBasedOnRadio('#correspondence_details','.corresAttachment','.correspondence_detail_attachment');
            updateFieldBasedOnRadio('#arbitration','.arbitrationAttachment','.arbitration_attachment');
            updateFieldBasedOnRadio('#dispute','.disputeAttachment','.dispute_attachment');
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
        
    </script>
@endpush
